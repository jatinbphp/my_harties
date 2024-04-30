<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Category;
use App\Models\Listing;
use App\Models\Gallery;
use Illuminate\Support\Facades\Validator;

class ApiController extends Controller
{
    public function home(Request $request){
        $response['categories'] = Category::select('id', 'name', 'image')->where('parent_id', 0)
            ->where('status', 'active')
            ->where('section','my_harties')
            ->orderBy('id', 'DESC')
            ->take(5)
            ->get()
            ->map(function ($category) {
                $category->image = url($category->image);
                return $category;
            });

        $response['featured_listings'] = Listing::with('listing_images', 'Category', 'SubCategory')
            ->where('is_featured', 'yes')
            ->where('section','my_harties')
            ->where('status', 'active')
            ->orderBy('id', 'DESC')
            ->take(5)
            ->get()
            ->map(function ($listing) {
                // Add full URL for main_image
                $listing->main_image = url($listing->main_image);
                
                // Add full URL for each listing image
                $listing->listing_images->each(function ($image) {
                    $image->image = url($image->image);
                });
                
                return $listing;
            });

        $response['special_offers'] = Listing::with('listing_images', 'Category', 'SubCategory')
            ->where('has_special', 'yes')
            ->where('section','my_harties')
            ->where('status', 'active')
            ->orderBy('id', 'DESC')
            ->take(5)
            ->get()
            ->map(function ($listing) {
                // Add full URL for main_image
                $listing->main_image = url($listing->main_image);
                
                // Add full URL for each listing image
                $listing->listing_images->each(function ($image) {
                    $image->image = url($image->image);
                });
                
                return $listing;
            });
            
        return response($response, 200);
    }

    public function getSubCategoriesById(Request $request){
        try{

            $validator = Validator::make($request->post(), [
                'category_id' => 'required',
            ]);

            if ($validator->fails()) {
                return response(['status' => false, 'message' => implode(',', $validator->errors()->all())], 404);
            }
            
            $parent_category = Category::where('status', 'active')->where('parent_id', 0)->where('section','my_harties')->where('id', $request['category_id'])->first();
            if(empty($parent_category)){
                return response(['status' => false, 'message' => 'No Record Found'], 404);
            }

            $sub_categories = Category::select('id', 'name', 'image')->where('parent_id', $request['category_id'])
                ->where('status', 'active')
                ->orderBy('id', 'DESC')
                ->get()
                ->map(function ($category) {
                    $category->image = url($category->image);
                    return $category;
                });

            if (empty($sub_categories)) {
                return response(['status' => false, 'message' => 'No Record Found'], 404);
            }

            return response(['status' => true, 'data' => $sub_categories], 200);

        } catch (Exception $e) {
            return $this->respond(['status' => false, 'message' => 'Oops, something went wrong. Please try again.'], 500);
        }
    }

    public function getServices(Request $request){
        $services = Category::select('id', 'name', 'image')->where('parent_id', 0)
            ->where('status', 'active')
            ->where('section','harties_services')
            ->orderBy('id', 'DESC')
            ->get()
            ->map(function ($category) {
                $category->image = url($category->image);
                return $category;
            });

        if (empty($services)) {
            return response(['status' => false, 'message' => 'No Record Found'], 404);
        }
        
        return response(['status' => true, 'data' => $services], 200);
    }

    public function getListings(Request $request){
        try{

            $listings = Listing::with('listing_images', 'Category', 'SubCategory')->where('status', 'active');

            if (!empty($request['section'])) {
                $listings->where('section', $request['section']);
            }

            if (!empty($request['category'])) {
                $listings->where('category', $request['category']);
            }

            if (!empty($request['sub_category'])) {
                $listings->where('sub_category', $request['sub_category']);
            }

            $listings = $listings->orderBy('id', 'DESC')
                ->get()
                ->map(function ($listing) {
                    // Add full URL for main_image
                    $listing->main_image = url($listing->main_image);
                    
                    // Add full URL for each listing image
                    $listing->listing_images->each(function ($image) {
                        $image->image = url($image->image);
                    });
                    
                    return $listing;
                });


            if (empty($listings)) {
                return response(['status' => false, 'message' => 'No Record Found'], 404);
            }

            return response(['status' => true, 'data' => $listings], 200);

        } catch (Exception $e) {
            return $this->respond(['status' => false, 'message' => 'Oops, something went wrong. Please try again.'], 500);
        }
    }

    public function getListingDetails(Request $request){
        try{

            $validator = Validator::make($request->post(), [
                'listing_id' => 'required',
            ]);

            if ($validator->fails()) {
                return response(['status' => false, 'message' => implode(',', $validator->errors()->all())], 404);
            }
            
            $listing_details = Listing::with('listing_images', 'Category', 'SubCategory')
                ->where('status', 'active')
                ->where('id', $request['listing_id'])
                ->get()
                ->map(function ($listing) {
                    // Add full URL for main_image
                    $listing->main_image = url($listing->main_image);
                    
                    // Add full URL for each listing image
                    $listing->listing_images->each(function ($image) {
                        $image->image = url($image->image);
                    });
                    
                    return $listing;
                });

            if(empty($listing_details)){
                return response(['status' => false, 'message' => 'No Record Found'], 404);
            }

            return response(['status' => true, 'data' => $listing_details], 200);

        } catch (Exception $e) {
            return $this->respond(['status' => false, 'message' => 'Oops, something went wrong. Please try again.'], 500);
        }
    }
}
