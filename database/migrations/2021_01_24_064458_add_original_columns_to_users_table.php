<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddOriginalColumnsToUsersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('users', function (Blueprint $table) {
            //
            $table->string('user_id', 13)->after('id')->comment('ユーザーID');
            $table->string('company_name')->after('user_id')->comment('会社名');
            $table->string('phone_number', 13)->after('email')->comment('電話番号');
            $table->unique('user_id');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('users', function (Blueprint $table) {
            //
            $table->dropColumn('phone_number');
            $table->dropColumn('company_name');
            $table->dropColumn('user_id');
        });
    }
}
