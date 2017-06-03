<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class RekapController extends Controller
{
    protected $ujian;
    public function __construct(Ujian $ujian)
    {
        $this->ujian = $ujian;
    }
}
