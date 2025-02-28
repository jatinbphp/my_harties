<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\ListingRequest;
use App\Http\Requests\ListingsImportRequest;
use DataTables;
use App\Models\Category;
use App\Models\Listing;
use App\Models\Gallery;
use App\Models\ImportListing;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;


class ListingController extends Controller
{
    public function index(Request $request)
    {
        $data['menu'] = "Listings";
        $data['search'] = $request['search'];

     
        if ($request->ajax()) {
            $data = Listing::select();

            return Datatables::of($data)
                ->addIndexColumn()
                ->addColumn('category', function ($row) {
            
                    $categoryIds = explode(',', $row['category']);                    
                  
                    $categoryNames = \App\Models\Category::whereIn('id', $categoryIds)
                        ->pluck('name')
                        ->toArray();                    
                   
                    return implode(', ', $categoryNames);
                })
                ->addColumn('sub_category', function ($row) {
                    return !empty($row['SubCategory']) ? $row['SubCategory']['name'] : '';
                })
                ->editColumn('section', function ($row) {
                    return ucwords(str_replace("_", " ", $row['section']));
                })
                ->editColumn('is_featured', function ($row) {
                    return ucwords($row['is_featured']);
                })
                ->editColumn('has_special', function ($row) {
                    return ucwords($row['has_special']);
                })
                ->editColumn('paid_member', function ($row) {
                    return ucwords($row['paid_member']);
                })
                ->editColumn('status', function($row){
                    $row['table_name'] = 'listings';
                    return view('admin.common.status-buttons', $row);
                })
                ->addColumn('action', function($row){
                    $row['section_name'] = 'listings';
                    $row['section_title'] = 'Listings';
                    return view('admin.common.action-buttons', $row);
                })
                ->rawColumns(['category','action'])
                ->make(true);
        }

        return view('admin.listings.index', $data);
    }

    public function create()
    {
        $data['menu'] = "Listings";
        $data['categories'] = Category::where('parent_id',0)->where('section','my_harties')->where('status','active')->orderBy('name')->pluck('name','id');
        $data['sub_categories'] = [];
        return view("admin.listings.create",$data);
    }

    public function store(ListingRequest $request)
    {
        $input = $request->all();
        $input['user_id'] = Auth::user()->id;
        if($photo = $request->file('main_image')){
            $input['main_image'] = $this->fileMove($photo,'listings');
        }
        $input['not_applicable'] = isset($input['not_applicable']) && $input['not_applicable'] == 1 ? 1 : 0;
        $input['special_heading'] = null;
        $input['special_description'] = null;
        $input['open_hours'] = isset($request->time) && !empty($request->time) ? json_encode($request->time) : [];

        if (!empty($request->category) && is_array($request->category)) {
            if (count($request->category) > 1) {
                // Multiple categories: Save as comma-separated string and set sub_category to null
                $input['category'] = implode(',', $request->category);
                $input['sub_category'] = null;
            } else {
                // Single category: Save normally along with sub_category
                $input['category'] = $request->category[0]; 
                $input['sub_category'] = $request->sub_category ?? null;
            }
        } else {
            $input['category'] = $request->category;
            $input['sub_category'] = $request->sub_category ?? null;
        }
        
        $listing = Listing::create($input);
        

        // Insert into special_instruction table using raw query
        if ($request->has('special_heading') && $request->has('special_description')) {
            $data = [];

            foreach ($request->special_heading as $key => $heading) {

                $heading = trim($heading);
                $description = isset($request->special_description[$key]) ? trim($request->special_description[$key]) : '';

                if (!empty($heading) && !empty($description)) {
                    $data[] = [
                        'listing_id' => $listing->id,
                        'special_heading' => $heading,
                        'special_description' => $description,
                        'created_at' => now(),
                        'updated_at' => now(),
                    ];
                }
            }

            if (!empty($data)) {
                DB::table('special_instruction')->insert($data);
            }
        }

        if ($request->hasFile('file')) {
            foreach ($request->file('file') as $image) {

                $imageName = $this->fileMove($image,'listings');
                Gallery::create([
                    'listing_id' => $listing->id,
                    'image' =>  $imageName,
                ]);
            }
        }

        \Session::flash('success', 'Listing has been inserted successfully!');
        return redirect()->route('listings.index');
    }

    public function edit($id)
    {
        $data['menu'] = "Listings";
        $data['listing'] = Listing::with('listing_images')->where('id',$id)->first();
        $data['specialInstructions'] = [];
        if(!empty($data['listing'])){
            $data['specialInstructions'] = DB::table('special_instruction')->where('listing_id', $data['listing']->id)->get();

        }
        $data['categories'] = Category::where('parent_id',0)->where('section',$data['listing']['section'])->where('status','active')->orderBy('name')->pluck('name','id');
        $data['sub_categories'] = Category::where('parent_id',$data['listing']['category'])->where('status','active')->orderBy('name')->pluck('name','id');
        return view('admin.listings.edit',$data);
    }

    public function update(ListingRequest $request, Listing $listing)
    {
        $input = $request->all();
        if($photo = $request->file('main_image')){
            if (!empty($listing['main_image']) && file_exists($listing['main_image'])) {
                unlink($listing['main_image']);
            }
            $input['main_image'] = $this->fileMove($photo,'listings');
        }

        if ($request->hasFile('file')) {
            foreach ($request->file('file') as $image) {

                $imageName = $this->fileMove($image,'listings');
                Gallery::create([
                    'listing_id' => $listing['id'],
                    'image' =>  $imageName,
                ]);
            }
        }
        $input['not_applicable'] = isset($input['not_applicable']) && $input['not_applicable'] == 1 ? 1 : 0;
        $input['special_heading'] = null;
        $input['special_description'] = null;
        $input['open_hours'] = isset($request->time) && !empty($request->time) ? json_encode($request->time) : [];

        if (!empty($request->category) && is_array($request->category)) {
            if (count($request->category) > 1) {
                // Multiple categories: Save as comma-separated string and set sub_category to null
                $input['category'] = implode(',', $request->category);
                $input['sub_category'] = null;
            } else {
                // Single category: Save normally along with sub_category
                $input['category'] = $request->category[0]; 
                $input['sub_category'] = $request->sub_category ?? null;
            }
        } else {
            $input['category'] = $request->category;
            $input['sub_category'] = $request->sub_category ?? null;
        }
        
        $listing->update($input);


        // Handle Special Instructions
        if ($request->has('special_heading') && $request->has('special_description')) {
            // Delete old records
            DB::table('special_instruction')->where('listing_id', $listing['id'])->delete();

            $data = [];

            foreach ($request->special_heading as $key => $heading) {
                $heading = trim($heading ?? '');
                $description = isset($request->special_description[$key]) ? trim($request->special_description[$key]) : '';
        
                if (!empty($heading) && !empty($description)) {
                    $data[] = [
                        'listing_id' => $listing['id'],
                        'special_heading' => $heading,
                        'special_description' => $description,
                        'created_at' => now(),
                        'updated_at' => now(),
                    ];
                }
            }

            if (!empty($data)) {
                DB::table('special_instruction')->insert($data);
            }
        }

        \Session::flash('success','Listing has been updated successfully!');
        return redirect()->route('listings.index');
    }

    public function destroy($id)
    {
        $listing = Listing::findOrFail($id);
        if(!empty($listing)){
            $listing->delete();
            return 1;
        }else{
            return 0;
        }
    }

    public function removeImage(Request $request)
    {
        $image = Gallery::findOrFail($request['id']);
        if(!empty($image)){
            unlink($request['img_name']);
            $image->delete();
            return 1;
        }else{
            return 0;
        }
    }

    public function getSubCategories(Request $request){
        $categoryId = $request->input('categoryId');

        if(isset($categoryId) && (!empty($categoryId))){
            $sub_categories = Category::where('parent_id',$categoryId)->where('status','active')->orderBy('name')->get();
            return response()->json($sub_categories);
        }

    }

    public function additionalFieldsData(Request $request)
    {
        $getSection = $request->section;
        $getTyp = ($getSection == 'my_harties') ? 'my_harties' : 'harties_services';
        $categories = Category::where('parent_id',0)->where('section',$getTyp)->where('status','active')->orderBy('name')->get();
        return response()->json($categories);
    }

    public function importListings()
    {
        $data['menu'] = 'Listings Import';        
        return view("admin.listings.import",$data);
    }

    public function importListingsStore(ListingsImportRequest $request)
    {
        $file = $request->file('file');
        $csvFile = $this->fileMove($file,'listings-csv');

        // store import file in database
        $inputImport = [];
        $inputImport['user_id'] = Auth::user()->id;
        $inputImport['file_name'] = $csvFile;
        $importListing = ImportListing::create($inputImport);

        if (($handle = fopen($csvFile, 'r')) !== false) {
            // Read the header row
            $header = fgetcsv($handle);

            // Process each row
            while (($row = fgetcsv($handle)) !== false) {

                $data = array_combine($header, $row);

                if(!empty($data['COMPANY_NAME']) && !empty($data['ADDRESS']) && !empty($data['DESCRIPTION']) && !empty($data['TELEPHONE_NUMBER']) && !empty($data['SECTION']) && !empty($data['CATEGORY_NAME']) && !empty($data['SUNDAY']) && !empty($data['MONDAY']) && !empty($data['TUESDAY']) && !empty($data['WEDNESDAY']) && !empty($data['THURSDAY']) && !empty($data['FRIDAY']) && !empty($data['SATURDAY']) && !empty($data['PUBLIC_HOLIDAY'])){


                    // Define a mapping of days to their corresponding keys
                    $dayMapping = [
                        'Sunday' => 'SUNDAY',
                        'Monday' => 'MONDAY',
                        'Tuesday' => 'TUESDAY',
                        'Wednesday' => 'WEDNESDAY',
                        'Thursday' => 'THURSDAY',
                        'Friday' => 'FRIDAY',
                        'Saturday' => 'SATURDAY',
                        'Public_holiday' => 'PUBLIC_HOLIDAY',
                    ];

                    // Initialize an array to store the transformed data
                    $transformedData = [];
                    $resultJson = NULL;

                    if($data['NOT_APPLICABLE'] != "YES" || $data['NOT_APPLICABLE'] != "yes"){
                        // Iterate over each day and transform the opening hours
                        foreach ($dayMapping as $dayName => $dayKey) {
                            
                            if($data[$dayKey]!='CLOSE'){
                                [$from, $to] = explode('-', $data[$dayKey]);

                                // Adjust time format and assign to transformedData array
                                $transformedData[$dayName] = [
                                    "from" => $from,
                                    "to" => $to
                                ];
                            } else {
                                $transformedData[$dayName] = [
                                    "from" => '00:00',
                                    "to" => '00:00',
                                    "close" => 1
                                ];
                            }
                        }

                        $resultJson = json_encode($transformedData, JSON_PRETTY_PRINT);
                    }

                    // Split categories and images
                    $categories = !empty($data['CATEGORY_NAME']) ? explode('||', $data['CATEGORY_NAME']) : [];
                    $categoryImages = !empty($data['CATEGORY_IMAGE']) ? explode('||', $data['CATEGORY_IMAGE']) : [];

                    // Initialize category IDs array
                    $categoryIds = [];

                    if (!empty($categories)) {
                        foreach ($categories as $index => $categoryName) {
                            $categoryName = trim($categoryName); // Trim spaces

                            if (!empty($categoryName)) {
                                // Get category image if available
                                $categoryImage = isset($categoryImages[$index]) && !empty($categoryImages[$index])
                                    ? 'public/uploads/category/' . trim($categoryImages[$index])
                                    : null;

                                // Check if category exists
                                $category = Category::where('name', $categoryName)
                                    ->where('section', $data['SECTION'])
                                    ->where('level', 1)
                                    ->first();

                                if (empty($category)) {
                                    $inputCategory = [
                                        'section' => $data['SECTION'],
                                        'name' => $categoryName,
                                        'image' => $categoryImage,
                                        'status' => 'active',
                                    ];
                                    $category = Category::create($inputCategory);
                                }

                                // Store category ID
                                $categoryIds[] = $category->id;
                            }
                        }
                    }

                    // If multiple categories exist, don't save subcategory
                    $subcategory = null;
                    if (count($categoryIds) === 1 && !empty($data['SUB_CATEGORY_NAME']) && $data['SECTION'] == 'my_harties') {
                        $subcategoryName = trim($data['SUB_CATEGORY_NAME']);
                        if (!empty($subcategoryName)) {
                            $subcategory = Category::where('name', $subcategoryName)
                                ->where('section', $data['SECTION'])
                                ->where('level', 2)
                                ->first();

                            if (empty($subcategory)) {
                                $subcategoryImage = !empty($data['SUB_CATEGORY_IMAGE']) ? 'public/uploads/category/' . trim($data['SUB_CATEGORY_IMAGE']) : null;
                                $inputSubCategory = [
                                    'parent_id' => $categoryIds[0],
                                    'section' => $data['SECTION'],
                                    'name' => $subcategoryName,
                                    'image' => $subcategoryImage,
                                    'level' => 2,
                                    'status' => 'active',
                                ];
                                $subcategory = Category::create($inputSubCategory);
                            }
                        }
                    }

                    // Get lat lng
                    $latitude = '';
                    $longitude = '';
                    $address = urlencode($data['ADDRESS']);
                    $url = "https://maps.googleapis.com/maps/api/geocode/json?address=$address&key=" . env('GOOGLE_MAP_API_KEY');
                    $curl = curl_init();
                    curl_setopt($curl, CURLOPT_URL, $url);
                    curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
                    $response = curl_exec($curl);
                    if ($response === false) {
                    } else {
                        $addressData = json_decode($response);
                        if ($addressData->status == "OK") {
                            $latitude = $addressData->results[0]->geometry->location->lat;
                            $longitude = $addressData->results[0]->geometry->location->lng;
                        }
                    }
                    curl_close($curl);

                   


                    // check Listing
                    $listing = Listing::where('company_name',$data['COMPANY_NAME'])->first();
                    $inputListing = [
                        'section' => $data['SECTION'],
                        'user_id' => Auth::user()->id,
                        'company_name' => $data['COMPANY_NAME'],
                        'address' => $data['ADDRESS'],
                        'latitude' => !empty($latitude) ? $latitude : NULL,
                        'longitude' => !empty($longitude) ? $longitude : NULL,
                        'description' => $data['DESCRIPTION'],
                        'telephone_number' => $data['TELEPHONE_NUMBER'],
                        'email' => !empty($data['EMAIL_ADDRESS']) ? $data['EMAIL_ADDRESS'] : NULL,
                        'website_address' => !empty($data['WEBSITE_ADDRESS']) ? $data['WEBSITE_ADDRESS'] : NULL,
                        'open_hours' => (!empty($data['NOT_APPLICABLE']) && strtolower($data['NOT_APPLICABLE']) === 'yes') ? NULL : $resultJson,
                        'main_image' => 'public/uploads/listings/'.$data['MAIN_IMAGE'],
                        'category' => !empty($categoryIds) ? implode(',', $categoryIds) : null,
                        'sub_category' => !empty($subcategory) ? $subcategory->id : null,
                        // 'special_heading' => !empty($data['SPECIAL_TITLE']) ? $data['SPECIAL_TITLE'] : NULL,
                        // 'special_description' => !empty($data['SPECIAL_DESCRIPTION']) ? $data['SPECIAL_DESCRIPTION'] : NULL,
                        'special_heading' => NULL,
                        'special_description' => NULL,
                        'keywords' => !empty($data['KEYWORDS']) ? $data['KEYWORDS'] : NULL,
                        'expiry_date' => date('Y-m-d', strtotime($data['EXPIRY_DATE'])),
                        'import_id' => $importListing->id,
                        'not_applicable' => (!empty($data['NOT_APPLICABLE']) && strtolower($data['NOT_APPLICABLE']) === 'yes') ? 1 : 0,
                        'created_at' => date('Y-m-d H:i:s'),
                        'updated_at' => date('Y-m-d H:i:s'),
                    ];

                    if(!empty($data['WHATSAPP_NUMBER'])){
                        $inputListing['whatsapp_number'] = $data['WHATSAPP_NUMBER'];
                    }

                    if(!empty($data['IS_FEATURED'])){
                        $inputListing['is_featured'] = $data['IS_FEATURED'];
                    }

                    if(!empty($data['HAS_SPECIAL'])){
                        $inputListing['has_special'] = $data['HAS_SPECIAL'];
                    }

                    if(!empty($data['PAID_MEMBER'])){
                        $inputListing['paid_member'] = $data['PAID_MEMBER'];
                    }

                    if(!empty($data['STATUS'])){
                        $inputListing['status'] = $data['STATUS'];
                    }

                    if(empty($listing)){
                        $listing = Listing::create($inputListing);
                    } else {
                        $listing->update($inputListing);
                    }

                    // check listing image
                    if(!empty($data['GALLERY_IMAGE'])){
                        foreach (explode(",", $data['GALLERY_IMAGE']) as $key => $value) {
                            $listingImage = Gallery::where('image','public/uploads/listings/'.trim($value))->where('listing_id',$listing->id)->first();

                            if(empty($listingImage)){
                                Gallery::create([
                                    'listing_id' => $listing->id,
                                    'image' =>  'public/uploads/listings/'.trim($value),
                                ]);
                            }
                        }
                    }

                 
                    /* SAVE MULTIPLE SPECIALS DATA */
                    $multiSpecialTitle = $data['SPECIAL_TITLE'] ?? '';
                    $multiSpecialDescription = $data['SPECIAL_DESCRIPTION'] ?? '';

                    $titles = array_filter(array_map('trim', explode('||', $multiSpecialTitle))); // Trim & remove empty values
                    $descriptions = array_map('trim', explode('||', $multiSpecialDescription)); // Trim descriptions

                    if(!empty($titles)){
                        foreach ($titles as $index => $title) {
                            $description = $descriptions[$index] ?? null; // Avoid index mismatch issues

                            // Check if the record already exists to prevent duplicates
                            DB::table('special_instruction')->updateOrInsert(
                                [
                                    'listing_id' => $listing->id,
                                    'special_heading' => $title,
                                ],
                                [
                                    'special_description' => $description,
                                    'updated_at' => now()
                                ]
                            );
                        }
                    }

                }
            }
            fclose($handle);
        }

        \Session::flash('success', 'Listings has been imported successfully!');
        return redirect()->back();
    }

    public function deleteSpecialInstruction($id)
    {

        try {

            // Check if the special instruction exists before deleting
            $instruction = DB::table('special_instruction')->where('id', $id)->exists();

            if (!$instruction) {
                return response()->json([
                    'success' => false,
                    'message' => 'Special instruction not found.'
                ], 404);
            }

            // Perform the deletion
            DB::table('special_instruction')->where('id', $id)->delete();

            return response()->json([
                'success' => true,
                'message' => 'Special instruction deleted successfully.'
            ], 200);

        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Error deleting special instruction: ' . $e->getMessage()
            ], 500);
        }
    }

    public function importListing(){

        $listings = DB::table('listings')->select('id','special_heading','special_description')->get();

        if(!empty($listings)){
            foreach ($listings as $listing) {
                // Check if the record already exists in the special_instruction table
                $exists = DB::table('special_instruction')
                    ->where('special_heading', $listing->special_heading)
                    ->where('special_description', $listing->special_description)
                    ->exists();
            
                if (!$exists) {
                    // Insert if not exists
                    DB::table('special_instruction')->insert([
                        'listing_id' => $listing->id,
                        'special_heading' => $listing->special_heading,
                        'special_description' => $listing->special_description,
                        'created_at' => now(),
                        'updated_at' => now(),
                    ]);
                }
            }
        }

    }

}
