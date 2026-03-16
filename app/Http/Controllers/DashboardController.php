<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\DailyMetric;
use App\Models\Transaction;
use Illuminate\Support\Facades\Auth;

class DashboardController extends Controller
{
    public function index()
    {
        // Verificamos que haya un usuario autenticado
        if (!Auth::check()) {
            return redirect()->route('login');
        }

        $user = Auth::user();
        
        // Obtener métricas de hoy. Si no existen, creamos una instancia vacía temporal
        $metrics = DailyMetric::where('user_id', $user->id)
                               ->where('date', now()->toDateString())
                               ->first();

        // Obtener los últimos 5 movimientos reales de la base de datos
        $recentMoves = Transaction::where('user_id', $user->id)
                                    ->latest()
                                    ->take(5)
                                    ->get();

        // IMPORTANTE: 'compact' envía estas dos variables a 'resumen.blade.php'
        return view('resumen', compact('metrics', 'recentMoves'));
    }
}