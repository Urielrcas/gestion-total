@extends('layouts.app')

@section('title', 'Finanzas y Compras')

{{-- Inyectamos datos del usuario para el Sidebar --}}
@section('user_name', Auth::user()->name)
@section('user_role_or_store', Auth::user()->store_name)
@section('user_avatar', 'https://ui-avatars.com/api/?name='.urlencode(Auth::user()->name).'&background=dcfce7&color=166534')

@section('styles')
<style>
    /* ESTILOS EXCLUSIVOS DE FINANZAS */
    .finance-summary {
        display: grid;
        grid-template-columns: repeat(auto-fit, minmax(250px, 1fr));
        gap: 24px;
        margin-bottom: 40px;
    }

    .balance-card {
        background: white;
        padding: 24px;
        border-radius: 16px;
        border: 1px solid var(--border-color);
        position: relative;
        box-shadow: 0 4px 6px -1px rgba(0,0,0,0.03);
    }

    .balance-card h4 {
        margin: 0 0 10px 0;
        font-size: 0.85rem;
        color: var(--text-muted);
        text-transform: uppercase;
        letter-spacing: 0.05em;
    }

    .balance-card .amount {
        font-size: 2rem;
        font-weight: 800;
        color: var(--text-main);
    }

    .indicator {
        position: absolute;
        top: 24px;
        right: 24px;
        width: 35px;
        height: 35px;
        border-radius: 10px;
        display: flex;
        align-items: center;
        justify-content: center;
        color: white;
    }

    .finance-grid {
        display: grid;
        grid-template-columns: 1fr 380px;
        gap: 30px;
    }

    /* Formulario de registro de compras */
    .form-card {
        background: white;
        padding: 30px;
        border-radius: 16px;
        border: 1px solid var(--border-color);
        height: fit-content;
        box-shadow: 0 4px 6px -1px rgba(0,0,0,0.03);
    }

    .type-badge {
        padding: 5px 10px;
        border-radius: 20px;
        font-size: 0.7rem;
        font-weight: 800;
    }

    .ingreso { background: #dcfce7; color: #166534; }
    .egreso { background: #fee2e2; color: #991b1b; }

    select, .finance-input {
        width: 100%;
        padding: 12px;
        border: 1px solid var(--border-color);
        border-radius: 10px;
        background: #f9fafb;
        font-size: 0.9rem;
        box-sizing: border-box;
    }
</style>
@endsection

@section('sidebar_menu')
    <a href="/dashboard" class="nav-item"><i class="fa-solid fa-chart-pie"></i> Resumen</a>
    <a href="/pos" class="nav-item"><i class="fa-solid fa-cash-register"></i> Punto de Venta</a>
    <a href="/inventario" class="nav-item"><i class="fa-solid fa-boxes-stacked"></i> Inventario</a>
    <a href="/finanzas" class="nav-item active"><i class="fa-solid fa-wallet"></i> Finanzas</a>
    <a href="/configuracion" class="nav-item"><i class="fa-solid fa-gears"></i> Configuración</a>
@endsection

@section('content')
    <div class="header-section">
        <div>
            <h1 style="margin:0">Finanzas y Compras</h1>
            <p style="color: var(--text-muted); margin-top: 5px;">Controla tus flujos de caja y pagos a proveedores.</p>
        </div>
        <button class="btn-action" style="background:white; color:var(--text-main); border:1px solid var(--border-color);">
            <i class="fa-solid fa-file-export"></i> Exportar Reporte
        </button>
    </div>

    {{-- Resumen de Balance --}}
    <div class="finance-summary">
        <div class="balance-card">
            <h4>Ingresos (Ventas)</h4>
            <div class="amount">${{ number_format($totalIncome, 2) }}</div>
            <div class="indicator" style="background: var(--primary-green);"><i class="fa-solid fa-arrow-up"></i></div>
            <p style="color: var(--primary-green); font-size: 0.8rem; font-weight: 600; margin: 12px 0 0;">Dinero entrante</p>
        </div>
        <div class="balance-card">
            <h4>Egresos (Compras)</h4>
            <div class="amount">${{ number_format($totalExpenses, 2) }}</div>
            <div class="indicator" style="background: var(--danger-red);"><i class="fa-solid fa-arrow-down"></i></div>
            <p style="color: var(--text-muted); font-size: 0.8rem; margin: 12px 0 0;">Gastos y resurtido</p>
        </div>
        <div class="balance-card">
            <h4>Balance Neto</h4>
            <div class="amount">${{ number_format($balance, 2) }}</div>
            <div class="indicator" style="background: #3b82f6;"><i class="fa-solid fa-scale-balanced"></i></div>
            <p style="color: var(--text-muted); font-size: 0.8rem; margin: 12px 0 0;">Utilidad disponible</p>
        </div>
    </div>

    <div class="finance-grid">
        {{-- Historial de Movimientos --}}
        <div class="table-container">
            <div style="padding: 20px 24px; border-bottom: 1px solid var(--border-color); font-weight: 700;">Historial de Movimientos</div>
            <table>
                <thead>
                    <tr>
                        <th>Fecha</th>
                        <th>Concepto</th>
                        <th>Tipo</th>
                        <th>Monto</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($transactions as $t)
                    <tr>
                        <td>{{ $t->created_at->format('d/m/Y H:i') }}</td>
                        <td style="font-weight: 700;">{{ $t->concept }}</td>
                        <td>
                            <span class="type-badge {{ $t->type == 'ingreso' ? 'ingreso' : 'egreso' }}">
                                {{ strtoupper($t->type) }}
                            </span>
                        </td>
                        <td style="font-weight: 800;" class="{{ $t->type == 'ingreso' ? 'positive' : 'negative' }}">
                            {{ $t->type == 'ingreso' ? '+' : '-' }}${{ number_format($t->amount, 2) }}
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="4" style="text-align: center; padding: 40px; color: var(--text-muted);">
                            No hay movimientos registrados.
                        </td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        {{-- Formulario de Registro de Compras --}}
        <div class="form-card">
            <h3><i class="fa-solid fa-cart-plus"></i> Registrar Compra</h3>
            <p style="font-size: 0.85rem; color: var(--text-muted); margin-bottom: 25px;">
                Registra egresos para actualizar tu balance neto.
            </p>
            
            <form action="{{ route('finanzas.egreso') }}" method="POST">
                @csrf
                <div style="margin-bottom: 20px;">
                    <label style="display: block; font-size: 0.85rem; font-weight: 600; margin-bottom: 8px;">Concepto / Proveedor</label>
                    <input type="text" name="concept" class="finance-input" placeholder="Ej. Pago a Bimbo" required>
                </div>

                <div style="margin-bottom: 20px;">
                    <label style="display: block; font-size: 0.85rem; font-weight: 600; margin-bottom: 8px;">Monto total ($)</label>
                    <input type="number" name="amount" step="0.01" class="finance-input" placeholder="0.00" required>
                </div>

                <button type="submit" class="btn-action" style="width: 100%; justify-content: center;">Guardar Egreso</button>
            </form>
        </div>
    </div>
@endsection