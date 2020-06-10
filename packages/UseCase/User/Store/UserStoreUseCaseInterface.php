<?php

namespace packages\UseCase\User\Store;

use packages\UseCase\User\Store\UserStoreInput;
use packages\UseCase\User\Store\UserStoreResponse;

interface UserStoreUseCaseInterface
{
    /**
     * @param  UserStoreInput $input
     * @return UserStoreResponse
     */
    public function handle(UserStoreInput $input): UserStoreResponse;
}
