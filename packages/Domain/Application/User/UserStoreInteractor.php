<?php

namespace packages\Domain\Application\User;

use packages\Domain\Domain\User\User;
use packages\Domain\Domain\User\UserRepositoryInterface;
use packages\UseCase\User\Store\UserStoreInput;
use packages\UseCase\User\Store\UserStoreUseCaseInterface;
use packages\UseCase\User\Store\UserStoreResponse;
use App\Notifications\User\MissionUserNotification;
use Notification;

class UserStoreInteractor implements UserStoreUseCaseInterface
{
    private $userRepository;

    public function __construct(
        UserRepositoryInterface $userRepository
    ) {
        $this->UserRepository  = $userRepository;
    }

    /**
     * @param  UserStoreInput $input
     * @return UserStoreResponse
     */
    public function handle(UserStoreInput $input): UserStoreResponse
    {
        
        return new UserStoreResponse($user);
    }
}
