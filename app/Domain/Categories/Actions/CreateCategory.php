<?php

declare(strict_types=1);

namespace App\Domain\Categories\Actions;

use App\Domain\Categories\DTOs\CategoryData;
use App\Domain\Categories\Models\Category;
use App\Domain\Categories\Repositories\CategoryRepository;

class CreateCategory
{
    public function __construct(private CategoryRepository $repository) {}

    public function execute(CategoryData $data): Category
    {
        return $this->repository->create($data->toArray());
    }
}
