<?php

namespace App\Http\Controllers;

use App\Models\Transaction;
use App\Models\DailyMetric;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class FinanceController extends Controller
{
    public function index()
    {
        $userId = Auth::id();

        // 1. Obtener historial completo de transacciones
        $transactions = Transaction::where('user_id', $userId)
                                    ->latest()
                                    ->paginate(10);

        // 2. Calcular totales globales para las tarjetas
        $totalIncome = Transaction::where('user_id', $userId)->where('type', 'ingreso')->sum('amount');
        $totalExpenses = Transaction::where('user_id', $userId)->where('type', 'egreso')->sum('amount');
        $balance = $totalIncome - $totalExpenses;

        return view('finanzas', compact('transactions', 'totalIncome', 'totalExpenses', 'balance'));
    }

    public function storeEgreso(Request $request)
    {
        // Validamos que el monto sea un número positivo
        $request->validate([
            'concept' => 'required|string|max:255',
            'amount' => 'required|numeric|min:0.01'
        ]);

        // 1. Registrar la transacción de Egreso
        Transaction::create([
            'user_id' => Auth::id(),
            'concept' => $request->concept,
            'amount' => $request->amount,
            'type' => 'egreso'
        ]);

        // 2. Actualizar las métricas diarias (para que se vea en el Dashboard)
        $metrics = DailyMetric::firstOrCreate(
            ['user_id' => Auth::id(), 'date' => now()->toDateString()]
        );
        $metrics->increment('expenses', $request->amount);

        return redirect()->route('finanzas')->with('success', 'Gasto registrado correctamente');
    }
}