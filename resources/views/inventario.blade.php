@extends('layouts.app')

@section('title', 'Inventario')
@section('icon_header', 'fa-boxes-stacked')

{{-- Inyectamos datos del usuario para el Sidebar --}}
@section('user_name', Auth::user()->name)
@section('user_role_or_store', Auth::user()->store_name)
@section('user_avatar', 'https://ui-avatars.com/api/?name='.urlencode(Auth::user()->name).'&background=dcfce7&color=166534')

@section('sidebar_menu')
    <a href="/dashboard" class="nav-item"><i class="fa-solid fa-chart-pie"></i> Resumen</a>
    <a href="/pos" class="nav-item"><i class="fa-solid fa-cash-register"></i> Punto de Venta</a>
    <a href="/inventario" class="nav-item active"><i class="fa-solid fa-boxes-stacked"></i> Inventario</a>
    <a href="/finanzas" class="nav-item"><i class="fa-solid fa-wallet"></i> Finanzas</a>
    <a href="/configuracion" class="nav-item"><i class="fa-solid fa-gears"></i> Configuración</a>
@endsection

@section('content')
    <div class="header-section">
        <div>
            <h1 style="margin:0">Gestión de Inventario</h1>
            <p style="color: var(--text-muted); margin-top: 5px;">Controla tus existencias y ajusta precios de venta.</p>
        </div>
        {{-- Botón que activa el Modal --}}
        <button class="btn-add" onclick="abrirModal()"><i class="fa-solid fa-plus"></i> Añadir producto</button>
    </div>

    <div class="inventory-summary">
        <div class="summary-card">
            <h4>Total Productos</h4>
            <div class="value">{{ $totalProducts }}</div>
        </div>
        <div class="summary-card">
            <h4>Valor Inventario</h4>
            <div class="value">${{ number_format($inventoryValue, 2) }}</div>
        </div>
        <div class="summary-card">
            <h4>Ganancia Proyectada</h4>
            <div class="value" style="color: var(--primary-green);">${{ number_format($projectedProfit, 2) }}</div>
        </div>
        <div class="summary-card">
            <h4>Alertas de Stock</h4>
            <div class="value" style="color: var(--danger-red);">{{ $lowStockAlerts }}</div>
        </div>
    </div>

    <div class="table-container">
        <table>
            <thead>
                <tr>
                    <th>Producto</th>
                    <th>Estado Stock</th>
                    <th>Costo Unit.</th>
                    <th>Precio Venta</th>
                    <th>Margen</th>
                    <th>Acciones</th>
                </tr>
            </thead>
            <tbody>
                @forelse($products as $product)
                <tr>
                    <td class="product-info">
                        <div>{{ $product->name }}</div>
                        <span>{{ $product->category }} • Cód: {{ $product->code }}</span>
                    </td>
                    <td>
                        @if($product->stock <= 0)
                            <span class="badge badge-out"><i class="fa-solid fa-circle-xmark"></i> Agotado</span>
                        @elseif($product->stock <= 5)
                            <span class="badge badge-low"><i class="fa-solid fa-triangle-exclamation"></i> {{ $product->stock }} un.</span>
                        @else
                            <span class="badge badge-stock"><i class="fa-solid fa-circle"></i> {{ $product->stock }} un.</span>
                        @endif
                    </td>
                    <td>${{ number_format($product->cost_price, 2) }}</td>
                    <td><input type="text" class="editable-price" value="${{ number_format($product->sell_price, 2) }}"></td>
                    <td><span class="margin-tag">{{ number_format($product->margin, 0) }}%</span></td>
                    <td>
                        <button style="background:none; border:none; color:var(--primary-green); cursor:pointer; font-weight:700;">
                            <i class="fa-solid fa-pen-to-square"></i> Editar
                        </button>
                    </td>
                </tr>
                @empty
                <tr>
                    <td colspan="6" style="text-align: center; padding: 40px; color: var(--text-muted);">
                        No hay productos registrados aún.
                    </td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>

    {{-- MODAL PARA AÑADIR PRODUCTO --}}
    <div id="modalProducto" style="display:none; position:fixed; top:0; left:0; width:100%; height:100%; background:rgba(0,0,0,0.5); z-index:1000; justify-content:center; align-items:center; backdrop-filter: blur(2px);">
        <div style="background:white; padding:30px; border-radius:20px; width:500px; box-shadow:0 20px 25px -5px rgba(0,0,0,0.1);">
            <h2 style="margin-top:0; color: var(--text-main);">Nuevo Producto</h2>
            
            <form action="{{ route('productos.guardar') }}" method="POST">
                @csrf
                <div style="display:grid; grid-template-columns: 1fr 1fr; gap:15px;">
                    <div style="grid-column: span 2;">
                        <label style="display:block; margin-bottom:5px; font-weight:600;">Nombre del Producto</label>
                        <input type="text" name="name" class="editable-price" style="width:100%; box-sizing:border-box;" required placeholder="Ej. Leche Alpura 1L">
                    </div>
                    <div>
                        <label style="display:block; margin-bottom:5px; font-weight:600;">Categoría</label>
                        <input type="text" name="category" class="editable-price" style="width:100%; box-sizing:border-box;" placeholder="Ej. Lácteos">
                    </div>
                    <div>
                        <label style="display:block; margin-bottom:5px; font-weight:600;">Código</label>
                        <input type="text" name="code" class="editable-price" style="width:100%; box-sizing:border-box;" required placeholder="750123456">
                    </div>
                    <div>
                        <label style="display:block; margin-bottom:5px; font-weight:600;">Costo ($)</label>
                        <input type="number" name="cost_price" step="0.01" class="editable-price" style="width:100%; box-sizing:border-box;" required>
                    </div>
                    <div>
                        <label style="display:block; margin-bottom:5px; font-weight:600;">Precio Venta ($)</label>
                        <input type="number" name="sell_price" step="0.01" class="editable-price" style="width:100%; box-sizing:border-box;" required>
                    </div>
                    <div style="grid-column: span 2;">
                        <label style="display:block; margin-bottom:5px; font-weight:600;">Stock Inicial</label>
                        <input type="number" name="stock" class="editable-price" style="width:100%; box-sizing:border-box;" required>
                    </div>
                </div>

                <div style="margin-top:25px; display:flex; gap:10px;">
                    <button type="submit" class="btn-add" style="flex:1; justify-content:center;">Guardar Producto</button>
                    <button type="button" onclick="cerrarModal()" style="background:#f3f4f6; color:#374151; border:none; padding:12px 24px; border-radius:10px; cursor:pointer; font-weight:600;">Cancelar</button>
                </div>
            </form>
        </div>
    </div>
@endsection

@section('scripts')
<script>
    function abrirModal() { document.getElementById('modalProducto').style.display = 'flex'; }
    function cerrarModal() { document.getElementById('modalProducto').style.display = 'none'; }
    window.onclick = function(event) {
        let modal = document.getElementById('modalProducto');
        if (event.target == modal) cerrarModal();
    }
</script>
@endsection