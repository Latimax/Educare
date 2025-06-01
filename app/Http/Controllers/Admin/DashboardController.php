<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\SchoolInfo;
use Illuminate\Http\Request;

class DashboardController extends Controller
{
    public function index(){

        $schoolinfo = SchoolInfo::first();
        return view('admin.pages.dashboard', compact('schoolinfo'));
    }
}
