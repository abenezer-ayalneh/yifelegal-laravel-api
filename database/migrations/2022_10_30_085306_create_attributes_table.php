<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up(): void
    {
        Schema::create('attributes', function (Blueprint $table) {
            $table->id();
            $table->string("name");
            $table->string("locale_string")->unique(); // A unique string of the locale file. Rule: *ALL CAPS LOCALE STRING FROM ATTRIBUTE*
            $table->text("description");
            $table->foreignId("created_by");
            $table->foreignId("updated_by");
            $table->timestamps();
            $table->foreignId("deleted_by")->nullable();
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down(): void
    {
        Schema::dropIfExists('attributes');
    }
};
