<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreatePackageToElementsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('package_to_elements', function (Blueprint $table) {
            $table->id();
            $table->integer('amount');
            $table->integer('frequency')->nullable();
            $table->tinyInteger('is_first_month')->nullable();
            $table->foreignId('package_id')->constrained();
            $table->foreignId('package_element_id')->constrained();
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
        Schema::dropIfExists('package_to_elements');
    }
}
