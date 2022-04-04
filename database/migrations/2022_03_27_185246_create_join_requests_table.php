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
        Schema::create('join_requests', function (Blueprint $table) {
            $table->id();

            $table->integer('status')
                ->comment("(1) => Waiting for HRM, (2) => Waiting For Volunteer Officer, (3) => Accepted, (4) => Declined")
                ->default(1);

            // Create admin_id and relate it with admins table.
            $table->foreignId('admin_id')
                ->constrained()
                ->onUpdate('cascade')
                ->onDelete('cascade');

            // Create user_id and relate it with users table.
            $table->foreignId('user_id')
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
        Schema::dropIfExists('join_requests');
    }
};
