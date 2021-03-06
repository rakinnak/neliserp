<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateDocItemsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('doc_items', function (Blueprint $table) {
            $table->increments('id');
            $table->unsignedInteger('doc_id');
            $table->unsignedInteger('item_id');
            $table->unsignedInteger('ref_id')->nullable();
            $table->uuid('doc_uuid');
            $table->uuid('item_uuid');
            $table->uuid('ref_uuid')->nullable();
            $table->uuid('uuid')->unique();
            $table->unsignedInteger('line_number');
            $table->string('item_code');
            $table->string('item_name');
            $table->integer('quantity');
            $table->integer('pending_quantity');
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
                ->on('doc_items')
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
        Schema::dropIfExists('doc_items');
    }
}
