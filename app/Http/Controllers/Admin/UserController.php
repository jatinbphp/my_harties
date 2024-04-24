<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Admin;
use App\Models\User;
use DataTables;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class UserController extends Controller
{
    public function index(Request $request)
    {
        $data['menu'] = "User";
        $data['search'] = $request['search'];

        if ($request->ajax()) {
            $data = User::where('id', '!=', Auth::user()->id)->where('role','!=','admin')->select();

            return Datatables::of($data)
                ->addIndexColumn()
                ->addColumn('action', function ($row) {
                    $records['row'] = $row;
                    return view('admin.users.action',$records);
                })
                ->rawColumns(['action'])
                ->make(true);
        }

        return view('admin.users.index', $data);
    }

    public function create()
    {
        $data['menu'] = "User";
        return view("admin.users.create",$data);
    }

    public function store(Request $request)
    {
        $this->validate($request, [
            'name' => 'required',
            'email' => 'required|email|unique:users',
            'password' => 'confirmed|min:6',
            'phone' =>'required|numeric',
            'status' => 'required',
        ]);

        $input = $request->all();
        $input['role'] = 'user';
        $user = User::create($input);

        \Session::flash('success', 'User has been inserted successfully!');
        return redirect()->route('users.index');
    }

    public function show($id)
    {
        //
    }

    public function edit($id)
    {
        $data['menu'] = "User";
        $data['user'] = User::where('id',$id)->first();
        return view('admin.users.edit',$data);
    }

    public function update(Request $request, $id)
    {
        $this->validate($request, [
            'name' => 'required',
            'email' => 'required|email|unique:users,email,'.$id.',id',
            'password' => 'confirmed|nullable|min:6',
            'phone' =>'required|numeric',
            'status' => 'required',
        ]);

        if(empty($request['password'])){
            unset($request['password']);
        }

        $input = $request->all();
        $user = User::findorFail($id);
        $user->update($input);

        \Session::flash('success','User has been updated successfully!');
        return redirect()->route('users.index');
    }

    public function destroy($id)
    {
        $users = User::findOrFail($id);
        if(!empty($users)){
            $users->delete();
            return 1;
        }else{
            return 0;
        }
    }

    public function assign(Request $request){
        $customer = User::findorFail($request['id']);
        $customer['status'] = "active";
        $customer->update($request->all());
    }

    public function unassign(Request $request){
        $customer = User::findorFail($request['id']);
        $customer['status'] = "inactive";
        $customer->update($request->all());
    }
}
