<?php

namespace packages\Domain\Domain\User;


interface UserRepositoryInterface
{
    /**
     * @param User $user
     * @return \App\Models\User
     */
    public function create(User $user): \App\Models\User;
}
