# EventFlow

PWA para administrar eventos tipo conferencia/meetup. Los organizadores gestionan agenda, speakers y salas. Los asistentes exploran el programa y crean su agenda personalizada.

## Stack Tecnologico

- **Backend**: PHP 8.2+ con Laravel 11
- **Frontend**: Vue 3.4+ con Composition API (`<script setup>`)
- **SPA**: Inertia.js 1.x
- **Estilos**: Tailwind CSS 3.4+ con HeadlessUI y Heroicons
- **Base de datos**: SQLite (dev) / MySQL 8.0+ (prod)
- **Build**: Vite 5.x
- **PWA**: vite-plugin-pwa con Workbox

## Requisitos del Sistema

- PHP 8.2 o superior
- Composer 2.x
- Node.js 18.x o superior
- Git

## Instalacion

```bash
# 1. Clonar el repositorio
git clone <repository-url>
cd EVENTFLOW

# 2. Instalar dependencias
composer install
npm install

# 3. Configurar entorno
cp .env.example .env
php artisan key:generate

# 4. Crear base de datos y cargar datos de prueba
touch database/database.sqlite
php artisan migrate --seed

# 5. Compilar assets
npm run build

# 6. Iniciar servidor
php artisan serve
```

Visita: http://localhost:8000

## Credenciales por Defecto

| Usuario | Email | Password |
|---------|-------|----------|
| Admin | admin@eventflow.test | password |
| Test | test@eventflow.test | password |

## Estructura del Proyecto (DDD)

```
app/
├── Domain/                    # Logica de negocio
│   ├── Events/               # Modelos, Actions, DTOs, Repos
│   ├── Sessions/
│   ├── Speakers/
│   ├── Venues/               # Salas
│   ├── Categories/
│   └── Users/
├── Http/
│   ├── Controllers/
│   │   ├── Admin/            # CRUD: Dashboard, Speakers, Sessions, Rooms, Categories, Events
│   │   └── Public/           # Home, Talks, Speakers, Schedule, MyTalks, Map, Info
│   ├── Middleware/
│   └── Requests/
└── Providers/

resources/js/
├── Pages/                    # Paginas Vue (Inertia)
│   ├── Admin/                # Panel de administracion
│   ├── Home.vue              # Landing del evento
│   ├── Talks/                # Lista y detalle de charlas
│   ├── Speakers/             # Lista y detalle de speakers
│   ├── Schedule/             # Programa por dia (timeline)
│   ├── MyTalks/              # Agenda personal
│   ├── Map/                  # Salas del evento
│   └── Info/                 # Informacion y contacto
├── Components/
│   ├── Layout/               # AppLayout, AdminLayout, BottomNav
│   ├── UI/                   # Button, Card, Modal, Badge, etc.
│   ├── Schedule/             # DaySelector, TimelineView
│   ├── Map/                  # RoomCard, RoomGrid
│   └── Info/                 # ContactCard, VenueMap
└── Composables/              # useAgenda, usePWA
```

## Flujo de Arquitectura

```
Request → Controller → Action(DTO) → Repository → Model
```

## Comandos Utiles

```bash
# Desarrollo
npm run dev                        # Vite dev server
php artisan serve                  # Laravel server

# Base de datos
php artisan migrate:fresh --seed   # Recrear BD con datos de prueba

# Testing
php artisan test                   # Ejecutar todos los tests

# Build produccion
npm run build                      # Compilar assets
php artisan config:cache           # Cache de configuracion
php artisan route:cache            # Cache de rutas
php artisan view:cache             # Cache de vistas

# Limpiar cache
php artisan optimize:clear         # Limpiar todo el cache
```

## Paleta de Colores

- **Primario**: Teal-600 (`#1B7D8C`)
- **Fondo**: White / Gray-50
- **Texto**: Gray-800 / Gray-500

## Licencia

MIT
