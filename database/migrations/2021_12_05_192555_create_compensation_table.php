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
            //$table->Integer('employee_id')->unsigned()->nullable();
            $table->timestamps();
            $table->string('age');
            $table->string('industry');
            $table->string('role');
            $table->string('annualSalary');
            $table->string('currencyType');
            $table->string('loc');
            $table->string('yearOfExperince');
            $table->string('additionalContents', 1000);
            $table->string('other');
            
            //$table->foreign('employee_id')->references('id')->on('employees');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('attendances');
    }
}
