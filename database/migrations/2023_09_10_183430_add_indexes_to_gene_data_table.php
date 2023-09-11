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
        Schema::table('gene_data', function (Blueprint $table) {
            $table->index('gene_id');
            $table->index('SRA');
            $table->index('Expriment');
            $table->index('Disease');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('gene_data', function (Blueprint $table) {
            $table->dropIndex('gene_data_gene_id_index');
            $table->dropIndex('gene_data_SRA_index');
            $table->dropIndex('gene_data_Expriment_index');
            $table->dropIndex('gene_data_Disease_index');
        });
    }
};
