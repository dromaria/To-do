<?php

namespace App\Actions\Auth;

use App\Repositories\Interfaces\UserRepositoryInterface;

class RefreshAction
{
    public function __construct(private UserRepositoryInterface $repository)
    {
    }
    public function execute(): string
    {
        return $this->repository->refresh();
    }
}
