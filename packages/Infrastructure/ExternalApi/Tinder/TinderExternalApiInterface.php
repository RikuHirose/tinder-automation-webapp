<?php
namespace packages\Infrastructure\ExternalApi\Tinder;


interface TinderExternalApiInterface
{
    /**
     *
     * @param $xAuthToken
     *
     * @return array
     */

    public function fetchUserList(string $xAuthToken): array;
}
