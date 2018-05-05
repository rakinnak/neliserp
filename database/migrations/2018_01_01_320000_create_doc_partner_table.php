<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateDocPartnerTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('doc_partner', function (Blueprint $table) {
            $table->unsignedInteger('doc_id');
            $table->unsignedInteger('partner_id');
            $table->string('purpose');  // customer, supplier

            $table->primary(['doc_id', 'partner_id']);

            $table->foreign('doc_id')
                ->references('id')
                ->on('docs')
                ->onDelete('cascade');

            $table->foreign('partner_id')
                ->references('id')
                ->on('partners')
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
        Schema::dropIfExists('doc_partner');
    }
}
