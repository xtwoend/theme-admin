<?php

namespace App\Http\Controllers\Admin;

use App\Entities\Ujian;
use App\Entities\UjianSiswa;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class UnlockController extends Controller
{
    protected $ujian;
    protected $ujiansiswa;

    public function __construct(Ujian $ujian, UjianSiswa $ujiansiswa)
    {   
        config(['site.menu' => 'unlock']);
        $this->ujian = $ujian;
        $this->ujiansiswa = $ujiansiswa;
    }

    public function index(Request $request)
    {
        $ujian_active = $this->ujian->where('status', 1)->pluck('id')->toArray();
        $rows = $this->ujiansiswa->whereIn('ujian_id', $ujian_active)->get();

        return view('admin.modules.unlock.index', compact('rows'));
    }

    public function unlock($id)
    {
        try {
            $row = $this->ujiansiswa->findOrFail($id);
            $row->status = 0;
            $row->save();
            return redirect()->route('admin.status.index')->with(['message' => 'Peserta berhasil di unlock']);
        } catch (\Exception $e) {
            return redirect()->route('admin.status.index')->withErrors(['message' => 'Ops.. peserta tidak bisa di unlock']);
        }
    }
}
