<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Category;
use App\Models\Listing;
use App\Models\Gallery;

class ApiController extends Controller
{
    public function home(Request $request){
        $response['categories'] = Category::where('parent_id', 0)
            ->where('status', 'active')
            ->orderBy('id', 'DESC')
            ->take(5)
            ->get()
            ->map(function ($category) {
                $category->image = url($category->image);
                return $category;
            });

        $response['featured_listings'] = Listing::with('listing_images')
            ->where('is_featured', 'yes')
            ->where('status', 'active')
            ->orderBy('id', 'DESC')
            ->take(5)
            ->get()
            ->map(function ($listing) {
                // Add full URL for main_image
                $listing->main_image = 'https://mytownonline.app/mtportal/' . $listing->main_image;
                
                // Add full URL for each listing image
                $listing->listing_images->each(function ($image) {
                    $image->image = 'https://mytownonline.app/mtportal/' . $image->image;
                });
                
                return $listing;
            });

        $response['special_offers'] = Listing::with('listing_images')
            ->where('has_special', 'yes')
            ->where('status', 'active')
            ->orderBy('id', 'DESC')
            ->take(5)
            ->get()
            ->map(function ($listing) {
                // Add full URL for main_image
                $listing->main_image = 'https://mytownonline.app/mtportal/' . $listing->main_image;
                
                // Add full URL for each listing image
                $listing->listing_images->each(function ($image) {
                    $image->image = 'https://mytownonline.app/mtportal/' . $image->image;
                });
                
                return $listing;
            });
            
        return response($response, 200);
    }
}
