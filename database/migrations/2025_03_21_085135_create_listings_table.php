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
    Schema::create('listings', function (Blueprint $table) {
        $table->id();
        $table->foreignId('user_id')->nullable()->constrained()->onDelete('cascade');
// Owner of the listing
        $table->string('name'); // Tool name or title
        $table->string('image')->nullable(); // Path to tool image
        $table->string('condition'); // e.g., "Like New", "Good", "Fair"
        $table->string('location');  // Location where the tool is available
        $table->decimal('price', 8, 2);  // Rental price (per day/hour)
        $table->text('description')->nullable();  // Additional details (optional)
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
    Schema::dropIfExists('listings');
}
  
};
