<?php

namespace packages\UseCase\User\Store;

class UserStoreResponse
{
    public $user;

    /**
     * PostIndexResponse constructor.
     * @param PostModel[] $user
     */
    public function __construct(\App\Models\User $user)
    {
        $this->user = $user;
    }

    /**
     * @return \App\Models\User
     */
    public function getUser(): \App\Models\User
    {
        return $this->user;
    }
}
