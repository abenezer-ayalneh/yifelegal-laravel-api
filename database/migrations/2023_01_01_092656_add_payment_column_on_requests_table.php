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
        Schema::table("requests", function (Blueprint $table){
            if(!Schema::hasColumn("requests","payment_status")){
                if(Schema::hasColumn("requests","requested_for_phone_number")){
                    $table->boolean("payment_status")->default(0)->after("requested_for_phone_number");
                }else{
                    $table->boolean("payment_status")->default(0);
                }
            }
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table("requests", function (Blueprint $table){
            if(Schema::hasColumn("requests","payment_status")){
                $table->dropColumn("payment_status");
            }
        });
    }
};
