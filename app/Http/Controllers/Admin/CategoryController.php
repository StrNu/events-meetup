<?php

declare(strict_types=1);

namespace App\Http\Controllers\Admin;

use App\Domain\Categories\Actions\CreateCategory;
use App\Domain\Categories\Actions\DeleteCategory;
use App\Domain\Categories\Actions\UpdateCategory;
use App\Domain\Categories\DTOs\CategoryData;
use App\Domain\Categories\Repositories\CategoryRepository;
use App\Domain\Events\Repositories\EventRepository;
use App\Http\Controllers\Controller;
use App\Http\Requests\StoreCategoryRequest;
use Illuminate\Http\RedirectResponse;
use Inertia\Inertia;
use Inertia\Response;

class CategoryController extends Controller
{
    public function index(CategoryRepository $repository, EventRepository $eventRepo): Response
    {
        $event = $eventRepo->getActive();

        return Inertia::render('Admin/Categories/Index', [
            'categories' => $event ? $repository->getByEvent($event->id) : [],
            'event' => $event,
        ]);
    }

    public function create(EventRepository $eventRepo): Response
    {
        return Inertia::render('Admin/Categories/Create', [
            'event' => $eventRepo->getActive(),
        ]);
    }

    public function store(StoreCategoryRequest $request, CreateCategory $action): RedirectResponse
    {
        $action->execute(CategoryData::from($request->validated()));

        return redirect()->route('admin.categories.index')
            ->with('success', 'Categoria creada exitosamente.');
    }

    public function edit(int $id, CategoryRepository $repository, EventRepository $eventRepo): Response
    {
        return Inertia::render('Admin/Categories/Edit', [
            'category' => $repository->findByIdOrFail($id),
            'event' => $eventRepo->getActive(),
        ]);
    }

    public function update(StoreCategoryRequest $request, int $id, UpdateCategory $action, CategoryRepository $repository): RedirectResponse
    {
        $category = $repository->findByIdOrFail($id);
        $action->execute($category, CategoryData::from($request->validated()));

        return redirect()->route('admin.categories.index')
            ->with('success', 'Categoria actualizada exitosamente.');
    }

    public function destroy(int $id, DeleteCategory $action, CategoryRepository $repository): RedirectResponse
    {
        $category = $repository->findByIdOrFail($id);
        $action->execute($category);

        return redirect()->route('admin.categories.index')
            ->with('success', 'Categoria eliminada exitosamente.');
    }
}
