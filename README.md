# Autotransformer

Autotransformer is a little tool which does basic DTO to entity transforming and vise versa. 

## Installation 
```
composer require tibisoft/autotransformer
```

## Usage

Without any extra configuration the transformer will loop over the properties of the target class/object and will try to find a equally named property in the source.

```php
class User {
    public function __construct(
        private string $email,
        private string $plainPassword,
        private int $age) {
    }
}

class UserDTO {
    public function __construct(
        private string $email,
        private int $age) {
    }
}

$user = new User('example@email.com', 'someSecretPassword', 25);

$transformer = new \Tibisoft\AutoTransformer\AutoTransformer();
$userDTO = $transformer->transform($user, UserDTO::class);

//output:
object(UserDTO)#8 (2) {
  ["email":"UserDTO":private]=>
  string(17) "example@email.com"
  ["age":"UserDTO":private]=>
  int(25)
}
```

### Manipulate Transforming

If the default transforming process is not enough you can add attributes to the target object/class and customise the output.

#### Synonyms

```php
class User {
    public function __construct(
        private string $email,
        private string $plainPassword,
        private int $age) {
    }
}

class UserDTO {
    public function __construct(
        private string $email, 
        #[\Tibisoft\AutoTransformer\Attribute\Synonyms(['age'])] 
        private int $yearsLive) {
    }
}

$user = new User('example@email.com', 'someSecretPassword', 25);

$transformer = new \Tibisoft\AutoTransformer\AutoTransformer();
$userDTO = $transformer->transform($user, UserDTO::class);

//output:
object(UserDTO)#8 (2) {
  ["email":"UserDTO":private]=>
  string(17) "example@email.com"
  ["yearsLive":"UserDTO":private]=>
  int(25)
}
```

#### Count
```php
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

//output:
object(UserDTO)#8 (2) {
  ["email":"UserDTO":private]=>
  string(17) "example@email.com"
  ["comments":"UserDTO":private]=>
  int(4)
}
```


