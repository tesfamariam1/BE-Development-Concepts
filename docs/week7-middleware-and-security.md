# Laravel API Middleware & Security

## Session Overview

**Duration:** 90 minutes  
**Testing Tool:** Postman  
**Focus:** API Development

### Time Breakdown

- **Part 1:** Understanding Middleware (20 min)
- **Part 2:** Creating Custom API Middleware (25 min)
- **Part 3:** API Security & Token Authentication (25 min)
- **Part 4:** Hands-on Practice with Postman (20 min)

---

## Part 1: Understanding API Middleware

### What is Middleware in APIs?

Middleware are filters that process HTTP requests before they reach your API endpoints. Think of them as checkpoints that validate, authenticate, or modify requests.

```
API Request → Middleware 1 → Middleware 2 → Controller → JSON Response
```

### Key API Middleware in Laravel

```php
// routes/api.php - Laravel's default API middleware
Route::middleware('api')->group(function () {
    // Your API routes here
});
```

The `api` middleware group includes:

- `throttle:api` - Rate limiting (60 requests per minute)
- `bindings` - Route model binding

### Common API Middleware Use Cases

1. **Authentication** - "Is this a valid API token?"
2. **Rate Limiting** - "Has this client made too many requests?"
3. **JSON Validation** - "Is the request properly formatted?"
4. **Logging** - "Log all API requests for monitoring"

---

## Part 2: Creating Custom API Middleware

### Example 1: API Key Authentication Middleware

#### Step 1: Create Middleware

```bash
php artisan make:middleware ApiKeyAuth
```

#### Step 2: Implement Logic

```php
<?php
// app/Http/Middleware/ApiKeyAuth.php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;

class ApiKeyAuth
{
    public function handle(Request $request, Closure $next)
    {
        $apiKey = $request->header('X-API-Key');

        // Check if API key exists
        if (!$apiKey) {
            return response()->json([
                'error' => 'API key is required',
                'message' => 'Please provide X-API-Key header'
            ], 401);
        }

        // Validate API key (you can check database here)
        $validKeys = ['your-secret-api-key-123', 'another-valid-key-456'];

        if (!in_array($apiKey, $validKeys)) {
            return response()->json([
                'error' => 'Invalid API key',
                'message' => 'The provided API key is not valid'
            ], 401);
        }

        return $next($request);
    }
}
```

#### Step 3: Register Middleware

```php
// app/Http/Kernel.php
protected $middlewareAliases = [
    // ... other middleware
    'api.key' => \App\Http\Middleware\ApiKeyAuth::class,
];
```

#### Step 4: Apply to Routes

```php
// routes/api.php
Route::middleware(['api.key'])->group(function () {
    Route::get('/users', [UserController::class, 'index']);
    Route::post('/users', [UserController::class, 'store']);
});
```

#### Postman Testing:

```
GET http://localhost:8000/api/users
Headers:
X-API-Key: your-secret-api-key-123
```

### Example 2: JSON Request Validator Middleware

```php
<?php
// app/Http/Middleware/JsonRequestValidator.php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;

class JsonRequestValidator
{
    public function handle(Request $request, Closure $next)
    {
        // Only validate POST, PUT, PATCH requests
        if (in_array($request->method(), ['POST', 'PUT', 'PATCH'])) {

            // Check Content-Type header
            if ($request->header('Content-Type') !== 'application/json') {
                return response()->json([
                    'error' => 'Invalid Content-Type',
                    'message' => 'Content-Type must be application/json'
                ], 400);
            }

            // Check if request body is valid JSON
            if (!$request->isJson()) {
                return response()->json([
                    'error' => 'Invalid JSON',
                    'message' => 'Request body must be valid JSON'
                ], 400);
            }
        }

        return $next($request);
    }
}
```

### Example 3: Simple API Logger Middleware

```php
<?php
// app/Http/Middleware/ApiLogger.php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

class ApiLogger
{
    public function handle(Request $request, Closure $next)
    {
        // Log request details
        Log::info('API Request', [
            'method' => $request->method(),
            'url' => $request->fullUrl(),
            'ip' => $request->ip(),
            'user_agent' => $request->userAgent(),
            'timestamp' => now()
        ]);

        $response = $next($request);

        // Log response status
        Log::info('API Response', [
            'status' => $response->status(),
            'timestamp' => now()
        ]);

        return $response;
    }
}
```

---

## Part 3: API Security & Token Authentication

### Laravel Sanctum for API Authentication

#### Step 1: Install Sanctum

```bash
composer require laravel/sanctum
php artisan vendor:publish --provider="Laravel\Sanctum\SanctumServiceProvider"
php artisan migrate
```

#### Step 2: Configure User Model

```php
<?php
// app/Models/User.php

use Laravel\Sanctum\HasApiTokens;

class User extends Authenticatable
{
    use HasApiTokens; // Add this trait

    protected $fillable = [
        'name', 'email', 'password',
    ];
}
```

#### Step 3: Create Auth Controller

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
    public function login(Request $request)
    {
        $request->validate([
            'email' => 'required|email',
            'password' => 'required',
        ]);

        $user = User::where('email', $request->email)->first();

        if (!$user || !Hash::check($request->password, $user->password)) {
            return response()->json([
                'message' => 'The provided credentials are incorrect.'
            ], 401);
        }

        $token = $user->createToken('api-token')->plainTextToken;

        return response()->json([
            'token' => $token,
            'user' => $user
        ]);
    }

    public function register(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users',
            'password' => 'required|string|min:8',
        ]);

        $user = User::create([
            'name' => $validated['name'],
            'email' => $validated['email'],
            'password' => Hash::make($validated['password']),
        ]);

        $token = $user->createToken('api-token')->plainTextToken;

        return response()->json([
            'token' => $token,
            'user' => $user
        ], 201);
    }

    public function logout(Request $request)
    {
        $request->user()->currentAccessToken()->delete();

        return response()->json([
            'message' => 'Logged out successfully'
        ]);
    }
}
```

#### Step 4: Protected API Routes

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
    Route::get('/user', function (Request $request) {
        return $request->user();
    });
    Route::apiResource('users', UserController::class);
});
```

### API Security Best Practices

#### 1. Input Validation

```php
// app/Http/Controllers/Api/UserController.php
public function store(Request $request)
{
    $validated = $request->validate([
        'name' => 'required|string|max:255',
        'email' => 'required|email|unique:users',
        'age' => 'required|integer|min:1|max:150'
    ]);

    $user = User::create($validated);

    return response()->json($user, 201);
}
```

#### 2. Rate Limiting

```php
// routes/api.php
Route::middleware(['throttle:10,1'])->group(function () {
    Route::post('/login', [AuthController::class, 'login']);
    Route::post('/register', [AuthController::class, 'register']);
});

// Custom rate limiting
Route::middleware(['throttle:api'])->group(function () {
    // 60 requests per minute (default)
});
```

#### 3. Error Handling

```php
// app/Http/Controllers/Controller.php
protected function errorResponse($message, $code = 400)
{
    return response()->json([
        'error' => true,
        'message' => $message,
        'timestamp' => now()
    ], $code);
}

protected function successResponse($data, $message = 'Success', $code = 200)
{
    return response()->json([
        'error' => false,
        'message' => $message,
        'data' => $data,
        'timestamp' => now()
    ], $code);
}
```

---

## Part 4: Hands-on Practice with Postman

### Setup Your Environment

#### 1. Create Postman Collection

Create a new collection called "Laravel API Testing"

#### 2. Environment Variables in Postman

Create environment with:

```
base_url: http://localhost:8000/api
token: (will be set after login)
api_key: your-secret-api-key-123
```

### Postman Test Examples

#### Test 1: API Key Authentication

```
GET {{base_url}}/users
Headers:
X-API-Key: {{api_key}}

Expected Response (401 without key):
{
    "error": "API key is required",
    "message": "Please provide X-API-Key header"
}
```

#### Test 2: User Registration

```
POST {{base_url}}/register
Headers:
Content-Type: application/json

Body (JSON):
{
    "name": "John Doe",
    "email": "john@example.com",
    "password": "password123"
}

Expected Response (201):
{
    "token": "1|abcd1234...",
    "user": {
        "id": 1,
        "name": "John Doe",
        "email": "john@example.com"
    }
}
```

#### Test 3: User Login

```
POST {{base_url}}/login
Headers:
Content-Type: application/json

Body (JSON):
{
    "email": "john@example.com",
    "password": "password123"
}

// Save token to environment variable
Tests Tab in Postman:
pm.environment.set("token", pm.response.json().token);
```

#### Test 4: Protected Route Access

```
GET {{base_url}}/user
Headers:
Authorization: Bearer {{token}}

Expected Response (200):
{
    "id": 1,
    "name": "John Doe",
    "email": "john@example.com"
}
```

#### Test 5: Rate Limiting Test

```
// Make multiple rapid requests to login endpoint
POST {{base_url}}/login

Expected Response (429 after limit):
{
    "message": "Too Many Attempts."
}
```

### Quick Exercise: Create and Test Role-Based Middleware

#### Create Admin Middleware

```php
<?php
// app/Http/Middleware/AdminOnly.php

class AdminOnly
{
    public function handle(Request $request, Closure $next)
    {
        if (!$request->user() || !$request->user()->is_admin) {
            return response()->json([
                'error' => 'Unauthorized',
                'message' => 'Admin access required'
            ], 403);
        }

        return $next($request);
    }
}
```

#### Test in Postman

```
GET {{base_url}}/admin/users
Headers:
Authorization: Bearer {{token}}

// Test with regular user (should get 403)
// Test with admin user (should get 200)
```

---

## Session Summary & Key Takeaways

### What We Covered:

1. ✅ **API Middleware Basics** - Understanding request filtering for APIs
2. ✅ **Custom Middleware Creation** - API key auth, JSON validation, logging
3. ✅ **Token Authentication** - Laravel Sanctum implementation
4. ✅ **Security Best Practices** - Validation, rate limiting, error handling
5. ✅ **Postman Testing** - Practical API testing workflows

### Essential Postman Collection Setup:

```javascript
// Pre-request Script for Authentication
if (pm.environment.get("token")) {
  pm.request.headers.add({
    key: "Authorization",
    value: "Bearer " + pm.environment.get("token"),
  });
}

// Test Script for Saving Tokens
if (pm.response.json().token) {
  pm.environment.set("token", pm.response.json().token);
}
```

### Next Steps:

1. Implement role-based permissions
2. Add API versioning middleware
3. Create comprehensive error handling
4. Set up API monitoring and logging

### Quick Reference Commands:

```bash
# Create middleware
php artisan make:middleware MiddlewareName

# Install Sanctum
composer require laravel/sanctum

# Create API controller
php artisan make:controller Api/ControllerName --api
```

Remember: Always test your middleware with different scenarios in Postman - valid tokens, expired tokens, missing headers, malformed requests, and rate limits!
