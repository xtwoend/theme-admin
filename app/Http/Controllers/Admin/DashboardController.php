<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class DashboardController extends Controller
{   
    /**
     * [__construct description]
     */
    public function __construct()
    {
        config(['site.menu' => 'dashboard']);
    }

    /**
     * [index description]
     * @return [type] [description]
     */
    public function index()
    {
        return view('admin.dashboard.index');
    }
}
