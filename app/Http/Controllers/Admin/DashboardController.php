<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Category;
use Carbon\Carbon;
use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Facades\Auth;

class DashboardController extends Controller
{
    public function __construct(){
        $this->middleware('auth');
    }

    public function index(){
        $data['menu'] = 'Dashboard';
        $data['category'] = Category::where('section','my_harties')->where('parent_id',0)->count();
        $data['services'] = Category::where('section','harties_services')->count();
        return view('admin.dashboard',$data);
    }
}
