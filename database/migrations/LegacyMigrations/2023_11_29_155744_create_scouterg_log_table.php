<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::connection('mysql_logging')->create('group_send_logon_details', function (Blueprint $table) {
            $table->integer('id', true);
            $table->integer('userID');
            $table->dateTime('created');
            $table->integer('createdby');
        });

        Schema::connection('mysql_logging')->create('system_user_logging', function (Blueprint $table) {
            $table->integer('id', true);
            $table->integer('countryID');
            $table->integer('regionID')->nullable();
            $table->integer('districtID')->nullable();
            $table->integer('groupID')->nullable()->index('assocToGroup');
            $table->integer('userID')->index('userID');
            $table->string('page', 1024)->index('page');
            $table->text('userAgent')->nullable();
            $table->text('post')->nullable();
            $table->text('files')->nullable();
            $table->string('IP', 40)->index('IP');
            $table->dateTime('created');
        });

        Schema::connection('mysql_logging')->create('system_users_fingerprint', function (Blueprint $table) {
            $table->integer('id', true);
            $table->integer('userID')->nullable();
            $table->text('agent')->nullable();
            $table->string('ipAddress', 25)->nullable();
            $table->dateTime('created');

            $table->index(['userID', 'agent', 'ipAddress'], 'userID');
        });
    }

    public function down()
    {
        Schema::connection('mysql_logging')->dropIfExists('system_users_fingerprint');

        Schema::connection('mysql_logging')->dropIfExists('system_user_logging');

        Schema::connection('mysql_logging')->dropIfExists('group_send_logon_details');
    }
};
