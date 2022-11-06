<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema; 
use App\Models\Collection;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('collections', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->unsignedBigInteger('id_creator')->unsigned();
            $table->foreign('id_creator')->references('id')->on('users')->onDelete('cascade');
            $table->unsignedBigInteger('id_owner')->unsigned();
            $table->foreign('id_owner')->references('id')->on('users')->onDelete('cascade');
            $table->unsignedBigInteger('id_topic')->unsigned();
            $table->foreign('id_topic')->references('id')->on('topics')->onDelete('cascade');
            $table->string('reaction');
            $table->string('status');
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
        Schema::dropIfExists('collections');
    }
};
