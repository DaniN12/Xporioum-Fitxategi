<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::table('fichaje', function (Blueprint $table) {
            if (!Schema::hasColumn('fichaje', 'descanso_inicio')) {
                $table->dateTime('descanso_inicio')->nullable();
            }
            if (!Schema::hasColumn('fichaje', 'minutos_descanso')) {
                $table->integer('minutos_descanso')->default(0);
            }
        });
    }

    public function down(): void
    {
        Schema::table('fichaje', function (Blueprint $table) {
            if (Schema::hasColumn('fichaje', 'descanso_inicio')) {
                $table->dropColumn('descanso_inicio');
            }
            if (Schema::hasColumn('fichaje', 'minutos_descanso')) {
                $table->dropColumn('minutos_descanso');
            }
        });
    }
};

