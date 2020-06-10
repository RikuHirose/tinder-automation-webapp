<?php

namespace packages\InMemoryInfrastructure\Repository;

use packages\Domain\Domain\User\UserRepositoryInterface;
use packages\Domain\Domain\User\User;

class InMemoryUserRepository implements UserRepositoryInterface
{
    private $db = [];

    /**
     * @param User $user
     * @return \App\Models\User
     */
    public function create(User $user): \App\Models\User
    {
        $eloquent = new \App\Models\User();
        $eloquent->name    = $user->getName();

        return $eloquent;
    }
}
