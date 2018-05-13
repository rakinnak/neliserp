<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

use App\Province;

class CreateProvincesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        // Nested set model : lft, rgt
        Schema::create('provinces', function (Blueprint $table) {
            $table->increments('id');
            $table->unsignedInteger('country_id');
            $table->uuid('country_uuid')->index();
            $table->uuid('uuid')->unique();
            $table->string('code')->unique();
            $table->string('name')->index();
            $table->timestamps();

            $table->foreign('country_id')
                ->references('id')
                ->on('countries');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('provinces');
    }
}
