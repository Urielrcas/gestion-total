<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title') - Gestión Total PyME</title>
    
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    
    <style>
        /* CONFIGURACIÓN BASE Y VARIABLES */
        :root {
            --sidebar-width: 280px;
            --primary-green: #10b981;
            --primary-dark: #059669;
            --bg-light: #f9fafb;
            --text-main: #111827;
            --text-muted: #6b7280;
            --border-color: #e5e7eb;
            --danger-red: #ef4444;
        }

        body {
            margin: 0;
            font-family: 'Inter', 'Segoe UI', system-ui, sans-serif;
            background-color: var(--bg-light);
            display: flex;
            color: var(--text-main);
        }

        /* SIDEBAR MAESTRO */
        .sidebar {
            width: var(--sidebar-width);
            height: 100vh;
            background: #d1fae5;
            border-right: 1px solid var(--border-color);
            display: flex;
            flex-direction: column;
            position: fixed;
            z-index: 100;
        }

        .sidebar-header {
            padding: 30px 24px;
            display: flex;
            align-items: center;
            gap: 12px;
            font-weight: 800;
            font-size: 1.2rem;
        }

        .logo-box {
            width: 35px;
            height: 35px;
            background: var(--primary-green);
            border-radius: 10px;
            display: flex;
            align-items: center;
            justify-content: center;
            color: white;
        }

        .nav-menu {
            flex: 1;
            padding: 10px 0;
        }

        .nav-item {
            display: flex;
            align-items: center;
            gap: 12px;
            padding: 12px 24px;
            text-decoration: none;
            color: var(--text-muted);
            font-weight: 500;
            transition: 0.2s;
            border-left: 4px solid transparent;
        }

        .nav-item i {
            width: 20px;
            text-align: center;
            font-size: 1.1rem;
        }

        .nav-item:hover {
            background: #f3f4f6;
            color: var(--text-main);
        }

        .nav-item.active {
            background: #ecfdf5;
            color: var(--primary-green);
            border-left: 4px solid var(--primary-green);
            font-weight: 600;
        }

        /* FOOTER DEL SIDEBAR (PERFIL) */
        .sidebar-footer {
            padding: 20px;
            border-top: 1px solid #f3f4f6;
            display: flex;
            align-items: center;
            justify-content: space-between;
        }

        .user-profile {
            display: flex;
            align-items: center;
            gap: 12px;
        }

        .user-avatar {
            width: 42px;
            height: 42px;
            border-radius: 50%;
            object-fit: cover;
            border: 2px solid #ecfdf5;
        }

        .user-info-text {
            display: flex;
            flex-direction: column;
        }

        .user-name {
            font-size: 0.9rem;
            font-weight: 700;
            color: var(--text-main);
        }

        .user-store {
            font-size: 0.75rem;
            color: var(--text-muted);
        }

        .logout-link {
            color: #9ca3af;
            font-size: 1.1rem;
            transition: color 0.2s;
            text-decoration: none;
        }

        .logout-link:hover { color: var(--danger-red); }

        /* CONTENIDO PRINCIPAL */
        .main-content {
            margin-left: var(--sidebar-width);
            flex: 1;
            padding: 40px;
            min-height: 100vh;
            box-sizing: border-box;
        }

        /* CABECERAS Y BOTONES */
        .header-section, .header-row {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 35px;
        }

        .btn-add, .btn-action {
            background: var(--primary-green);
            color: white;
            padding: 12px 24px;
            border-radius: 10px;
            text-decoration: none;
            font-weight: 600;
            border: none;
            cursor: pointer;
            transition: background 0.3s;
            display: flex;
            align-items: center;
            gap: 8px;
        }

        .btn-add:hover, .btn-action:hover { background: var(--primary-dark); }

        /* GRID DE TARJETAS (MÉTRICAS E INVENTARIO) */
        .inventory-summary, .metrics-grid {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(200px, 1fr));
            gap: 24px;
            margin-bottom: 40px;
        }

        .summary-card, .metric-card {
            background: white;
            padding: 24px;
            border-radius: 16px;
            border: 1px solid var(--border-color);
            box-shadow: 0 4px 6px -1px rgba(0,0,0,0.03);
        }

        .summary-card h4, .metric-label {
            margin: 0 0 10px 0;
            color: var(--text-muted);
            font-size: 0.75rem;
            text-transform: uppercase;
            letter-spacing: 0.05em;
        }

        .summary-card .value, .metric-value {
            font-size: 1.8rem;
            font-weight: 800;
            color: var(--text-main);
        }

        /* LAYOUT DASHBOARD (GRÁFICA + MOVIMIENTOS) */
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

        /* GRÁFICA DE BARRAS MANUAL */
        .bar-chart {
            display: flex;
            align-items: flex-end;
            justify-content: space-between;
            height: 200px;
            padding-top: 20px;
            border-bottom: 1px solid #f3f4f6;
        }
        .bar-group { display: flex; flex-direction: column; align-items: center; width: 45px; }
        .bar-stack { display: flex; gap: 4px; align-items: flex-end; height: 150px; }
        .bar { width: 14px; border-radius: 4px 4px 0 0; }
        .bar.green { background: var(--primary-green); }
        .bar.red { background: #fca5a5; }

        /* MOVIMIENTOS RECIENTES */
        .move-item {
            display: flex;
            justify-content: space-between;
            align-items: center;
            padding: 15px 0;
            border-bottom: 1px solid #f9fafb;
        }

        /* TABLAS E INVENTARIO */
        .table-container {
            background: white;
            border-radius: 16px;
            border: 1px solid var(--border-color);
            overflow: hidden;
        }

        table { width: 100%; border-collapse: collapse; text-align: left; }
        thead { background: #f9fafb; border-bottom: 1px solid var(--border-color); }
        th { padding: 16px 24px; font-size: 0.75rem; color: var(--text-muted); font-weight: 700; text-transform: uppercase; }
        td { padding: 20px 24px; border-bottom: 1px solid #f3f4f6; font-size: 0.95rem; }

        /* BADGES Y ESTADOS */
        .badge { padding: 6px 12px; border-radius: 20px; font-size: 0.75rem; font-weight: 700; display: inline-flex; align-items: center; gap: 6px; }
        .badge-stock { background: #ecfdf5; color: #065f46; }
        .badge-low { background: #fff7ed; color: #9a3412; }
        .badge-out { background: #fef2f2; color: #991b1b; }
        .positive { color: var(--primary-green); }
        .negative { color: var(--danger-red); }

        .margin-tag { background: #f0fdf4; color: #166534; padding: 4px 10px; border-radius: 8px; font-weight: 800; font-size: 0.85rem; }
        .editable-price { border: 1px solid var(--border-color); padding: 8px 12px; border-radius: 8px; width: 90px; background: #f9fafb; font-weight: 600; color: var(--text-main); }
    </style>

    @yield('styles')
</head>
<body>

    <aside class="sidebar">
<div class="sidebar-header">
    <div class="logo-box">
        <i class="fa-solid fa-store"></i> 
    </div>
    <span>Gestión Total</span>
</div>
        
        <nav class="nav-menu">
            @yield('sidebar_menu') 
        </nav>

        <div class="sidebar-footer">
            <div class="user-profile">
                <img src="@yield('user_avatar', 'https://ui-avatars.com/api/?name=Usuario&background=10b981&color=fff')" class="user-avatar" alt="Avatar">
                
                <div class="user-info-text">
                    <span class="user-name">@yield('user_name', 'Usuario')</span>
                    <span class="user-store">@yield('user_role_or_store', 'Tienda')</span>
                </div>
            </div>
            
            <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
                @csrf
            </form>
            <a href="#" class="logout-link" title="Cerrar Sesión" 
               onclick="event.preventDefault(); document.getElementById('logout-form').submit();">
                <i class="fa-solid fa-right-from-bracket"></i>
            </a>
        </div>
    </aside>

    <main class="main-content">
        @yield('content')
    </main>

    @yield('scripts')
</body>
</html>