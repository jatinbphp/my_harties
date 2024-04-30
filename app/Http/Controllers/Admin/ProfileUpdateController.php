<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class ProfileUpdateController extends Controller
{
    public function index()
    {
        //
    }

    public function create()
    {
        //
    }

    public function store(Request $request)
    {
        //
    }

    public function show($id)
    {
        //
    }

    public function edit($id)
    {
        $data['menu']="User";
        $data['user'] = User::findorFail($id);
        return view('admin.users.profile_edit',$data);
    }

    public function update(Request $request, $id)
    {
        $this->validate($request, [
            'name' => 'required',
            'email' => 'required|email|unique:users,email,'.$id.',id',
            'password' => 'confirmed',
        ]);

        if(empty($request['password'])){
            unset($request['password']);
        }

        $input = $request->all();
        $user = User::findorFail($id);
        $user->update($input);
        \Session::flash('success','Profile has been updated successfully!');
        return redirect('admin/profile_update/'.$id."/edit");
    }

    public function destroy($id)
    {
        //
    }
}
