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
        Schema::create('requests', function (Blueprint $table) {
            $table->id();
            $table->foreignId("entity_id");
            $table->foreignId("entity_type_id")->nullable();
            $table->foreignId("attribute_id");
            $table->longText("value");
            $table->foreignId("created_by");
            $table->foreignId("updated_by");
            $table->timestamps();
            $table->foreignId("deleted_by")->nullable();
            $table->softDeletes();
            $table->unique(["entity_id","entity_type_id","attribute_id"],"unique_entity_entity_type_and_attribute");
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('requests');
    }
};
