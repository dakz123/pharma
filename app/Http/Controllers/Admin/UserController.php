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

        $department_id = Auth::user()->department;
        $searchKey = $request->input('search');
        if ($searchKey != "") {
            $data = WeeklyData::where('department_id', $department_id)
                ->whereHas('user', function ($query) use ($searchKey) {
                    $query->where('name', "like", "%" . $searchKey . "%");
                })
                ->with('user')
                ->orderBy('id', 'desc')
                ->paginate(5);
            return view('admin.user.index', compact('data'));
        } else {
            $data = WeeklyData::where('department_id', $department_id)->with('user')->orderBy('id', 'desc')->paginate(5);
            return view('admin.user.index', compact('data'));
        }
    }

    public function update(Request $request, $id)
    {
        dd($id);
        $data = WeeklyData::find($id);
        $data->status = 1;
        $data->save();
        return response()->json([
            'status' => 200,
            'message' => ' Approved.',
        ]);
    }
}
