<?php

namespace App\Http\Controllers;

use App\Entities\Ujian;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class HomeController extends Controller
{
    protected $ujian;

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct(Ujian $ujian)
    {
        $this->middleware('auth');
        $this->ujian = $ujian;
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $row = Auth::user();
        $ujian = $this->ujian->noExpired()->active()->get();
        
        

        return view('home', compact('row', 'ujian'));
    }
}
