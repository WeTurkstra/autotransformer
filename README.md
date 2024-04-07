# Autotransformer

Autotransformer is a little tool which does basic DTO to entity transforming and vise versa. 

## Installation 
```
composer require tibisoft/autotransformer
```

## Usage

The transformer will loop over the properties of the target and will try to find equally named properties:
```php
class User {
    public function __construct(private string $email, private string $plainPassword, private int $age) {
    
    }
}

class UserDTO {
    public function __construct(private string $email, private int $age) {
    
    }
}

$user = new User('example@email.com', 'someSecretPassword', 25);

$transformer = new AutoTransformer();
$userDTO = $transformer->transform($user, UserDTO::class);
```

