<?php

declare(strict_types=1);

namespace App\Http\Controllers\Public;

use App\Domain\Sessions\Repositories\SessionRepository;
use App\Http\Controllers\Controller;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Inertia\Inertia;
use Inertia\Response;

class MyTalksController extends Controller
{
    public function index(Request $request): Response
    {
        $user = $request->user();

        $sessions = $user
            ? $user->savedSessions()
                ->with(['speakers', 'room', 'category'])
                ->orderBy('start_time')
                ->get()
            : [];

        return Inertia::render('MyTalks/Index', [
            'sessions' => $sessions,
        ]);
    }

    public function store(Request $request, int $sessionId, SessionRepository $sessionRepo): RedirectResponse
    {
        $session = $sessionRepo->findByIdOrFail($sessionId);
        $request->user()->savedSessions()->syncWithoutDetaching([$session->id]);

        return back()->with('success', 'Sesion agregada a tu agenda.');
    }

    public function destroy(Request $request, int $sessionId): RedirectResponse
    {
        $request->user()->savedSessions()->detach($sessionId);

        return back()->with('success', 'Sesion eliminada de tu agenda.');
    }
}
