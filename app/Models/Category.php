<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Category extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = ['parent_id','level','section','name','image','status'];

    const STATUS_ACTIVE = 'active';
    const STATUS_INACTIVE = 'inactive';

    public static $status = [
        self::STATUS_ACTIVE => 'Active',
        self::STATUS_INACTIVE => 'In Active',
    ];

    const SECTION_1 = 'my_harties';
    const SECTION_2 = 'harties_services';

    public static $sections = [
        self::SECTION_1 => 'My Harties',
        self::SECTION_2 => 'Harties Services',
    ];

    public function ParentCategory(){
        return $this->belongsTo(Category::class,'parent_id');
    }
}
