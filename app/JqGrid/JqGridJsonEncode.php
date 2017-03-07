<?php

namespace App\JqGrid;

use App\JqGrid\Exceptions\JsonEncodingMaxDepthException;
use App\JqGrid\Exceptions\JsonEncodingStateMismatchException;
use App\JqGrid\Exceptions\JsonEncodingSyntaxErrorException;
use App\JqGrid\Exceptions\JsonEncodingUnexpectedControlCharException;
use App\JqGrid\Exceptions\JsonEncodingUnknownException;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Http\Request;

/**
* 
*/
class JqGridJsonEncode 
{
    protected $model;
    protected $filters;
    protected $rows;
    protected $visibleColumns;
    protected $orderBy = array(array());
    protected $treeGrid;
    protected $parentColumn;
    protected $leafColumn;

    public function __construct(Model $model)
    {
        $this->model = $model;
    }

    public function filters(Request $request)
    {   

        if($request->has('filters') && !empty($request->filters))
        {
            $filters = json_decode(str_replace('\'','"',$request->filters), true);
        }

        if(isset($filters['rules']) && is_array($filters['rules']))
        {
            foreach ($filters['rules'] as &$filter)
            {
                switch ($filter['op'])
                {
                    case 'eq': //equal
                        $filter['op'] = '=';
                        break;
                    case 'ne': //not equal
                        $filter['op'] = '!=';
                        break;
                    case 'lt': //less
                        $filter['op'] = '<';
                        break;
                    case 'le': //less or equal
                        $filter['op'] = '<=';
                        break;
                    case 'gt': //greater
                        $filter['op'] = '>';
                        break;
                    case 'ge': //greater or equal
                        $filter['op'] = '>=';
                        break;
                    case 'bw': //begins with
                        $filter['op'] = 'like';
                        $filter['data'] = $filter['data'] . '%';
                        break;
                    case 'bn': //does not begin with
                        $filter['op'] = 'not like';
                        $filter['data'] = $filter['data'] . '%';
                        break;
                    case 'in': //is in
                        $filter['op'] = 'is in';
                        break;
                    case 'ni': //is not in
                        $filter['op'] = 'is not in';
                        break;
                    case 'ew': //ends with
                        $filter['op'] = 'like';
                        $filter['data'] = '%' . $filter['data'];
                        break;
                    case 'en': //does not end with
                        $filter['op'] = 'not like';
                        $filter['data'] = '%' . $filter['data'];
                        break;
                    case 'cn': //contains
                        $filter['op'] = 'like';
                        $filter['data'] = '%' . str_replace(' ', '%', $filter['data']) . '%';
                        break;
                    case 'cnpg': //contains PostgreSQL
                        $filter['op'] = 'ilike';
                        $filter['data'] = '%' . str_replace(' ', '%', $filter['data']) . '%';
                        break;
                    case 'nc': //does not contains
                        $filter['op'] = 'not like';
                        $filter['data'] = '%' . $filter['data'] . '%';
                        break;
                    case 'nu': //is null
            $filter['op'] = 'is null';
            $filter['data'] = '';
            break;
            case 'nn': //is not null
            $filter['op'] = 'is not null';
            $filter['data'] = '';
            break;
                        case 'btw': //between
                        $filter['op'] = 'between';
                        break;
                }
            }
        }
        else
        {
            $filters['rules'] = array();
        }
        
        $this->filters = $filters;
        
        $this->rows = $this->data($request);

        return $this;
    }

    public function json()
    {
        return $this->rows;
    }

    private function data(Request $request)
    {
        $page = $request->get('page', 1);
        $limit = $request->get('rows', null);
        $orderBy = $request->get('sidx', null);
        $sord = $request->get('sord', 'asc');

        $filters = $this->filters;

        $exporting = $request->has('exportFormat');

        $count = $this->getTotalNumberOfRows($filters['rules']);


        if(empty($limit))
        {
            $limit = $count;
        }

        if(!is_int($count))
        {
            throw new \Exception('The method getTotalNumberOfRows must return an integer');
        }

        if( $count > 0 )
        {
            $totalPages = ceil($count/$limit);
        }
        else
        {
            $totalPages = 0;
        }

        if ($page > $totalPages)
        {
            $page = $totalPages;
        }

        if ($limit < 0 )
        {
            $limit = 0;
        }

        $start = ($limit * $page) - $limit;

        if ($start < 0)
        {
            $start = 0;
        }

        $limit = ($limit * $page);

        $rows = $this->model->whereNested(function($query) use ($filters)
        {   
            foreach ($filters['rules'] as $filter)
            {
                if($filter['op'] == 'is in')
                {
                    $query->whereIn($filter['field'], explode(',',$filter['data']));
                    continue;
                }

                if($filter['op'] == 'is not in')
                {
                    $query->whereNotIn($filter['field'], explode(',',$filter['data']));
                    continue;
                }

                if($filter['op'] == 'is null')
                {
                    $query->whereNull($filter['field']);
                    continue;
                }

                if($filter['op'] == 'is not null')
                {
                    $query->whereNotNull($filter['field']);
                    continue;
                }

                if($filter['op'] == 'between')
                {
                    if(strpos($filter['data'], ' - ') !== false)
                    {
                        list($from, $to) = explode(' - ', $filter['data'], 2);

                        if(!$from or !$to)
                        {
                            throw new \Exception('Invalid between format');
                        }
                    }
                    else
                    {
                        throw new \Exception('Invalid between format');
                    }

                    if( $from == $to)
                    {
                        $query->where($filter['field'], $from);
                    }else
                    {
                        //$query->whereBetween($filter['field'], array($from, $to));
                        $query->where($filter['field'], '>=', $from);
                        $query->where($filter['field'], '<=', $to);
                    }
                    continue;
                }

                $query->where($filter['field'], $filter['op'], $filter['data']);
            }
        });

        if(!is_null($orderBy)){
            $rows = $rows->orderBy($orderBy, $sord);
        }
        
        $rows = $rows->take($limit)->skip($start)->get();

        return [
            'page' => $page, 
            'total' => $totalPages, 
            'records' => $count, 
            'rows' => $rows->toArray()
        ]; 
    }


    /**
     * Calculate the number of rows. It's used for paging the result.
     *
     * @param  array $filters
     *  An array of filters, example: array(array('field'=>'column index/name 1','op'=>'operator','data'=>'searched string column 1'), array('field'=>'column index/name 2','op'=>'operator','data'=>'searched string column 2'))
     *  The 'field' key will contain the 'index' column property if is set, otherwise the 'name' column property.
     *  The 'op' key will contain one of the following operators: '=', '<', '>', '<=', '>=', '<>', '!=','like', 'not like', 'is in', 'is not in'.
     *  when the 'operator' is 'like' the 'data' already contains the '%' character in the appropiate position.
     *  The 'data' key will contain the string searched by the user.
     * @return integer
     *  Total number of rows
     */
    public function getTotalNumberOfRows(array $filters = array())
    {
        return  intval($this->model->whereNested(function($query) use ($filters)
        {
            foreach ($filters as $filter)
            {
                if($filter['op'] == 'is in')
                {
                    $query->whereIn($filter['field'], explode(',',$filter['data']));
                    continue;
                }

                if($filter['op'] == 'is not in')
                {
                    $query->whereNotIn($filter['field'], explode(',',$filter['data']));
                    continue;
                }

                if($filter['op'] == 'is null')
                {
                    $query->whereNull($filter['field']);
                    continue;
                }

                if($filter['op'] == 'is not null')
                {
                    $query->whereNotNull($filter['field']);
                    continue;
                }

                if($filter['op'] == 'between')
                {
                    if(strpos($filter['data'], ' - ') !== false)
                    {
                        list($from, $to) = explode(' - ', $filter['data'], 2);

                        if(!$from or !$to)
                        {
                            throw new \Exception('Invalid between format');
                        }
                    }
                    else
                    {
                        throw new \Exception('Invalid between format');
                    }

                    if( $from == $to)
                    {
                        $query->where($filter['field'], $from);
                    }else
                    {
                        //$query->whereBetween($filter['field'], array($from, $to));
                        $query->where($filter['field'], '>=', $from);
                        $query->where($filter['field'], '<=', $to);
                    }

                    continue;
                }

                $query->where($filter['field'], $filter['op'], $filter['data']);
            }
        })
        ->count());
    }

    /**
     * Safe JSON_ENCODE function that tries to deal with UTF8 chars or throws a valid exception.
     *
     * Lifted from http://stackoverflow.com/questions/10199017/how-to-solve-json-error-utf8-error-in-php-json-decode
     * Based on: http://php.net/manual/en/function.json-last-error.php#115980
     * @param $value
     * @return string
     */
    protected function safe_json_encode($value){
        if (version_compare(PHP_VERSION, '5.4.0') >= 0) {
            $encoded = json_encode($value, JSON_PRETTY_PRINT);
        } else {
            $encoded = json_encode($value);
        }
        switch (json_last_error()) {
            case JSON_ERROR_NONE:
                return $encoded;
            case JSON_ERROR_DEPTH:
                throw new JsonEncodingMaxDepthException('Maximum stack depth exceeded');
            case JSON_ERROR_STATE_MISMATCH:
                throw new JsonEncodingStateMismatchException('Underflow or the modes mismatch');
            case JSON_ERROR_CTRL_CHAR:
                throw new JsonEncodingUnexpectedControlCharException('Unexpected control character found');
            case JSON_ERROR_SYNTAX:
                throw new JsonEncodingSyntaxErrorException('Syntax error, malformed JSON');
            case JSON_ERROR_UTF8:
                $clean = self::utf8ize($value);
                return self::safe_json_encode($clean);
            default:
                throw new JsonEncodingUnknownException('Unknown error');

        }
    }
}