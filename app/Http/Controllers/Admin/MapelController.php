<?php

namespace App\Http\Controllers\Admin;

use App\DataGrid\Facades\Datatables;
use App\Entities\Mapel;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class MapelController extends Controller
{
    protected $mapel;

    public function __construct(Mapel $mapel)
    {   
        config(['site.menu' => 'mapel']);
        $this->mapel = $mapel;
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return view('admin.modules.mapel.index');
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('admin.modules.mapel.create');
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

        $this->mapel->create($request->all());
        return redirect()->route('admin.mapel.index')->with(['message' => 'Success add mapel']);
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
        $row = $this->mapel->findOrFail($id);
        return view('admin.modules.mapel.edit', compact('row'));
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

        $row = $this->mapel->findOrFail($id);
        $row->fill($request->all());
        $row->save();

        return redirect()->route('admin.mapel.index')->with(['message' => 'Success edit mapel']);
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
            $this->mapel->whereIn('id', $request->ids)->delete();

            return response()->json(['status' => 'success', 'message' => 'mapel has been delete'], 200);
        }

        $this->mapel->findOrFail($id)->delete();

        return redirect()->route('admin.mapel.index')->with(['message' => 'mapel has been delete']);
    }

    /**
     * [data description]
     * @param  Request $request [description]
     * @return [type]           [description]
     */
    public function data(Request $request)
    {
        $rows = $this->mapel->select('*');
        return Datatables::eloquent($rows)
            ->addColumn('action', function($row){
                $btn  = '<a href="'.route('admin.mapel.edit',$row->id).'" class="btn btn-xs btn-success" title="Edit" data-bjax> <i class="icon-pencil"></i> </a>';
                return $btn;
            })
            ->make(true);
    }
}
