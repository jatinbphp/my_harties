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
            $table->integer('user_id');
            $table->string('company_name');
            $table->string('address');
            $table->string('latitude');
            $table->string('longitude');
            $table->longText('description');
            $table->string('telephone_number')->nullable();
            $table->string('whatsapp_number')->nullable();
            $table->string('email')->nullable();
            $table->string('website_address')->nullable();
            $table->text('open_hours')->nullable();
            $table->text('main_image')->nullable();
            $table->integer('category')->nullable();
            $table->integer('sub_category')->nullable();
            $table->integer('is_featured')->default(0);
            $table->string('has_special')->default('no');
            $table->string('special_heading')->nullable();
            $table->text('special_description')->nullable();
            $table->longText('keywords')->nullable();
            $table->string('paid_member')->nullable();
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
