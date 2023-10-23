<?php

class UserOptions
{
    public $id;
    private $login;
    public $model;

    public function __construct($id, $login)
    {
        $this->id = $id;
        $this->login = $login;
    }

    public function __serialize(): array
    {
        return [
            'id' => $this->id,
            'login' => $this->login,
            'model' => $this->model,
        ];
    }

    public function __unserialize(array $data): void
    {
        $this->id = $data['id'];
        $this->login = $data['login'];
        $this->model = $data['model'];
    }
}

$options = new UserOptions(10, 'user');

$serialisedOptions = serialize($options);

echo $serialisedOptions . PHP_EOL;

file_put_contents(__DIR__ . '/userOptions', $serialisedOptions);