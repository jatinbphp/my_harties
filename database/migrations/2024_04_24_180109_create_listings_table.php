<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        /*
         * 'user_id','company_name','address','description','telephone_number','whatsapp_number',
        'email','website_address','open_hours','main_image','category','sub_category','is_featured','has_special',
        'special_heading','special_description','keywords','paid_member','expiry_date','status'
         * */

        Schema::create('listings', function (Blueprint $table) {
            $table->id();
            $table->string('section')->default('my_harties');
            $table->integer('user_id')->default(0);
            $table->string('company_name')->nullable();
            $table->longText('address')->nullable();
            $table->string('latitude')->nullable();
            $table->string('longitude')->nullable();
            $table->longText('description')->nullable();
            $table->string('telephone_number')->nullable();
            $table->string('whatsapp_number')->nullable();
            $table->string('email')->nullable();
            $table->string('website_address')->nullable();
            $table->text('open_hours')->nullable();
            $table->text('main_image')->nullable();
            $table->integer('category')->nullable();
            $table->integer('sub_category')->nullable();
            $table->string('is_featured')->default('yes');
            $table->string('has_special')->default('no');
            $table->string('special_heading')->nullable();
            $table->text('special_description')->nullable();
            $table->longText('keywords')->nullable();
            $table->string('paid_member')->nullable('yes');
            $table->string('expiry_date')->nullable();
            $table->string('status')->default('active');
            $table->softDeletes();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('listings');
    }
};
