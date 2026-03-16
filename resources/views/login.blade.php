<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Iniciar Sesión - Gestión Total PyME</title>
    <style>
        /* Mantenemos tu CSS original por consistencia */
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

        .tag-login {
            display: inline-block;
            background-color: #dcfce7;
            color: #166534;
            padding: 4px 12px;
            border-radius: 20px;
            font-size: 0.8rem;
            font-weight: 600;
            margin-bottom: 20px;
            width: fit-content;
        }

        .main-title {
            font-size: 2.5rem;
            color: #064e3b;
            line-height: 1.1;
            margin-bottom: 20px;
        }

        .description {
            color: #6b7280;
            line-height: 1.5;
            margin-bottom: 40px;
            font-size: 0.95rem;
        }

        .feature-card {
            background: white;
            padding: 15px 20px;
            border-radius: 12px;
            margin-bottom: 15px;
            border: 1px solid #d1fae5;
        }

        .feature-card h3 {
            margin: 0;
            font-size: 0.95rem;
            color: #111827;
        }

        .feature-card p {
            margin: 5px 0 0 0;
            font-size: 0.85rem;
            color: #6b7280;
        }

        .form-side {
            flex: 1;
            padding: 60px;
            display: flex;
            flex-direction: column;
            justify-content: center;
        }

        .form-header h2 {
            font-size: 1.8rem;
            margin-bottom: 10px;
            color: #111827;
        }

        .form-header p {
            color: #6b7280;
            margin-bottom: 30px;
            font-size: 0.9rem;
        }

        .input-group {
            display: flex;
            flex-direction: column;
            gap: 8px;
            margin-bottom: 20px;
        }

        .label-row {
            display: flex;
            justify-content: space-between;
            align-items: center;
        }

        label {
            font-size: 0.9rem;
            font-weight: 500;
            color: #374151;
        }

        .forgot-pass {
            font-size: 0.85rem;
            color: #10b981;
            text-decoration: none;
        }

        input {
            padding: 12px;
            border: 1px solid #e5e7eb;
            border-radius: 8px;
            font-size: 0.95rem;
            background-color: #f9fafb;
        }

        .btn-login {
            width: 100%;
            background-color: #10b981;
            color: white;
            padding: 15px;
            border: none;
            border-radius: 8px;
            font-size: 1rem;
            font-weight: 600;
            cursor: pointer;
            margin-top: 10px;
            transition: background 0.3s;
        }

        .btn-login:hover {
            background-color: #059669;
        }

        .register-footer {
            margin-top: 40px;
            padding: 20px;
            background-color: #f0fdf4;
            border-radius: 12px;
            display: flex;
            justify-content: space-between;
            align-items: center;
        }

        .register-text h4 {
            margin: 0;
            font-size: 0.95rem;
            color: #111827;
        }

        .register-text p {
            margin: 5px 0 0 0;
            font-size: 0.85rem;
            color: #6b7280;
        }

        .btn-register-redirect {
            background-color: #e8f5e9;
            border: none;
            padding: 10px 20px;
            border-radius: 8px;
            color: #166534;
            text-decoration: none;
            font-weight: 500;
            font-size: 0.9rem;
        }

        /* Estilos para errores */
        .error-message {
            color: #ef4444;
            font-size: 0.8rem;
            margin-bottom: 15px;
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
        
        <div class="tag-login">Acceso al sistema</div>
        
        <h1 class="main-title">Inicia sesión para administrar inventario, ventas y finanzas.</h1>
        <p class="description">Diseñado para abarrotes y misceláneas que necesitan registrar ventas, revisar stock y controlar ingresos y egresos desde un solo lugar.</p>
        
        <div class="feature-card">
            <h3>Punto de venta</h3>
            <p>Registra cada ticket, costo y forma de pago.</p>
        </div>
        <div class="feature-card">
            <h3>Inventario actualizado</h3>
            <p>Consulta stock, costo y precio de venta de tus productos.</p>
        </div>
        <div class="feature-card">
            <h3>Finanzas claras</h3>
            <p>Lleva control de compras, ingresos, egresos y proveedores.</p>
        </div>
    </div>

    <div class="form-side">
        <div class="form-header">
            <h2>Iniciar sesión</h2>
            <p>Ingresa con tu correo y contraseña para entrar a tu cuenta.</p>
        </div>

        @if ($errors->any())
            <div class="error-message">
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </div>
        @endif

        <form action="{{ route('auth.login') }}" method="POST">
            @csrf
            <div class="input-group">
                <label for="email">Correo electrónico</label>
                <input type="email" id="email" name="email" placeholder="micuenta@tienda.com" required value="{{ old('email') }}">
            </div>

            <div class="input-group">
                <div class="label-row">
                    <label for="password">Contraseña</label>
                    <a href="#" class="forgot-pass">¿Olvidaste tu contraseña?</a>
                </div>
                <input type="password" id="password" name="password" placeholder="••••••••••••" required>
            </div>

            <button type="submit" class="btn-login">Iniciar sesión</button>
        </form>

        <div class="register-footer">
            <div class="register-text">
                <h4>¿Aún no te has registrado?</h4>
                <p>Crea tu cuenta y configura tu negocio en pocos pasos.</p>
            </div>
            <a href="{{ route('registro') }}" class="btn-register-redirect">Registrarme</a>
        </div>
    </div>
</div>

</body>
</html>