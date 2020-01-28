<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class WebhookInvocations extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('webhook_invocations', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->bigInteger('webhook_id'); 
            $table->integer('status')->default(0);
            $table->jsonb('head')->nullable();
            $table->jsonb('body');
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
        Schema::dropIfExists('webhook_invocations');
    }
}
