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
            $table->unsignedInteger('company_id');
            $table->uuid('uuid')->unique();
            $table->string('name')->index();
            //$table->string('type'); // purchase_order, receive_order, receive_invoice, sales_order, delivery_order, sales_invoice
            $table->string('company_uuid');
            $table->string('company_code');
            $table->string('company_name');
            $table->timestamp('issued_at');
            //$table->timestamp('due_at')->nullable();
            $table->timestamps();
            //$table->string('status')->nullable(); // open, partial, closed, paid

            // keys
            //$table->unique(['name', 'type']);

            $table->foreign('company_id')
                ->references('id')
                ->on('companies')
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
        Schema::dropIfExists('docs');
    }
}
