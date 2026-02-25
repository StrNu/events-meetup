<?php

declare(strict_types=1);

namespace Database\Seeders;

use App\Domain\Events\Models\Event;
use Illuminate\Database\Seeder;

class EventSeeder extends Seeder
{
    public function run(): void
    {
        Event::create([
            'name' => 'TechConf 2025',
            'description' => "La conferencia de tecnologia mas importante del ano. Dos dias de charlas, talleres y networking con los mejores profesionales de la industria.\n\nTemas principales: Inteligencia Artificial, Desarrollo Web, Diseno de Producto, Liderazgo Tech y mas.",
            'start_date' => now()->addDays(7)->format('Y-m-d'),
            'end_date' => now()->addDays(8)->format('Y-m-d'),
            'location' => 'Centro de Convenciones CDMX, Av. Constituyentes 268, Miguel Hidalgo',
            'contact_phone' => '+52 55 1234 5678',
            'contact_email' => 'info@techconf.mx',
            'twitter_url' => 'https://x.com/techconfmx',
            'logo_url' => null,
        ]);
    }
}
