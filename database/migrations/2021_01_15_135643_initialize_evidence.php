<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class InitializeEvidence extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('delegations', function (Blueprint $table) {
            $table->id();
            $table->timestamps();
            $table->text('name');
            $table->string('code', 3);
            $table->string('access_token', 256)->unique();
        });

        Schema::create('contestants', function (Blueprint $table) {
            $table->id();
            $table->timestamps();
            $table->text('name');
            $table->string('code', 5);
            $table->string('access_token', 256)->unique();
            $table->foreignId('delegation_id')->references('id')->on('delegations');
        });

        Schema::create('evidence', function (Blueprint $table) {
            $table->id();
            $table->timestamps();
            $table->enum('status', ['created', 'present']);
            $table->enum('type', ['screenCapture', 'workScene']);
            $table->text('filename');
            $table->foreignId('contestant_id')->references('id')->on('contestants');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('delegations');
        Schema::dropIfExists('contestants');
        Schema::dropIfExists('evidence');
    }
}
