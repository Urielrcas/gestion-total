<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Global - Gestión Total PyME</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    
    <style>
        :root {
            --sidebar-width: 280px;
            --primary-green: #10b981;
            --primary-dark: #059669;
            --bg-light: #f9fafb;
            --border-color: #e5e7eb;
            --text-main: #111827;
            --text-muted: #6b7280;
        }

        body {
            margin: 0;
            font-family: 'Inter', 'Segoe UI', sans-serif;
            background-color: var(--bg-light);
            display: flex;
            color: var(--text-main);
        }

        /* --- SIDEBAR --- */
        .sidebar {
            width: var(--sidebar-width);
            height: 100vh;
            background: white;
            border-right: 1px solid var(--border-color);
            position: fixed;
            display: flex;
            flex-direction: column;
        }

        .sidebar-brand {
            padding: 30px 24px;
            display: flex;
            align-items: center;
            gap: 12px;
            font-weight: 800;
            font-size: 1.2rem;
            color: var(--text-main);
        }

        .brand-icon {
            width: 35px;
            height: 35px;
            background: var(--primary-green);
            border-radius: 10px;
            display: flex;
            align-items: center;
            justify-content: center;
            color: white;
            font-size: 1.2rem;
        }

        .nav-menu {
            flex: 1;
            padding: 10px 0;
        }

        .nav-label {
            padding: 20px 24px 10px;
            font-size: 0.7rem;
            font-weight: 700;
            color: #9ca3af;
            text-transform: uppercase;
            letter-spacing: 0.05em;
        }

        .nav-item {
            display: flex;
            align-items: center;
            gap: 12px;
            padding: 12px 24px;
            color: var(--text-muted);
            text-decoration: none;
            font-weight: 500;
            transition: 0.2s;
            border-left: 4px solid transparent;
        }

        .nav-item i {
            width: 20px;
            text-align: center;
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

        /* --- FOOTER DEL SIDEBAR (PERFIL) --- */
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

        .user-role {
            font-size: 0.75rem;
            color: var(--text-muted);
        }

        .logout-link {
            color: #9ca3af;
            font-size: 1.2rem;
            transition: color 0.2s;
            text-decoration: none;
        }

        .logout-link:hover {
            color: #ef4444;
        }

        /* --- CONTENIDO PRINCIPAL --- */
        .main-content {
            margin-left: var(--sidebar-width);
            flex: 1;
            padding: 40px;
        }

        .admin-header {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 35px;
        }

        .btn-new-store {
            background: var(--primary-green);
            color: white;
            padding: 12px 24px;
            border-radius: 10px;
            text-decoration: none;
            font-weight: 600;
            border: none;
            cursor: pointer;
            transition: background 0.3s;
        }

        .btn-new-store:hover { background: var(--primary-dark); }

        /* --- TARJETAS DE ESTADÍSTICAS --- */
        .stats-grid {
            display: grid;
            grid-template-columns: repeat(4, 1fr);
            gap: 24px;
            margin-bottom: 40px;
        }

        .stat-card {
            background: white;
            padding: 24px;
            border-radius: 16px;
            border: 1px solid var(--border-color);
            box-shadow: 0 4px 6px -1px rgba(0,0,0,0.03);
        }

        .stat-label {
            color: var(--text-muted);
            font-size: 0.85rem;
            font-weight: 500;
        }

        .stat-value {
            font-size: 1.8rem;
            font-weight: 800;
            margin: 10px 0;
            color: var(--text-main);
        }

        .stat-trend {
            font-size: 0.8rem;
            font-weight: 600;
        }

        .up { color: #10b981; }
        .down { color: #ef4444; }

        /* --- TABLA DE MONITOREO --- */
        .table-container {
            background: white;
            border-radius: 16px;
            border: 1px solid var(--border-color);
            overflow: hidden;
        }

        .table-header {
            padding: 24px;
            border-bottom: 1px solid var(--border-color);
            display: flex;
            justify-content: space-between;
            align-items: center;
        }

        .search-box {
            padding: 10px 15px;
            border: 1px solid var(--border-color);
            border-radius: 8px;
            width: 300px;
            background: #f9fafb;
        }

        table {
            width: 100%;
            border-collapse: collapse;
        }

        th {
            background: #f9fafb;
            padding: 16px 24px;
            text-align: left;
            font-size: 0.75rem;
            font-weight: 700;
            color: var(--text-muted);
            text-transform: uppercase;
        }

        td {
            padding: 18px 24px;
            border-bottom: 1px solid #f3f4f6;
            font-size: 0.9rem;
        }

        .store-id { font-size: 0.75rem; color: #9ca3af; }

        .badge {
            padding: 5px 12px;
            border-radius: 20px;
            font-size: 0.75rem;
            font-weight: 700;
        }

        .active-badge { background: #dcfce7; color: #166534; }
        .pending-badge { background: #fff7ed; color: #9a3412; }
    </style>
</head>
<body>

    <aside class="sidebar">
        <div class="sidebar-brand">
            <div class="brand-icon"><i class="fa-solid fa-shield-halved"></i></div>
            <span>Gestión Total Admin</span>
        </div>
        
        <nav class="nav-menu">
            <div class="nav-label">Administración Global</div>
            <a href="#" class="nav-item active"><i class="fa-solid fa-chart-line"></i> Resumen Cuentas</a>
            <a href="#" class="nav-item"><i class="fa-solid fa-store"></i> Directorio de Tiendas</a>
            <a href="#" class="nav-item"><i class="fa-solid fa-credit-card"></i> Suscripciones</a>
            
            <div class="nav-label">Reportes del Sistema</div>
            <a href="#" class="nav-item"><i class="fa-solid fa-earth-americas"></i> Finanzas Globales</a>
            <a href="#" class="nav-item"><i class="fa-solid fa-bell"></i> Alertas de Sistema</a>
            
            <div class="nav-label">Ajustes</div>
            <a href="#" class="nav-item"><i class="fa-solid fa-sliders"></i> Configuración Global</a>
        </nav>

        <div class="sidebar-footer">
            <div class="user-profile">
                <img src="https://ui-avatars.com/api/?name=Laura+Admin&background=10b981&color=fff" class="user-avatar" alt="Admin Avatar">
                <div class="user-info-text">
                    <span class="user-name">Laura Admin</span>
                    <span class="user-role">Súper Administrador</span>
                </div>
            </div>
            <a href="/login" class="logout-link" title="Cerrar Sesión">
                <i class="fa-solid fa-right-from-bracket"></i>
            </a>
        </div>
    </aside>

    <main class="main-content">
        <div class="admin-header">
            <div>
                <h1 style="margin:0">Panel de Control General</h1>
                <p style="color: var(--text-muted); margin-top: 5px;">Bienvenida, Laura. Aquí está el estado global de la plataforma.</p>
            </div>
            <button class="btn-new-store"><i class="fa-solid fa-plus"></i> Registrar Nueva Tienda</button>
        </div>

        <div class="stats-grid">
            <div class="stat-card">
                <div class="stat-label">Tiendas Registradas</div>
                <div class="stat-value">1,248</div>
                <div class="stat-trend up"><i class="fa-solid fa-arrow-up"></i> +12 este mes</div>
            </div>
            <div class="stat-card">
                <div class="stat-label">Ingresos Globales</div>
                <div class="stat-value">12,4M</div>
                <div class="stat-trend up"><i class="fa-solid fa-arrow-up"></i> +8.2% vs anterior</div>
            </div>
            <div class="stat-card">
                <div class="stat-label">Egresos Globales</div>
                <div class="stat-value">8,1M</div>
                <div class="stat-trend down"><i class="fa-solid fa-arrow-up"></i> +2.1% gastos</div>
            </div>
            <div class="stat-card">
                <div class="stat-label">Usuarios Activos</div>
                <div class="stat-value">856</div>
                <div class="stat-trend" style="color: #3b82f6;">En tiempo real</div>
            </div>
        </div>

        <div class="table-container">
            <div class="table-header">
                <h3 style="margin:0">Monitoreo de Cuentas (Tiendas)</h3>
                <input type="text" class="search-box" placeholder="Buscar por nombre, dueño o ID...">
            </div>
            <table>
                <thead>
                    <tr>
                        <th>Tienda</th>
                        <th>Propietario</th>
                        <th>Ingresos (Mes)</th>
                        <th>Egresos (Mes)</th>
                        <th>Balance</th>
                        <th>Estado</th>
                    </tr>
                </thead>
                <tbody>
                    <tr>
                        <td>
                            <strong>Abarrotes "La Esperanza"</strong><br>
                            <span class="store-id">ID: 10482 • CDMX</span>
                        </td>
                        <td>Juan Pérez</td>
                        <td>$45,200.00</td>
                        <td>$32,150.00</td>
                        <td style="font-weight: 800;">$13,050.00</td>
                        <td><span class="badge active-badge">Activa</span></td>
                    </tr>
                    <tr>
                        <td>
                            <strong>Miselánea "El Sol"</strong><br>
                            <span class="store-id">ID: 10933 • Guadalajara</span>
                        </td>
                        <td>María García</td>
                        <td>$28,500.00</td>
                        <td>$19,800.00</td>
                        <td style="font-weight: 800;">$8,700.00</td>
                        <td><span class="badge active-badge">Activa</span></td>
                    </tr>
                    <tr>
                        <td>
                            <strong>Cremería "San Juan"</strong><br>
                            <span class="store-id">ID: 11504 • Puebla</span>
                        </td>
                        <td>Ana López</td>
                        <td>$12,300.00</td>
                        <td>$14,500.00</td>
                        <td style="font-weight: 800; color: #ef4444;">-$2,200.00</td>
                        <td><span class="badge pending-badge">Atraso Pago</span></td>
                    </tr>
                </tbody>
            </table>
        </div>
    </main>

</body>
</html>