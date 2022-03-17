<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

return new class extends Migration {
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('release_ticket', function (Blueprint $table) {
            $table
                ->foreign('release_id')
                ->references('id')
                ->on('releases')
                ->onUpdate('CASCADE')
                ->onDelete('CASCADE');

            $table
                ->foreign('ticket_id')
                ->references('id')
                ->on('tickets')
                ->onUpdate('CASCADE')
                ->onDelete('CASCADE');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('release_ticket', function (Blueprint $table) {
            $table->dropForeign(['release_id']);
            $table->dropForeign(['ticket_id']);
        });
    }
};
