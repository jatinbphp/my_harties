<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Emergencies;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class EmergenciesController extends Controller
{
    public function edit($id)
    {
        $data['menu']="Emergencies";
        $data['emergencies'] = Emergencies::findorFail($id);
        return view('admin.emergencies.edit',$data);
    }

    public function update(Request $request, $id)
    {
        $this->validate($request, [
            'description' => 'required',
        ]);

        $input = $request->all();
        $emergencies = Emergencies::findorFail($id);
        $emergencies->update($input);
        \Session::flash('success','Emergencies has been updated successfully!');
        return redirect()->back();
    }
}
