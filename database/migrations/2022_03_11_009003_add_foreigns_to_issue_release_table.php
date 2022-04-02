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
        Schema::table('issue_release', function (Blueprint $table) {
            $table
                ->foreign('release_id')
                ->references('id')
                ->on('releases')
                ->onUpdate('CASCADE')
                ->onDelete('CASCADE');

            $table
                ->foreign('issue_id')
                ->references('id')
                ->on('issues')
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
        Schema::table('issue_release', function (Blueprint $table) {
            $table->dropForeign(['release_id']);
            $table->dropForeign(['issue_id']);
        });
    }
};
