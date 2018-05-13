<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

use App\District;

class CreateDistrictsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        // Nested set model : lft, rgt
        Schema::create('districts', function (Blueprint $table) {
            $table->increments('id');
            $table->unsignedInteger('province_id')->index();
            $table->uuid('uuid')->unique();
            $table->uuid('province_uuid')->index();
            $table->string('code')->unique();
            $table->string('name')->index();
            $table->timestamps();

            $table->foreign('province_id')
                ->references('id')
                ->on('provinces');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('districts');
    }
}
