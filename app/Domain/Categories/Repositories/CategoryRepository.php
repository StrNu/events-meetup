<?php

declare(strict_types=1);

namespace App\Domain\Categories\Repositories;

use App\Domain\Categories\Models\Category;
use Illuminate\Database\Eloquent\Collection;

class CategoryRepository
{
    public function create(array $data): Category
    {
        return Category::create($data);
    }

    public function findById(int $id): ?Category
    {
        return Category::find($id);
    }

    public function findByIdOrFail(int $id): Category
    {
        return Category::findOrFail($id);
    }

    public function update(Category $category, array $data): Category
    {
        $category->update($data);
        return $category->refresh();
    }

    public function delete(Category $category): void
    {
        $category->delete();
    }

    public function getByEvent(int $eventId): Collection
    {
        return Category::where('event_id', $eventId)->get();
    }
}
