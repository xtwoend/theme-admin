<?php

namespace App\Http\Controllers\Admin;

use App\DataGrid\Facades\Datatables;
use App\Entities\Soal;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Maatwebsite\Excel\Facades\Excel;

class SoalController extends Controller
{
    protected $soal;

    public function __construct(Soal $soal)
    {   
        config(['site.menu' => 'soal']);
        $this->soal = $soal;
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return view('admin.modules.soal.index');
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('admin.modules.soal.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $this->validate($request, [
            'pertanyaan' => 'required',
            'mapel_id' => 'required',
            'kategori' => 'required'
        ]);

        $this->soal->create($request->all());
        return redirect()->route('admin.soal.index')->with(['message' => 'Success add soal']);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $row = $this->soal->findOrFail($id);
        return view('admin.modules.soal.show', compact('row')); 
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $row = $this->soal->findOrFail($id);
        return view('admin.modules.soal.edit', compact('row'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function quickEdit($id)
    {
        $row = $this->soal->findOrFail($id);
        return view('admin.modules.soal.quickedit', compact('row'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {   
        $this->validate($request, [
            'pertanyaan' => 'required',
            'mapel_id' => 'required',
            'kategori' => 'required'
        ]);
        
        $row = $this->soal->findOrFail($id);
        $row->fill($request->all());
        $row->save();

        if($request->ajax()){
            return response()->json([
                'success' => true,
                'message' => 'Berhasil di ubah'
            ], 200);
        }

        return redirect()->route('admin.soal.index')->with(['message' => 'Success edit soal']);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(Request $request, $id)
    {
        if($request->ajax() && $id === '0'){
            $this->soal->whereIn('id', $request->ids)->delete();

            return response()->json(['status' => 'success', 'message' => 'soal has been delete'], 200);
        }

        $this->soal->findOrFail($id)->delete();

        return redirect()->route('admin.soal.index')->with(['message' => 'soal has been delete']);
    }

    /**
     * [data description]
     * @param  Request $request [description]
     * @return [type]           [description]
     */
    public function data(Request $request)
    {
        $rows = $this->soal->with('mapel')->select('*');
        
        return Datatables::eloquent($rows)
            ->editColumn('type', function($row){
                return ($row->type)? 'Essay': 'PG';
            })
            ->editColumn('kategori', function($row){
                $kategoris = ['Mudah', 'Sedang', 'Sulit'];
                return $kategoris[$row->kategori];
            })
            ->editColumn('pertanyaan', function($row){
                return strip_tags($row->pertanyaan);
            })
            ->addColumn('action', function($row){
                $btn  = '<a href="'.route('admin.soal.edit',$row->id).'" class="btn btn-xs btn-success" title="Edit" data-bjax> <i class="icon-pencil"></i> </a>';
                $btn .= '<a href="'.route('admin.soal.show', $row->id).'" data-toggle="ajaxModal" class="btn btn-xs btn-primary" title="Lihat Password"><i class="icon-eye"></i></a>';
                return $btn;
            })
            ->make(true);
    }

    public function upload()
    {
        return view('admin.modules.soal.upload'); 
    }

    public function uploadPost(Request $request)
    {
        if($request->hasFile('file') && $request->file('file')->isValid()){
            $mapel_id   = $request->mapel_id;
            $file       = $request->file;
            $data = [];
            foreach (Excel::load($file)->toObject() as $row) {
                if(is_null($row->pertanyaan)) continue;
                $data[] = [
                    'mapel_id' => $mapel_id,
                    'pertanyaan' => $row->pertanyaan,
                    'opsi' => json_encode([
                        1 => $row->opsi_1,
                        2 => $row->opsi_2,
                        3 => $row->opsi_3,
                        4 => $row->opsi_4,
                        5 => $row->opsi_5,
                    ], TRUE),
                    'kunci' => $row->kunci,
                    'type' => $row->tipe_soal,
                    'kategori' => $row->kategori,
                    'created_at' => date('Y-m-d H:i:s'),
                    'updated_at' => date('Y-m-d H:i:s'),
                ];
            }
            // insert bulk 
            $this->soal->insert($data);
            return redirect()->route('admin.soal.index')->with(['message' => 'Soal berhasil di upload']);
        }
        return redirect()->route('admin.soal.index')->withError('Soal gagal di upload');
    }

    // sum max soal by mapel_id
    public function sum(Request $request)
    {
        $soal = $this->soal->where('mapel_id', $request->mapel_id)->get();
        $max = $soal->count();
        $max_pg = $soal->where('type', 0)->count();
        $pg_mudah = $soal->where('type', 0)->where('kategori', 0)->count();
        $pg_sedang= $soal->where('type', 0)->where('kategori', 1)->count();
        $pg_sulit = $soal->where('type', 0)->where('kategori', 2)->count();

        $max_essay = $soal->where('type', 1)->count();
        $essay_mudah = $soal->where('type', 1)->where('kategori', 0)->count();
        $essay_sedang= $soal->where('type', 1)->where('kategori', 1)->count();
        $essay_sulit = $soal->where('type', 1)->where('kategori', 2)->count();

        return response()->json([
            'max'   => $max,
            'max_pg' => $max_pg,
            'max_pgx' => [
                'mudah'     => $pg_mudah,
                'sedang'    => $pg_sedang,
                'sulit'     => $pg_sulit
            ],
            'max_essay' => $max_essay,
            'max_essayx' => [
                'mudah'     => $essay_mudah,
                'sedang'    => $essay_sedang,
                'sulit'     => $essay_sulit
            ],
        ], 200);
    }
}
