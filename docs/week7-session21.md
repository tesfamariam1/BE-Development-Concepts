# Session 21: Testing Basics in Laravel

## 🎯 Learning Objectives

By the end of this session, you will be able to:

- Understand why testing is important in API development.
- Write basic PHPUnit tests in a Laravel project.
- Perform Feature testing for API endpoints.
- Use Database testing with Laravel’s in-memory testing database.

---

## 📚 Session Outline

### 1: Introduction to Testing

#### What is testing?

- A way to ensure our code works as expected.
- Reduces bugs when the app grows.

### Types of tests in Laravel:

- Unit tests: Test small pieces of logic (functions, classes).
- Feature tests: Test API endpoints / user flows (end-to-end).

### Tools:

- Laravel uses PHPUnit (default).
- Pest

**👉 Example:**

```
Without testing:
Developer changes code → runs Postman manually → hopes everything works.

With testing:
Write test once → run php artisan test → Laravel automatically checks APIs.
```

### 2: PHPUnit Fundamentals

- PHPUnit is installed by default in Laravel.
- Test files are stored in tests/Feature and tests/Unit.

Commands:

```bash
php artisan test          # Run all tests
php artisan make:test UserTest
```

Example: Simple Unit Test

File: tests/Unit/ExampleTest.php

```php
public function test_basic_math_works()
{
    $this->assertTrue(1 + 1 === 2);
}
```

👉 Demo: Run php artisan test → see green ✅ if passed.

### 3. Feature Testing

- Focus on API endpoint testing.
- Uses Laravel’s HTTP testing methods.

Example: Testing an API Route

Suppose we have GET /api/users.

Test:

```php
<?php

use Tests\TestCase;

class UserTest extends TestCase
{
    public function test_users_list_endpoint_returns_success()
    {
        $response = $this->get('/api/users');
        $response->assertStatus(200);
    }
}

```

- Class declaration: class UserTest extends TestCase
- Method declaration: public function test_users_list_endpoint_returns_success()
- Even for one simple test, you must write the class and method.

👉 Concepts introduced:

- $this->get() → simulates API request.
- assertStatus(200) → ensures OK response.
- assertJsonStructure() → validates response structure.

Exercise for you:

- Create a test for POST /api/users (e.g., user creation).

### 4. Database Testing

- Laravel provides tools for fresh DB per test.
- Uses RefreshDatabase trait → resets DB between tests.

Example: Testing User Creation

```php
use Illuminate\Foundation\Testing\RefreshDatabase;

class UserTest extends TestCase
{
    use RefreshDatabase;

    public function test_user_can_be_created()
    {
        $response = $this->post('/api/users', [
            'name' => 'John Doe',
            'email' => 'john@example.com',
            'password' => 'secret123'
        ]);

        $response->assertStatus(201);
        $this->assertDatabaseHas('users', [
            'email' => 'john@example.com'
        ]);
    }
}
```

👉 Key Points:

- RefreshDatabase → ensures tests don’t pollute each other.
- assertDatabaseHas() → confirms record exists.

Exercise for you:

- Write a test that checks DELETE /api/users/{id} actually removes the user.

### 5. Introduction to Pest

- What is Pest?
  - Pest is a PHP testing framework built on PHPUnit.
  - Provides simpler, readable syntax and modern testing features.
  - Works perfectly with Laravel.

#### Installing Pest in Laravel

```bash
composer require pestphp/pest --dev
php artisan pest:install
```

#### Pest Syntax Example

```php
it('adds numbers correctly', function () {
    expect(1 + 1)->toBe(2);
});
```

- Compare with PHPUnit: much shorter and readable.
- Pest can run unit and feature tests.

### 6. Feature Testing with Pest

- Example: Testing API endpoint GET /api/users

```php
it('returns list of users', function () {
    $response = $this->get('/api/users');

    $response->assertStatus(200);
    $response->assertJsonStructure([
        '*' => ['id', 'name', 'email']
    ]);
});
```

- Pest uses closures, no class boilerplate needed (Pest allows you to write a test directly as a closure function, without wrapping it in a class).
- No class declaration is needed.
- No method declaration is needed.
- Each it() function is a self-contained test.
- The closure contains all the test logic.
- Integrates with Laravel’s HTTP testing methods.

Exercise for you:

- Write a Pest test for POST /api/users (user creation).

### 7. Database Testing with Pest

- Pest supports Laravel traits like RefreshDatabase.

```php
uses(RefreshDatabase::class);

it('creates a user in the database', function () {
    $response = $this->post('/api/users', [
        'name' => 'Jane Doe',
        'email' => 'jane@example.com',
        'password' => 'secret123'
    ]);

    $response->assertStatus(201);
    $this->assertDatabaseHas('users', ['email' => 'jane@example.com']);
});
```

- Clear, concise syntax without extra boilerplate.

Exercise for you:

- Write a Pest test for deleting a user (DELETE /api/users/{id}).

### 5. Wrap-Up & Q/A

- Recap:

  - PHPUnit = testing framework.
  - Feature tests = simulate API calls.
  - Database tests = ensure DB changes happen.
  - Pest: Cleaner, closure-based syntax, fully compatible with Laravel.

- Show how tests save time compared to manual Postman testing.

### 📝 Homework:

1. Write a test for updating a user (PUT /api/users/{id}).
2. Explore Laravel docs: Testing in Laravel [Testing In Laravel](https://laravel.com/docs/testing).
3. Add at least 2 new feature tests in their API project.
