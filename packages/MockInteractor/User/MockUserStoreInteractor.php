<?php

namespace packages\MockInteractor\User;


use packages\UseCase\User\Store\UserStoreUseCaseInterface;
use packages\UseCase\User\Store\UserStoreInput;
use packages\UseCase\User\Store\UserStoreResponse;

class MockUserStoreInteractor implements UserStoreUseCaseInterface
{

    /**
     * @param UserStoreRequest $request
     * @return UserStoreResponse
     */
    public function handle(UserStoreInput $request)
    {
        return new UserStoreResponse('test-id');
    }
}
