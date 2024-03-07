<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('students', function (Blueprint $table) {
            $table->id();
            $table ->foreignId('classrooms_id')->nullable()->constrained() ->onDelete('cascade');
            $table->string('last_name');
            $table->string('first_name');
            $table->string('email')->nullable()->unique();
            $table->string('email2')->nullable()->unique();
            $table->string('num1')->nullable();
            $table->string('num2')->nullable();
            $table->string('gender')->nullable();
            $table->timestamp('email_verified_at')->nullable();
            $table->rememberToken();
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
        Schema::dropIfExists('students');
    }
};
