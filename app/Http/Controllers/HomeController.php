<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Auth;
class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index()
    {
        return view('home');
    }

    public function upload(Request $request)
    {
        try {
            Log::info('Inicio de la función upload múltiple');
            $request->validate([
                'audios' => 'required|array',
                'audios.*' => 'required|file|mimes:mp3,wav,ogg|max:20480', // Max 20MB por archivo
            ]);

            $uploadedFiles = [];
            $totalSize = 0;
            $maxTotalSize = 100 * 1024 * 1024; // 100MB máximo total

            // Verificar tamaño total antes de procesar
            foreach ($request->file('audios') as $audio) {
                $totalSize += $audio->getSize();
            }

            if ($totalSize > $maxTotalSize) {
                return redirect('/home')->with('error', 'El tamaño total de los archivos excede el límite de 100MB.');
            }

            // Procesar cada archivo
            foreach ($request->file('audios') as $audio) {
                Log::info('Procesando archivo: ' . $audio->getClientOriginalName());
                $filename = time() . '_' . uniqid() . '.' . $audio->getClientOriginalExtension();
                Log::info('Nombre del archivo generado: ' . $filename);
                $audio->storeAs('public/audios', $filename);
                Log::info('Archivo guardado en: public/audios/' . $filename);
                $uploadedFiles[] = $filename;
                
                // Guardar referencia en la base de datos
                $user = Auth::user();
                if ($user) {
                    $audioValue = $user->audio ? $user->audio . ',' . $filename : $filename;
                    \App\Models\User::where('id', $user->id)->update(['audio' => $audioValue]);
                    Log::info('Audio guardado en base de datos para usuario: ' . $user->id);
                }
            }

            $count = count($uploadedFiles);
            Log::info('Fin de la función upload múltiple. Archivos subidos: ' . $count);

            if ($count === 1) {
                return redirect('/home')->with('success', '1 audio subido correctamente.');
            } else {
                return redirect('/home')->with('success', $count . ' audios subidos correctamente.');
            }
        } catch (\Exception $e) {
            Log::error('Error en la función upload múltiple: ' . $e->getMessage());
            return redirect('/home')->with('error', 'Error al subir los audios: ' . $e->getMessage());
        }
    }
}
