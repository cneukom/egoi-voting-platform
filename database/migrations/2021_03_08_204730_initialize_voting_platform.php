<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class InitializeVotingPlatform extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('users', function (Blueprint $table) {
            $table->string('delegation')->nullable();
            $table->boolean('is_admin');
            $table->string('auth_token');
        });

        Schema::create('questions', function (Blueprint $table) {
            $table->id();
            $table->timestamps();
            $table->text('question');
            $table->longText('information')->nullable();
            $table->dateTime('closes_at');
        });

        Schema::create('options', function (Blueprint $table) {
            $table->id();
            $table->timestamps();
            $table->foreignId('question_id')->references('id')->on('questions');
            $table->text('label');

            $table->unique(['id', 'question_id']);
        });

        Schema::create('option_question_user', function (Blueprint $table) {
            $table->foreignId('question_id')->references('id')->on('questions');
            $table->foreignId('user_id')->references('id')->on('users');
            $table->foreignId('option_id')->references('id')->on('options');

            $table->primary(['question_id', 'user_id']); // each user can only vote once per question
            $table->foreign(['option_id', 'question_id'])->references(['id', 'question_id'])->on('options'); // option must belong to question
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('questions');
        Schema::dropIfExists('options');
        Schema::dropIfExists('option_user_question');
        Schema::table('users', function (Blueprint $table) {
            $table->dropColumn(['delegation', 'is_admin', 'auth_token']);
        });
    }
}
