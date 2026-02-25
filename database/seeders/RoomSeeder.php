<?php

declare(strict_types=1);

namespace Database\Seeders;

use App\Domain\Events\Models\Event;
use App\Domain\Venues\Models\Room;
use Illuminate\Database\Seeder;

class RoomSeeder extends Seeder
{
    public function run(): void
    {
        $event = Event::first();

        $rooms = [
            [
                'name' => 'Auditorio Principal',
                'capacity' => 500,
                'description' => 'Sala principal con capacidad para 500 personas. Equipada con pantalla LED gigante y sistema de sonido envolvente.',
            ],
            [
                'name' => 'Sala Workshop A',
                'capacity' => 50,
                'description' => 'Sala de talleres con mesas de trabajo, proyector y pizarras. Ideal para sesiones practicas.',
            ],
            [
                'name' => 'Sala Workshop B',
                'capacity' => 40,
                'description' => 'Sala de talleres con estaciones de trabajo individuales y conectividad de alta velocidad.',
            ],
            [
                'name' => 'Sala de Conferencias',
                'capacity' => 150,
                'description' => 'Sala mediana para conferencias y paneles. Disposicion tipo teatro con buena acustica.',
            ],
            [
                'name' => 'Zona de Networking',
                'capacity' => 200,
                'description' => 'Espacio abierto con areas de descanso, cafe y snacks. Perfecto para conectar con otros asistentes.',
            ],
        ];

        foreach ($rooms as $room) {
            Room::create(array_merge($room, ['event_id' => $event->id]));
        }
    }
}
