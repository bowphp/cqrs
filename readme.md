# Bow CQRS

CQRS (Command Query Responsibility Segregation). It's a pattern that I first heard described by Greg Young. At its heart is the notion that you can use a different model to update information than the model you use to read information. For some situations, this separation can be valuable but beware that for most systems CQRS adds risky complexity.

[For more information](https://www.martinfowler.com/bliki/CQRS.html)

## Install

The package uses php >= 8.1

```bash
composer require bowphp/cqrs
```

## Help

First, create the example command:

```php
use Bow\CQRS\Command\CommandInterface;

class CreateUserCommand implements CommandInterface
{
    public function __construct(
        public string $username,
        public string $email
    ) {}
}
```

Create the handler here:

```php
use Bow\CQRS\Command\CommandHandlerInterface;

class CreateUserCommandHandler implements CommandHandlerInterface
{
    public function __construct(public UserService $userService) {}

    public function process(CommandInterface $command): mixed
    {
        if ($this->userService->exists($command->email)) {
            throw new UserServiceException(
                "The user already exists"
            );
        }

        return $this->userService->create([
            "username" => $command->username,
            "email" => $command->email
        ]);
    }
}
```

Add command to the register in `App\Configurations\ApplicationConfiguration::class`:

```php
use Bow\CQRS\Registration as CQRSRegistration;

public function run()
{
    CQRSRegistration::commands([
        CreateUserCommand::class => CreateUserCommandHandler::class
    ]);
}
```

Execute the command in the controller:

```php
namespace App\Controllers;

use App\Controllers\Controller;
use App\Commands\CreateUserCommand;

class UserController extends Controller
{
    public function __construct(private CommandBus $commandBus) {}

    public function __invoke(Request $request)
    {
        $payload = $request->only(['username', 'email']);
        $command = new CreateUserCommand(
            $payload['username'],
            $payload['email']
        );

        $result = $this->commandBus->execute($command);

        return redirect()
            ->back()
            ->withFlash("message", "User created");
    }
}
```

Put a new route:

```php
$app->post("/users/create", UserController::class);
```

Put a new route:

```php
$app->post("/users/create", UserController::class);
```

## Contributing

Thank you for considering contributing to Bow Framework! The contribution guide is in the framework documentation.

- [Franck DAKIA](https://github.com/papac)
- [Thank's collaborators](https://github.com/bowphp/framework/graphs/contributors)

## Contact

[papac@bowphp.com](mailto:papac@bowphp.com) - [@papacdev](https://twitter.com/papacdev)

**Please, if there is a bug in the project. Contact me by email or leave me a message on [slack](https://bowphp.slack.com). or [join us on slack](https://join.slack.com/t/bowphp/shared_invite/enQtNzMxOTQ0MTM2ODM5LTQ3MWQ3Mzc1NDFiNDYxMTAyNzBkNDJlMTgwNDJjM2QyMzA2YTk4NDYyN2NiMzM0YTZmNjU1YjBhNmJjZThiM2Q)**
