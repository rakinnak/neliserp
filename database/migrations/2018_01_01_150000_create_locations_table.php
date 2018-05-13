<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

use App\Location;

class CreateLocationsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        // Nested set model : lft, rgt
        Schema::create('locations', function (Blueprint $table) {
            $table->increments('id');
            $table->unsignedInteger('parent_id')->nullable();
            $table->uuid('uuid')->unique();
            $table->uuid('parent_uuid')->nullable();
            $table->string('code')->unique();
            $table->string('name')->index();
            $table->unsignedInteger('lft')->unique();
            $table->unsignedInteger('rgt')->unique();
            $table->string('address')->nullable();
            $table->string('floor')->nullable();
            $table->string('building')->nullable();
            $table->string('street')->nullable();
            $table->string('city')->nullable();             // City, Sub District, Tambon
            $table->string('district')->nullable();         // Amphone, County, District
            $table->string('province')->nullable();         // Province, Region, State
            $table->string('country')->nullable();
            $table->string('zip_code')->nullable();
            $table->string('address_line_1')->nullable();   // custom print address line 1
            $table->string('address_line_2')->nullable();   // custom print address line 2
            $table->string('address_line_3')->nullable();   // custom print address line 3
            $table->decimal('latitude', 8, 6)->nullable();
            $table->decimal('longitude', 9, 6)->nullable();
            $table->string('phone')->nullable();
            $table->string('fax')->nullable();
            $table->string('mobile')->nullable();
            $table->string('email')->nullable();
            $table->timestamps();

            $table->foreign('parent_id')
                ->references('id')
                ->on('locations');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('locations');
    }
}
