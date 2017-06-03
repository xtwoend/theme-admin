<?php

namespace App\Http\Controllers\Admin;

use App\DataGrid\Facades\Datatables;
use App\Entities\Kelas;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class KelasController extends Controller
{
    protected $kelas;

    public function __construct(Kelas $kelas)
    {
        config(['site.menu' => 'kelas']);
        $this->kelas = $kelas;
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return view('admin.modules.kelas.index');
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('admin.modules.kelas.create');
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
            'nama' => 'required',
            'jurusan_id' => 'required'
        ]);

        $this->kelas->create($request->all());
        return redirect()->route('admin.kelas.index')->with(['message' => 'Success add kelas']);
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
        $row = $this->kelas->findOrFail($id);
        return view('admin.modules.kelas.edit', compact('row'));
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
            'nama' => 'required',
            'jurusan_id' => 'required'
        ]);
        
        $row = $this->kelas->findOrFail($id);
        $row->fill($request->all());
        $row->save();

        return redirect()->route('admin.kelas.index')->with(['message' => 'Success edit kelas']);
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
            $this->kelas->whereIn('id', $request->ids)->delete();

            return response()->json(['status' => 'success', 'message' => 'Kelas has been delete'], 200);
        }

        $this->kelas->findOrFail($id)->delete();

        return redirect()->route('admin.kelas.index')->with(['message' => 'Kelas has been delete']);
    }

    /**
     * [data description]
     * @param  Request $request [description]
     * @return [type]           [description]
     */
    public function data(Request $request)
    {
        $rows = $this->kelas->with('jurusan');
        return Datatables::eloquent($rows)
            ->addColumn('action', function($row){
                $btn  = '<a href="'.route('admin.kelas.edit',$row->id).'" class="btn btn-xs btn-success" title="Edit" data-bjax> <i class="icon-pencil"></i> </a>';
                return $btn;
            })
            ->make(true);
    }
}
