<?php

declare(strict_types=1);

namespace App\Domain\Categories\Actions;

use App\Domain\Categories\Models\Category;
use App\Domain\Categories\Repositories\CategoryRepository;

class DeleteCategory
{
    public function __construct(private CategoryRepository $repository) {}

    public function execute(Category $category): void
    {
        $this->repository->delete($category);
    }
}
