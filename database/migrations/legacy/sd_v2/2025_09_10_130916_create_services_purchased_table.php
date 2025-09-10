<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('services_purchased', function (Blueprint $table) {
            $table->integer('id', true);
            $table->string('emailAddress');
            $table->string('paymentType');
            $table->decimal('amountInclVAT', 10);
            $table->text('serviceName');
            $table->text('productDescription');
            $table->integer('active');
            $table->dateTime('created');
            $table->integer('processed')->default(0);
            $table->dateTime('processedDate')->nullable();
            $table->integer('cancelled')->default(0);
            $table->dateTime('cancelledDate')->nullable();
            $table->integer('groupID')->nullable();
            $table->dateTime('associatedToGroupDate')->nullable();
            $table->integer('associatedToGroupBy')->nullable();
            $table->date('startDate')->nullable();
            $table->date('endDate')->nullable();

            $table->index(['emailAddress', 'serviceName', 'active', 'processed'], 'emailaddress');
            $table->index(['groupID', 'serviceName', 'active', 'processed'], 'groupid');
            $table->index(['groupID', 'active', 'processed', 'endDate'], 'groupid_2');
            $table->index(['processed', 'groupID', 'active'], 'processed');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('services_purchased');
    }
};
