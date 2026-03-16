@extends('layouts.app')

@section('title', 'Resumen General')
@section('icon_header', 'fa-chart-pie')

{{-- Datos dinámicos del usuario --}}
@section('user_name', Auth::user()->name)
@section('user_role_or_store', Auth::user()->store_name)
@section('user_avatar', 'https://ui-avatars.com/api/?name='.urlencode(Auth::user()->name).'&background=dcfce7&color=166534')

@section('styles')
<style>
    /* --- ESTILOS EXCLUSIVOS DE RESUMEN --- */
    .header-row {
        display: flex;
        justify-content: space-between;
        align-items: center;
        margin-bottom: 35px;
    }

    /* Grid de tarjetas superiores */
    .metrics-grid {
        display: grid;
        grid-template-columns: repeat(auto-fit, minmax(200px, 1fr));
        gap: 20px;
        margin-bottom: 30px;
    }

    .metric-card {
        background: white;
        padding: 24px;
        border-radius: 16px;
        border: 1px solid var(--border-color);
        box-shadow: 0 4px 6px -1px rgba(0,0,0,0.03);
    }

    .metric-label {
        color: var(--text-muted);
        font-size: 0.9rem;
        margin-bottom: 10px;
        font-weight: 500;
    }

    .metric-value {
        font-size: 1.8rem;
        font-weight: 800;
        color: var(--text-main);
    }

    .metric-change {
        font-size: 0.8rem;
        margin-top: 8px;
        font-weight: 600;
    }

    .positive { color: var(--primary-green); }
    .negative { color: #ef4444; }

    /* Layout central (Gráfica y Movimientos) */
    .dashboard-row {
        display: grid;
        grid-template-columns: 2fr 1fr;
        gap: 24px;
    }

    .chart-container, .recent-moves {
        background: white;
        padding: 24px;
        border-radius: 16px;
        border: 1px solid var(--border-color);
    }

    /* Estilos de la gráfica de barras manual */
    .bar-chart {
        display: flex;
        align-items: flex-end;
        justify-content: space-between;
        height: 200px;
        padding-top: 20px;
        border-bottom: 1px solid #f3f4f6;
    }

    .bar-group {
        display: flex;
        flex-direction: column;
        align-items: center;
        width: 45px;
    }

    .bar-stack {
        display: flex;
        gap: 4px;
        align-items: flex-end;
        height: 150px;
    }

    .bar { width: 14px; border-radius: 4px 4px 0 0; }
    .bar.green { background: var(--primary-green); }
    .bar.red { background: #fca5a5; }

    /* Lista de movimientos */
    .move-item {
        display: flex;
        justify-content: space-between;
        align-items: center;
        padding: 15px 0;
        border-bottom: 1px solid #f9fafb;
    }
</style>
@endsection

@section('sidebar_menu')
    <a href="/dashboard" class="nav-item active"><i class="fa-solid fa-chart-pie"></i> Resumen</a>
    <a href="/pos" class="nav-item"><i class="fa-solid fa-cash-register"></i> Punto de Venta</a>
    <a href="/inventario" class="nav-item"><i class="fa-solid fa-boxes-stacked"></i> Inventario</a>
    <a href="/finanzas" class="nav-item"><i class="fa-solid fa-wallet"></i> Finanzas</a>
    <a href="/configuracion" class="nav-item"><i class="fa-solid fa-gears"></i> Configuración</a>
@endsection

@section('content')
    <div class="header-row">
        <h1>Resumen General</h1>
        <a href="/pos" class="btn-action"><i class="fa-solid fa-plus"></i> Nueva Venta</a>
    </div>

    <div class="metrics-grid">
        <div class="metric-card">
            <div class="metric-label">Ingresos del Día</div>
            <div class="metric-value">${{ number_format($metrics->income ?? 0, 2) }}</div>
            <div class="metric-change positive"><i class="fa-solid fa-arrow-up"></i> Hoy</div>
        </div>
        
        <div class="metric-card">
            <div class="metric-label">Egresos del Día</div>
            <div class="metric-value">${{ number_format($metrics->expenses ?? 0, 2) }}</div>
            <div class="metric-change negative"><i class="fa-solid fa-arrow-down"></i> Hoy</div>
        </div>

        <div class="metric-card">
            <div class="metric-label">Ganancia Neta</div>
            @php 
                $ganancia = ($metrics->income ?? 0) - ($metrics->expenses ?? 0); 
            @endphp
            <div class="metric-value" style="color: {{ $ganancia >= 0 ? 'var(--primary-green)' : '#ef4444' }}">
                ${{ number_format($ganancia, 2) }}
            </div>
            <div class="metric-change" style="color:var(--text-muted)">Total en caja</div>
        </div>

        <div class="metric-card">
            <div class="metric-label">Alertas Inventario</div>
            <div class="metric-value" style="color:#f59e0b">{{ $metrics->low_stock_alerts ?? 0 }}</div>
            <div class="metric-change">Productos bajo stock</div>
        </div>
    </div>

    <div class="dashboard-row">
        <div class="chart-container">
            <h3 style="margin-top:0">Balance Semanal</h3>
            <div class="bar-chart">
                <div class="bar-group">
                    <div class="bar-stack">
                        <div class="bar green" style="height: 60%"></div>
                        <div class="bar red" style="height: 20%"></div>
                    </div>
                    <span style="font-size: 12px; margin-top:8px; font-weight:600">Lun</span>
                </div>
                <div class="bar-group">
                    <div class="bar-stack">
                        <div class="bar green" style="height: 90%"></div>
                        <div class="bar red" style="height: 35%"></div>
                    </div>
                    <span style="font-size: 12px; margin-top:8px; font-weight:600">Mié</span>
                </div>
                <div class="bar-group">
                    <div class="bar-stack">
                        <div class="bar green" style="height: 75%"></div>
                        <div class="bar red" style="height: 15%"></div>
                    </div>
                    <span style="font-size: 12px; margin-top:8px; font-weight:600">Vie</span>
                </div>
            </div>
        </div>

        <div class="recent-moves">
            <h3 style="margin-top:0">Últimos Movimientos</h3>
            @forelse($recentMoves as $move)
                <div class="move-item">
                    <div>
                        <div style="font-weight: 700">{{ $move->concept }}</div>
                        <div style="font-size: 12px; color:var(--text-muted)">
                            {{ $move->created_at->diffForHumans() }}
                        </div>
                    </div>
                    <div class="{{ $move->type == 'ingreso' ? 'positive' : 'negative' }}">
                        {{ $move->type == 'ingreso' ? '+' : '-' }}${{ number_format($move->amount, 2) }}
                    </div>
                </div>
            @empty
                <p style="color: var(--text-muted); font-size: 0.9rem; text-align: center; margin-top: 20px;">
                    No hay movimientos registrados hoy.
                </p>
            @endforelse
        </div>
    </div>
@endsection