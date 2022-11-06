<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use App\Models\Transaction;
use App\Models\User;
use App\Models\NFT;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('transactions', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('id_buyer')->unsigned();
            $table->foreign('id_buyer')->references('id')->on('users')->onDelete('cascade');
            $table->unsignedBigInteger('id_seller')->unsigned();
            $table->foreign('id_seller')->references('id')->on('users')->onDelete('cascade');
            $table->unsignedBigInteger('id_nft')->unsigned();
            $table->foreign('id_nft')->references('id')->on('nfts')->onDelete('cascade');
            $table->string('date');
            $table->double('price');
            $table->unsignedBigInteger('id_crypto')->unsigned();
            $table->foreign('id_crypto')->references('id')->on('cryptos')->onDelete('cascade');
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
        Schema::dropIfExists('transactions');
    }
};
