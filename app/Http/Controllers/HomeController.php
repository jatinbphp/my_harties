<?php

namespace App\Http\Controllers;
use App\Models\Listing;

class HomeController extends Controller
{
    public function index(string $id){
    	$data['listing'] = Listing::with('listing_images')->findOrFail($id);
    	return view('listing-details',$data);
    }
}
