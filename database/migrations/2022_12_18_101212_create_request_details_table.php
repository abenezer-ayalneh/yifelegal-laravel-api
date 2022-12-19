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
    public function up(): void
    {
        Schema::create('request_details', function (Blueprint $table) {
            $table->id();
            $table->foreignId("request_id");
            $table->string("attribute");
            $table->text("value");
            $table->foreignId("created_by");
            $table->foreignId("updated_by");
            $table->timestamps();
            $table->foreignId("deleted_by")->nullable();
            $table->softDeletes();
            $table->unique(["request_id","attribute"],"unique_request_id_and_attribute");

        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down(): void
    {
        Schema::dropIfExists('request_details');
    }
};
