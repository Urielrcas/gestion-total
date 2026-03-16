<?php

namespace App\Http\Controllers;

use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ProductController extends Controller
{
    public function index()
    {
        $user = Auth::user();
        $products = Product::where('user_id', $user->id)->get();

        $totalProducts = $products->count();
        $inventoryValue = $products->sum(fn($p) => $p->stock * $p->cost_price);
        $projectedProfit = $products->sum(fn($p) => $p->stock * ($p->sell_price - $p->cost_price));
        $lowStockAlerts = $products->where('stock', '<=', 5)->count();

        return view('inventario', compact('products', 'totalProducts', 'inventoryValue', 'projectedProfit', 'lowStockAlerts'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'code' => 'required|string|unique:products,code',
            'cost_price' => 'required|numeric',
            'sell_price' => 'required|numeric',
            'stock' => 'required|integer',
        ]);

        Product::create([
            'user_id' => Auth::id(),
            'name' => $request->name,
            'category' => $request->category ?? 'General',
            'code' => $request->code,
            'cost_price' => $request->cost_price,
            'sell_price' => $request->sell_price,
            'stock' => $request->stock,
        ]);

        return redirect()->back()->with('success', 'Producto agregado correctamente.');
    }
}