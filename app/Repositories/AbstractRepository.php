<?php

namespace App\Repositories;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Collection;

class AbstractRepository
{
    protected $model;

    public function __construct(Model $model)
    {
        $this->model = $model;
    }

    public function all(): Collection
    {
        return $this->model->all();
    }

    public function with(array $relations): Collection
    {
        return $this->model->with($relations)->get();
    }

    public function find(int $id, array $relations = []): ?Model
    {
        if (!empty($relations)) {
            return $this->model->with($relations)->find($id);
        }
        return $this->model->find($id);
    }

    public function create(array $attributes): Model
    {
        return $this->model->create($attributes);
    }

    public function update(int $id, array $attributes): bool
    {
        $model = $this->model->find($id);
        if ($model) {
            return $model->update($attributes);
        }
        return false;
    }

    public function delete(int $id): bool
    {
        $model = $this->model->find($id);
        if ($model) {
            return $model->delete();
        }
        return false;
    }
}