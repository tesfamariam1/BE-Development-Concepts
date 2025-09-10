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
  - Why: The request succeeded, but there's nothing to return.
  - When to use:
    - DELETE request succeeds.
    - PUT/PATCH updates without needing to return content.
  - Example: Deleting a user successfully.

### Client Error Codes (4xx = client made a mistake)

- 400 Bad Request
  - Why: The server can't process the request due to invalid syntax or missing data.
  - When to use: Malformed JSON, missing required fields, or wrong query format.
  - Example: Client sends { "email": } instead of a valid string.
- 401 Unauthorized
  - Why: Authentication failed (token missing/expired/invalid).
  - When to use: When a user tries to access a protected resource without logging in.
  - Example: No Bearer token or invalid API key.
- 403 Forbidden
  - Why: The user is authenticated, but doesn't have permission.
  - When to use:
    - A normal user tries to access an admin-only page.
    - Tenant isolation violation in multi-tenant apps.
  - Example: User has a valid token but lacks "admin" role.
- 404 Not Found
  - Why: The requested resource doesn't exist.
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

**Error vs Success: 2xx = success, 4xx = client's fault, 5xx = server's fault.**

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

- Create and use API resources for clean data formatting
- Build a complete API with authentication
- Test your API effectively

## Quick Setup (15 minutes)

### 1. Install Laravel Sanctum

```bash
composer require laravel/sanctum
php artisan vendor:publish --provider="Laravel\Sanctum\SanctumServiceProvider"
php artisan migrate
```

### 1.A Auth:Sanctum Middleware

This middleware is the gatekeeper that decides:

`Does the request belongs to a valid, authenticated user? If yes, let it through. If not, block it.`

**What Does auth:sanctum Do?**
When you put auth:sanctum on a routes, Laravel will check two possible ways of authenticating a user:

1. Session Cookie Authentication (SPA Mode)

- Used when your Vue/React frontend is on the same domain as your laravel app.
- Browser automatically sends the sesion cookie.
- Sanctum says: "Cool, I see your session, you're logged in as User #1."

2. API Token Authentication

- Used by mobile app, Postman, or external APIs.
- You send a header

### 2. Update User Model

```php
// app/Models/User.php
use Laravel\Sanctum\HasApiTokens;

class User extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable;
    // ... rest stays the same
}
```

## Part 1: API Resources

### What are API Resources?

Think of API Resources as **formatters** - they clean up your data before sending it to users.

### Create a User Resource

```bash
php artisan make:resource UserResource
```

### Simple User Resource

```php
<?php
// app/Http/Resources/UserResource.php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class UserResource extends JsonResource
{
    public function toArray($request)
    {
        return [
            'id' => $this->id,
            'name' => $this->name,
            'email' => $this->email,
            'joined' => $this->created_at->format('M d, Y'),
            // Notice: NO password field!
        ];
    }
}
```

### Use Resource in Controller

```php
<?php
// app/Http/Controllers/Api/UserController.php

use App\Http\Resources\UserResource;

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
}
```

## Part 2: Simple Authentication API

### Create Auth Controller

```bash
php artisan make:controller Api/AuthController
```

### Auth Controller (Copy-Paste Friendly)

```php
<?php
// app/Http/Controllers/Api/AuthController.php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class AuthController extends Controller
{
    // Register new user
    public function register(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users',
            'password' => 'required|string|min:8',
        ]);

        $user = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->password),
        ]);

        $token = $user->createToken('API Token')->plainTextToken;

        return response()->json([
            'message' => 'Registration successful!',
            'user' => $user,
            'token' => $token
        ], 201);
    }

    // Login user
    public function login(Request $request)
    {
        $request->validate([
            'email' => 'required|email',
            'password' => 'required',
        ]);

        $user = User::where('email', $request->email)->first();

        if (!$user || !Hash::check($request->password, $user->password)) {
            return response()->json([
                'message' => 'Invalid credentials'
            ], 401);
        }

        $token = $user->createToken('API Token')->plainTextToken;

        return response()->json([
            'message' => 'Login successful!',
            'user' => $user,
            'token' => $token
        ]);
    }

    // Logout user
    public function logout(Request $request)
    {
        $request->user()->currentAccessToken()->delete();

        return response()->json([
            'message' => 'Logged out successfully'
        ]);
    }

    // Get current user
    public function me(Request $request)
    {
        return response()->json([
            'user' => $request->user()
        ]);
    }
}
```

### Set Up Routes

```php
// routes/api.php
use App\Http\Controllers\Api\AuthController;
use App\Http\Controllers\Api\UserController;

// Public routes (no authentication needed)
Route::post('/register', [AuthController::class, 'register']);
Route::post('/login', [AuthController::class, 'login']);

// Protected routes (need authentication)
Route::middleware('auth:sanctum')->group(function () {
    Route::post('/logout', [AuthController::class, 'logout']);
    Route::get('/me', [AuthController::class, 'me']);
    Route::apiResource('users', UserController::class);
});
```

## Part 3: Hands-On Exercise - Build a Task API

### Step 1: Create Task Model

```bash
php artisan make:model Task -m
```

### Step 2: Task Migration

```php
// database/migrations/create_tasks_table.php
public function up()
{
    Schema::create('tasks', function (Blueprint $table) {
        $table->id();
        $table->string('title');
        $table->text('description')->nullable();
        $table->boolean('completed')->default(false);
        $table->foreignId('user_id')->constrained()->onDelete('cascade');
        $table->timestamps();
    });
}
```

### Step 3: Task Model

```php
// app/Models/Task.php
class Task extends Model
{
    protected $fillable = ['title', 'description', 'completed', 'user_id'];

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
```

### Step 4: Task Resource

```bash
php artisan make:resource TaskResource
```

```php
// app/Http/Resources/TaskResource.php
public function toArray($request)
{
    return [
        'id' => $this->id,
        'title' => $this->title,
        'description' => $this->description,
        'completed' => $this->completed,
        'created_at' => $this->created_at->format('M d, Y'),
    ];
}
```

### Step 5: Task Controller

```bash
php artisan make:controller Api/TaskController --api
```

```php
// app/Http/Controllers/Api/TaskController.php
namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Resources\TaskResource;
use App\Models\Task;
use Illuminate\Http\Request;

class TaskController extends Controller
{
    public function index(Request $request)
    {
        $tasks = $request->user()->tasks;
        return TaskResource::collection($tasks);
    }

    public function store(Request $request)
    {
        $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'nullable|string',
        ]);

        $task = $request->user()->tasks()->create([
            'title' => $request->title,
            'description' => $request->description,
        ]);

        return new TaskResource($task);
    }

    public function show(Task $task)
    {
        // Make sure user owns this task
        if ($task->user_id !== auth()->id()) {
            return response()->json(['message' => 'Not found'], 404);
        }

        return new TaskResource($task);
    }

    public function update(Request $request, Task $task)
    {
        if ($task->user_id !== auth()->id()) {
            return response()->json(['message' => 'Not found'], 404);
        }

        $request->validate([
            'title' => 'sometimes|required|string|max:255',
            'description' => 'nullable|string',
            'completed' => 'boolean',
        ]);

        $task->update($request->all());
        return new TaskResource($task);
    }

    public function destroy(Task $task)
    {
        if ($task->user_id !== auth()->id()) {
            return response()->json(['message' => 'Not found'], 404);
        }

        $task->delete();
        return response()->json(['message' => 'Task deleted']);
    }
}
```

### Step 6: Add Task Routes

```php
// routes/api.php
Route::middleware('auth:sanctum')->group(function () {
    // ... existing routes
    Route::apiResource('tasks', TaskController::class);
});
```

### Step 7: Update User Model

```php
// app/Models/User.php
public function tasks()
{
    return $this->hasMany(Task::class);
}
```

## Part 4: Testing with Postman

### Quick Postman Setup

1. **Create Environment**:
   - `base_url`: `http://localhost:8000/api`
   - `token`: (empty for now)

### Test Flow:

1. **Register**: POST `{{base_url}}/register`
2. **Login**: POST `{{base_url}}/login` → Save token
3. **Create Task**: POST `{{base_url}}/tasks` with Bearer token
4. **Get Tasks**: GET `{{base_url}}/tasks` with Bearer token

### Sample Request Bodies:

**Register:**

```json
{
  "name": "John Doe",
  "email": "john@example.com",
  "password": "password123"
}
```

**Login:**

```json
{
  "email": "john@example.com",
  "password": "password123"
}
```

**Create Task:**

```json
{
  "title": "Learn Laravel APIs",
  "description": "Complete the Laravel API tutorial"
}
```

## What You Built (Summary)

✅ User authentication (register, login, logout)
✅ Protected API routes
✅ Clean data formatting with Resources
✅ Complete CRUD API for tasks
✅ User-specific data (users only see their tasks)

This gives you a solid foundation for any API project!

---

# Laravel File Handling - Session 18

---

## 1. Introduction to File Handling {#introduction}

File handling is a crucial aspect of web applications. Laravel provides robust tools for:

- **File Uploads**: Receiving files from users
- **Storage Management**: Organizing and storing files securely
- **File Validation**: Ensuring uploaded files meet requirements
- **Image Processing**: Resizing, cropping, and optimizing images
- **File Serving**: Delivering files to users safely

### Common Use Cases

- Profile picture uploads
- Document management systems
- Image galleries
- File sharing platforms
- Report generation and downloads

---

## 2. Setting Up File Storage {#setup}

### Storage Configuration

Laravel uses the **Filesystem** abstraction for file storage. Configure in `config/filesystems.php`:

```php
// config/filesystems.php
'disks' => [
    'local' => [
        'driver' => 'local',
        'root' => storage_path('app'),
    ],

    'public' => [
        'driver' => 'local',
        'root' => storage_path('app/public'),
        'url' => env('APP_URL').'/storage',
        'visibility' => 'public',
    ],

    'uploads' => [
        'driver' => 'local',
        'root' => storage_path('app/uploads'),
        'visibility' => 'private',
    ],
],
```

### Create Storage Link

```bash
# Create symbolic link to access public files
php artisan storage:link
```

### Directory Structure

```
storage/
├── app/
│   ├── public/          # Publicly accessible files
│   │   ├── images/
│   │   ├── documents/
│   │   └── uploads/
│   ├── private/         # Private files
│   └── uploads/         # Custom upload directory
├── framework/
└── logs/
```

---

## 3. Basic File Upload {#basic-upload}

### Step 1: Create Migration for File Records

```bash
php artisan make:migration create_uploaded_files_table
```

```php
// database/migrations/xxxx_create_uploaded_files_table.php
<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::create('uploaded_files', function (Blueprint $table) {
            $table->id();
            $table->string('original_name');
            $table->string('file_name');
            $table->string('file_path');
            $table->string('mime_type');
            $table->unsignedBigInteger('file_size');
            $table->string('disk')->default('public');
            $table->json('metadata')->nullable();
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('uploaded_files');
    }
};
```

### Step 2: Create File Model

```bash
php artisan make:model UploadedFile
```

```php
// app/Models/UploadedFile.php
<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Storage;

class UploadedFile extends Model
{
    use HasFactory;

    protected $fillable = [
        'original_name',
        'file_name',
        'file_path',
        'mime_type',
        'file_size',
        'disk',
        'metadata'
    ];

    protected $casts = [
        'metadata' => 'array'
    ];

    /**
     * Get the full URL to the file
     */
    public function getUrlAttribute()
    {
        if ($this->disk === 'public') {
            return Storage::disk('public')->url($this->file_path);
        }

        return route('files.download', $this->id);
    }

    /**
     * Get human readable file size
     */
    public function getFileSizeHumanAttribute()
    {
        $bytes = $this->file_size;
        $units = ['B', 'KB', 'MB', 'GB'];

        for ($i = 0; $bytes > 1024 && $i < count($units) - 1; $i++) {
            $bytes /= 1024;
        }

        return round($bytes, 2) . ' ' . $units[$i];
    }

    /**
     * Check if file is an image
     */
    public function isImage()
    {
        return str_starts_with($this->mime_type, 'image/');
    }

    /**
     * Delete the file from storage when model is deleted
     */
    protected static function boot()
    {
        parent::boot();

        static::deleting(function ($file) {
            Storage::disk($file->disk)->delete($file->file_path);
        });
    }
}
```

### Step 3: Create File Upload Controller

```bash
php artisan make:controller FileUploadController
```

```php
// app/Http/Controllers/FileUploadController.php
<?php

namespace App\Http\Controllers;

use App\Models\UploadedFile;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Str;

class FileUploadController extends Controller
{
    /**
     * Upload a single file
     */
    public function uploadSingle(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'file' => 'required|file|max:10240', // Max 10MB
        ]);

        if ($validator->fails()) {
            return response()->json([
                'success' => false,
                'message' => 'Validation failed',
                'errors' => $validator->errors()
            ], 422);
        }

        try {
            $file = $request->file('file');
            $originalName = $file->getClientOriginalName();
            $mimeType = $file->getMimeType();
            $fileSize = $file->getSize();

            // Generate unique filename
            $fileName = Str::uuid() . '.' . $file->getClientOriginalExtension();

            // Store file
            $filePath = $file->storeAs('uploads', $fileName, 'public');

            // Save file record
            $uploadedFile = UploadedFile::create([
                'original_name' => $originalName,
                'file_name' => $fileName,
                'file_path' => $filePath,
                'mime_type' => $mimeType,
                'file_size' => $fileSize,
                'disk' => 'public',
                'metadata' => [
                    'uploaded_at' => now(),
                    'ip_address' => $request->ip()
                ]
            ]);

            return response()->json([
                'success' => true,
                'message' => 'File uploaded successfully',
                'data' => [
                    'id' => $uploadedFile->id,
                    'original_name' => $uploadedFile->original_name,
                    'file_size' => $uploadedFile->file_size_human,
                    'mime_type' => $uploadedFile->mime_type,
                    'url' => $uploadedFile->url,
                    'uploaded_at' => $uploadedFile->created_at
                ]
            ], 201);

        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Upload failed: ' . $e->getMessage()
            ], 500);
        }
    }

    /**
     * Upload multiple files
     */
    public function uploadMultiple(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'files' => 'required|array|max:5',
            'files.*' => 'file|max:5120', // Max 5MB per file
        ]);

        if ($validator->fails()) {
            return response()->json([
                'success' => false,
                'message' => 'Validation failed',
                'errors' => $validator->errors()
            ], 422);
        }

        $uploadedFiles = [];

        try {
            foreach ($request->file('files') as $file) {
                $originalName = $file->getClientOriginalName();
                $mimeType = $file->getMimeType();
                $fileSize = $file->getSize();

                // Generate unique filename
                $fileName = Str::uuid() . '.' . $file->getClientOriginalExtension();

                // Store file
                $filePath = $file->storeAs('uploads', $fileName, 'public');

                // Save file record
                $uploadedFile = UploadedFile::create([
                    'original_name' => $originalName,
                    'file_name' => $fileName,
                    'file_path' => $filePath,
                    'mime_type' => $mimeType,
                    'file_size' => $fileSize,
                    'disk' => 'public',
                    'metadata' => [
                        'uploaded_at' => now(),
                        'ip_address' => $request->ip()
                    ]
                ]);

                $uploadedFiles[] = [
                    'id' => $uploadedFile->id,
                    'original_name' => $uploadedFile->original_name,
                    'file_size' => $uploadedFile->file_size_human,
                    'mime_type' => $uploadedFile->mime_type,
                    'url' => $uploadedFile->url,
                ];
            }

            return response()->json([
                'success' => true,
                'message' => count($uploadedFiles) . ' files uploaded successfully',
                'data' => $uploadedFiles
            ], 201);

        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Upload failed: ' . $e->getMessage()
            ], 500);
        }
    }

    /**
     * Get file information
     */
    public function getFile($id)
    {
        $file = UploadedFile::find($id);

        if (!$file) {
            return response()->json([
                'success' => false,
                'message' => 'File not found'
            ], 404);
        }

        return response()->json([
            'success' => true,
            'data' => [
                'id' => $file->id,
                'original_name' => $file->original_name,
                'file_size' => $file->file_size_human,
                'mime_type' => $file->mime_type,
                'url' => $file->url,
                'is_image' => $file->isImage(),
                'uploaded_at' => $file->created_at,
                'metadata' => $file->metadata
            ]
        ]);
    }

    /**
     * Download file
     */
    public function downloadFile($id)
    {
        $file = UploadedFile::find($id);

        if (!$file) {
            return response()->json([
                'success' => false,
                'message' => 'File not found'
            ], 404);
        }

        if (!Storage::disk($file->disk)->exists($file->file_path)) {
            return response()->json([
                'success' => false,
                'message' => 'File not found on disk'
            ], 404);
        }

        return Storage::disk($file->disk)->download($file->file_path, $file->original_name);
    }

    /**
     * Delete file
     */
    public function deleteFile($id)
    {
        $file = UploadedFile::find($id);

        if (!$file) {
            return response()->json([
                'success' => false,
                'message' => 'File not found'
            ], 404);
        }

        try {
            $file->delete(); // Will also delete from storage due to boot method

            return response()->json([
                'success' => true,
                'message' => 'File deleted successfully'
            ]);

        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Delete failed: ' . $e->getMessage()
            ], 500);
        }
    }

    /**
     * List all files
     */
    public function listFiles(Request $request)
    {
        $perPage = $request->input('per_page', 10);
        $files = UploadedFile::latest()->paginate($perPage);

        $filesData = $files->getCollection()->map(function ($file) {
            return [
                'id' => $file->id,
                'original_name' => $file->original_name,
                'file_size' => $file->file_size_human,
                'mime_type' => $file->mime_type,
                'url' => $file->url,
                'is_image' => $file->isImage(),
                'uploaded_at' => $file->created_at
            ];
        });

        return response()->json([
            'success' => true,
            'data' => $filesData,
            'pagination' => [
                'current_page' => $files->currentPage(),
                'total_pages' => $files->lastPage(),
                'per_page' => $files->perPage(),
                'total_items' => $files->total()
            ]
        ]);
    }
}
```

---

## 4. File Validation {#validation}

### Advanced Validation Rules

```php
// app/Http/Requests/FileUploadRequest.php
<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class FileUploadRequest extends FormRequest
{
    public function authorize()
    {
        return true;
    }

    public function rules()
    {
        return [
            'file' => [
                'required',
                'file',
                'max:10240', // 10MB
                'mimes:jpg,jpeg,png,gif,pdf,doc,docx,txt',
                'dimensions:max_width=2000,max_height=2000' // For images only
            ]
        ];
    }

    public function messages()
    {
        return [
            'file.required' => 'Please select a file to upload.',
            'file.max' => 'File size must not exceed 10MB.',
            'file.mimes' => 'File must be an image, PDF, or document.',
            'file.dimensions' => 'Image dimensions must not exceed 2000x2000 pixels.'
        ];
    }
}
```

---

## 5. Testing with Postman {#testing}

### API Routes Setup

Add these routes to your `routes/api.php`:

```php
// routes/api.php
<?php

use App\Http\Controllers\FileUploadController;
use App\Http\Controllers\ImageController;
use Illuminate\Support\Facades\Route;

// File Upload Routes
Route::prefix('files')->group(function () {
    Route::post('upload/single', [FileUploadController::class, 'uploadSingle']);
    Route::post('upload/multiple', [FileUploadController::class, 'uploadMultiple']);
    Route::get('list', [FileUploadController::class, 'listFiles']);
    Route::get('{id}', [FileUploadController::class, 'getFile']);
    Route::get('{id}/download', [FileUploadController::class, 'downloadFile'])->name('files.download');
    Route::delete('{id}', [FileUploadController::class, 'deleteFile']);
});

// Image Processing Routes
Route::prefix('images')->group(function () {
    Route::post('upload', [ImageController::class, 'uploadAndProcess']);
    Route::post('{id}/sizes', [ImageController::class, 'generateSizes']);
    Route::post('{id}/filter', [ImageController::class, 'applyFilter']);
});
```

### Postman Collection Examples

#### 1. Single File Upload

```
POST: {{base_url}}/api/files/upload/single
Content-Type: multipart/form-data

Body (form-data):
- Key: file, Type: File, Value: [Select your file]
```

#### 2. Multiple File Upload

```
POST: {{base_url}}/api/files/upload/multiple
Content-Type: multipart/form-data

Body (form-data):
- Key: files[], Type: File, Value: [Select file 1]
- Key: files[], Type: File, Value: [Select file 2]
```
