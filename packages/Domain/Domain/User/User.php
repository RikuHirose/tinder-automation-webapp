<?php

namespace packages\Domain\Domain\User;


class User
{
    /**
     * @var string
     */
    private $name;

    /**
     * コンストラクタをプライベートにしてファクトリーメソッド経由での作成に強制
     */
    private function __construct()
    {
    }

    /**
     * factory method of signUp
     * @param int $name
     * @return User
     */
    public static function signUp(int $name): User
    {
        $object = new User();

        $object->name = $name;

        return $object;
    }

    /**
     * @return string
     */
    public function getName(): string
    {
        return $this->name;
    }
}
