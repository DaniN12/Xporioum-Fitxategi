<?php
namespace App\Http\Controllers;
use App\Models\Norma;

class NormaController extends Controller {
    public function index() {
        $normas = Norma::all(); // Trae todas las normas de la DB
        return view('normas.index', compact('normas'));
    }

    public function descargar($id) {
        $norma = Norma::findOrFail($id);
        // Descarga el archivo desde el storage
        return response()->download(storage_path('app/public/' . $norma->archivo_pdf));
    }
}
?>
