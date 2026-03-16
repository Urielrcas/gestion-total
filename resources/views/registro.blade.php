<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Registro - Gestión Total PyME</title>
    <style>
        /* CSS PURO - Mantenemos tu diseño original */
        body {
            margin: 0;
            padding: 0;
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            background-color: #f0fdf4;
            display: flex;
            justify-content: center;
            align-items: center;
            min-height: 100vh;
        }

        .container {
            display: flex;
            width: 1000px;
            background: white;
            border-radius: 20px;
            overflow: hidden;
            box-shadow: 0 10px 25px rgba(0,0,0,0.05);
        }

        .info-side {
            flex: 1;
            background-color: #f0fdf4;
            padding: 60px;
            display: flex;
            flex-direction: column;
            justify-content: center;
        }

        .logo-section {
            display: flex;
            align-items: center;
            gap: 10px;
            margin-bottom: 40px;
        }

        .logo-box {
            width: 32px;
            height: 32px;
            background-color: #10b981;
            border-radius: 6px;
        }

        .brand-name {
            font-weight: bold;
            font-size: 1.2rem;
            color: #1f2937;
        }

        .main-title {
            font-size: 2.5rem;
            color: #064e3b;
            line-height: 1.1;
            margin-bottom: 30px;
        }

        .feature-card {
            background: white;
            padding: 20px;
            border-radius: 12px;
            margin-bottom: 15px;
            border: 1px solid #d1fae5;
        }

        .feature-card h3 {
            margin: 0 0 5px 0;
            font-size: 1rem;
            color: #111827;
        }

        .feature-card p {
            margin: 0;
            font-size: 0.9rem;
            color: #6b7280;
        }

        .form-side {
            flex: 1;
            padding: 60px;
        }

        .form-header h2 {
            font-size: 1.8rem;
            margin-bottom: 5px;
            color: #111827;
        }

        .form-header p {
            color: #6b7280;
            margin-bottom: 30px;
        }

        .form-grid {
            display: grid;
            grid-template-columns: 1fr 1fr;
            gap: 20px;
            margin-bottom: 20px;
        }

        .input-group {
            display: flex;
            flex-direction: column;
            gap: 8px;
        }

        label {
            font-size: 0.9rem;
            font-weight: 500;
            color: #374151;
        }

        input {
            padding: 12px;
            border: 1px solid #e5e7eb;
            border-radius: 8px;
            font-size: 0.95rem;
            background-color: #f9fafb;
        }

        input::placeholder {
            color: #9ca3af;
        }

        .btn-register {
            width: 100%;
            background-color: #10b981;
            color: white;
            padding: 15px;
            border: none;
            border-radius: 8px;
            font-size: 1rem;
            font-weight: 600;
            cursor: pointer;
            margin-top: 20px;
            transition: background 0.3s;
        }

        .btn-register:hover {
            background-color: #059669;
        }

        .login-footer {
            margin-top: 30px;
            padding: 20px;
            background-color: #f0fdf4;
            border-radius: 12px;
            display: flex;
            justify-content: space-between;
            align-items: center;
        }

        .btn-login-redirect {
            background-color: white;
            border: 1px solid #d1fae5;
            padding: 10px 20px;
            border-radius: 8px;
            color: #065f46;
            text-decoration: none;
            font-weight: 500;
        }

        /* Estilos para alertas de error */
        .error-alert {
            background-color: #fef2f2;
            border: 1px solid #fee2e2;
            color: #991b1b;
            padding: 15px;
            border-radius: 8px;
            margin-bottom: 20px;
            font-size: 0.85rem;
        }
    </style>
</head>
<body>

<div class="container">
    <div class="info-side">
        <div class="logo-section">
            <div class="logo-box"></div>
            <span class="brand-name">Gestión Total PyME</span>
        </div>
        <h1 class="main-title">Registra tu tienda y administra ventas, inventario y finanzas.</h1>
        
        <div class="feature-card">
            <h3>Inventario claro</h3>
            <p>Consulta existencias, precios de venta y movimiento de productos.</p>
        </div>
        <div class="feature-card">
            <h3>Punto de venta</h3>
            <p>Registra ventas rápidas y lleva control diario de cada operación.</p>
        </div>
        <div class="feature-card">
            <h3>Finanzas del negocio</h3>
            <p>Controla ingresos, egresos y compras a proveedores desde un solo lugar.</p>
        </div>
    </div>

    <div class="form-side">
        <div class="form-header">
            <h2>Crear cuenta</h2>
            <p>Completa tu información para registrar tu tienda.</p>
        </div>

        @if ($errors->any())
            <div class="error-alert">
                <ul style="margin:0; padding-left:20px;">
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        <form action="{{ route('auth.registrar') }}" method="POST">
            @csrf
            <div class="form-grid">
                <div class="input-group">
                    <label>Nombre completo</label>
                    <input type="text" name="name" placeholder="Escribe tu nombre" required value="{{ old('name') }}">
                </div>
                <div class="input-group">
                    <label>Nombre de la tienda</label>
                    <input type="text" name="store_name" placeholder="Ej. Abarrotes San José" required value="{{ old('store_name') }}">
                </div>
            </div>

            <div class="form-grid">
                <div class="input-group">
                    <label>Teléfono (Opcional)</label>
                    <input type="text" name="phone" placeholder="Ingresa tu número" value="{{ old('phone') }}">
                </div>
                <div class="input-group">
                    <label>Correo electrónico</label>
                    <input type="email" name="email" placeholder="correo@tienda.com" required value="{{ old('email') }}">
                </div>
            </div>

            <div class="form-grid">
                <div class="input-group">
                    <label>Contraseña</label>
                    <input type="password" name="password" placeholder="••••••••••••" required>
                </div>
                <div class="input-group">
                    <label>Confirmar contraseña</label>
                    <input type="password" name="password_confirmation" placeholder="••••••••••••" required>
                </div>
            </div>

            <button type="submit" class="btn-register">Registrar tienda</button>
        </form>

        <div class="login-footer">
            <div>
                <strong style="display:block; color:#111827">¿Ya tienes cuenta?</strong>
                <span style="font-size:0.85rem; color:#6b7280">Ingresa para acceder a tu panel.</span>
            </div>
            <a href="{{ route('login') }}" class="btn-login-redirect">Ir a iniciar sesión</a>
        </div>
    </div>
</div>

</body>
</html>