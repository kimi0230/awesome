<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateMessageTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('messages', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('token', 30)->comment('使用者登入token');
            $table->text('message')->comment('留言內容');
            $table->text('reply')->comment('留言內容');
            $table->enum('isReply', [0, 1])->default(0)->comment('啟用狀態 ( 1:已回覆 | 0:未回覆 )');
            $table->enum('status', [0, 1])->default(1)->comment('啟用狀態 ( 1:啟用 | 0:停用 )');
            $table->timestamps();

            $table->index('isReply', 'isReply');

        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('messages');
    }
}
