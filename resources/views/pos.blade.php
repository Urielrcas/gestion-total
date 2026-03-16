@extends('layouts.app')

@section('title', 'Punto de Venta')

{{-- Sidebar dinámico --}}
@section('sidebar_menu')
    <a href="/dashboard" class="nav-item"><i class="fa-solid fa-chart-pie"></i> Resumen</a>
    <a href="/pos" class="nav-item active"><i class="fa-solid fa-cash-register"></i> Punto de Venta</a>
    <a href="/inventario" class="nav-item"><i class="fa-solid fa-boxes-stacked"></i> Inventario</a>
    <a href="/finanzas" class="nav-item"><i class="fa-solid fa-wallet"></i> Finanzas</a>
    <a href="/configuracion" class="nav-item"><i class="fa-solid fa-gears"></i> Configuración</a>
@endsection

@section('styles')
<style>
    /* Estilos específicos para que el POS no interfiera con otras páginas */
    .main-container-pos {
        display: flex;
        flex-direction: column;
        height: calc(100vh - 80px);
        overflow: hidden;
    }

    .top-bar {
        padding: 15px 0;
        display: flex;
        justify-content: space-between;
        align-items: center;
        margin-bottom: 20px;
    }

    .search-input-pos {
        width: 450px;
        padding: 12px 40px;
        border: 1px solid var(--border-color);
        border-radius: 10px;
        background: white;
    }

    .pos-content {
        display: grid;
        grid-template-columns: 1fr 400px;
        gap: 20px;
        flex: 1;
        overflow: hidden;
    }

    .products-section {
        overflow-y: auto;
        padding-right: 10px;
    }

    .products-grid {
        display: grid;
        grid-template-columns: repeat(auto-fill, minmax(200px, 1fr));
        gap: 15px;
    }

    .product-card {
        background: white;
        border-radius: 16px;
        padding: 20px;
        border: 1px solid var(--border-color);
        cursor: pointer;
        transition: all 0.2s;
        text-align: center;
    }

    .product-card:hover {
        border-color: var(--primary-green);
        transform: translateY(-3px);
        box-shadow: 0 4px 12px rgba(0,0,0,0.05);
    }

    .ticket-section {
        background: white;
        border-radius: 16px;
        border: 1px solid var(--border-color);
        display: flex;
        flex-direction: column;
        padding: 25px;
    }

    .ticket-items {
        flex: 1;
        overflow-y: auto;
        margin: 20px 0;
    }

    .ticket-item {
        display: flex;
        justify-content: space-between;
        margin-bottom: 12px;
        font-size: 0.9rem;
    }

    .btn-pay {
        width: 100%;
        background: var(--primary-green);
        color: white;
        border: none;
        padding: 18px;
        border-radius: 12px;
        font-size: 1.1rem;
        font-weight: 700;
        cursor: pointer;
    }
</style>
@endsection

@section('content')
<div class="main-container-pos">
    <div class="top-bar">
        <div style="position: relative;">
            <i class="fa-solid fa-magnifying-glass" style="position: absolute; left: 15px; top: 15px; color: var(--text-muted);"></i>
            <input type="text" id="search-input" class="search-input-pos" placeholder="Escanear código o buscar nombre...">
        </div>
        <h2 style="margin:0; color: var(--primary-dark);">Venta en Curso</h2>
    </div>

    <div class="pos-content">
        <div class="products-section">
            <div class="products-grid">
                @forelse($products as $product)
                <div class="product-card" onclick="addToCart({{ $product->id }}, '{{ $product->name }}', {{ $product->sell_price }})">
                    <div style="font-size: 2rem; margin-bottom: 10px;">📦</div>
                    <span style="font-weight:700; display:block;">{{ $product->name }}</span>
                    <span style="color: var(--text-muted); font-size: 0.8rem;">Stock: {{ $product->stock }}</span>
                    <div style="color: var(--primary-green); font-weight: 800; margin-top: 10px;">
                        ${{ number_format($product->sell_price, 2) }}
                    </div>
                </div>
                @empty
                <p>No hay productos en inventario.</p>
                @endforelse
            </div>
        </div>

        <div class="ticket-section">
            <div style="border-bottom: 2px dashed var(--border-color); padding-bottom: 15px;">
                <span style="font-weight:700; color:var(--text-muted); text-transform:uppercase; font-size:0.8rem;">Ticket de Venta</span>
            </div>

            <div class="ticket-items" id="ticket-list">
                <p style="text-align: center; color: var(--text-muted); margin-top: 50px;">Carrito vacío</p>
            </div>

            <div style="border-top: 1px solid var(--border-color); padding-top: 20px;">
                <div style="display: flex; justify-content: space-between; font-size: 1.5rem; font-weight: 800;">
                    <span>Total</span>
                    <span id="total-amount">$0.00</span>
                </div>
                <button class="btn-pay" onclick="procesarVenta()">
                    <i class="fa-solid fa-cash-register"></i> COBRAR VENTA
                </button>
            </div>
        </div>
    </div>
</div>
@endsection

@section('scripts')
<script>
    let cart = [];

    function addToCart(id, name, price) {
        let item = cart.find(i => i.id === id);
        if (item) {
            item.qty++;
        } else {
            cart.push({ id, name, price, qty: 1 });
        }
        renderTicket();
    }

    function renderTicket() {
        const list = document.getElementById('ticket-list');
        const totalDisp = document.getElementById('total-amount');
        list.innerHTML = '';
        let total = 0;

        cart.forEach(item => {
            total += item.price * item.qty;
            list.innerHTML += `
                <div class="ticket-item">
                    <span>${item.name} x${item.qty}</span>
                    <span style="font-weight:600;">$${(item.price * item.qty).toFixed(2)}</span>
                </div>
            `;
        });

        totalDisp.innerText = `$${total.toFixed(2)}`;
    }

    function procesarVenta() {
        if (cart.length === 0) return alert("El carrito está vacío");
        
        fetch('{{ route("pos.checkout") }}', {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
                'X-CSRF-TOKEN': '{{ csrf_token() }}'
            },
            body: JSON.stringify({ items: cart })
        })
        .then(res => res.json())
        .then(data => {
            if (data.success) {
                alert("Venta realizada con éxito");
                location.reload(); // Recarga para actualizar stock visualmente
            }
        });
    }
</script>
@endsection