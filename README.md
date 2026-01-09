# EventFlow

PWA para administrar eventos tipo conferencia/meetup. Los organizadores gestionan agenda, speakers y salas. Los asistentes exploran el programa y crean su agenda personalizada.

## 🚀 Stack Tecnológico

- **Backend**: PHP 8.2+ con Laravel 11
- **Frontend**: Vue 3.4+ con Composition API
- **SPA**: Inertia.js 1.x
- **Estilos**: Tailwind CSS 3.4+
- **Base de datos**: MySQL 8.0+
- **Build**: Vite 5.x
- **PWA**: vite-plugin-pwa

## 📋 Requisitos del Sistema

- PHP 8.2 o superior
- Composer 2.x
- Node.js 18.x o superior
- MySQL 8.0 o superior
- Git

## 🔧 Instalación

### 1. Clonar el repositorio

```bash
git clone <repository-url>
cd EVENTFLOW
```

### 2. Instalar dependencias de PHP

```bash
composer install
```

### 3. Instalar dependencias de Node

```bash
npm install
```

### 4. Configurar el entorno

```bash
cp .env.example .env
php artisan key:generate
```

Edita el archivo `.env` y configura tu base de datos:

```env
DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=eventflow
DB_USERNAME=root
DB_PASSWORD=tu_password
```

### 5. Crear la base de datos

```bash
mysql -u root -p -e "CREATE DATABASE eventflow CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci"
```

### 6. Ejecutar migraciones y seeders

```bash
php artisan migrate --seed
```

### 7. Compilar assets

Para desarrollo:
```bash
npm run dev
```

Para producción:
```bash
npm run build
```

### 8. Iniciar el servidor

```bash
php artisan serve
```

Visita: http://localhost:8000

## 👤 Credenciales por Defecto

- **Admin**: admin@eventflow.test / password
- **Usuario**: test@eventflow.test / password

## 📁 Estructura del Proyecto

```
app/
├── Domain/                    # Lógica de negocio (DDD)
│   ├── Events/               # Gestión de eventos
│   ├── Sessions/             # Gestión de sesiones/charlas
│   ├── Speakers/             # Gestión de ponentes
│   ├── Venues/               # Gestión de salas
│   ├── Categories/           # Categorías de sesiones
│   └── Schedule/             # Agenda personal
├── Http/
│   ├── Controllers/
│   │   ├── Admin/           # Panel de administración
│   │   └── Public/          # App pública
│   └── Requests/            # Validación de formularios
└── Providers/

resources/
├── js/
│   ├── Pages/               # Páginas Vue (Inertia)
│   ├── Components/          # Componentes reutilizables
│   ├── Composables/         # Lógica reutilizable
│   └── Stores/              # Estado global
└── views/
    └── app.blade.php        # Template principal
```

## 🏗️ Arquitectura: Domain-Driven Design

El proyecto sigue los principios de DDD con módulos independientes:

### Flujo de Petición (5 Capas)

1. **Request** → Valida datos de entrada
2. **Controller** → Coordina (sin lógica de negocio)
3. **Action** → Ejecuta UN caso de uso específico
4. **Service** → Lógica compleja (si aplica)
5. **Repository** → Acceso a base de datos

### Ejemplo de Flujo

```php
// 1. Request valida los datos
class StoreSpeakerRequest extends FormRequest { ... }

// 2. Controller coordina
public function store(StoreSpeakerRequest $request, CreateSpeaker $action)
{
    $speaker = $action->execute(SpeakerData::from($request->validated()));
    return redirect()->route('admin.speakers.index');
}

// 3. Action ejecuta el caso de uso
class CreateSpeaker
{
    public function __construct(private SpeakerRepository $repository) {}
    
    public function execute(SpeakerData $data): Speaker
    {
        return $this->repository->create($data->toArray());
    }
}

// 4. Repository accede a la BD
class SpeakerRepository
{
    public function create(array $data): Speaker
    {
        return Speaker::create($data);
    }
}
```

## 🎨 Paleta de Colores

- **Primario**: Teal-600 (#1B7D8C)
- **Secundario**: Purple-500
- **Accent**: Cyan-600
- **Texto**: Gray-800, Gray-500
- **Fondo**: White, Gray-50

## 🧪 Testing

```bash
php artisan test
```

## 📦 Comandos Útiles

```bash
# Limpiar caché
php artisan optimize:clear

# Recrear base de datos
php artisan migrate:fresh --seed

# Generar IDE helpers
php artisan ide-helper:generate

# Verificar código (Laravel Pint)
./vendor/bin/pint
```

## 🚧 Estado del Proyecto

### ✅ Completado
- [x] Configuración del proyecto
- [x] Estructura de carpetas Domain
- [x] Migraciones de base de datos (en progreso)

### 🔄 En Progreso
- [ ] Modelos y relaciones
- [ ] Repositorios
- [ ] Actions y DTOs
- [ ] Controllers
- [ ] Vistas Vue del admin
- [ ] Seeders

### 📝 Pendiente
- [ ] App pública (frontend)
- [ ] Configuración PWA completa
- [ ] Tests
- [ ] Optimización para producción

## 📖 Documentación Adicional

- [Laravel 11 Documentation](https://laravel.com/docs/11.x)
- [Vue 3 Documentation](https://vuejs.org/)
- [Inertia.js Documentation](https://inertiajs.com/)
- [Tailwind CSS Documentation](https://tailwindcss.com/)

## 📄 Licencia

MIT

## 👥 Contribuir

Este es un proyecto en desarrollo. Las contribuciones son bienvenidas.

---

**Nota**: Este proyecto está en desarrollo activo. Algunas funcionalidades pueden estar incompletas.
