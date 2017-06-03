<?php

namespace App\Http\Controllers\Admin;

use App\DataGrid\Facades\Datatables;
use App\Entities\PaketSoal;
use App\Entities\Ujian;
use App\Entities\UjianSiswa;
use App\Entities\UjianSiswaDetail;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Maatwebsite\Excel\Facades\Excel;

class LaporanController extends Controller
{
    protected $ujian;
    protected $ujiansiswa;
    protected $ujiansiswadetail;
    protected $paketsoal;

    public function __construct(
        Ujian $ujian, 
        UjianSiswa $ujiansiswa, 
        UjianSiswaDetail $ujiansiswadetail, 
        PaketSoal $paketsoal
    ){
        $this->ujian = $ujian;
        $this->ujiansiswa = $ujiansiswa;
        $this->ujiansiswadetail = $ujiansiswadetail;
        $this->paketsoal = $paketsoal;
        config(['site.menu' => 'laporan']);
    }

    public function index()
    {
        return view('admin.modules.laporan.index');
    }

    public function show($id)
    {
        $row = $this->ujiansiswa->find($id);
        return view('admin.modules.laporan.show', compact('row'));
    }

    public function data(Request $request)
    {
        $rows = $this->ujiansiswa->with(['user', 'ujian.paket'])->select('*');
        if($request->has('ujian_id')){
            $rows = $rows->where('ujian_id', $request->ujian_id);
        }
        return Datatables::eloquent($rows)
            ->editColumn('status', function($row){
                $status = ['Belum Ujian', 'Sedang Ujian', 'Selesai', 'Sudah di koreksi'];

                return $status[$row->status]?? 'Belum Ujian';
            })

            ->addColumn('action', function($row){
                $btn  = '<a href="'.route('admin.laporan.show', $row->id).'" class="btn btn-xs btn-success" title="Lihat Detail" data-bjax>Lihat Detail</a>';
                return $btn;
            })
            ->make(true);
    }

    public function koreksi(Request $request)
    {
        $time = microtime(true);

        $rows = $this->ujiansiswa->where('status', 2)->get();

        // update jawaban siswa dengan kunci jawaban
        DB::update('update ujian_siswa_details a join soals b on a.soal_id = b.id set a.kunci = b.kunci, a.nilai = if(a.jawaban = b.kunci, 1, 0), a.status=2 where b.kunci IS NOT NULL and a.status=1');

        // hitung jawaban yang benar dan salah
        foreach ($rows as $row) {
            
            $jumlah_pg = $row->ujian->soal_pg;
            $row->benar = $this->ujiansiswadetail->where('ujian_siswa_id', $row->id)->where('nilai', 1)->count();
            $row->salah = $this->ujiansiswadetail->where('ujian_siswa_id', $row->id)->where('nilai', 0)->count();
            $row->kosong = $jumlah_pg - ($row->benar + $row->salah);
            $row->save();
        }

        $ex_time = (microtime(true) - $time);
        return response()->json([
            'success' => true,
            'message' => 'Ujian Berhasil di koreksi',
            'time'    => $ex_time,
        ], 200);
    }

    public function download(Request $request)
    {
        $rows = $this->ujiansiswa->with(['user', 'ujian.paket'])->select('*');
        if($request->has('ujian_id')){
            $rows = $rows->where('ujian_id', $request->ujian_id);
        }
        $rows = $rows->get();

        return Excel::create('Export Hasil Ujian', function($excel) use ($rows) {

            $excel->sheet('New sheet', function($sheet) use ($rows) {

                $sheet->loadView('admin.export.hasilujian', compact('rows'));

            });

        })->export('xls');
    }
}
