<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('details', function (Blueprint $table) {

            // Generate ID.
            $table->id();

            // Table content.
            $table->string('name');
            $table->string('contact');
            $table->string('street');
            $table->string('zip_code');
            $table->string('location');
            $table->string('country');

            $table->boolean('invoice_is_same')->default(1);
            $table->string('iv_name')->nullable();
            $table->string('iv_street')->nullable();
            $table->string('iv_zip_code')->nullable();
            $table->string('iv_location')->nullable();
            $table->string('iv_country')->nullable();

            $table->string('email');
            $table->string('phone')->unique()->nullable();
            $table->string('mobile')->unique();

            $table->string('coc')->nullable();
            $table->string('vat')->nullable();
            $table->string('bank')->nullable();

            // Generate timestaps (created_at, updated_at)
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('details');
    }
};
