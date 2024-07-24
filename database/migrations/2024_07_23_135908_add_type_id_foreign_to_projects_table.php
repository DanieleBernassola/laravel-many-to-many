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
        Schema::table('projects', function (Blueprint $table) {
            //CREAZIONE CAMPO POSIZIONATO SUBITO DOPO ID
            $table->unsignedBigInteger('type_id')->nullable()->after('id');

            //CREAZIONE FOREIGN KEY
            $table->foreign('type_id')
                ->references('id')
                ->on('types')
                ->nullOnDelete();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('projects', function (Blueprint $table) {
            //DROPPA RELAZIONE
            $table->dropForeign('projects_type_id_foreign');
            //DROPPA IL CAMPO
            $table->dropColumn('type_id');
        });
    }
};
