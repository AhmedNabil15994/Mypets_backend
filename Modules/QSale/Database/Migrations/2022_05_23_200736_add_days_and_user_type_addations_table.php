<?php

use Modules\User\Enums\UserType;
use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddDaysAndUserTypeAddationsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('addations', function (Blueprint $table) {
            $table->string("user_type", 10)->default(UserType::USER)->index();
            $table->bigInteger("days")->default(1);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('addations', function (Blueprint $table) {
            $table->dropColumn(["type", "days"]);
        });
    }
}
