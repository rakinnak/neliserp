<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateDocItemTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('doc_item', function (Blueprint $table) {
            $table->increments('id');
            $table->unsignedInteger('doc_id');
            $table->unsignedInteger('item_id');
            $table->unsignedInteger('ref_id')->nullable();
            $table->uuid('uuid')->unique();
            $table->unsignedInteger('line_number');
            $table->string('item_uuid');
            $table->string('item_code');
            $table->string('item_name');
            $table->unsignedInteger('quantity');
            $table->unsignedInteger('pending_quantity');
            $table->decimal('unit_price', 10, 2);
            $table->timestamps();

            $table->foreign('doc_id')
                ->references('id')
                ->on('docs')
                ->onDelete('cascade');

            $table->foreign('item_id')
                ->references('id')
                ->on('items')
                ->onDelete('cascade');

            $table->foreign('ref_id')
                ->references('id')
                ->on('doc_item')
                ->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('doc_item');
    }
}
