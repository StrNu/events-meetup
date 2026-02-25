<?php

declare(strict_types=1);

namespace Database\Seeders;

use App\Domain\Categories\Models\Category;
use App\Domain\Events\Models\Event;
use App\Domain\Sessions\Models\Session;
use App\Domain\Speakers\Models\Speaker;
use App\Domain\Venues\Models\Room;
use Illuminate\Database\Seeder;

class SessionSeeder extends Seeder
{
    public function run(): void
    {
        $event = Event::first();
        $rooms = Room::where('event_id', $event->id)->get();
        $categories = Category::where('event_id', $event->id)->get();
        $speakers = Speaker::where('event_id', $event->id)->get();

        $day1 = $event->start_date->format('Y-m-d');
        $day2 = $event->end_date->format('Y-m-d');

        // Room references
        $auditorio = $rooms->firstWhere('name', 'Auditorio Principal');
        $workshopA = $rooms->firstWhere('name', 'Sala Workshop A');
        $workshopB = $rooms->firstWhere('name', 'Sala Workshop B');
        $conferencias = $rooms->firstWhere('name', 'Sala de Conferencias');
        $networking = $rooms->firstWhere('name', 'Zona de Networking');

        // Category references
        $webDev = $categories->firstWhere('name', 'Desarrollo Web');
        $ai = $categories->firstWhere('name', 'Inteligencia Artificial');
        $design = $categories->firstWhere('name', 'Diseno de Producto');
        $leadership = $categories->firstWhere('name', 'Liderazgo Tech');
        $devops = $categories->firstWhere('name', 'DevOps & Cloud');
        $mobile = $categories->firstWhere('name', 'Mobile');

        $sessions = [
            // === DIA 1 ===
            [
                'title' => 'Keynote: El Futuro de la Ingenieria de Software',
                'description' => 'Una vision sobre como la IA esta transformando la forma en que construimos software y que habilidades seran esenciales en los proximos anos.',
                'room_id' => $auditorio->id,
                'category_id' => $leadership->id,
                'start_time' => "$day1 09:00:00",
                'end_time' => "$day1 10:00:00",
                'is_featured' => true,
                'speakers' => [0], // Ana Martinez
            ],
            [
                'title' => 'Construyendo APIs con Laravel y GraphQL',
                'description' => 'Aprende a crear APIs flexibles y eficientes combinando Laravel con GraphQL. Cubriremos autenticacion, paginacion y optimizacion de queries.',
                'room_id' => $conferencias->id,
                'category_id' => $webDev->id,
                'start_time' => "$day1 10:30:00",
                'end_time' => "$day1 11:30:00",
                'is_featured' => false,
                'speakers' => [3], // Diego Morales
            ],
            [
                'title' => 'Introduccion a LLMs: De la Teoria a la Practica',
                'description' => 'Un recorrido por los fundamentos de los modelos de lenguaje, como funcionan y como integrarlos en tus aplicaciones de manera practica.',
                'room_id' => $auditorio->id,
                'category_id' => $ai->id,
                'start_time' => "$day1 10:30:00",
                'end_time' => "$day1 11:30:00",
                'is_featured' => true,
                'speakers' => [1], // Carlos Hernandez
            ],
            [
                'title' => 'Workshop: Design Systems desde Cero',
                'description' => 'Taller practico donde construiremos un design system completo. Desde tokens de diseno hasta componentes reutilizables en Figma y codigo.',
                'room_id' => $workshopA->id,
                'category_id' => $design->id,
                'start_time' => "$day1 10:30:00",
                'end_time' => "$day1 12:30:00",
                'is_featured' => false,
                'speakers' => [2], // Sofia Rodriguez
            ],
            [
                'title' => 'Kubernetes en Produccion: Lecciones Aprendidas',
                'description' => 'Experiencias reales desplegando y operando clusters de Kubernetes en produccion. Errores comunes, mejores practicas y herramientas esenciales.',
                'room_id' => $conferencias->id,
                'category_id' => $devops->id,
                'start_time' => "$day1 12:00:00",
                'end_time' => "$day1 13:00:00",
                'is_featured' => false,
                'speakers' => [9], // Andres Vargas
            ],
            [
                'title' => 'Networking Lunch',
                'description' => 'Hora de comida y networking. Aprovecha para conocer a otros asistentes y speakers.',
                'room_id' => $networking->id,
                'category_id' => $leadership->id,
                'start_time' => "$day1 13:00:00",
                'end_time' => "$day1 14:30:00",
                'is_featured' => false,
                'speakers' => [],
            ],
            [
                'title' => 'Performance Web: Core Web Vitals en 2025',
                'description' => 'Estrategias avanzadas para optimizar el rendimiento web. Cubriremos lazy loading, code splitting, y como medir e interpretar Core Web Vitals.',
                'room_id' => $conferencias->id,
                'category_id' => $webDev->id,
                'start_time' => "$day1 14:30:00",
                'end_time' => "$day1 15:30:00",
                'is_featured' => false,
                'speakers' => [6], // Laura Gutierrez
            ],
            [
                'title' => 'De Developer a Engineering Manager',
                'description' => 'Una guia practica para la transicion de contribuidor individual a lider de equipo. Que cambia, que se mantiene y como sobrevivir el proceso.',
                'room_id' => $auditorio->id,
                'category_id' => $leadership->id,
                'start_time' => "$day1 14:30:00",
                'end_time' => "$day1 15:30:00",
                'is_featured' => false,
                'speakers' => [4], // Valentina Torres
            ],
            [
                'title' => 'Workshop: Tu Primera App con React Native',
                'description' => 'Taller hands-on donde construiremos una app mobile funcional con React Native. Desde el setup hasta el deploy en un dispositivo real.',
                'room_id' => $workshopB->id,
                'category_id' => $mobile->id,
                'start_time' => "$day1 14:30:00",
                'end_time' => "$day1 16:30:00",
                'is_featured' => false,
                'speakers' => [8], // Patricia Reyes
            ],
            [
                'title' => 'Seguridad en Apps Web: OWASP Top 10',
                'description' => 'Repaso de las vulnerabilidades mas comunes en aplicaciones web y como prevenirlas. Demos en vivo de ataques y defensas.',
                'room_id' => $conferencias->id,
                'category_id' => $webDev->id,
                'start_time' => "$day1 16:00:00",
                'end_time' => "$day1 17:00:00",
                'is_featured' => false,
                'speakers' => [11], // Fernando Castro
            ],
            [
                'title' => 'Panel: IA Responsable y Etica en Tech',
                'description' => 'Un panel de discusion sobre los retos eticos de la inteligencia artificial, sesgo en modelos, privacidad y regulacion.',
                'room_id' => $auditorio->id,
                'category_id' => $ai->id,
                'start_time' => "$day1 16:00:00",
                'end_time' => "$day1 17:00:00",
                'is_featured' => true,
                'speakers' => [1, 10, 11], // Carlos, Isabella, Fernando
            ],
            [
                'title' => 'Happy Hour & Networking',
                'description' => 'Cierra el primer dia con bebidas y snacks. Musica en vivo y networking informal.',
                'room_id' => $networking->id,
                'category_id' => $leadership->id,
                'start_time' => "$day1 17:30:00",
                'end_time' => "$day1 19:00:00",
                'is_featured' => false,
                'speakers' => [],
            ],

            // === DIA 2 ===
            [
                'title' => 'Keynote: Escalando Equipos de Ingenieria',
                'description' => 'Como construir y escalar equipos de ingenieria de alto rendimiento. Estructura organizacional, procesos y cultura.',
                'room_id' => $auditorio->id,
                'category_id' => $leadership->id,
                'start_time' => "$day2 09:00:00",
                'end_time' => "$day2 10:00:00",
                'is_featured' => true,
                'speakers' => [7], // Roberto Sanchez
            ],
            [
                'title' => 'Serverless en la Practica con AWS Lambda',
                'description' => 'Arquitecturas serverless reales: cuando usarlas, patrones comunes, costos y trampas a evitar.',
                'room_id' => $conferencias->id,
                'category_id' => $devops->id,
                'start_time' => "$day2 10:30:00",
                'end_time' => "$day2 11:30:00",
                'is_featured' => false,
                'speakers' => [5], // Miguel Angel Lopez
            ],
            [
                'title' => 'NLP Aplicado: Construyendo un Chatbot Inteligente',
                'description' => 'Taller practico de procesamiento de lenguaje natural. Construiremos un chatbot usando embeddings y retrieval augmented generation.',
                'room_id' => $workshopA->id,
                'category_id' => $ai->id,
                'start_time' => "$day2 10:30:00",
                'end_time' => "$day2 12:30:00",
                'is_featured' => false,
                'speakers' => [10], // Isabella Mendez
            ],
            [
                'title' => 'Accesibilidad Web: Mas que Solo Compliance',
                'description' => 'Por que la accesibilidad importa y como implementarla correctamente. Herramientas de testing, ARIA patterns y diseno inclusivo.',
                'room_id' => $auditorio->id,
                'category_id' => $design->id,
                'start_time' => "$day2 10:30:00",
                'end_time' => "$day2 11:30:00",
                'is_featured' => false,
                'speakers' => [2], // Sofia Rodriguez
            ],
            [
                'title' => 'Flutter vs React Native en 2025',
                'description' => 'Comparativa actualizada de los dos frameworks mobile mas populares. Rendimiento, ecosistema, DX y casos de uso ideales para cada uno.',
                'room_id' => $conferencias->id,
                'category_id' => $mobile->id,
                'start_time' => "$day2 12:00:00",
                'end_time' => "$day2 13:00:00",
                'is_featured' => false,
                'speakers' => [8], // Patricia Reyes
            ],
            [
                'title' => 'Networking Lunch Dia 2',
                'description' => 'Hora de comida y networking del segundo dia.',
                'room_id' => $networking->id,
                'category_id' => $leadership->id,
                'start_time' => "$day2 13:00:00",
                'end_time' => "$day2 14:30:00",
                'is_featured' => false,
                'speakers' => [],
            ],
            [
                'title' => 'Microservicios con Go: Arquitectura y Patrones',
                'description' => 'Disenar e implementar microservicios con Go. Event sourcing, CQRS, comunicacion entre servicios y manejo de errores.',
                'room_id' => $conferencias->id,
                'category_id' => $webDev->id,
                'start_time' => "$day2 14:30:00",
                'end_time' => "$day2 15:30:00",
                'is_featured' => false,
                'speakers' => [3], // Diego Morales
            ],
            [
                'title' => 'Workshop: Observabilidad con OpenTelemetry',
                'description' => 'Implementa observabilidad en tus servicios con OpenTelemetry. Traces, metricas y logs unificados.',
                'room_id' => $workshopB->id,
                'category_id' => $devops->id,
                'start_time' => "$day2 14:30:00",
                'end_time' => "$day2 16:30:00",
                'is_featured' => false,
                'speakers' => [9], // Andres Vargas
            ],
            [
                'title' => 'El Arte del Code Review',
                'description' => 'Como dar y recibir feedback constructivo en code reviews. Cultura de revision, automatizacion y mejores practicas.',
                'room_id' => $auditorio->id,
                'category_id' => $leadership->id,
                'start_time' => "$day2 14:30:00",
                'end_time' => "$day2 15:30:00",
                'is_featured' => false,
                'speakers' => [4], // Valentina Torres
            ],
            [
                'title' => 'Vue 3 Avanzado: Composables y Performance',
                'description' => 'Patrones avanzados en Vue 3: composables reutilizables, optimizacion de re-renders y manejo de estado complejo.',
                'room_id' => $conferencias->id,
                'category_id' => $webDev->id,
                'start_time' => "$day2 16:00:00",
                'end_time' => "$day2 17:00:00",
                'is_featured' => false,
                'speakers' => [6], // Laura Gutierrez
            ],
            [
                'title' => 'Keynote de Cierre: Construyendo el Futuro Juntos',
                'description' => 'Reflexiones finales sobre el futuro de la tecnologia en Latinoamerica y como la comunidad puede impulsar el cambio.',
                'room_id' => $auditorio->id,
                'category_id' => $leadership->id,
                'start_time' => "$day2 17:00:00",
                'end_time' => "$day2 18:00:00",
                'is_featured' => true,
                'speakers' => [0, 7], // Ana Martinez, Roberto Sanchez
            ],
        ];

        foreach ($sessions as $sessionData) {
            $speakerIndices = $sessionData['speakers'];
            unset($sessionData['speakers']);

            $session = Session::create(array_merge($sessionData, ['event_id' => $event->id]));

            foreach ($speakerIndices as $idx) {
                $speaker = $speakers[$idx];
                $role = $speaker->type === 'keynote' ? 'main' : ($speaker->type === 'panelist' ? 'moderator' : 'co-speaker');
                $session->speakers()->attach($speaker->id, ['role' => $role]);
            }
        }
    }
}
