<?php

namespace packages\Infrastructure\Repository;

use packages\Domain\Domain\User\User;
use packages\Domain\Domain\User\UserRepositoryInterface;

class UserRepository implements UserRepositoryInterface
{
    /** @var EloquentUser */
    private $eloquentUser;

    /**
     * @param EloquentUser $eloquentUser
     */
    public function __construct(\App\Models\User $eloquentUser)
    {
        $this->eloquentUser = $eloquentUser;
    }

    /**
     * @param User $User
     * @return mixed
     */
    public function create(User $User): \App\Models\User
    {
        return $this->eloquentUser->create([
            'name'  => $User->getName(),
        ]);
    }
}
