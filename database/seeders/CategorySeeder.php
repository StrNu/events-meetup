<?php

declare(strict_types=1);

namespace Database\Seeders;

use App\Domain\Categories\Models\Category;
use App\Domain\Events\Models\Event;
use Illuminate\Database\Seeder;

class CategorySeeder extends Seeder
{
    public function run(): void
    {
        $event = Event::first();

        $categories = [
            ['name' => 'Desarrollo Web', 'description' => 'Frontend, backend, frameworks y herramientas para desarrollo web moderno.'],
            ['name' => 'Inteligencia Artificial', 'description' => 'Machine learning, LLMs, computer vision y aplicaciones de IA.'],
            ['name' => 'Diseno de Producto', 'description' => 'UX/UI, design systems, investigacion de usuarios y prototipado.'],
            ['name' => 'Liderazgo Tech', 'description' => 'Gestion de equipos, cultura de ingenieria y carrera profesional.'],
            ['name' => 'DevOps & Cloud', 'description' => 'Infraestructura, CI/CD, Kubernetes, AWS, GCP y observabilidad.'],
            ['name' => 'Mobile', 'description' => 'Desarrollo nativo, React Native, Flutter y PWAs.'],
        ];

        foreach ($categories as $category) {
            Category::create(array_merge($category, ['event_id' => $event->id]));
        }
    }
}
