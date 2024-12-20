# PHP-based GenericCollection

![GitHub tag (latest by date)](https://img.shields.io/github/v/tag/shahmal1yev/gCollection?label=latest&style=flat)
[![License: MIT](https://img.shields.io/badge/License-MIT-green.svg)](https://opensource.org/licenses/MIT)
![GitHub last commit](https://img.shields.io/github/last-commit/shahmal1yev/gCollection)
![GitHub issues](https://img.shields.io/github/issues/shahmal1yev/gCollection)
![GitHub stars](https://img.shields.io/github/stars/shahmal1yev/gCollection)
![GitHub forks](https://img.shields.io/github/forks/shahmal1yev/gCollection)
![GitHub contributors](https://img.shields.io/github/contributors/shahmal1yev/gCollection)

`GenericCollection` is a PHP library for handling collections with support for various primitive types. It allows for flexible type validation and manipulation of collections.

## Features

- **Flexible Type Handling**: Supports various primitive types such as `int`, `string`, `float`, `bool`, and more.
- **Type Validation**: Provides methods to validate if an item in the collection adheres to the specified type.
- **Extensible**: Easily extendable to support custom types and validation logic.

## Dependencies

```json
{
  "require": {
    "php": ">=7.4"
  },
  "require-dev": {
    "phpunit/phpunit": "9.6.20"
  }
}
```

## Installation

You can install `GenericCollection` via Composer. If you don't have Composer installed, you can get it from [getcomposer.org](https://getcomposer.org).

Run the following command to install `GenericCollection`:

```bash
composer require shahmal1yev/gcollection
```

## Usage

Here is a basic example of how to use the `GenericCollection`:

```php
<?php

require 'vendor/autoload.php';

use GenericCollection\GenericCollection;
use GenericCollection\Types\Primitive\StringType;

class Foo
{
    public function __toString(): string
    {
        return "Foo as string";
    }
}

// Create a new collection with Foo validation
$collection = new GenericCollection(Foo::class);

// Add items to the collection
$collection[] = new Foo;
$collection->add(1, new Foo);

// Retrieve items from the collection
echo $collection[0];
echo $collection->get(1); // Outputs: Foo as string

// Validate an item
var_dump($collection->validate(new Foo)); // Outputs: bool(true)
```

```php
<?php

require 'vendor/autoload.php';

use GenericCollection\GenericCollection;
use GenericCollection\Types\Primitive\StringType;

// Create a new collection with StringType validation
$collection = new GenericCollection(new StringType());

// Add items to the collection
$collection[] = "Hello";
$collection->add(1, "World");

// Retrieve items from the collection
echo $collection[1];
echo $collection->get(0); // Outputs: Hello

// Validate an item
var_dump($collection->validate("Test")); // Outputs: bool(true)
```

## Available Primitive Types

`GenericCollection` includes the following primitive types:

- **IntType**: Validates integer values.
- **StringType**: Validates string values.
- **FloatType**: Validates float values.
- **BoolType**: Validates boolean values.
- **ObjectType**: Validates object values.
- **CallableType**: Validates callable values.
- **ResourceType**: Validates resource values.
- **IterableType**: Validates iterable values.

## Contributing

Contributions are welcome! Please follow these steps to contribute to the project:

1. **Fork the Repository**: Create a personal copy of the repository by forking it on GitHub.
2. **Create a Branch**: Create a new branch for your changes.
3. **Make Changes**: Implement your changes or fix issues.
4. **Submit a Pull Request**: Push your changes and submit a pull request for review.

## Running Tests

To run the tests, make sure you have PHPUnit installed. You can install it via Composer:

```bash
composer require --dev phpunit/phpunit:9.6.20
```

Run the tests with the following command:

```bash
vendor/bin/phpunit ./tests
```

## License

This project is licensed under the MIT License. For more information, see the [LICENSE](https://opensource.org/license/MIT).

## Contact

For any questions or feedback, please contact us at [LinkedIn](https://linkedin.com/in/shahmal1yev).