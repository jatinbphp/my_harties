<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Listing extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = ['section','user_id','company_name','address','latitude','longitude','description','telephone_number',
        'whatsapp_number','email','website_address','open_hours','main_image','category','sub_category',
        'is_featured','has_special','special_heading','special_description','keywords','paid_member','expiry_date','status'];

    const STATUS_ACTIVE = 'active';
    const STATUS_INACTIVE = 'inactive';

    public static $status = [
        self::STATUS_ACTIVE => 'Active',
        self::STATUS_INACTIVE => 'In Active',
    ];

    const YES = 'yes';
    const NO = 'no';

    public static $yes_no = [
        self::YES => 'Yes',
        self::NO => 'No',
    ];

    const DAY1 = 'Sunday';
    const DAY2 = 'Monday';
    const DAY3 = 'Tuesday';
    const DAY4 = 'Wednesday';
    const DAY5 = 'Thursday';
    const DAY6 = 'Friday';
    const DAY7 = 'Saturday';
    const PUBLIC_HOLIDAY = 'Public_holiday';

    public static $days = [
        self::DAY1 => 'Sunday',
        self::DAY2 => 'Monday',
        self::DAY3 => 'Tuesday',
        self::DAY4 => 'Wednesday',
        self::DAY5 => 'Thursday',
        self::DAY6 => 'Friday',
        self::DAY7 => 'Saturday',
        self::PUBLIC_HOLIDAY => 'Public Holiday',
    ];

    public function Category(){
        return $this->belongsTo(Category::class,'category')->select('id', 'name', 'image');
    }

    public function SubCategory(){
        return $this->belongsTo(Category::class,'sub_category')->select('id', 'name', 'image');
    }

    public function listing_images(){
        return $this->hasMany(Gallery::class, 'listing_id')->orderBy('id', 'DESC');
    }
}
