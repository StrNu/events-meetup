<?php

declare(strict_types=1);

namespace Database\Seeders;

use App\Domain\Events\Models\Event;
use App\Domain\Speakers\Models\Speaker;
use Illuminate\Database\Seeder;

class SpeakerSeeder extends Seeder
{
    public function run(): void
    {
        $event = Event::first();

        $speakers = [
            [
                'name' => 'Ana Martinez',
                'title' => 'VP of Engineering',
                'organization' => 'MercadoLibre',
                'bio' => 'Ana lidera el equipo de ingenieria de plataforma en MercadoLibre. Con mas de 15 anos de experiencia en desarrollo de software, se especializa en arquitectura de sistemas distribuidos y liderazgo tecnico.',
                'photo_url' => 'https://randomuser.me/api/portraits/women/44.jpg',
                'type' => 'keynote',
                'social_links' => ['twitter' => 'https://x.com/anamtz', 'linkedin' => 'https://linkedin.com/in/anamtz'],
            ],
            [
                'name' => 'Carlos Hernandez',
                'title' => 'Senior AI Researcher',
                'organization' => 'Google DeepMind',
                'bio' => 'Investigador en inteligencia artificial con enfoque en modelos de lenguaje y razonamiento. PhD en Computer Science por Stanford.',
                'photo_url' => 'https://randomuser.me/api/portraits/men/32.jpg',
                'type' => 'keynote',
                'social_links' => ['twitter' => 'https://x.com/carlosh_ai', 'linkedin' => 'https://linkedin.com/in/carloshernandez'],
            ],
            [
                'name' => 'Sofia Rodriguez',
                'title' => 'Lead Product Designer',
                'organization' => 'Spotify',
                'bio' => 'Disenadora de producto con experiencia en design systems y accesibilidad. Ha liderado redisenos de productos usados por millones de personas.',
                'photo_url' => 'https://randomuser.me/api/portraits/women/68.jpg',
                'type' => 'speaker',
                'social_links' => ['twitter' => 'https://x.com/sofiarod_design'],
            ],
            [
                'name' => 'Diego Morales',
                'title' => 'Staff Engineer',
                'organization' => 'Stripe',
                'bio' => 'Ingeniero de software especializado en sistemas de pagos y fintech. Contribuidor activo a proyectos open source y mentor en comunidades tech latinas.',
                'photo_url' => 'https://randomuser.me/api/portraits/men/75.jpg',
                'type' => 'speaker',
                'social_links' => ['twitter' => 'https://x.com/diegom_dev', 'linkedin' => 'https://linkedin.com/in/diegomorales'],
            ],
            [
                'name' => 'Valentina Torres',
                'title' => 'Engineering Manager',
                'organization' => 'Rappi',
                'bio' => 'Lider de equipos de ingenieria con enfoque en cultura de alto rendimiento. Apasionada por la diversidad en tech y el desarrollo profesional.',
                'photo_url' => 'https://randomuser.me/api/portraits/women/17.jpg',
                'type' => 'speaker',
                'social_links' => ['linkedin' => 'https://linkedin.com/in/valentinatorres'],
            ],
            [
                'name' => 'Miguel Angel Lopez',
                'title' => 'Cloud Architect',
                'organization' => 'AWS',
                'bio' => 'Arquitecto de soluciones cloud con certificaciones en AWS, GCP y Azure. Especialista en migraciones a la nube y arquitectura serverless.',
                'photo_url' => 'https://randomuser.me/api/portraits/men/22.jpg',
                'type' => 'speaker',
                'social_links' => ['twitter' => 'https://x.com/miguelcloud'],
            ],
            [
                'name' => 'Laura Gutierrez',
                'title' => 'Frontend Lead',
                'organization' => 'Vercel',
                'bio' => 'Desarrolladora frontend apasionada por el rendimiento web y la experiencia de usuario. Core contributor de un popular framework de CSS.',
                'photo_url' => 'https://randomuser.me/api/portraits/women/56.jpg',
                'type' => 'speaker',
                'social_links' => ['twitter' => 'https://x.com/laurag_frontend', 'website' => 'https://lauragutierrez.dev'],
            ],
            [
                'name' => 'Roberto Sanchez',
                'title' => 'CTO',
                'organization' => 'Platzi',
                'bio' => 'CTO con amplia experiencia en edtech y escalabilidad de plataformas. Evangelista de la educacion en linea y la democratizacion del conocimiento tech.',
                'photo_url' => 'https://randomuser.me/api/portraits/men/45.jpg',
                'type' => 'keynote',
                'social_links' => ['twitter' => 'https://x.com/robertocto', 'linkedin' => 'https://linkedin.com/in/robertosanchez'],
            ],
            [
                'name' => 'Patricia Reyes',
                'title' => 'Mobile Tech Lead',
                'organization' => 'Nubank',
                'bio' => 'Lider tecnica en desarrollo mobile con experiencia en React Native y Flutter. Ha construido apps usadas por mas de 10 millones de usuarios.',
                'photo_url' => 'https://randomuser.me/api/portraits/women/33.jpg',
                'type' => 'speaker',
                'social_links' => ['twitter' => 'https://x.com/patriciamobile'],
            ],
            [
                'name' => 'Andres Vargas',
                'title' => 'DevOps Lead',
                'organization' => 'Globant',
                'bio' => 'Experto en DevOps y SRE con enfoque en observabilidad y automatizacion. Speaker frecuente en conferencias de cloud computing.',
                'photo_url' => 'https://randomuser.me/api/portraits/men/67.jpg',
                'type' => 'speaker',
                'social_links' => ['twitter' => 'https://x.com/andresdevops'],
            ],
            [
                'name' => 'Isabella Mendez',
                'title' => 'Data Scientist',
                'organization' => 'Meta',
                'bio' => 'Cientifica de datos especializada en NLP y sistemas de recomendacion. Autora de articulos publicados en conferencias internacionales de ML.',
                'photo_url' => 'https://randomuser.me/api/portraits/women/90.jpg',
                'type' => 'speaker',
                'social_links' => ['linkedin' => 'https://linkedin.com/in/isabellamendez'],
            ],
            [
                'name' => 'Fernando Castro',
                'title' => 'Security Engineer',
                'organization' => 'Mercado Pago',
                'bio' => 'Ingeniero de seguridad con experiencia en pentesting y seguridad de aplicaciones. Certificado OSCP y CISSP.',
                'photo_url' => 'https://randomuser.me/api/portraits/men/55.jpg',
                'type' => 'panelist',
                'social_links' => ['twitter' => 'https://x.com/fernandosec'],
            ],
        ];

        foreach ($speakers as $speaker) {
            Speaker::create(array_merge($speaker, ['event_id' => $event->id]));
        }
    }
}
