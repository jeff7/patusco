<?php

namespace App\Repositories;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Collection;

class UserRepository extends AbstractRepository
{
  public function findDoctors()
    {
        return $this->model->where(['user_type' => 'D'])->get();
    }
}