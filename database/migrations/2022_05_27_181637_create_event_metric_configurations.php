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
        Schema::create('event_metric_configurations', function (Blueprint $table) {
            $table->id();
            $table->integer("max_value")->nullable();
            $table->integer("min_value")->nullable();
            $table->integer("values_limit")->nullable();
            $table->boolean("at_event_end")->nullable();
            $table->foreignId('metric_id')
                ->constrained();
            $table->foreignId('event_id')
                ->constrained();
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
        Schema::dropIfExists('event_metric_configurations');
    }
};
