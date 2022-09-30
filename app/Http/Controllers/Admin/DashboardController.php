<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\WeeklyData;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class DashboardController extends Controller
{
    public function index(){
    $deparment_id=Auth::user()->department;
    $count=WeeklyData::where([['department_id',$deparment_id],['status',0]])->count();
   
        return view('admin.dashboard',compact('count'));
    }
}
