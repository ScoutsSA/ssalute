<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('commerce_products', function (Blueprint $table) {
            $table->integer('id', true);
            $table->integer('groupID')->default(0);
            $table->integer('stockLocationID')->nullable()->index('stocklocationid');
            $table->integer('stockSupplierID')->nullable();
            $table->integer('catID')->nullable();
            $table->integer('subCatID')->nullable();
            $table->integer('subSubCatID')->nullable();
            $table->string('image', 1024)->nullable();
            $table->string('thumb', 1024)->nullable();
            $table->string('name')->fulltext('name');
            $table->string('slug');
            $table->text('description')->fulltext('description');
            $table->text('extended')->nullable()->fulltext('extended');
            $table->integer('featured')->default(0);
            $table->integer('onSale')->default(0);
            $table->decimal('priceIncVAT', 7);
            $table->decimal('salePriceIncVAT', 7)->nullable();
            $table->decimal('costPriceIncVAT', 7)->nullable();
            $table->integer('active');
            $table->dateTime('created');
            $table->integer('createdby');
            $table->dateTime('modified')->nullable();
            $table->integer('modifiedby')->nullable();

            $table->index(['catID', 'subCatID', 'subSubCatID'], 'catid');
            $table->index(['groupID', 'active'], 'groupid');
            $table->index(['groupID', 'featured', 'active'], 'groupid_2');
            $table->index(['groupID', 'onSale', 'active'], 'groupid_3');
            $table->index(['groupID', 'catID', 'active'], 'groupid_4');
            $table->fullText(['name'], 'name_2');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('commerce_products');
    }
};
