<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="theme-color" content="#1B7D8C">
    <title>{{ config('app.name', 'EventFlow') }}</title>
    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=inter:400,500,600,700&display=swap" rel="stylesheet" />
    <style>
        *,
        *::before,
        *::after {
            box-sizing: border-box;
            margin: 0;
            padding: 0;
        }

        body {
            font-family: 'Inter', sans-serif;
            background: linear-gradient(135deg, #0f172a 0%, #1e293b 50%, #0f172a 100%);
            min-height: 100vh;
            display: flex;
            align-items: center;
            justify-content: center;
            color: #e2e8f0;
        }

        .container {
            text-align: center;
            padding: 3rem;
        }

        .logo {
            width: 100px;
            height: 100px;
            margin: 0 auto 2rem;
            background: linear-gradient(135deg, #1B7D8C, #06b6d4, #8b5cf6);
            border-radius: 24px;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 2.5rem;
            font-weight: 700;
            color: white;
            box-shadow: 0 20px 60px rgba(27, 125, 140, 0.4);
            animation: float 3s ease-in-out infinite;
        }

        @keyframes float {

            0%,
            100% {
                transform: translateY(0);
            }

            50% {
                transform: translateY(-10px);
            }
        }

        h1 {
            font-size: 3rem;
            font-weight: 700;
            background: linear-gradient(135deg, #1B7D8C, #06b6d4, #8b5cf6);
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
            background-clip: text;
            margin-bottom: 0.75rem;
        }

        .subtitle {
            font-size: 1.25rem;
            color: #94a3b8;
            margin-bottom: 2.5rem;
        }

        .status {
            display: flex;
            flex-wrap: wrap;
            gap: 1rem;
            justify-content: center;
            margin-bottom: 2.5rem;
        }

        .badge {
            background: rgba(27, 125, 140, 0.15);
            border: 1px solid rgba(27, 125, 140, 0.3);
            padding: 0.5rem 1.25rem;
            border-radius: 9999px;
            font-size: 0.875rem;
            color: #5eead4;
            backdrop-filter: blur(10px);
        }

        .badge.active {
            background: rgba(27, 125, 140, 0.3);
            border-color: #1B7D8C;
            color: #fff;
        }

        .info {
            background: rgba(255, 255, 255, 0.05);
            border: 1px solid rgba(255, 255, 255, 0.1);
            border-radius: 16px;
            padding: 2rem;
            backdrop-filter: blur(10px);
            max-width: 500px;
            margin: 0 auto;
        }

        .info h3 {
            font-size: 1rem;
            color: #5eead4;
            margin-bottom: 1rem;
        }

        .info ul {
            list-style: none;
            text-align: left;
        }

        .info li {
            padding: 0.5rem 0;
            border-bottom: 1px solid rgba(255, 255, 255, 0.05);
            display: flex;
            align-items: center;
            gap: 0.75rem;
            font-size: 0.9rem;
            color: #cbd5e1;
        }

        .info li:last-child {
            border: none;
        }

        .dot {
            width: 8px;
            height: 8px;
            border-radius: 50%;
            background: #22c55e;
            flex-shrink: 0;
        }

        .dot.pending {
            background: #f59e0b;
        }

        .version {
            margin-top: 2rem;
            font-size: 0.75rem;
            color: #475569;
        }
    </style>
</head>

<body>
    <div class="container">
        <div class="logo">EF</div>
        <h1>EventFlow</h1>
        <p class="subtitle">Conference & Meetup Event Management PWA</p>

        <div class="status">
            <span class="badge active">✓ Laravel {{ app()->version() }}</span>
            <span class="badge active">✓ PHP {{ PHP_VERSION }}</span>
            <span class="badge active">✓ Database Ready</span>
            <span class="badge">⏳ Vue + Inertia</span>
        </div>

        <div class="info">
            <h3>🚀 Project Status</h3>
            <ul>
                <li><span class="dot"></span> Server running</li>
                <li><span class="dot"></span> Database connected (SQLite)</li>
                <li><span class="dot"></span> Migrations applied</li>
                <li><span class="dot pending"></span> Frontend build pending (npm run dev)</li>
                <li><span class="dot pending"></span> Domain modules pending</li>
            </ul>
        </div>

        <p class="version">EventFlow v0.1 • {{ date('Y-m-d H:i') }}</p>
    </div>
</body>

</html>