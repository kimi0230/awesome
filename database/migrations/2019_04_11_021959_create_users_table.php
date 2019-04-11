<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateUsersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('users', function (Blueprint $table) {
            $table->bigIncrements('id');

            $table->string('username', 20)->unique('account')->comment('帳號');
            $table->string('password', 60)->comment('密碼');
            $table->string('name', 10)->comment('姓名');
            $table->string('email', 30)->comment('Email');
            $table->string('mobile', 30)->comment('手機號碼，台灣手機');

            $table->enum('status', [0, 1])->default(1)->comment('啟用狀態 ( 1:啟用 | 0:停用 )');

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('users');
    }
}
