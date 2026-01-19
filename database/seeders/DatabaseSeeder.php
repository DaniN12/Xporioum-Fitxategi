<?php
namespace Database\Seeders;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class PruebaSeeder extends Seeder {
    public function run() {
        // Insertar datos mínimos para que funcionen las claves foráneas
        $idioma = DB::table('idioma')->insertGetId(['nombre' => 'Español', 'codigo' => 'es']);
        $userProf = DB::table('usuario')->insertGetId(['email'=>'p@test.com','contrasena'=>'123','nombre'=>'Prof','dni'=>'1','idioma_id'=>$idioma]);
        $userAlum = DB::table('usuario')->insertGetId(['email'=>'a@test.com','contrasena'=>'123','nombre'=>'Alum','dni'=>'2','idioma_id'=>$idioma]);
        $profId = DB::table('profesor')->insertGetId(['usuario_id' => $userProf]);
        $empresaId = DB::table('empresa')->insertGetId(['nombre' => 'Test']);
        DB::table('alumno')->insert(['usuario_id'=>$userAlum,'profesor_id'=>$profId,'empresa_id'=>$empresaId,'fecha_alta'=>now()]);

        // Insertar una norma de prueba
        DB::table('normas')->insert(['idioma_id'=>$idioma, 'titulo'=>'Norma 1', 'descripcion'=>'Respetar el silencio', 'archivo_pdf'=>'normas/ejemplo.pdf']);
    }
}
?>
