<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateChatsRealtimesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('chats_realtimes', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->integer('sender_id')->unsigned();
            $table->integer('receiver_id')->unsigned();
            $table->longText('message')->nullable();
            $table->json('files')->default('[]');
            $table->enum('read', [0, 1, 2])->default(0);
            $table->foreign('sender_id')->references('id')->on('users'); //->onDelete('cascade');
            $table->foreign('receiver_id')->references('id')->on('users'); //->onDelete('cascade');
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
        Schema::dropIfExists('chats_realtimes');
    }
}
