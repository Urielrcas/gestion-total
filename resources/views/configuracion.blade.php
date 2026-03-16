<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Configuración - Gestión Total PyME</title>
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

        .user-store {
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

        .section-card {
            background: white;
            border-radius: 16px;
            border: 1px solid var(--border-color);
            padding: 30px;
            margin-bottom: 30px;
            box-shadow: 0 4px 6px -1px rgba(0,0,0,0.03);
        }

        .section-header {
            margin-bottom: 25px;
            border-bottom: 1px solid #f3f4f6;
            padding-bottom: 15px;
        }

        .section-header h2 {
            margin: 0;
            font-size: 1.25rem;
            color: var(--text-main);
            display: flex;
            align-items: center;
            gap: 10px;
        }

        .section-header p {
            margin: 5px 0 0 0;
            font-size: 0.9rem;
            color: var(--text-muted);
        }

        /* FOTO DE PERFIL */
        .profile-upload {
            display: flex;
            align-items: center;
            gap: 20px;
            margin-bottom: 30px;
        }

        .avatar-preview {
            width: 80px;
            height: 80px;
            border-radius: 50%;
            object-fit: cover;
            border: 3px solid #ecfdf5;
        }

        /* FORMULARIOS GRID */
        .form-grid {
            display: grid;
            grid-template-columns: 1fr 1fr;
            gap: 25px;
            margin-bottom: 20px;
        }

        .input-group {
            display: flex;
            flex-direction: column;
            gap: 8px;
        }

        label {
            font-size: 0.85rem;
            font-weight: 700;
            color: var(--text-main);
        }

        input, select {
            padding: 12px;
            border: 1px solid var(--border-color);
            border-radius: 10px;
            background: #f9fafb;
            font-size: 0.95rem;
            color: var(--text-main);
        }

        input:focus {
            outline: none;
            border-color: var(--primary-green);
            background: white;
        }

        /* BOTONES */
        .btn-save {
            background: var(--primary-green);
            color: white;
            padding: 12px 24px;
            border: none;
            border-radius: 10px;
            font-weight: 700;
            cursor: pointer;
            float: right;
            transition: background 0.3s;
        }

        .btn-save:hover { background: var(--primary-dark); }

        .btn-outline {
            background: white;
            border: 1px solid var(--border-color);
            color: var(--text-main);
            padding: 10px 20px;
            border-radius: 8px;
            font-weight: 600;
            cursor: pointer;
            transition: all 0.2s;
        }

        .btn-outline:hover { background: #f3f4f6; }
    </style>
</head>
<body>

    <aside class="sidebar">
        <div class="sidebar-header">
            <div class="logo-box"><i class="fa-solid fa-store"></i></div>
            <span>Gestión Total</span>
        </div>
        
        <nav class="nav-menu">
            <a href="/dashboard" class="nav-item"><i class="fa-solid fa-chart-pie"></i> Resumen</a>
            <a href="/pos" class="nav-item"><i class="fa-solid fa-cash-register"></i> Punto de Venta</a>
            <a href="/inventario" class="nav-item"><i class="fa-solid fa-boxes-stacked"></i> Inventario</a>
            <a href="/finanzas" class="nav-item"><i class="fa-solid fa-wallet"></i> Finanzas</a>
            <a href="/configuracion" class="nav-item active"><i class="fa-solid fa-gears"></i> Configuración</a>
        </nav>

        <div class="sidebar-footer">
            <div class="user-profile">
                <img src="https://ui-avatars.com/api/?name=Mari+Gomez&background=dcfce7&color=166534" class="user-avatar" alt="Avatar">
                <div class="user-info-text">
                    <span class="user-name">Doña Mari</span>
                    <span class="user-store">Abarrotes Esperanza</span>
                </div>
            </div>
            <a href="/login" class="logout-link" title="Cerrar Sesión">
                <i class="fa-solid fa-right-from-bracket"></i>
            </a>
        </div>
    </aside>

    <main class="main-content">
        <h1 style="margin-bottom: 30px;">Configuración del Sistema</h1>
        
        <div class="section-card">
            <div class="section-header">
                <h2><i class="fa-solid fa-address-card" style="color: var(--primary-green);"></i> Perfil y Negocio</h2>
                <p>Gestiona la información pública de tu tienda y los datos de contacto.</p>
            </div>

            <div class="profile-upload">
                <img src="https://ui-avatars.com/api/?name=Mari+Gomez&background=dcfce7&color=166534" class="avatar-preview" alt="Profile">
                <div>
                    <button class="btn-outline"><i class="fa-solid fa-camera"></i> Cambiar foto</button>
                    <p style="font-size: 0.8rem; color: var(--text-muted); margin-top: 8px;">Recomendado: Cuadrada, JPG o PNG.</p>
                </div>
            </div>

            <form>
                <div class="form-grid">
                    <div class="input-group">
                        <label>Nombre Completo</label>
                        <input type="text" value="Doña Mari Gómez">
                    </div>
                    <div class="input-group">
                        <label>Nombre de la Tienda</label>
                        <input type="text" value="Abarrotes La Esperanza">
                    </div>
                    <div class="input-group">
                        <label>Correo Electrónico</label>
                        <input type="email" value="contacto@laesperanza.com">
                    </div>
                    <div class="input-group">
                        <label>Teléfono de Contacto</label>
                        <input type="text" value="555-123-4567">
                    </div>
                </div>
                <div class="input-group" style="margin-bottom: 25px;">
                    <label>Dirección Física del Negocio</label>
                    <input type="text" value="Calle Independencia #45, Col. Centro">
                </div>
                <button type="button" class="btn-save">Guardar Cambios</button>
                <div style="clear:both"></div>
            </form>
        </div>

        <div class="section-card">
            <div class="section-header">
                <h2><i class="fa-solid fa-sliders" style="color: var(--primary-green);"></i> Preferencias de Operación</h2>
                <p>Ajusta el comportamiento del punto de venta y las notificaciones.</p>
            </div>

            <div class="form-grid">
                <div class="input-group">
                    <label>Moneda de Trabajo</label>
                    <select>
                        <option>MXN - Peso Mexicano</option>
                        <option>USD - Dólar Estadounidense</option>
                    </select>
                </div>
                <div class="input-group">
                    <label>Comportamiento de Tickets</label>
                    <select>
                        <option>Imprimir automáticamente al cobrar</option>
                        <option>Preguntar antes de imprimir</option>
                        <option>Solo generar ticket digital</option>
                    </select>
                </div>
                <div class="input-group">
                    <label>Umbral de Inventario Bajo</label>
                    <input type="text" value="Notificar cuando queden 5 unidades o menos">
                </div>
                <div class="input-group">
                    <label>Idioma del Sistema</label>
                    <select>
                        <option>Español (México)</option>
                        <option>English</option>
                    </select>
                </div>
            </div>
            <button type="button" class="btn-save">Actualizar Preferencias</button>
            <div style="clear:both"></div>
        </div>
    </main>

</body>
</html>