<?php

namespace App\Http\Controllers\Admin;

use App\DataGrid\Facades\Datatables;
use App\Entities\Jurusan;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class JurusanController extends Controller
{
    protected $jurusan;

    public function __construct(Jurusan $jurusan)
    {   
        config(['site.menu' => 'jurusan']);
        $this->jurusan = $jurusan;
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return view('admin.modules.jurusan.index');
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('admin.modules.jurusan.create');
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
            'nama' => 'required'
        ]);

        $this->jurusan->create($request->all());
        return redirect()->route('admin.jurusan.index')->with(['message' => 'Success add jurusan']);
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
        $row = $this->jurusan->findOrFail($id);
        return view('admin.modules.jurusan.edit', compact('row'));
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
            'nama' => 'required'
        ]);
        
        $row = $this->jurusan->findOrFail($id);
        $row->fill($request->all());
        $row->save();

        return redirect()->route('admin.jurusan.index')->with(['message' => 'Success edit jurusan']);
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
            $this->jurusan->whereIn('id', $request->ids)->delete();

            return response()->json(['status' => 'success', 'message' => 'Jurusan has been delete'], 200);
        }

        $this->jurusan->findOrFail($id)->delete();

        return redirect()->route('admin.jurusan.index')->with(['message' => 'Jurusan has been delete']);
    }

    /**
     * [data description]
     * @param  Request $request [description]
     * @return [type]           [description]
     */
    public function data(Request $request)
    {
        $rows = $this->jurusan->select('*');
        return Datatables::eloquent($rows)
            ->addColumn('action', function($row){
                $btn  = '<a href="'.route('admin.jurusan.edit',$row->id).'" class="btn btn-xs btn-success" title="Edit" data-bjax> <i class="icon-pencil"></i> </a>';
                return $btn;
            })
            ->make(true);
    }
}
