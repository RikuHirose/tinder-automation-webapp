<?php

namespace packages\UseCase\User\Store;

class UserStoreInput
{
    /**
     * @var App\Models\User
     */
    private $user;

    /**
     * @var string
     */
    private $name;

    /**
     * @var int
     */
    private $mission_id;

    /**
     * UserStoreRequest constructor.
     * @param string $name
     */
    public function __construct(
        \App\Models\User $user,
        string $name
    ) {
        $this->user    = $user;
        $this->name    = $name;
    }

    /**
     * @return \App\Models\User
     */
    public function getUser(): \App\Models\User
    {
        return $this->user;
    }

    /**
     * @return string
     */
    public function getName(): string
    {
        return $this->name;
    }
}
