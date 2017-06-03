<?php

namespace App\Http\Controllers\Admin;

use App\DataGrid\Facades\Datatables;
use App\Entities\PaketSoal;
use App\Entities\Soal;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class PaketSoalController extends Controller
{
    protected $paket;
    protected $soal;

    public function __construct(PaketSoal $paket, Soal $soal)
    {   
        config(['site.menu' => 'paket']);
        $this->paket = $paket;
        $this->soal = $soal;
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return view('admin.modules.paket.index');
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('admin.modules.paket.create');
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
            'mapel_id' => 'required',
            'jumlah_soal' => 'required'
        ]);

        $this->paket->create($request->all());
        return redirect()->route('admin.paket.index')->with(['message' => 'Success add paket']);
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
     * [getData description]
     * @param  Request $request [description]
     * @return [type]           [description]
     */
    public function getData(Request $request)
    {
        return $this->paket->where('mapel_id', $request->mapel_id)->pluck('nama', 'id');
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $row = $this->paket->findOrFail($id);
        return view('admin.modules.paket.edit', compact('row'));
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
            'mapel_id' => 'required',
            'jumlah_soal' => 'required'
        ]);
        
        $row = $this->paket->findOrFail($id);
        $row->fill($request->all());
        $row->save();

        return redirect()->route('admin.paket.index')->with(['message' => 'Success edit paket']);
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
            $this->paket->whereIn('id', $request->ids)->delete();

            return response()->json(['status' => 'success', 'message' => 'paket has been delete'], 200);
        }

        $this->paket->findOrFail($id)->delete();

        return redirect()->route('admin.paket.index')->with(['message' => 'paket has been delete']);
    }

    /**
     * [data description]
     * @param  Request $request [description]
     * @return [type]           [description]
     */
    public function data(Request $request)
    {
        $rows = $this->paket->with('mapel');
        return Datatables::eloquent($rows)
            ->addColumn('action', function($row){
                $btn    = '<a href="'.route('admin.paket.edit',$row->id).'" class="btn btn-xs btn-block btn-success" title="Edit" data-bjax> <i class="icon-folder-alt"></i> Tambah Soal </a>';
                // $btn   .= '<a href="'.route('admin.paket.addsoal', $row->id).'" data-toggle="modal" class="btn btn-xs btn-primary" title="Tambah Soal" data-target="#soalModal"><i class="icon-notebook"></i></a>';
                return $btn;
            })
            ->make(true);
    }

    public function addSoal($id)
    {
        $row = $this->paket->findOrFail($id);
        return view('admin.modules.paket.addsoal', compact('row'));
    }

    public function addSoalSubmit($id, Request $request)
    {
        $row = $this->paket->findOrFail($id);
        $ids = (! is_null($row->soal))? $row->soal: [];
        
        $row->soal = array_merge($ids, $request->id);

        $jumlah_pg = $this->soal->whereIn('id', $row->soal)->where('type', 0)->count();
        $jumlah_essay = $this->soal->whereIn('id', $row->soal)->where('type', 1)->count();

        $row->jumlah_soal  = $jumlah_pg + $jumlah_essay;
        $row->soal_pg = $jumlah_pg;
        $row->soal_essay = $jumlah_essay;

        $row->save();

        return response()->json([
            'success' => true
        ], 200);
    }

    public function removeSoal($id, $soal_id)
    {
        $row = $this->paket->findOrFail($id);
        $soalIds = $row->soal;
        if(($key = array_search($soal_id, $soalIds)) !== false) {
            unset($soalIds[$key]);
        }
        
        $jumlah_pg = $this->soal->whereIn('id', $soalIds)->where('type', 0)->count();
        $jumlah_essay = $this->soal->whereIn('id', $soalIds)->where('type', 1)->count();

        $row->jumlah_soal  = $jumlah_pg + $jumlah_essay;
        $row->soal_pg = $jumlah_pg;
        $row->soal_essay = $jumlah_essay;

        $row->soal = $soalIds;
        $row->save();

        return response()->json([
            'success' => true
        ], 200);
    }

    public function dataSoal($id, Request $request)
    {   
        $paket = $this->paket->find($id);
        $ids = (! is_null($paket->soal))? $paket->soal: [];

        $rows = $this->soal->with('mapel')->where('mapel_id', $paket->mapel_id)->whereNotIn('id', $ids)->select('*');
        
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
                // $btn  = '<a href="'.route('admin.soal.edit',$row->id).'" class="btn btn-xs btn-success" title="Edit" data-bjax> <i class="icon-pencil"></i> </a>';
                $btn = '<a href="'.route('admin.soal.show', $row->id).'" data-toggle="ajaxModal" class="btn btn-xs btn-primary" title="Lihat Password"><i class="icon-eye"></i></a>';
                return $btn;
            })
            ->make(true);
    }

    // sum max soal by mapel_id
    public function sum(Request $request)
    {
        $soal = $this->paket->find($request->id);
        return response()->json([
            'max'   => $soal->jumlah_soal,
            'max_pg' => $soal->soal_pg,
            'max_essay' => $soal->soal_essay,
        ], 200);
    }
}
