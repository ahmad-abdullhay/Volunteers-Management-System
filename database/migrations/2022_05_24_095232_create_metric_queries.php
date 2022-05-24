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
        Schema::create('metric_query', function (Blueprint $table) {
            $table->id();

        });
        Schema::create('metric_queries', function (Blueprint $table) {
            $table->id();

            $table->string('first_operation');
            $table->string('second_operation');
            $table->string('compare_operation');
            $table->foreignId('metric_id')
                ->constrained()
                ->onUpdate('cascade')
                ->onDelete('cascade');
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
        Schema::dropIfExists('metric_queries');
    }
};
