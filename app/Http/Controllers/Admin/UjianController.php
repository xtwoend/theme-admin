<?php

namespace App\Http\Controllers\Admin;

use App\DataGrid\Facades\Datatables;
use App\Entities\Ujian;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class UjianController extends Controller
{
    protected $ujian;

    public function __construct(Ujian $ujian)
    {   
        config(['site.menu' => 'ujian']);
        $this->ujian = $ujian;
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {   
        $rows = $this->ujian->latest()->paginate(9);
        $ujian = false;
        if($request->has('id')){
            $ujian = $this->ujian->findOrFail($request->id);
        }
        return view('admin.modules.ujian.index', compact('rows', 'ujian'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('admin.modules.ujian.create');
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
            'mapel_id' => 'required',
            'waktu_mulai' => 'required',
            'lama_waktu' => 'required',
            'batas_terlambat' => 'required',
            'jumlah_soal' => 'required',
            'soal_pg'   => 'required',
            'soal_essay' => 'required'
        ]);

        $request->request->add(['waktu_berakhir' => create_date($request->waktu_mulai)->addMinutes($request->lama_waktu)]);
        $request->request->add(['token' => token()]);
        
        $this->ujian->create($request->all());
        return redirect()->route('admin.ujian.index')->with(['message' => 'Success add ujian']);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        // 
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {   
        $row = $this->ujian->findOrFail($id);
        return view('admin.modules.ujian.edit', compact('row'));
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
            'mapel_id' => 'required',
            'waktu_mulai' => 'required',
            'lama_waktu' => 'required',
            'batas_terlambat' => 'required',
            'jumlah_soal' => 'required',
            'soal_pg'   => 'required',
            'soal_essay' => 'required'
        ]);
        
        $request->request->add(['waktu_berakhir' => create_date($request->waktu_mulai)->addMinutes($request->lama_waktu)]);

        $row = $this->ujian->findOrFail($id);
        $row->fill($request->all());
        $row->save();

        return redirect()->route('admin.ujian.index')->with(['message' => 'Success edit ujian']);
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
            $this->ujian->whereIn('id', $request->ids)->delete();
            return response()->json(['status' => 'success', 'message' => 'ujian has been delete'], 200);
        }

        $this->ujian->findOrFail($id)->delete();
        return redirect()->route('admin.ujian.index')->with(['message' => 'ujian has been delete']);
    }

    /**
     * [data description]
     * @param  Request $request [description]
     * @return [type]           [description]
     */
    public function data(Request $request)
    {
        $rows = $this->ujian->select('*');
        return Datatables::eloquent($rows)
            ->addColumn('action', function($row){
                $btn  = '<a href="'.route('admin.ujian.edit',$row->id).'" class="btn btn-xs btn-success" title="Edit" data-bjax> <i class="icon-pencil"></i> </a>';
                return $btn;
            })
            ->make(true);
    }


    public function refreshToken($id, Request $request)
    {
        $row = $this->ujian->findOrFail($id);
        $row->token = token();
        $row->save();
        return response()->json($row->token, 200);
    }
}
