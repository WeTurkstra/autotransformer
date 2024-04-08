<?php
require 'vendor/autoload.php';

class User {
    public function __construct(
        private string $email,
        private array $comments) {
    }
}

class UserDTO {
    public function __construct(
        private string $email,
        #[\Tibisoft\AutoTransformer\Attribute\Count]
        private int $comments) {
    }
}

$user = new User('example@email.com', ['Comment #1', 'Comment #2', 'Comment #3', 'Comment #4']);

$transformer = new \Tibisoft\AutoTransformer\AutoTransformer();
$userDTO = $transformer->transform($user, UserDTO::class);

var_dump($userDTO);
exit;
