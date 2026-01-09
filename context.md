## Parte 2: Archivo de Contexto

Crea este archivo en la raíz del proyecto. Antigravity lo leerá automáticamente para entender tu arquitectura.

**Archivo: `CONTEXT.md`** (crea este archivo primero, antes de cualquier otra cosa)

```markdown
# EventFlow - Contexto del Proyecto

## Qué es EventFlow
PWA para administrar eventos tipo conferencia/meetup. Los organizadores gestionan agenda, speakers y salas. Los asistentes exploran el programa y crean su agenda personalizada.

## Stack Tecnológico
- PHP 8.2+ con Laravel 11
- Vue 3.4+ con Composition API (<script setup>)
- Inertia.js 1.x (SPA sin API REST separada)
- Tailwind CSS 3.4+
- MySQL 8.0+
- Vite 5.x
- vite-plugin-pwa para PWA

## Arquitectura: Domain-Driven Design

### Regla de Oro
Cada módulo es INDEPENDIENTE. Si modificas Speakers, NUNCA tocas archivos de Sessions u otros dominios.

### Estructura Backend (Laravel)
```
app/
├── Domain/                    # Lógica de negocio por módulo
│   ├── Events/
│   │   ├── Models/Event.php
│   │   ├── Actions/CreateEvent.php
│   │   ├── Actions/UpdateEvent.php
│   │   ├── Repositories/EventRepository.php
│   │   └── DTOs/EventData.php
│   ├── Sessions/
│   │   ├── Models/Session.php
│   │   ├── Actions/CreateSession.php
│   │   ├── Actions/AssignSpeakerToSession.php
│   │   ├── Repositories/SessionRepository.php
│   │   └── DTOs/SessionData.php
│   ├── Speakers/
│   │   ├── Models/Speaker.php
│   │   ├── Actions/CreateSpeaker.php
│   │   ├── Repositories/SpeakerRepository.php
│   │   └── DTOs/SpeakerData.php
│   ├── Venues/
│   │   ├── Models/Room.php
│   │   ├── Actions/CreateRoom.php
│   │   └── Repositories/RoomRepository.php
│   ├── Categories/
│   │   ├── Models/Category.php
│   │   └── Repositories/CategoryRepository.php
│   ├── Schedule/
│   │   ├── Actions/AddToAgenda.php
│   │   ├── Actions/RemoveFromAgenda.php
│   │   └── Services/PersonalAgendaService.php
│   └── Users/
│       ├── Models/User.php
│       └── Actions/RegisterUser.php
├── Http/
│   ├── Controllers/
│   │   ├── Admin/             # CRUD para administradores
│   │   └── Public/            # Vistas públicas de la app
│   └── Requests/              # Validación de formularios
└── Providers/
    └── DomainServiceProvider.php
```

### Estructura Frontend (Vue)
```
resources/js/
├── Pages/                     # Una página por ruta (Inertia)
│   ├── Home.vue
│   ├── Talks/Index.vue, Show.vue
│   ├── Schedule/Index.vue
│   ├── Speakers/Index.vue, Show.vue
│   ├── MyTalks/Index.vue
│   ├── Map/Index.vue
│   ├── Info/Index.vue
│   └── Admin/                 # Panel de administración
├── Components/
│   ├── Layout/AppLayout.vue, AdminLayout.vue, BottomNav.vue
│   ├── UI/Button.vue, Card.vue, Modal.vue, SearchBar.vue, Avatar.vue
│   ├── Speakers/SpeakerCard.vue, SpeakerCarousel.vue
│   ├── Sessions/SessionCard.vue, SessionList.vue
│   └── Schedule/DaySelector.vue, TimelineView.vue
├── Composables/useAgenda.js, useSearch.js, usePWA.js
└── Stores/agenda.js, user.js
```

## Flujo de Petición (5 Capas)
1. **Request** → Valida datos de entrada
2. **Controller** → Coordina (sin lógica de negocio)
3. **Action** → Ejecuta UN caso de uso específico
4. **Service** → Lógica compleja (si aplica)
5. **Repository** → Acceso a base de datos

## Reglas de Código PHP

SIEMPRE incluir:
- `declare(strict_types=1);` en todos los archivos
- Type hints en parámetros y retornos
- Constructor property promotion
- Inyección de dependencias (nunca usar `new` dentro de clases)

Patrón de Controller:
```php
public function store(StoreSpeakerRequest $request, CreateSpeaker $action)
{
    $speaker = $action->execute(SpeakerData::from($request->validated()));
    return redirect()->route('admin.speakers.index')->with('success', 'Creado');
}
```

Patrón de Action:
```php
class CreateSpeaker
{
    public function __construct(private SpeakerRepository $repository) {}
    
    public function execute(SpeakerData $data): Speaker
    {
        return $this->repository->create([...]);
    }
}
```

Patrón de Repository:
```php
class SpeakerRepository
{
    public function create(array $data): Speaker { return Speaker::create($data); }
    public function findById(int $id): ?Speaker { return Speaker::find($id); }
    public function getByEvent(int $eventId): Collection { ... }
}
```

## Reglas de Código Vue

SIEMPRE usar:
- Composition API con `<script setup>`
- Props tipadas con `defineProps` y validadores
- Eventos con `defineEmits`
- Tailwind CSS (evitar CSS custom)
- Componentes pequeños (máximo 150 líneas)

Patrón de Componente:
```vue
<script setup>
defineProps({
  speaker: { type: Object, required: true }
});
defineEmits(['click']);
</script>

<template>
  <article class="bg-white rounded-xl p-4" @click="$emit('click', speaker)">
    ...
  </article>
</template>
```

## Paleta de Colores (Tailwind)
- Primario: teal-600 (#1B7D8C)
- Secundario: purple-500
- Accent: cyan-600
- Texto: gray-800, gray-500
- Fondo: white, gray-50

## Base de Datos - Tablas
- events, sessions, speakers, rooms, categories, users
- session_speaker (pivot), user_sessions (agenda personal)

## NO HACER
- Lógica de negocio en Controllers
- Usar `new` para dependencias
- Options API en Vue
- CSS custom si Tailwind tiene la utilidad
- Componentes de más de 150 líneas
- Modificar un módulo para arreglar otro
```

---

## Parte 3: Prompts para Antigravity (Paso a Paso)

Copia y ejecuta estos prompts en orden. Espera a que cada uno termine antes de continuar.

### PASO 1: Scaffolding del Proyecto

```
Crea un nuevo proyecto Laravel 11 con las siguientes características:

1. Ejecuta: composer create-project laravel/laravel . "11.*"

2. Instala las dependencias necesarias:
   - laravel/breeze con stack vue + inertia
   - spatie/laravel-permission
   - spatie/laravel-medialibrary

3. Configura Breeze con: php artisan breeze:install vue --typescript=false

4. Instala dependencias de NPM incluyendo:
   - @vueuse/core
   - @headlessui/vue
   - vite-plugin-pwa

5. Configura el archivo .env para usar MySQL con:
   - DB_DATABASE=eventflow
   - DB_USERNAME=root
   - DB_PASSWORD= (vacío o tu password)

6. Crea la base de datos si no existe

7. Verifica que todo funcione ejecutando:
   - php artisan migrate
   - npm run build

Lee el archivo CONTEXT.md para entender la arquitectura del proyecto.
```

### PASO 2: Estructura de Carpetas del Dominio

```
Crea la estructura de carpetas para Domain-Driven Design:

1. Crea las siguientes carpetas dentro de app/Domain/:
   - Events/Models, Events/Actions, Events/Repositories, Events/DTOs
   - Sessions/Models, Sessions/Actions, Sessions/Repositories, Sessions/DTOs
   - Speakers/Models, Speakers/Actions, Speakers/Repositories, Speakers/DTOs
   - Venues/Models, Venues/Actions, Venues/Repositories
   - Categories/Models, Categories/Repositories
   - Schedule/Actions, Schedule/Services
   - Users/Models, Users/Actions

2. Crea app/Providers/DomainServiceProvider.php que registre los repositorios

3. Registra DomainServiceProvider en bootstrap/providers.php

4. Crea las carpetas para Controllers:
   - app/Http/Controllers/Admin/
   - app/Http/Controllers/Public/

Sigue estrictamente la estructura definida en CONTEXT.md
```

### PASO 3: Modelos y Migraciones

```
Crea los modelos y migraciones para EventFlow:

1. Event (events):
   - id, name, description (text), start_date, end_date
   - location, contact_phone, contact_email, twitter_url
   - logo_url, timestamps

2. Speaker (speakers):
   - id, event_id (FK), name, title, organization (nullable)
   - bio (text, nullable), photo_url (nullable)
   - social_links (json, nullable), type (enum: keynote, speaker, panelist, host)
   - timestamps

3. Room (rooms):
   - id, event_id (FK), name, capacity (nullable)
   - description (nullable), photo_url (nullable), timestamps

4. Category (categories):
   - id, event_id (FK), name, description (nullable)
   - image_url (nullable), timestamps

5. Session (sessions):
   - id, event_id (FK), room_id (FK nullable), category_id (FK nullable)
   - title, description (text, nullable)
   - start_time (datetime), end_time (datetime)
   - is_featured (boolean default false), timestamps
   - Índices en [event_id, start_time] y [room_id, start_time]

6. Tabla pivot session_speaker:
   - session_id, speaker_id, role (enum: main, co-speaker, moderator)

7. Tabla pivot user_sessions (agenda personal):
   - id, user_id, session_id, notify (boolean default true), timestamps
   - Unique en [user_id, session_id]

Coloca cada modelo en su carpeta Domain correspondiente (ej: app/Domain/Events/Models/Event.php).

Define las relaciones en cada modelo:
- Event hasMany: sessions, speakers, rooms, categories
- Session belongsTo: event, room, category
- Session belongsToMany: speakers
- Speaker belongsToMany: sessions
- User belongsToMany: sessions (como savedSessions)

Ejecuta las migraciones al terminar.
```

### PASO 4: Repositorios Base

```
Crea los repositorios para cada dominio siguiendo este patrón:

Para cada repositorio (EventRepository, SessionRepository, SpeakerRepository, RoomRepository, CategoryRepository):

1. Ubicación: app/Domain/{Dominio}/Repositories/{Nombre}Repository.php

2. Métodos estándar:
   - create(array $data): Model
   - findById(int $id): ?Model
   - findByIdOrFail(int $id): Model
   - update(Model $model, array $data): Model
   - delete(Model $model): void
   - getByEvent(int $eventId): Collection

3. Métodos específicos según dominio:
   - SessionRepository: getByRoom(), getByCategory(), getUpcoming(), getFeatured()
   - SpeakerRepository: search(), getByType()
   - RoomRepository: getWithSessionCount()

4. Usa siempre declare(strict_types=1) y type hints completos

5. Registra todos los repositorios en DomainServiceProvider

Sigue el patrón de Repository mostrado en CONTEXT.md
```

### PASO 5: DTOs y Actions para Speakers

```
Implementa el módulo completo de Speakers como ejemplo del patrón:

1. DTO - app/Domain/Speakers/DTOs/SpeakerData.php:
   - Propiedades: eventId, name, title, organization, bio, socialLinks, type
   - Método estático from(array $data): self

2. Actions en app/Domain/Speakers/Actions/:
   - CreateSpeaker.php: recibe SpeakerData, usa SpeakerRepository
   - UpdateSpeaker.php: recibe Speaker y SpeakerData
   - DeleteSpeaker.php: recibe Speaker

3. Request - app/Http/Requests/StoreSpeakerRequest.php:
   - Validación completa de todos los campos
   - social_links como array con validación de URLs

4. Request - app/Http/Requests/UpdateSpeakerRequest.php

5. Controller - app/Http/Controllers/Admin/SpeakerController.php:
   - Métodos: index, create, store, edit, update, destroy
   - Usa Inertia para renderizar vistas
   - Inyecta Actions en los métodos (no en constructor)

6. Rutas en routes/web.php:
   - Route::resource('admin/speakers', Admin\SpeakerController::class)

El controller solo coordina, toda la lógica está en Actions.
```

### PASO 6: Vistas Vue para Admin de Speakers

```
Crea las vistas de administración de Speakers:

1. Layout - resources/js/Components/Layout/AdminLayout.vue:
   - Sidebar con navegación: Dashboard, Events, Sessions, Speakers, Rooms, Categories
   - Header con título de página
   - Slot para contenido principal
   - Usa Tailwind con colores de CONTEXT.md

2. Componentes UI base en resources/js/Components/UI/:
   - Button.vue (variantes: primary, secondary, danger)
   - Card.vue
   - Modal.vue (con HeadlessUI)
   - SearchBar.vue
   - Avatar.vue (con fallback de iniciales)
   - Badge.vue
   - EmptyState.vue

3. Páginas en resources/js/Pages/Admin/Speakers/:
   - Index.vue: tabla de speakers con foto, nombre, título, tipo, acciones
   - Create.vue: formulario completo con upload de foto
   - Edit.vue: mismo formulario con datos precargados

4. Formulario de Speaker como componente:
   - resources/js/Components/Admin/SpeakerForm.vue
   - Campos: name, title, organization, bio, type (select), social links
   - Validación de errores de Inertia
   - Preview de imagen

Usa Composition API con <script setup> y Tailwind para estilos.
```

### PASO 7: Módulo de Sessions (Replicar Patrón)

```
Replica el patrón de Speakers para el módulo de Sessions:

1. DTO: app/Domain/Sessions/DTOs/SessionData.php
   - eventId, roomId, categoryId, title, description, startTime, endTime, isFeatured

2. Actions:
   - CreateSession.php
   - UpdateSession.php
   - DeleteSession.php
   - AssignSpeakerToSession.php (maneja el pivot)
   - RemoveSpeakerFromSession.php

3. Requests:
   - StoreSessionRequest.php (validar que endTime > startTime)
   - UpdateSessionRequest.php

4. Controller: Admin/SessionController.php

5. Vistas Vue:
   - Pages/Admin/Sessions/Index.vue (tabla con sala, horario, speakers)
   - Pages/Admin/Sessions/Create.vue
   - Pages/Admin/Sessions/Edit.vue
   - Components/Admin/SessionForm.vue (con selects de room, category, speakers)

6. Rutas: Route::resource('admin/sessions', ...)

El formulario debe permitir seleccionar múltiples speakers con sus roles.
```

### PASO 8: Módulos Restantes de Admin

```
Completa los módulos de administración restantes:

1. Events (solo 1 evento activo por ahora):
   - EventController con solo edit y update
   - Vista Edit.vue con todos los campos del evento
   - Seeder con evento de ejemplo

2. Rooms:
   - CRUD completo siguiendo patrón de Speakers
   - Formulario simple: name, capacity, description, photo

3. Categories:
   - CRUD completo siguiendo patrón de Speakers
   - Formulario simple: name, description, image

4. Dashboard:
   - DashboardController que muestra estadísticas
   - Vista con cards: total speakers, sessions, rooms, categorías
   - Lista de próximas sesiones

5. Navegación del sidebar actualizada con todas las rutas

Todos siguen el mismo patrón: DTO → Action → Repository → Controller → Vista
```

### PASO 9: App Pública - Layout y Home

```
Crea el layout y home de la app pública (lo que ven los asistentes):

1. Layout - resources/js/Components/Layout/AppLayout.vue:
   - Header teal con título del evento y menú hamburguesa
   - Contenido principal con scroll
   - BottomNav fijo con iconos: Home, Talks, Schedule, My Talks, Info
   - Mobile-first, máximo 428px centrado en desktop

2. BottomNav.vue:
   - 5 items con icono y label
   - Indicador de página activa (color teal)
   - Iconos de Heroicons o similar

3. Home.vue (resources/js/Pages/Home.vue):
   - Hero section con gradiente teal y nombre del evento
   - Sección Speakers: SpeakerCarousel horizontal
   - Sección Talks: carrusel de próximas sesiones
   - Sección Categories: grid 2 columnas
   - Sección Map: preview de salas (grid 2 col)

4. Componentes para Home:
   - Speakers/SpeakerCard.vue (foto circular, nombre, título)
   - Speakers/SpeakerCarousel.vue (scroll horizontal con snap)
   - Sessions/SessionCard.vue (foto speaker, fecha en teal, título)
   - Categories/CategoryCard.vue (imagen de fondo, nombre)
   - Categories/CategoryGrid.vue

5. HomeController que carga datos y renderiza con Inertia

6. Ruta: Route::get('/', [HomeController::class, 'index'])

Diseño basado en las capturas de UXVC: cards redondeadas, sombras sutiles, fotos circulares.
```

### PASO 10: Páginas Públicas - Talks y Speakers

```
Crea las páginas de Talks y Speakers:

1. Talks/Index.vue:
   - SearchBar sticky debajo del header
   - Sesiones agrupadas por Room (Main Room, Big Room, etc.)
   - Cada grupo con título y "See All"
   - SessionCard para cada sesión
   - TalkController@index con datos agrupados

2. Talks/Show.vue:
   - Imagen/banner de la sesión
   - Título, fecha/hora, sala
   - Descripción completa
   - Lista de speakers con link a perfil
   - Botón "Add to My Talks" (heart icon)
   - TalkController@show

3. Speakers/Index.vue:
   - SearchBar
   - Grid 2 columnas de SpeakerCard
   - Filtro por tipo (All, Keynote, Speaker, etc.)
   - SpeakerController@index

4. Speakers/Show.vue:
   - Foto grande
   - Nombre, título, organización
   - Bio completa
   - Links a redes sociales (iconos)
   - Lista de sesiones del speaker
   - SpeakerController@show

5. Componentes adicionales:
   - Sessions/SessionsByRoom.vue
   - Sessions/SessionDetail.vue
   - Speakers/SpeakerDetail.vue
   - UI/SocialLinks.vue

Rutas públicas en routes/web.php
```

### PASO 11: Schedule y My Talks

```
Crea las páginas de Schedule y My Talks:

1. Schedule/Index.vue:
   - DaySelector: fecha actual con flechas prev/next
   - Toggle Day/Week (Day por default)
   - TimelineView: franjas horarias de 12 AM a 11 PM
   - Sesiones como bloques posicionados en el timeline
   - Color coding por sala
   - Línea indicadora de hora actual
   - ScheduleController@index con sesiones del día

2. Componentes de Schedule:
   - DaySelector.vue (fecha, flechas, dropdown Day/Week)
   - TimelineView.vue (container con horas)
   - TimeSlot.vue (bloque de sesión en timeline)

3. MyTalks/Index.vue:
   - Lista de sesiones guardadas ordenadas por fecha
   - SessionCard con botón de eliminar
   - EmptyState si no hay sesiones guardadas
   - CTA "Explore Talks" que lleva a /talks
   - MyTalksController@index

4. Composable useAgenda.js:
   - savedSessions (persiste en localStorage)
   - isInAgenda(sessionId)
   - addToAgenda(sessionId) - POST /my-talks/{session}
   - removeFromAgenda(sessionId) - DELETE /my-talks/{session}
   - toggleAgenda(sessionId)

5. MyTalksController:
   - index: lista sesiones del usuario
   - store: agrega sesión a agenda
   - destroy: quita sesión de agenda

6. Actualizar SessionCard y SessionDetail con botón de agenda

Requiere autenticación para My Talks.
```

### PASO 12: Map e Info

```
Crea las páginas de Map e Info:

1. Map/Index.vue:
   - SearchBar para buscar salas
   - Grid 2 columnas de RoomCard
   - Cada card: foto, nombre de sala
   - MapController@index

2. Map/Show.vue:
   - Foto grande de la sala
   - Nombre y capacidad
   - Descripción
   - Lista de sesiones en esta sala (con horarios)
   - MapController@show

3. Componentes:
   - Map/RoomCard.vue
   - Map/RoomGrid.vue

4. Info/Index.vue:
   - Mapa embebido (Mapbox o Google Maps estático)
   - Descripción del venue
   - Card de contacto:
     - Teléfono (con botón para llamar)
     - Email (con botón para enviar)
     - Twitter (link)
   - InfoController@index carga datos del evento

5. Componentes:
   - Info/ContactCard.vue
   - Info/VenueMap.vue (placeholder si no hay API key)

Rutas: /map, /map/{room}, /info
```

### PASO 13: Configuración PWA

```
Configura la aplicación como PWA instalable:

1. Actualiza vite.config.js con VitePWA:
   - manifest con name, short_name, theme_color (#1B7D8C)
   - icons de 192x192 y 512x512
   - display: standalone
   - orientation: portrait

2. Crea los iconos en public/icons/:
   - icon-192.png
   - icon-512.png
   - apple-touch-icon.png

3. Configura workbox para caché:
   - Archivos estáticos (js, css, imágenes)
   - API calls con NetworkFirst

4. Crea composable usePWA.js:
   - Detecta si se puede instalar
   - Muestra prompt de instalación
   - Maneja el evento beforeinstallprompt

5. Agrega banner de instalación en AppLayout:
   - Aparece solo si se puede instalar
   - Botón "Instalar App"
   - Dismiss que no vuelve a mostrar

6. Actualiza head en app.blade.php:
   - Meta tags para PWA
   - Apple touch icon
   - Theme color

7. Prueba:
   - npm run build
   - Abre en Chrome
   - Verifica que aparezca opción de instalar
```

### PASO 14: Seeders y Datos de Prueba

```
Crea seeders con datos realistas para probar la app:

1. database/seeders/EventSeeder.php:
   - Un evento "TechConf 2025" con fechas próximas
   - Información de contacto completa

2. database/seeders/RoomSeeder.php:
   - 4-6 salas: Main Room, Workshop Room, Networking Area, etc.

3. database/seeders/CategorySeeder.php:
   - 5-6 categorías: Design, Development, AI, Leadership, etc.

4. database/seeders/SpeakerSeeder.php:
   - 10-15 speakers con datos variados
   - Diferentes tipos (keynote, speaker, panelist)
   - Usar https://randomuser.me para fotos

5. database/seeders/SessionSeeder.php:
   - 20-30 sesiones distribuidas en 2 días
   - Diferentes salas y categorías
   - Asignar speakers a sesiones

6. database/seeders/UserSeeder.php:
   - Usuario admin: admin@eventflow.test / password
   - Usuario de prueba: test@eventflow.test / password

7. DatabaseSeeder.php que ejecuta todos en orden

8. Ejecuta: php artisan migrate:fresh --seed

9. Verifica en el navegador que todo se vea bien
```

### PASO 15: Testing Básico

```
Crea tests para los flujos principales:

1. tests/Feature/Speakers/CreateSpeakerTest.php:
   - Test que admin puede crear speaker
   - Test validación de campos requeridos
   - Test que usuario no autenticado no puede crear

2. tests/Feature/Sessions/SessionTest.php:
   - Test crear sesión
   - Test asignar speaker a sesión
   - Test validación de horarios

3. tests/Feature/Agenda/PersonalAgendaTest.php:
   - Test agregar sesión a agenda
   - Test quitar sesión de agenda
   - Test que requiere autenticación

4. tests/Feature/Public/HomeTest.php:
   - Test que home carga correctamente
   - Test que muestra speakers y sesiones

5. tests/Unit/Domain/Speakers/CreateSpeakerActionTest.php:
   - Test unitario del action

Ejecuta: php artisan test

Asegúrate de que pasen todos los tests.
```

### PASO 16: Optimización y Deploy

```
Prepara la aplicación para producción:

1. Optimizaciones de Laravel:
   - php artisan config:cache
   - php artisan route:cache
   - php artisan view:cache
   - php artisan icons:cache (si usas blade-icons)

2. Optimizaciones de frontend:
   - npm run build (ya optimizado por Vite)
   - Verificar que chunks no sean muy grandes

3. Archivo .env.example actualizado con todas las variables

4. README.md con:
   - Descripción del proyecto
   - Requisitos del sistema
   - Instrucciones de instalación
   - Comandos útiles

5. Verificar que todo funcione:
   - Crear evento desde admin
   - Agregar speakers, salas, categorías, sesiones
   - Navegar como asistente
   - Agregar a mi agenda
   - Instalar como PWA

La aplicación está lista para deploy.
```

---

## Parte 4: Tips para Trabajar con Antigravity

### Comandos Útiles en el Chat

```
# Ver el plan antes de ejecutar
/plan Implementa el módulo de speakers

# Modo rápido para cambios pequeños
/fast Agrega validación de email único en StoreSpeakerRequest

# Generar tests
/generate-unit-tests para CreateSpeaker action
```

### Si Algo Sale Mal

1. **El agente se confunde:** Sé más específico en tu prompt
2. **Código incorrecto:** Dile exactamente qué cambiar: "En SpeakerController.php, el método store debe inyectar CreateSpeaker, no instanciarlo"
3. **Pierde el contexto:** Recuérdale: "Lee CONTEXT.md y sigue el patrón de Actions"

### Cuándo Usar Claude Projects en Lugar de Antigravity

- Decidir cómo resolver un problema complejo
- Revisar arquitectura antes de implementar
- Entender código que no escribiste
- Actualizar el PRD o documentación

---

## Parte 5: Checklist de Progreso

Marca cada paso completado:

- [ ] Setup inicial y dependencias
- [ ] Estructura de carpetas Domain
- [ ] Modelos y migraciones
- [ ] Repositorios
- [ ] Módulo Speakers completo (backend)
- [ ] Vistas Admin Speakers (frontend)
- [ ] Módulo Sessions completo
- [ ] Módulos restantes Admin
- [ ] Layout y Home públicos
- [ ] Talks y Speakers públicos
- [ ] Schedule y My Talks
- [ ] Map e Info
- [ ] Configuración PWA
- [ ] Seeders y datos de prueba
- [ ] Tests básicos
- [ ] Optimización para deploy

---

¡Éxito construyendo EventFlow! 🚀
