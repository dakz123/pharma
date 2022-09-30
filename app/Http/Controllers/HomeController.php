<?php

namespace App\Http\Controllers;

use App\Models\WeeklyData;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Validator;

class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    // public function __construct()
    // {
    //     $this->middleware('auth');
    // }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index()
    {
        $id = Auth::user()->id;
        $datas = WeeklyData::where('user_id', $id)->orderBy('id', 'desc')->paginate(5);
        return view('home', compact('datas'));
    }
    public function create(Request $request)
    {

        if ($request->ajax()) {
            $id = Auth::user()->id;
            $datas = WeeklyData::where('user_id', $id)->orderBy('id', 'desc')->paginate(5);
            return view('pagination', compact('datas'))->render();
        }
    }
    public function store(Request $request)
    {

        $validation = Validator::make($request->all(), [
            'data' => 'required',
            'file' => 'required|image|mimes:jpeg,png,jpg,gif,pdf,svg|max:2048',
        ]);
        if ($validation->passes()) {
            $user_id = Auth::user()->id;
            $department_id = Auth::user()->department;
            $image = $request->file('file');
            $new_name = time() . '.' . $image->getClientOriginalExtension();
            $location_name = 'images/' . $new_name;
            $path = $image->move(public_path('images'), $new_name);
            $data = new WeeklyData();
            $data->user_id = $user_id;
            $data->data = $request->input('data');
            $data->image = $location_name;
            $data->department_id = $department_id;
            $data->save();
            return response()->json([
                'success' => true,
                'message'   => 'Data Added Successfully',
                'class_name'  => 'alert-success',

            ]);
        } else {
            return response()->json([
                'message'   => $validation->errors()->all(),
                'class_name'  => 'alert-danger'
            ]);
        }
    }
    public function edit($id)
    {
        $data = WeeklyData::find($id);
        if ($data) {
            return response()->json([
                'success' => true,
                'data' => $data,
                'class_name'  => 'alert-success',
            ]);
        } else {
            return response()->json([
                'success' => false,
                'message' => 'Data Not Found',
                'class_name'  => 'alert-danger'
            ]);
        }
    }
    public function update(Request $request, $id)
    {
        $validation = Validator::make($request->all(), [
            'edit_data' => 'required',



        ]);
        if ($validation->fails()) {
            return response()->json([
                'message'   => $validation->errors()->all(),
                'class_name'  => 'alert-danger'
            ]);
        } else {
            $data = WeeklyData::find($id);
            if ($data) {
                $data->data = $request->input('edit_data');
                if ($request->hasFile('edit_file')) {
                    $path_info = $data->image;
                    if (File::exists($path_info)) {
                        File::delete($path_info);
                    }
                    $image = $request->file('edit_file');
                    $new_name = time() . '.' . $image->getClientOriginalExtension();
                    $location_name = 'images/' . $new_name;
                    $path = $image->move(public_path('images'), $new_name);
                    $data->image = $location_name;
                }
                $data->save();
                return response()->json([
                    'message'   => 'Data Updated Successfully',
                    'class_name'  => 'alert-success'
                ]);
            } else {
                return response()->json([
                    'success' => true,
                    'class_name'  => 'alert-danger',
                ]);
            }
        }
    }
    public function destroy($id)
    {
        $data = WeeklyData::find($id);
        $data->delete();
        return response()->json([
            'success' => true,
            'message' => 'Data Deleted Successfully',
            'class_name'  => 'alert-success',
        ]);
    }
}
