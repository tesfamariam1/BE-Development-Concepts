# Laravel Developer Course: Sessions 16-18

## API Development & File Handling

---

# Session 16: API Fundamentals

## Learning Objectives

By the end of this session, you will:

- Understand what APIs are and their importance in modern web development
- Know the principles of REST architecture
- Be able to create API routes and controllers in Laravel
- Understand how to return proper JSON responses

## 1. What are APIs?

### Definition and Purpose

- **API (Application Programming Interface)**: A set of rules and protocols that allows different software applications to communicate with each other
- Think of APIs as waiters in a restaurant - they take your order (request) and bring back your food (response)

### Real-World Examples

- Weather apps getting data from weather services
- Social media login (OAuth)
- Payment processing (Stripe, PayPal, Chapa)
- Maps integration (Google Maps, Mapbox)

### Why APIs Matter

- Enable mobile app development
- Allow third-party integrations
- Support microservices architecture
- Enable data sharing between systems

## 2. REST Architecture

### What is REST?

**REST (Representational State Transfer)** is an architectural style for designing networked applications.

### REST Principles

1. **Client-Server Architecture**: Separation of concerns
2. **Stateless**: Each request contains all necessary information
3. **Cacheable**: Responses should be cacheable when appropriate
4. **Uniform Interface**: Consistent way to interact with resources
5. **Layered System**: Architecture can be composed of hierarchical layers

### HTTP Methods and Their Meanings

```
GET    /api/users        # Retrieve all users
GET    /api/users/1      # Retrieve user with ID 1
POST   /api/users        # Create a new user
PUT    /api/users/1      # Update user with ID 1 (full update)
PATCH  /api/users/1      # Update user with ID 1 (partial update)
DELETE /api/users/1      # Delete user with ID 1
```

### REST vs Traditional Web Pages

- **Traditional**: Returns HTML for humans
- **REST API**: Returns data (usually JSON) for applications

## 3. Laravel API Routes

### Setting Up API Routes

Laravel provides a dedicated file for API routes: `routes/api.php`

```php
// routes/api.php
<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\UserController;

// API routes automatically get /api prefix
Route::get('/users', [UserController::class, 'index']);
Route::get('/users/{id}', [UserController::class, 'show']);
Route::post('/users', [UserController::class, 'store']);
Route::put('/users/{id}', [UserController::class, 'update']);
Route::delete('/users/{id}', [UserController::class, 'destroy']);

// Or use resource routes for all CRUD operations
Route::apiResource('users', UserController::class);
```

### API vs Web Routes

- **Web routes** (`routes/web.php`): For traditional web pages, include CSRF protection, sessions
- **API routes** (`routes/api.php`): For APIs, stateless, no CSRF protection by default

## 4. API Controllers

### Creating API Controllers

```bash
# Create controller specifically for API
php artisan make:controller Api/UserController --api
```

### Basic API Controller Structure

```php
<?php
// app/Http/Controllers/Api/UserController.php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;

class UserController extends Controller
{
    public function index(): JsonResponse
    {
        $users = User::all();

        return response()->json([
            'status' => 'success',
            'data' => $users
        ]);
    }

    public function show(string $id): JsonResponse
    {
        $user = User::find($id);

        if (!$user) {
            return response()->json([
                'status' => 'error',
                'message' => 'User not found'
            ], 404);
        }

        return response()->json([
            'status' => 'success',
            'data' => $user
        ]);
    }

    public function store(Request $request): JsonResponse
    {
        $validatedData = $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users',
            'password' => 'required|string|min:8',
        ]);

        $user = User::create([
            'name' => $validatedData['name'],
            'email' => $validatedData['email'],
            'password' => bcrypt($validatedData['password']),
        ]);

        return response()->json([
            'status' => 'success',
            'message' => 'User created successfully',
            'data' => $user
        ], 201);
    }

    public function update(Request $request, string $id): JsonResponse
    {
        $user = User::find($id);

        if (!$user) {
            return response()->json([
                'status' => 'error',
                'message' => 'User not found'
            ], 404);
        }

        $validatedData = $request->validate([
            'name' => 'sometimes|required|string|max:255',
            'email' => 'sometimes|required|string|email|max:255|unique:users,email,' . $id,
        ]);

        $user->update($validatedData);

        return response()->json([
            'status' => 'success',
            'message' => 'User updated successfully',
            'data' => $user
        ]);
    }

    public function destroy(string $id): JsonResponse
    {
        $user = User::find($id);

        if (!$user) {
            return response()->json([
                'status' => 'error',
                'message' => 'User not found'
            ], 404);
        }

        $user->delete();

        return response()->json([
            'status' => 'success',
            'message' => 'User deleted successfully'
        ]);
    }
}
```

## 5. JSON Responses

### HTTP Status Codes

- **200**: OK (successful GET, PUT, PATCH)
- **201**: Created (successful POST)
- **204**: No Content (successful DELETE)
- **400**: Bad Request
- **401**: Unauthorized
- **403**: Forbidden
- **404**: Not Found
- **422**: Unprocessable Entity (validation errors)
- **500**: Internal Server Error

### Response Structure Best Practices

```php
// Success Response
return response()->json([
    'status' => 'success',
    'data' => $data,
    'message' => 'Operation completed successfully'
], 200);

// Error Response
return response()->json([
    'status' => 'error',
    'message' => 'Something went wrong',
    'errors' => $validationErrors // optional
], 400);

// Validation Error Response
return response()->json([
    'status' => 'error',
    'message' => 'Validation failed',
    'errors' => [
        'email' => ['The email field is required.'],
        'password' => ['The password must be at least 8 characters.']
    ]
], 422);
```

### Success Codes

- 200 OK
  - Why: The request was successful.
  - When to use:
    - GET request returns data.
    - PUT/PATCH request successfully updates a resource.
  - Example: Fetching a user profile successfully.
- 201 Created
  - Why: The server successfully created a new resource.
  - When to use: After a successful POST.
  - Example: User registration creates a new account → return 201 + resource details.
- 204 No Content
  - Why: The request succeeded, but there’s nothing to return.
  - When to use:
    - DELETE request succeeds.
    - PUT/PATCH updates without needing to return content.
  - Example: Deleting a user successfully.

### Client Error Codes (4xx = client made a mistake)

- 400 Bad Request
  - Why: The server can’t process the request due to invalid syntax or missing data.
  - When to use: Malformed JSON, missing required fields, or wrong query format.
  - Example: Client sends { "email": } instead of a valid string.
- 401 Unauthorized
  - Why: Authentication failed (token missing/expired/invalid).
  - When to use: When a user tries to access a protected resource without logging in.
  - Example: No Bearer token or invalid API key.
- 403 Forbidden
  - Why: The user is authenticated, but doesn’t have permission.
  - When to use:
    - A normal user tries to access an admin-only page.
    - Tenant isolation violation in multi-tenant apps.
  - Example: User has a valid token but lacks "admin" role.
- 404 Not Found
  - Why: The requested resource doesn’t exist.
  - When to use:
    - User tries to fetch /users/9199 but no such user exists.
    - API route is missing.
- 422 Unprocessable Entity
  - Why: Request is well-formed but fails validation.
  - When to use:
    - Invalid form submission.
    - Business rules not met.
  - Example: Registration form with invalid email → return validation errors.

### Server Error Codes (5xx = server messed up)

- 500 Internal Server Error
  - Why: Something unexpected went wrong on the server.
  - When to use:
    - Database crashes.
    - Unhandled exception in code.
  - Example: You forgot to handle division by zero in your API logic.

**Error vs Success: 2xx = success, 4xx = client’s fault, 5xx = server’s fault.**

## Hands-On Exercise

Create a simple Product API with the following endpoints:
Include HTTP Status Code.

- GET /api/products (list all products)
- GET /api/products/{id} (show single product)
- POST /api/products (create product)
- PUT /api/products/{id} (update product)
- DELETE /api/products/{id} (delete product)

---

# Session 17: Building API Endpoints

## Learning Objectives

By the end of this session, you will:

- Know how to create and use API resources for data transformation
- Understand basic API authentication methods
- Be able to test APIs effectively using Postman

## 1. Creating API Resources

### What are API Resources?

API Resources provide a transformation layer between your Eloquent models and the JSON responses sent to your API consumers.

### Why Use API Resources?

- **Consistency**: Standardize output format
- **Control**: Hide sensitive data
- **Flexibility**: Transform data as needed
- **Maintainability**: Centralize response logic

### Creating Resources

```bash
# Create a single resource
php artisan make:resource UserResource

# Create a resource collection
php artisan make:resource UserCollection

# Create both at once
php artisan make:resource User --collection
```

### Basic Resource Example

```php
<?php
// app/Http/Resources/UserResource.php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class UserResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     */
    public function toArray(Request $request): array
    {
        return [
            'id' => $this->id,
            'name' => $this->name,
            'email' => $this->email,
            'created_at' => $this->created_at->format('Y-m-d H:i:s'),
            'updated_at' => $this->updated_at->format('Y-m-d H:i:s'),
            // Don't include password or other sensitive data
        ];
    }
}
```

### Using Resources in Controllers

```php
<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Resources\UserResource;
use App\Models\User;

class UserController extends Controller
{
    public function index()
    {
        $users = User::all();
        return UserResource::collection($users);
    }

    public function show(User $user)
    {
        return new UserResource($user);
    }

    public function store(Request $request)
    {
        $validatedData = $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users',
            'password' => 'required|string|min:8',
        ]);

        $user = User::create([
            'name' => $validatedData['name'],
            'email' => $validatedData['email'],
            'password' => bcrypt($validatedData['password']),
        ]);

        return new UserResource($user);
    }
}
```

### Advanced Resource Features

```php
<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class UserResource extends JsonResource
{
    public function toArray(Request $request): array
    {
        return [
            'id' => $this->id,
            'name' => $this->name,
            'email' => $this->email,

            // Conditional attributes
            'email_verified_at' => $this->when(
                $this->email_verified_at,
                $this->email_verified_at?->format('Y-m-d H:i:s')
            ),

            // Conditional relationships
            'posts' => PostResource::collection($this->whenLoaded('posts')),

            // Computed attributes
            'full_name' => $this->first_name . ' ' . $this->last_name,

            // Timestamps
            'created_at' => $this->created_at->format('Y-m-d H:i:s'),
            'updated_at' => $this->updated_at->format('Y-m-d H:i:s'),
        ];
    }

    /**
     * Get additional data that should be returned with the resource array.
     */
    public function with(Request $request): array
    {
        return [
            'version' => '1.0',
            'author_url' => url('http://author.com'),
        ];
    }
}
```

### Resource Collections

```php
<?php
// app/Http/Resources/UserCollection.php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\ResourceCollection;

class UserCollection extends ResourceCollection
{
    /**
     * Transform the resource collection into an array.
     */
    public function toArray(Request $request): array
    {
        return [
            'data' => $this->collection,
            'meta' => [
                'total' => $this->collection->count(),
                'fetched_at' => now()->format('Y-m-d H:i:s'),
            ],
        ];
    }
}
```

## 2. API Authentication Basics

### Why API Authentication?

- Protect sensitive endpoints
- Track API usage
- Rate limiting
- Personalized responses

### Token-Based Authentication

Laravel provides built-in token authentication via Laravel Sanctum.

### Installing Laravel Sanctum

```bash
composer require laravel/sanctum
php artisan vendor:publish --provider="Laravel\Sanctum\SanctumServiceProvider"
php artisan migrate
```

### Setting Up Sanctum

```php
// config/sanctum.php - Key configurations
'stateful' => explode(',', env('SANCTUM_STATEFUL_DOMAINS', sprintf(
    '%s%s',
    'localhost,localhost:3000,127.0.0.1,127.0.0.1:8000,::1',
    Sanctum::currentApplicationUrlWithPort()
))),

'guard' => ['web'],
'expiration' => null, // tokens don't expire by default
'middleware' => [
    'verify_csrf_token' => App\Http\Middleware\VerifyCsrfToken::class,
    'encrypt_cookies' => App\Http\Middleware\EncryptCookies::class,
],
```

### User Model Setup

```php
<?php
// app/Models/User.php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;

class User extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable;

    // ... rest of your User model
}
```

### Authentication Controller

```php
<?php
// app/Http/Controllers/Api/AuthController.php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\ValidationException;

class AuthController extends Controller
{
    public function register(Request $request)
    {
        $validatedData = $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users',
            'password' => 'required|string|min:8|confirmed',
        ]);

        $user = User::create([
            'name' => $validatedData['name'],
            'email' => $validatedData['email'],
            'password' => Hash::make($validatedData['password']),
        ]);

        $token = $user->createToken('API Token')->plainTextToken;

        return response()->json([
            'status' => 'success',
            'message' => 'User registered successfully',
            'data' => [
                'user' => $user,
                'token' => $token,
                'token_type' => 'Bearer'
            ]
        ], 201);
    }

    public function login(Request $request)
    {
        $request->validate([
            'email' => 'required|email',
            'password' => 'required',
        ]);

        $user = User::where('email', $request->email)->first();

        if (! $user || ! Hash::check($request->password, $user->password)) {
            throw ValidationException::withMessages([
                'email' => ['The provided credentials are incorrect.'],
            ]);
        }

        $token = $user->createToken('API Token')->plainTextToken;

        return response()->json([
            'status' => 'success',
            'message' => 'Login successful',
            'data' => [
                'user' => $user,
                'token' => $token,
                'token_type' => 'Bearer'
            ]
        ]);
    }

    public function logout(Request $request)
    {
        $request->user()->currentAccessToken()->delete();

        return response()->json([
            'status' => 'success',
            'message' => 'Logged out successfully'
        ]);
    }

    public function me(Request $request)
    {
        return response()->json([
            'status' => 'success',
            'data' => $request->user()
        ]);
    }
}
```

### Protected Routes

```php
// routes/api.php
use App\Http\Controllers\Api\AuthController;
use App\Http\Controllers\Api\UserController;

// Public routes
Route::post('/register', [AuthController::class, 'register']);
Route::post('/login', [AuthController::class, 'login']);

// Protected routes
Route::middleware('auth:sanctum')->group(function () {
    Route::post('/logout', [AuthController::class, 'logout']);
    Route::get('/me', [AuthController::class, 'me']);
    Route::apiResource('users', UserController::class);
});
```

## 3. Testing APIs with Postman

### Setting Up Postman

- Download and install Postman
- Create a new workspace for your project
- Set up environment variables

### Environment Variables in Postman

```json
{
  "base_url": "http://localhost:8000/api",
  "token": ""
}
```

### Testing Authentication Flow

#### 1. Register a New User

```
POST {{base_url}}/register
Headers:
  Content-Type: application/json
Body (JSON):
{
    "name": "John Doe",
    "email": "john@example.com",
    "password": "password123",
    "password_confirmation": "password123"
}
```

#### 2. Login

```
POST {{base_url}}/login
Headers:
  Content-Type: application/json
Body (JSON):
{
    "email": "john@example.com",
    "password": "password123"
}
```

_Save the token from response to environment variable_

#### 3. Access Protected Route

```
GET {{base_url}}/me
Headers:
  Authorization: Bearer {{token}}
  Accept: application/json
```

### Testing CRUD Operations

```
# GET all users
GET {{base_url}}/users
Headers:
  Authorization: Bearer {{token}}
  Accept: application/json

# GET single user
GET {{base_url}}/users/1
Headers:
  Authorization: Bearer {{token}}
  Accept: application/json

# POST create user
POST {{base_url}}/users
Headers:
  Authorization: Bearer {{token}}
  Content-Type: application/json
Body (JSON):
{
    "name": "Jane Doe",
    "email": "jane@example.com",
    "password": "password123"
}

# PUT update user
PUT {{base_url}}/users/1
Headers:
  Authorization: Bearer {{token}}
  Content-Type: application/json
Body (JSON):
{
    "name": "Jane Smith",
    "email": "jane.smith@example.com"
}

# DELETE user
DELETE {{base_url}}/users/1
Headers:
  Authorization: Bearer {{token}}
  Accept: application/json
```

### Postman Collections and Testing

Create automated tests in Postman:

```javascript
// Test for successful login
pm.test("Login successful", function () {
  pm.response.to.have.status(200);
  const response = pm.response.json();
  pm.expect(response.status).to.eql("success");
  pm.expect(response.data.token).to.exist;

  // Save token for other requests
  pm.environment.set("token", response.data.token);
});

// Test for user creation
pm.test("User created successfully", function () {
  pm.response.to.have.status(201);
  const response = pm.response.json();
  pm.expect(response.status).to.eql("success");
  pm.expect(response.data.id).to.exist;
});
```

## Hands-On Exercise

1. Create a Product API with authentication
2. Create ProductResource for data transformation
3. Set up protected routes for product management
4. Test all endpoints with Postman including authentication flow

---

# Session 18: File Handling

## Learning Objectives

By the end of this session, you will:

- Understand how to handle file uploads in Laravel
- Know how to store and organize files
- Be able to process and validate uploaded files
- Understand basic image processing concepts

### --Continue--
