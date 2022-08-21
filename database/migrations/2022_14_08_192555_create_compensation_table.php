<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateCompensationTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('compensation', function (Blueprint $table) {
            $table->id();
            $table->timestamps();
            $table->integer('employee_id')->unsigned()->nullable();   
            $table->string('timeUploaded')->nullable();
            $table->string('age');
            $table->string('industry')->nullable();
            $table->string('role');
            $table->bigInteger('annualSalary')->nullable();
            $table->string('currencyType');
            $table->string('loc')->nullable();
            $table->string('yearOfExperince');
            $table->string('additionalContents')->length(1000)->nullable();
            $table->string('other')->length(1000)->nullable();
            
            $table->foreign('employee_id')->references('id')->on('employees') ;
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('compensation');
    }
}
