<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Category;
use App\Models\Listing;
use App\Models\Gallery;
use App\Models\ContactUs;
use App\Models\Emergencies;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\DB;

class ApiController extends Controller
{
    public function home(Request $request){
        $response['categories'] = Category::select('id', 'name', 'image')->where('parent_id', 0)
            ->where('status', 'active')
            ->where('is_featured', 'yes')
            ->where('section','my_harties')
            ->orderBy('name', 'ASC')
            ->take(5)
            ->get()
            ->map(function ($category) {
                $category->image = url($category->image);
                $category->has_subcategories = Category::where('parent_id', $category->id)->exists();
                return $category;
            });

       


        $response['featured_listings'] = Listing::with('listing_images', 'Category', 'SubCategory')
            ->where('is_featured', 'yes')
            ->where('section','my_harties')
            ->where('status', 'active')
            ->inRandomOrder()
            ->take(5)
            ->get()
            ->sortBy('company_name')
            ->map(function ($listing) {
                // Add full URL for main_image
                $listing->main_image = url($listing->main_image);
                
                // Add full URL for each listing image
                $listing->listing_images->each(function ($image) {
                    $image->image = url($image->image);
                });

                // Fetch special instructions from the database
                $specialInstruction = DB::table('special_instruction')
                ->where('listing_id', $listing->id)
                ->inRandomOrder()
                ->first();

                $listing->special_heading = $specialInstruction ? $specialInstruction->special_heading : null;
                $listing->special_description = $specialInstruction ? $specialInstruction->special_description : null;
                
                return $listing;
            })
            ->values() // Reset keys after sorting
            ->toArray();
            

        $response['special_offers'] = Listing::with('listing_images', 'Category', 'SubCategory')
            ->where('has_special', 'yes')
            ->where('section','my_harties')
            ->where('status', 'active')
            ->inRandomOrder()
            ->orderBy('company_name', 'ASC')
            ->take(5)
            ->get()
            ->map(function ($listing) {
                // Add full URL for main_image
                $listing->main_image = url($listing->main_image);
                
                // Add full URL for each listing image
                $listing->listing_images->each(function ($image) {
                    $image->image = url($image->image);
                });

                // Fetch special instructions from the database
                $specialInstruction = DB::table('special_instruction')
                    ->where('listing_id', $listing->id)
                    ->inRandomOrder()
                    ->first();

                $listing->special_heading = $specialInstruction ? $specialInstruction->special_heading : null;
                $listing->special_description = $specialInstruction ? $specialInstruction->special_description : null;
                
                return $listing;
            });

        $response['additional_info'] = [
            'phone' => env('ADDITIONAL_PHONE'),
            'email' => env('ADDITIONAL_EMAIL'),
            'facebook' => env('ADDITIONAL_FACEBOOK'),
            'instagram' => env('ADDITIONAL_INSTAGRAM'),
            'whatsapp_number' => env('ADDITIONAL_WHATSAPP_NUMBER'),
            'whatsapp_link' => env('ADDITIONAL_WHATSAPP_LINK'),
        ];

        $categoryCounts = $response['categories']->count();
        $catsCount = $categoryCounts;
        if($categoryCounts < 2){
            $catsCount = 1;
        }elseif($categoryCounts > 2 && $categoryCounts < 4){
            $catsCount = 2.3;
        }else{
            $catsCount = 3.3;
        }

        $response['categories_num_for_slides'] = $catsCount;
        $response['featured_listings_num_for_slides'] = 1.2;
        $response['special_offers_num_for_slides'] = 1.2;
            
        return response($response, 200);
    }

    public function home_new(Request $request){
        $data[0]['categories'] = Category::select('id', 'name', 'image')->where('parent_id', 0)
            ->where('status', 'active')
            ->where('is_featured', 'yes')
            ->where('section','my_harties')
            ->orderBy('name', 'ASC')
            ->take(5)
            ->get()
            ->map(function ($category) {
                $category->image = url($category->image);
                return $category;
            });

        $data[0]['featured_listings'] = Listing::with('listing_images', 'Category', 'SubCategory')
            ->where('is_featured', 'yes')
            ->where('section','my_harties')
            ->where('status', 'active')
            ->orderBy('company_name', 'ASC')
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

        $data[0]['special_offers'] = Listing::with('listing_images', 'Category', 'SubCategory')
            ->where('has_special', 'yes')
            ->where('section','my_harties')
            ->where('status', 'active')
            ->orderBy('company_name', 'ASC')
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

        return response(['status' => true, 'data' => $data], 200);
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
                ->orderBy('name', 'ASC')
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
            ->orderBy('name', 'ASC')
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

    public function getCategories(Request $request){
        $services = Category::select('id', 'name', 'image')->where('parent_id', 0)
            ->where('status', 'active')
            ->where('section','my_harties')
            ->orderBy('name', 'ASC')
            ->get()
            ->map(function ($category) {
                $category->image = url($category->image);
                $category->has_subcategories = Category::where('parent_id', $category->id)->exists();
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
                // $listings->where('category', $request['category']);
                $categories = explode(',', $request['category']); // Convert string to array
            
                $listings->where(function ($query) use ($categories) {
                    foreach ($categories as $category) {
                        $query->orWhereRaw("FIND_IN_SET(?, category)", [$category]);
                    }
                });
            }

            if (!empty($request['sub_category'])) {
                $listings->where('sub_category', $request['sub_category']);
            }

            if (!empty($request['search'])) {
                $searchTerm = '%' . $request['search'] . '%';
                $listings->where(function($query) use ($searchTerm) {
                    $query->where('company_name', 'like', $searchTerm)
                          ->orWhere('address', 'like', $searchTerm)
                          ->orWhere('description', 'like', $searchTerm)
                          ->orWhere('telephone_number', 'like', $searchTerm)
                          ->orWhere('email', 'like', $searchTerm)
                          ->orWhere('keywords', 'like', $searchTerm);
                });
            }

            $listings = $listings->orderBy('company_name', 'ASC')
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

            $specialInstructions = DB::table('special_instruction')->where('listing_id', $request['listing_id'])->get();
            
            $listing_details = Listing::with('listing_images', 'Category', 'SubCategory')
                ->where('status', 'active')
                ->where('id', $request['listing_id'])
                ->orderBy('company_name', 'ASC')
                ->get()
                ->map(function ($listing) {
                    // Add full URL for main_image

                    $listing->main_image = url($listing->main_image);

                    $main_images = [url($listing->main_image)];
                    $imageUrls = $listing->listing_images->map(function ($image) {
                        return url($image->image);
                    });
                    $main_images_collection = collect($main_images);
                    $imageUrls = $main_images_collection->merge($imageUrls);
                    $listing->main_images = $imageUrls;

                    /*// Add full URL for each listing image
                    $listing->listing_images->each(function ($image) {
                        $image->image = url($image->image);
                    });*/

                    // Decode the open_hours JSON field
                    $listing->open_hours = json_decode($listing->open_hours);

                    // Fetch special instructions for this listing
                    $specialInstructions = DB::table('special_instruction')
                    ->where('listing_id', $listing->id)
                    ->get();

                    // Attach special instructions to the listing
                    $listing->special_instructions = $specialInstructions;

                    
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

    public function submitContactUs(Request $request){
        try{

            $validator = Validator::make($request->post(), [
                'name' => 'required',
                'contact_number' => 'required',
                'email' => 'required|email',
                'message' => 'required',
            ]);

            if ($validator->fails()) {
                return response(['status' => false, 'message' => implode(',', $validator->errors()->all())], 404);
            }

            $input = $request->all();
            $contact_us = ContactUs::create($input);
            
            if(empty($contact_us)){
                return response(['status' => false, 'message' => 'Oops, something went wrong. Please try again.'], 404);
            }

            $this->sendMail($contact_us, 'New Inquiry','contact_us');

            return response(['status' => true, 'data' => $contact_us], 200);

        } catch (Exception $e) {
            return $this->respond(['status' => false, 'message' => 'Oops, something went wrong. Please try again.'], 500);
        }
    }

    public function submitListYourBusiness(Request $request){
        try{

            $validator = Validator::make($request->post(), [
                'name' => 'required',
                'contact_number' => 'required',
                'email' => 'required|email',
                'company_name' => 'required',
                'message' => 'required',
            ]);

            if ($validator->fails()) {
                return response(['status' => false, 'message' => implode(',', $validator->errors()->all())], 404);
            }

            $input = $request->all();
            $input['type'] = 1;
            $contact_us = ContactUs::create($input);
            
            if(empty($contact_us)){
                return response(['status' => false, 'message' => 'Oops, something went wrong. Please try again.'], 404);
            }

            $this->sendMail($contact_us, 'List Your Business','list_your_business');

            return response(['status' => true, 'data' => $contact_us], 200);

        } catch (Exception $e) {
            return $this->respond(['status' => false, 'message' => 'Oops, something went wrong. Please try again.'], 500);
        }
    }

    public function getEmergencies(Request $request){

        $emergencies = Emergencies::findorFail(1);

        if (empty($emergencies)) {
            return response(['status' => false, 'message' => 'No Record Found'], 404);
        }
        
        return response(['status' => true, 'data' => $emergencies], 200);
    }

    public function searchListings(Request $request){
        try{

            $sections = ['my_harties', 'harties_services'];
            $data = [];

            foreach ($sections as $section) {
                $listings = Listing::with('listing_images', 'Category', 'SubCategory')
                    ->where('status', 'active')
                    ->where('section', $section);

                if (!empty($request->search_value)) {
                    $searchTerm = '%' . $request->search_value . '%';
                    $listings->where(function ($query) use ($searchTerm) {
                        $query->where('company_name', 'like', "%{$searchTerm}%")
                            ->orWhere('address', 'like', "%{$searchTerm}%")
                            ->orWhere('description', 'like', "%{$searchTerm}%")
                            ->orWhere('telephone_number', 'like', "%{$searchTerm}%")
                            ->orWhere('email', 'like', "%{$searchTerm}%")
                            ->orWhere('keywords', 'like', "%{$searchTerm}%");
                    });
                }

                $data[$section] = $listings->orderBy('company_name', 'ASC')
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
            }

            if (empty(array_filter($data))) {
                return response(['status' => false, 'message' => 'No Record Found'], 404);
            }

            return response(['status' => true, 'data' => $data], 200);

        } catch (Exception $e) {
            return $this->respond(['status' => false, 'message' => 'Oops, something went wrong. Please try again.'], 500);
        }
    }
}
