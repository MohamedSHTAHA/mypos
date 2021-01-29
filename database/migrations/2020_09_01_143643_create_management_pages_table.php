<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateManagementPagesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('management_pages', function (Blueprint $table) {
            $table->bigIncrements('id');
            //$table->string('uri'); //as => dashboard/categories/{category}/edit
            //$table->string('getActionName')->nullable(); //as => App\Http\Controllers\Dashboard\CategoryController@edit
            //$table->string('getName'); //as => dashboard.categories.edit
            $table->string('route')->default('#'); //as => dashboard.categories.edit
            $table->string('permission')->nullable();
            //$table->string('link')->default('#');
            $table->enum('type', [1, 2, 3, 4])->default(1);
            $table->enum('status', ['open', 'close'])->default('open');
            $table->integer('sorted')->nullable();
            $table->string('fa_icon')->default('fas fa-list');
            $table->bigInteger('management_page_id')->unsigned()->nullable();
            $table->foreign('management_page_id')->references('id')->on('management_pages'); //->onDelete('cascade');

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
        Schema::dropIfExists('management_pages');
    }
}
