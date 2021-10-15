<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateCampaignsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('campaigns', function (Blueprint $table) {
            $table->id();
            $table->string('domain');
            $table->integer('cycle');
            $table->longText('description')->nullable();
            $table->float('budget', 12);
            $table->float('budget_real', 12);
            $table->date('payment_date');
            $table->date('start_date');
            $table->integer('status')->default(1);
            $table->integer('teamwork_id')->nullable();
            $table->foreignId('company_id')->constrained();
            $table->foreignId('manager_seo_id')->constrained('users');
            $table->foreignId('manager_technical_id')->constrained('users');
            $table->foreignId('currency_id')->constrained();
            $table->foreignId('niche_id')->constrained();

            $table->unsignedBigInteger('package_id');
            $table->foreign('package_id')->references('id')->on('packages');

            $table->softDeletes();
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
        Schema::dropIfExists('campaigns');
    }
}
