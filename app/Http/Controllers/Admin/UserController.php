<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\WeeklyData;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class UserController extends Controller
{
    public function index(Request $request)
    {
        $department_id = Auth::user()->department;
       
            $data = WeeklyData::where('department_id', $department_id)->with('user')->orderBy('id', 'desc')->paginate(5);
        
        return view('admin.user.index', compact('data'));
    }
    public function create(Request $request)
    {

        if ($request->ajax()) {
            $department_id = Auth::user()->department;
            $searchKey = $request->get('search');
            if ($searchKey != "") {
                $data = WeeklyData::where('department_id', $department_id)
                    ->whereHas('user', function ($query) use ($searchKey) {
                        $query->where('name', "like", "%" . $searchKey . "%");
                    })
                    ->with('user')
                    ->orderBy('id', 'desc')
                    ->paginate(5);
                    return view('admin.user.index', compact('data'))->render();
            } else {
                $data = WeeklyData::where('department_id', $department_id)->with('user')->orderBy('id', 'desc')->paginate(5);
                return view('admin.user.index', compact('data'))->render();
            }
            
        }
    }
    public function update(Request $request, $id)
    {
        $data=WeeklyData::find($id);
        $data->status=1;
        $data->save();
        return response()->json([
            'status'=>200,
            'message'=>' Approved.',
        ]);
    }
    

}
