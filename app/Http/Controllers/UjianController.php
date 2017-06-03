<?php

namespace App\Http\Controllers;

use App\Entities\PaketSoal;
use App\Entities\Soal;
use App\Entities\Ujian;
use App\Entities\UjianSiswa;
use App\Entities\UjianSiswaDetail;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class UjianController extends Controller
{   
    protected $ujian;
    protected $paket;
    protected $soal;
    protected $ujiansiswa;
    protected $ujiandetail;

    public function __construct(
        Ujian $ujian, 
        PaketSoal $paket, 
        Soal $soal, 
        UjianSiswa $ujiansiswa, 
        UjianSiswaDetail $ujiandetail
    ){
        $this->ujian = $ujian;
        $this->paket = $paket;
        $this->soal = $soal;
        $this->ujiansiswa = $ujiansiswa;
        $this->ujiandetail = $ujiandetail;
    }

    public function index($id, Request $request)
    {   
        $user = Auth::user();

        $row = $this->ujiansiswa->where('ujian_id', $id)->where('user_id', $user->id)->where('status', 1)->first(); 

        if($row){
            
            if($this->endTime($row->id)) return redirect()->to('/');

            $number = $request->get('no', 1);
            $soals = collect($row->soals);
            $soal = $soals->forPage($number, 1);
            return view('ujian', compact('row', 'soals', 'soal', 'number'));
        }else{
            return redirect()->to('/');
        }
        
    }

    public function show($id, $no)
    {
        $user = Auth::user();

        $row = $this->ujiansiswa->where('ujian_id', $id)->where('user_id', $user->id)->where('status', 1)->first(); 
                
        if($row){

            if($this->endTime($row->id)) return redirect()->to('/');

            $number = $no;
            $soals = collect($row->soals);
            $soal = $soals->forPage($number, 1);
            return view('ujian', compact('row', 'soals', 'soal', 'number'));
        }else{
            return redirect()->to('/');
        }
    }

    public function informasi(Request $request)
    {
        $this->validate($request, ['token' => 'required|exists:ujians']);
        $token = $request->token;
        $row = $this->ujian->whereToken($token)->firstOrFail();
        
        $open = true;
        $user = Auth::user();

        $ujiansiswa = $this->ujiansiswa->where('ujian_id', $row->id)->where('user_id', $user->id)->first();
        if($ujiansiswa && $ujiansiswa->status != 0){
            $open = false;
        }
        return view('konfrim', compact('row', 'open'));
    }

    public function mulai(Request $request)
    {
        $this->validate($request, ['id' => 'required|exists:ujians']);
        $user = Auth::user();

        $ujian = $this->ujian->findOrFail($request->id);
        $last = $this->ujiansiswa->where('user_id', $user->id)->where('ujian_id', $ujian->id)->first();

        if(! $last)
        {
            $paket  = $ujian->paket;
            // Soal PG 
            $soalPaket = $this->soal->whereIn('id', $paket->soal)->orderBy('type')->limit($ujian->jumlah_soal);
            if($ujian->soal_acak){
                $soalPaket = $soalPaket->inRandomOrder();
            }
            $soalPaket = $soalPaket->get();

            $soals = [];
            $no=1;
            foreach ($soalPaket as $row) {
                $opsi = null;
                if($row->type==0)
                {
                    $opsi = $row->opsi;
                    if($ujian->opsi_acak){
                        $opsi = acak_opsi($opsi);
                    }
                }
                $soals[$no++] = [
                    'id' => $row->id,
                    'opsi'  => $opsi
                ];
            }
            
            $last = $this->ujiansiswa->create([
                'ujian_id'  => $ujian->id,
                'user_id'   => $user->id,
                'ip'        => $request->ip(),
                'soals'     => $soals,
                'status'    => 0,
                'last_submit' => Carbon::now(),
                'lose_time' => 0,
            ]);
        }
        if($last->status == 0){
            $last->status = 1;
            $last->save();
            return redirect()->route('ujian', $ujian->id);
        }
        return redirect()->to('/')->withErrors(['message' => 'Anda tercatat sedang mengerjakan soal. pastikan anda tidak login ditempat lain']);
    }

    public function jawab(Request $request)
    {
        $row = $this->ujiansiswa->find($request->ujian_id);
        if($request->has('jawaban')){
            $row->soal()->syncWithoutDetaching([
                $request->soal_id => [
                    'jawaban_text' => $request->get('jawaban', null),
                    'waktu_jawab' => Carbon::now(),
                    'status' => $request->get('status', 1)
                ]
            ]);
        }else{
            $row->soal()->syncWithoutDetaching([
                $request->soal_id => [
                    'jawaban' => $request->get('opsi_id', null),
                    'jawaban_text' => $request->get('opsi', null),
                    'waktu_jawab' => Carbon::now(),
                    'status' => $request->get('status', 1)
                ]
            ]);
        }

        $row->save();

        return response()->json([
            'success' => true
        ], 200);
    }

    public function setStatus(Request $request)
    {
        $row = $this->ujiandetail->where('ujian_siswa_id', $request->ujian_id)
                ->where('soal_id', $request->soal_id)
                ->first();

        $row->status = ($request->state == 'true')? 2: 1;
        $row->save();

        return response()->json([
            'success' => true
        ], 200);
    }

    public function finish($id)
    {   
        $row = $this->ujian->find($id);

        $user = Auth::user();
        $ujian = $this->ujiansiswa->where('ujian_id',$row->id)->where('user_id', $user->id)->firstOrFail();
        try {
            $ujian->status = 2;
            $ujian->save();
            return redirect('/');
        } catch (\Exception $e) {
            return view('finish', compact('row'));
        }
    }

    protected function endTime($id)
    {
        $row = $this->ujiansiswa->findOrFail($id);
        $lama_waktu = $row->ujian->lama_waktu;
        $bataswaktu = $row->created_at->addMinutes($lama_waktu);
        if($bataswaktu < Carbon::now()){
            return true;
        }
        return false;
    }
}
