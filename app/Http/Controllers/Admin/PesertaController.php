<?php

namespace App\Http\Controllers\Admin;

use App\DataGrid\Facades\Datatables;
use App\Entities\User;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Intervention\Image\Facades\Image;
use Maatwebsite\Excel\Facades\Excel;

class PesertaController extends Controller
{   
    protected $peserta;

    /**
     * [__construct description]
     * @param User $peserta [description]
     */
    public function __construct(User $peserta)
    {   
        config(['site.menu' => 'peserta']);
        $this->peserta = $peserta;
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return view('admin.modules.peserta.index');
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('admin.modules.peserta.create');
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
            'name' => 'required',
            'username' => 'required',
            'password' => 'required',
            'kelas_id' => 'required'
        ]);

        $request->request->add(['password_text' => $request->password]);
        $request->request->add(['password' => bcrypt($request->password)]);
        $this->peserta->create($request->all());
        return redirect()->route('admin.peserta.index')->with(['message' => 'Success add peserta']);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {   
        $row = $this->peserta->findOrFail($id);
        return view('admin.modules.peserta.show', compact('row'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {   
        $row = $this->peserta->findOrFail($id);
        return view('admin.modules.peserta.edit', compact('row'));
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
            'name' => 'required',
            'username' => 'required',
            'kelas_id' => 'required'
        ]);

        if($request->has('password') && !empty($request->password)){
            $request->request->add(['password_text' => $request->password]);
            $request->request->add(['password' => bcrypt($request->password)]);
        }else{
            $request->request->remove('password');
        }

        $this->peserta->find($id)->update($request->all());

        return redirect()->route('admin.peserta.index')->with(['message' => 'Success add peserta']);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id, Request $request)
    {
        $row = $this->peserta;
        if($request->ajax()){
            $row->whereIn('id', $request->ids)->delete();
            return response()->json(['status' => 'success'], 200);
        }
        $row->find($id)->delete();

        return redirect()->route('admin.peserta.index');
    }

    /**
     * [data description]
     * @param  Request $request [description]
     * @return [type]           [description]
     */
    public function data(Request $request)
    {   
        $rows = $this->peserta->with('kelas');
        return Datatables::eloquent($rows)
            ->editColumn('gender', function($row){
                return ($row->gender == 'L')? 'Laki-laki' : 'Perempuan';
            })
            ->addColumn('action', function($row){
                $btn  = '<a href="'.route('admin.peserta.edit',$row->id).'" class="btn btn-xs btn-success" title="Edit" data-bjax> <i class="icon-pencil"></i> </a>';
                $btn .= '<a href="'.route('admin.peserta.show', $row->id).'" data-toggle="ajaxModal" class="btn btn-xs btn-primary" title="Lihat Password"><i class="icon-eye"></i></a>';
                return $btn;
            })
            ->make(true);
    }

    public function foto(Request $request)
    {   
        if($request->hasFile('img') && $request->file('img')->isValid()){

            list($width, $height) = getimagesize($request->img->path());
            
            $filename = str_random(10) . '.' . $request->img->extension();
            $path = $request->img->storeAs('public/photo', $filename);

            return response()->json([
                'status'    => 'success',
                'url'       => url('storage/photo/'.$filename),
                'width'     => $width,
                'height'    => $height,
            ],200);
        }

        return response()->json([
            'status'    => 'error',
            'message'   => 'ops.. error upload'
        ], 200);
    }

    public function fotoCrop(Request $request)
    {   
        $filename = $filename = str_random(10) . '_'. $request->cropW. 'x' .$request->cropH . '.png';
        $img = Image::make($request->imgUrl);
        $img->resize($request->imgW, $request->imgH);
        $img->crop($request->cropW, $request->cropH, $request->imgX1 ,$request->imgY1);
        $img->save(storage_path('app/public/photo/'.$filename), 80);

        return response()->json([
            'status' =>'success',
            'url' =>  url('storage/photo/'. $filename)
        ], 200);
    }

    // upload & download
    
    public function upload()
    {
        return view('admin.modules.peserta.upload');     
    } 

    public function uploadPost(Request $request)
    {
        if($request->hasFile('file') && $request->file('file')->isValid()){
            
            $kelas_id   = $request->kelas_id;
            $file       = $request->file;

            $data = [];
            $password = '123456';
            $password_hash = bcrypt($password);
            foreach (Excel::load($file)->toObject() as $row) {
                $data[] = [
                    'name' => $row->nama,
                    'username' => $row->username,
                    'nis' => $row->nis,
                    'tgl_lahir' => $row->tanggal_lahir,
                    'gender' => $row->jenis_kelamin,
                    'password_text' => $password,
                    'password' => $password_hash,
                    'kelas_id' => $kelas_id,
                    'created_at' => date('Y-m-d H:i:s'),
                    'updated_at' => date('Y-m-d H:i:s')
                ];
            }

            $this->peserta->insert($data);

            return redirect()->route('admin.peserta.index')->with(['message' => 'File upload success']);
        }

        return redirect()->route('admin.peserta.index')->withError(['message' => 'File No valid']);
    }
    
    public function generate(Request $request)
    {
        $setting = \App\Entities\Setting::first();

        $jml_ruang = $setting->jumlah_ruang;
        $jml_unit  = $setting->jumlah_unit;

        $peserta = $this->peserta->get();
        $no = 1;
        $ruang = 1;
        $sesi = 1;
        foreach ($peserta as $row) {
            $row->nomor = $no++;
            $row->ruang = $ruang;
            $row->sesi  = $sesi;
            $row->save();

            if($no > $jml_unit){
                $no = 1;
                $ruang++;
            }

            if($ruang > $jml_ruang){
                $ruang = 1;
                $sesi++;
            }
        }

        return response()->json(['status' => 'success', 'message' => 'berhasil'], 200);
    }

    /**
     * Catak Daftar Hadir Perserta
     * @return response view
     */
    public function daftarHadir()
    {   
        config(['site.menu' => 'print']);
        config(['site.submenu' => 'daftarhadir']);
        return view('admin.modules.peserta.daftarhadir');
    }

    public function daftarHadirPrint()
    {
        $peserta = $this->peserta;
        $setting = \App\Entities\Setting::first();
        return view('admin.print.daftarhadir', compact('peserta', 'setting'));
    }

    public function kartu()
    {   
        config(['site.menu' => 'print']);
        config(['site.submenu' => 'kartuperserta']);
        return view('admin.modules.peserta.kartu');
    }

    public function kartuPrint()
    {
        $peserta = $this->peserta;
        $setting = \App\Entities\Setting::first();
        return view('admin.print.kartu', compact('peserta', 'setting'));
    }
}
