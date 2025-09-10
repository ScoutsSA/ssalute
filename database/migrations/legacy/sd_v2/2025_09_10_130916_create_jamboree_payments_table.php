<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('jamboree_payments', function (Blueprint $table) {
            $table->integer('id', true);
            $table->integer('jamboreeID');
            $table->integer('userID');
            $table->integer('paymentType');
            $table->decimal('amount', 10);
            $table->date('paymentDate');
            $table->integer('active')->default(1);
            $table->dateTime('created');
            $table->integer('createdby');
            $table->dateTime('modified')->nullable();
            $table->integer('modifiedby')->nullable();
            $table->text('notes')->nullable();

            $table->index(['jamboreeID', 'userID', 'active'], 'jamboreeid');
            $table->index(['jamboreeID', 'active'], 'jamboreeid_2');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('jamboree_payments');
    }
};
