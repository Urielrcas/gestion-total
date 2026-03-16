<?php

namespace App\Http\Controllers;

use App\Models\Product;
use App\Models\Transaction;
use App\Models\DailyMetric;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;

class PosController extends Controller
{
    public function index()
    {
        // IMPORTANTE: Obtenemos los productos para que la vista no marque error
        $products = Product::where('user_id', Auth::id())->get();
        
        return view('pos', compact('products'));
    }

    // Buscar producto específico (por ejemplo, con lector de barras)
    public function search(Request $request)
    {
        $product = Product::where('user_id', Auth::id())
                          ->where('code', $request->code)
                          ->first();
        return response()->json($product);
    }

    // Registrar la venta final
    public function checkout(Request $request)
    {
        $cart = $request->items;
        $totalVenta = 0;

        try {
            DB::transaction(function () use ($cart, &$totalVenta) {
                foreach ($cart as $item) {
                    $product = Product::find($item['id']);
                    if ($product) {
                        $product->decrement('stock', $item['qty']);
                        $totalVenta += ($product->sell_price * $item['qty']);
                    }
                }

                // Registrar el movimiento en la tabla de transacciones
                Transaction::create([
                    'user_id' => Auth::id(),
                    'concept' => 'Venta POS #' . time(),
                    'amount' => $totalVenta,
                    'type' => 'ingreso'
                ]);

                // Actualizar los ingresos del día en la tabla de métricas
                $metrics = DailyMetric::firstOrCreate(
                    ['user_id' => Auth::id(), 'date' => now()->toDateString()]
                );
                $metrics->increment('income', $totalVenta);
            });

            return response()->json(['success' => true]);
        } catch (\Exception $e) {
            return response()->json(['success' => false, 'message' => $e->getMessage()], 500);
        }
    }
}