<?php

namespace App\Actions\Auth;

use App\Models\User;
use App\Repositories\Interfaces\UserRepositoryInterface;
use Illuminate\Contracts\Auth\Authenticatable;

class MeAction
{
    public function __construct(private UserRepositoryInterface $repository)
    {
    }

    public function execute(): User|Authenticatable|null
    {
        return $this->repository->me();
    }
}
