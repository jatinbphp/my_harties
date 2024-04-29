<?php

namespace App\Http\Controllers;

use Carbon\Carbon;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Routing\Controller as BaseController;
use Illuminate\Support\Str;

class Controller extends BaseController
{
    use AuthorizesRequests, DispatchesJobs, ValidatesRequests;

    public function fileMove($photo, $path){
        $root = public_path('uploads/'.$path);
        $filename = pathinfo($photo->getClientOriginalName(), PATHINFO_FILENAME);
        $name = $filename."_".date('His',time()).".".$photo->getClientOriginalExtension();
        if (!file_exists($root)) {
            mkdir($root, 0777, true);
        }
        $photo->move($root,$name);
        return 'public/uploads/'.$path."/".$name;
    }
}

