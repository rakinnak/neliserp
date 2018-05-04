<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateDocsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('docs', function (Blueprint $table) {
            $table->increments('id');
            $table->unsignedInteger('partner_id')->index();
            $table->unsignedInteger('user_id');
            $table->uuid('uuid')->unique();
            $table->string('name')->index();
            $table->string('type'); // purchase_order, receive_order, receive_invoice, sales_order, delivery_order, sales_invoice
            $table->uuid('partner_uuid');
            $table->string('partner_code');
            $table->string('partner_name');
            $table->uuid('user_uuid');
            $table->uuid('user_username');
            $table->timestamp('issued_at');
            //$table->timestamp('due_at')->nullable();
            $table->timestamps();
            //$table->string('status')->nullable(); // open, partial, closed, paid

            // keys
            //$table->unique(['name', 'type']);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('docs');
    }
}
