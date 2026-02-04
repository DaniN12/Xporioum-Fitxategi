<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use setasign\Fpdi\Fpdi;
use App\Models\Documento;

class NormasController extends Controller
{
    // ✅ función para sacar el id_usuario de tu sesión (sin Auth)
    private function getUserIdFromSession()
    {
        // Caso 1: guardas id_usuario directamente
        if (session()->has('id_usuario')) {
            return session('id_usuario');
        }

        // Caso 2: guardas un array usuario
        if (session()->has('usuario') && is_array(session('usuario')) && isset(session('usuario')['id_usuario'])) {
            return session('usuario')['id_usuario'];
        }

        // Caso 3: guardas un objeto usuario
        if (session()->has('usuario') && is_object(session('usuario')) && isset(session('usuario')->id_usuario)) {
            return session('usuario')->id_usuario;
        }

        return null;
    }

    public function show()
    {
        $idUsuario = $this->getUserIdFromSession();

        // Si no hay sesión -> login
        if (!$idUsuario) {
            return redirect()->route('login.form');
        }

        $firmado = Documento::where('id_usuario', $idUsuario)
            ->where('tipo_archivo', 'norma_firmada')
            ->exists();

        return view('normas.index', compact('firmado'));
    }

    public function firmar(Request $request)
    {
        $idUsuario = $this->getUserIdFromSession();

        if (!$idUsuario) {
            return response()->json(['message' => 'No autenticado'], 401);
        }

        $request->validate([
            'signature' => ['required', 'string'],
        ]);

        // 1) Firma (dataURL) -> PNG
        $dataUrl = $request->input('signature');
        $base64 = substr($dataUrl, strpos($dataUrl, ',') + 1);
        $pngBinary = base64_decode($base64);

        if ($pngBinary === false) {
            return response()->json(['message' => 'Firma inválida'], 422);
        }

        $sigPath = "firmas/{$idUsuario}/firma_" . now()->format('Ymd_His') . ".png";
        Storage::disk('public')->put($sigPath, $pngBinary);

        // 2) PDF base
        $sourcePdf = public_path('norma/Contrato.pdf');
        if (!file_exists($sourcePdf)) {
            return response()->json(['message' => 'No existe el PDF base'], 404);
        }

        // 3) Crear PDF final con firma
        $pdf = new Fpdi();
        $pageCount = $pdf->setSourceFile($sourcePdf);

        for ($pageNo = 1; $pageNo <= $pageCount; $pageNo++) {
            $tplId = $pdf->importPage($pageNo);
            $size = $pdf->getTemplateSize($tplId);

            $pdf->AddPage($size['orientation'], [$size['width'], $size['height']]);
            $pdf->useTemplate($tplId);

            // Firma SOLO en la última página
            if ($pageNo === $pageCount) {
                $sigAbs = Storage::disk('public')->path($sigPath);

                $w = 50;
                $h = 18;
                $x = 20;
                $y = $size['height'] - 35;

                $pdf->Image($sigAbs, $x, $y, $w, $h);

                $pdf->SetFont('Helvetica', '', 9);
                $pdf->SetXY($x, $y + $h + 2);
                $pdf->Cell(0, 5, 'Firmado: ' . now()->format('d/m/Y H:i'), 0, 1);
            }
        }

        // 4) Guardar PDF en storage
        $fileName = "Contrato_firmado_" . now()->format('Ymd_His') . ".pdf";
        $outPath = "documentos/{$idUsuario}/{$fileName}";
        Storage::disk('public')->put($outPath, $pdf->Output('S'));

        // 5) Guardar en BD
      Documento::create([
    'id_usuario' => $idUsuario,
    'incidencia_id' => null,
    'nombre_archivo' => $fileName,
    'ruta_archivo' => $outPath,
    'tipo_archivo' => 'norma_firmada',
]);

        return response()->json(['message' => 'OK']);
    }

    public function misDocumentos()
    {
        $idUsuario = $this->getUserIdFromSession();

        if (!$idUsuario) {
            return redirect()->route('login.form');
        }

        $docs = Documento::where('id_usuario', $idUsuario)
            ->orderByDesc('id_documento')
            ->get();

        return view('alumno.cuenta.documentos', compact('docs'));
    }
}
