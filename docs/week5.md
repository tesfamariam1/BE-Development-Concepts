# Laravel Intermediate Features - Complete Guide

## Prerequisites Setup

Before we begin, let's set up a fresh Laravel 12 project with Vue starter kit:

```bash
# Create new Laravel project
composer create-project laravel/laravel laravel-intermediate-course
# or
laravel new laravel-intermediate-course

# select starter kit

# Navigate to project
cd laravel-intermediate-course

# Install dependencies and vue
npm install
npm install vue@next @vitejs/plugin-vue

# Update vite.config.js and add the Vue plugin
import { defineConfig } from 'vite';
import laravel from 'laravel-vite-plugin';
import vue from '@vitejs/plugin-vue'; // Add this line

export default defineConfig({
    plugins: [
        vue(), // Add this line
        laravel({
            input: ['resources/css/app.css', 'resources/js/app.js'],
            refresh: true,
        }),
    ],
    resolve: {
        alias: {
            vue: 'vue/dist/vue.esm-bundler.js',
        },
    },
});

# Create resources/js/app.js and initialize your Vue app:
import { createApp } from 'vue';
import App from './App.vue';

createApp(App).mount('#app');

# Create resources/js/App.vue
<template>
    <div>
        <h1>Hello from Vue!</h1>
    </div>
</template>

<script setup>
// Your component logic
</script>

#Integrate Vue into a Blade template.
<!DOCTYPE html>
<html>
<head>
    <title>Laravel Vue App</title>
    @vite('resources/css/app.css')
</head>
<body>
    <div id="app"></div>

    @vite('resources/js/app.js')
</body>
</html>

# Run the development server.
npm run dev

# Start development server
php artisan serve
```

---

## Session 13: Relationships I - One-to-Many Relationships

### Understanding One-to-Many Relationships

A **One-to-Many relationship** is where one record in a table can be associated with multiple records in another table. Common examples:

- One User can have many Posts
- One Category can have many Products
- One Author can have many Books

### 1. Database Structure with Foreign Keys

Let's create a blog system where users can have multiple posts:

```bash
# Create Post model with migration
php artisan make:model Post -m
```

**Migration file: `database/migrations/xxxx_create_posts_table.php`**

```php
<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('posts', function (Blueprint $table) {
            $table->id();
            $table->string('title');
            $table->text('content');
            $table->string('slug')->unique();
            $table->boolean('is_published')->default(false);

            // Foreign key - references id on users table
            $table->foreignId('user_id')->constrained()->onDelete('cascade');

            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('posts');
    }
};
```

**Key Points about Foreign Keys:**

- `foreignId('user_id')` creates an unsigned big integer column
- `constrained()` automatically references the `id` column of the `users` table
- `onDelete('cascade')` means when a user is deleted, all their posts are also deleted

**Alternative foreign key syntax:**

```php
// More explicit way
$table->unsignedBigInteger('user_id');
$table->foreign('user_id')->references('id')->on('users')->onDelete('cascade');
```

Run the migration:

```bash
php artisan migrate
```

### 2. Model Relationships

**User Model: `app/Models/User.php`**

```php
<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Illuminate\Database\Eloquent\Relations\HasMany;

class User extends Authenticatable
{
    use HasFactory, Notifiable;

    protected $fillable = [
        'name',
        'email',
        'password',
    ];

    protected $hidden = [
        'password',
        'remember_token',
    ];

    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'password' => 'hashed',
        ];
    }

    /**
     * Get all posts for the user (One-to-Many)
     */
    public function posts(): HasMany
    {
        return $this->hasMany(Post::class);
    }

    /**
     * Get only published posts
     */
    public function publishedPosts(): HasMany
    {
        return $this->hasMany(Post::class)->where('is_published', true);
    }
}
```

**Post Model: `app/Models/Post.php`**

```php
<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Post extends Model
{
    use HasFactory;

    protected $fillable = [
        'title',
        'content',
        'slug',
        'is_published',
        'user_id',
    ];

    protected function casts(): array
    {
        return [
            'is_published' => 'boolean',
        ];
    }

    /**
     * Get the user that owns the post (Inverse of One-to-Many)
     */
    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }
}
```

### 3. Using Relationships in Controllers

**Create a PostController:**

```bash
php artisan make:controller PostController
```

**PostController: `app/Http/Controllers/PostController.php`**

```php
<?php

namespace App\Http\Controllers;

use App\Models\Post;
use App\Models\User;
use Illuminate\Http\Request;
use Inertia\Inertia;

class PostController extends Controller
{
    public function index()
    {
        // Get all posts with their users (avoiding N+1 problem)
        $posts = Post::with('user')->paginate(10);

        return Inertia::render('Posts/Index', [
            'posts' => $posts
        ]);
    }

    public function show(Post $post)
    {
        // Load the post with its user
        $post->load('user');

        return Inertia::render('Posts/Show', [
            'post' => $post
        ]);
    }

    public function userPosts(User $user)
    {
        // Get all posts for a specific user
        $posts = $user->posts()->paginate(10);

        return Inertia::render('Posts/UserPosts', [
            'user' => $user,
            'posts' => $posts
        ]);
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'title' => 'required|max:255',
            'content' => 'required',
            'slug' => 'required|unique:posts',
        ]);

        // Create post for authenticated user
        auth()->user()->posts()->create($validated);

        return redirect()->route('posts.index');
    }
}
```

### 4. Eager Loading Basics

**The N+1 Problem:**

```php
// BAD - This creates N+1 queries (1 for posts + N for each user)
$posts = Post::all();
foreach ($posts as $post) {
    echo $post->user->name; // Each iteration triggers a database query
}
```

**Solution - Eager Loading:**

```php
// GOOD - This creates only 2 queries (1 for posts + 1 for all users)
$posts = Post::with('user')->get();
foreach ($posts as $post) {
    echo $post->user->name; // No additional queries
}
```

**Advanced Eager Loading Examples:**

```php
// Load multiple relationships
$posts = Post::with(['user', 'comments'])->get();

// Load nested relationships
$posts = Post::with('user.profile')->get();

// Conditional eager loading
$posts = Post::with(['user' => function ($query) {
    $query->select('id', 'name', 'email');
}])->get();

// Load relationships with constraints
$users = User::with(['posts' => function ($query) {
    $query->where('is_published', true);
}])->get();
```

### 5. Practical Examples

**Creating test data with Tinker:**

```bash
php artisan tinker
```

```php
// Create some users and posts
$user1 = User::create([
    'name' => 'John Doe',
    'email' => 'john@example.com',
    'password' => bcrypt('password')
]);

$user2 = User::create([
    'name' => 'Jane Smith',
    'email' => 'jane@example.com',
    'password' => bcrypt('password')
]);

// Create posts for users
$user1->posts()->create([
    'title' => 'My First Post',
    'content' => 'This is my first blog post content.',
    'slug' => 'my-first-post',
    'is_published' => true
]);

$user1->posts()->create([
    'title' => 'Laravel Tips',
    'content' => 'Here are some Laravel tips...',
    'slug' => 'laravel-tips',
    'is_published' => true
]);

// Alternative way to create posts
Post::create([
    'title' => 'Jane\'s Post',
    'content' => 'Content by Jane',
    'slug' => 'janes-post',
    'is_published' => true,
    'user_id' => $user2->id
]);
```

---

## Session 14: Relationships II - Many-to-Many Relationships

### Understanding Many-to-Many Relationships

A **Many-to-Many relationship** is where multiple records in one table can be associated with multiple records in another table. Examples:

- Users can have many Roles, and Roles can belong to many Users
- Posts can have many Tags, and Tags can belong to many Posts
- Students can enroll in many Courses, and Courses can have many Students

### 1. Setting Up Many-to-Many: Posts and Tags

**Create Tag model and pivot table:**

```bash
# Create Tag model with migration
php artisan make:model Tag -m

# Create pivot table migration
php artisan make:migration create_post_tag_table
```

**Tag Migration: `database/migrations/xxxx_create_tags_table.php`**

```php
<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('tags', function (Blueprint $table) {
            $table->id();
            $table->string('name')->unique();
            $table->string('slug')->unique();
            $table->string('color')->default('#3b82f6'); // Hex color for UI
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('tags');
    }
};
```

**Pivot Table Migration: `database/migrations/xxxx_create_post_tag_table.php`**

```php
<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('post_tag', function (Blueprint $table) {
            $table->id();

            // Foreign keys
            $table->foreignId('post_id')->constrained()->onDelete('cascade');
            $table->foreignId('tag_id')->constrained()->onDelete('cascade');

            // Additional pivot data (optional)
            $table->integer('order')->default(0); // For tag ordering
            $table->timestamps();

            // Ensure unique combinations
            $table->unique(['post_id', 'tag_id']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('post_tag');
    }
};
```

**Run migrations:**

```bash
php artisan migrate
```

### 2. Model Relationships

**Tag Model: `app/Models/Tag.php`**

```php
<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

class Tag extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'slug',
        'color',
    ];

    /**
     * Get all posts that have this tag
     */
    public function posts(): BelongsToMany
    {
        return $this->belongsToMany(Post::class)
                   ->withPivot(['order']) // Include pivot columns
                   ->withTimestamps() // Include created_at, updated_at from pivot
                   ->orderBy('pivot_order'); // Order by pivot column
    }
}
```

**Update Post Model: `app/Models/Post.php`**

```php
<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

class Post extends Model
{
    use HasFactory;

    protected $fillable = [
        'title',
        'content',
        'slug',
        'is_published',
        'user_id',
    ];

    protected function casts(): array
    {
        return [
            'is_published' => 'boolean',
        ];
    }

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    /**
     * Get all tags for this post
     */
    public function tags(): BelongsToMany
    {
        return $this->belongsToMany(Tag::class)
                   ->withPivot(['order'])
                   ->withTimestamps()
                   ->orderBy('pivot_order');
    }
}
```

### 3. Working with Pivot Tables

**Attaching and Detaching Relationships:**

```php
// Get a post and some tags
$post = Post::find(1);
$tag1 = Tag::find(1);
$tag2 = Tag::find(2);

// Attach single tag
$post->tags()->attach($tag1->id);

// Attach with pivot data
$post->tags()->attach($tag2->id, ['order' => 1]);

// Attach multiple tags
$post->tags()->attach([1, 2, 3]);

// Attach multiple with different pivot data
$post->tags()->attach([
    1 => ['order' => 1],
    2 => ['order' => 2],
    3 => ['order' => 3]
]);

// Detach specific tags
$post->tags()->detach([1, 2]);

// Detach all tags
$post->tags()->detach();

// Sync (replace all existing with new set)
$post->tags()->sync([1, 2, 3]);

// Sync with pivot data
$post->tags()->sync([
    1 => ['order' => 1],
    2 => ['order' => 2]
]);
```

**Toggle Relationships:**

```php
// Toggle tags (attach if not present, detach if present)
$post->tags()->toggle([1, 2, 3]);
```

### 4. Querying Many-to-Many Relationships

**Controller Examples:**

```bash
php artisan make:controller TagController
```

**TagController: `app/Http/Controllers/TagController.php`**

```php
<?php

namespace App\Http\Controllers;

use App\Models\Tag;
use App\Models\Post;
use Illuminate\Http\Request;
use Inertia\Inertia;

class TagController extends Controller
{
    public function index()
    {
        // Get tags with post counts
        $tags = Tag::withCount('posts')->get();

        return Inertia::render('Tags/Index', [
            'tags' => $tags
        ]);
    }

    public function show(Tag $tag)
    {
        // Get tag with its posts and post authors
        $tag->load(['posts.user']);

        return Inertia::render('Tags/Show', [
            'tag' => $tag
        ]);
    }

    public function postsWithTag($tagSlug)
    {
        // Find posts that have a specific tag
        $posts = Post::whereHas('tags', function ($query) use ($tagSlug) {
            $query->where('slug', $tagSlug);
        })->with(['user', 'tags'])->paginate(10);

        $tag = Tag::where('slug', $tagSlug)->firstOrFail();

        return Inertia::render('Posts/TaggedPosts', [
            'posts' => $posts,
            'tag' => $tag
        ]);
    }

    public function attachTag(Request $request, Post $post)
    {
        $validated = $request->validate([
            'tag_ids' => 'required|array',
            'tag_ids.*' => 'exists:tags,id'
        ]);

        // Sync tags with the post
        $post->tags()->sync($validated['tag_ids']);

        return back()->with('success', 'Tags updated successfully');
    }
}
```

**Advanced Relationship Queries:**

```php
// Posts with specific tags
$posts = Post::whereHas('tags', function ($query) {
    $query->whereIn('slug', ['laravel', 'php']);
})->get();

// Posts with ALL specified tags
$posts = Post::whereHas('tags', function ($query) {
    $query->where('slug', 'laravel');
})->whereHas('tags', function ($query) {
    $query->where('slug', 'php');
})->get();

// Posts without any tags
$posts = Post::doesntHave('tags')->get();

// Tags that have more than 5 posts
$popularTags = Tag::has('posts', '>', 5)->get();

// Get pivot data
$post = Post::with('tags')->find(1);
foreach ($post->tags as $tag) {
    echo $tag->pivot->order; // Access pivot column
    echo $tag->pivot->created_at; // Access pivot timestamp
}
```

### 5. Creating Test Data

```php
// In tinker: php artisan tinker

// Create some tags
$tags = [
    ['name' => 'Laravel', 'slug' => 'laravel', 'color' => '#ff2d20'],
    ['name' => 'PHP', 'slug' => 'php', 'color' => '#777bb4'],
    ['name' => 'Vue.js', 'slug' => 'vuejs', 'color' => '#4fc08d'],
    ['name' => 'JavaScript', 'slug' => 'javascript', 'color' => '#f7df1e'],
    ['name' => 'Tutorial', 'slug' => 'tutorial', 'color' => '#17a2b8']
];

foreach ($tags as $tagData) {
    Tag::create($tagData);
}

// Attach tags to posts
$post1 = Post::find(1);
$post1->tags()->attach([1, 2, 5], ['order' => 1]); // Laravel, PHP, Tutorial

$post2 = Post::find(2);
$post2->tags()->attach([1, 3, 4], ['order' => 1]); // Laravel, Vue.js, JavaScript
```

---

## Session 15: Authentication Basics

### Laravel's Built-in Authentication

Laravel provides robust authentication features out of the box. With Laravel Breeze (which we installed), we already have:

- User registration
- User login/logout
- Password reset
- Email verification
- Session management

### API Authentication in Laravel

When building APIs, we don’t use session-based authentication. Instead, Laravel provides token-based authentication methods. The most common approach is Laravel Sanctum, which is lightweight and perfect for SPA/mobile/API use cases.

With Sanctum you get:

- Token-based login for APIs

- Ability to issue and revoke tokens per user

- Middleware protection for API routes

### 1. Understanding Laravel Breeze Structure

**Key Authentication Files:**

- `app/Http/Controllers/Auth/` - Authentication controllers
- `app/Http/Requests/Auth/` - Form requests for authentication
- `resources/js/Pages/Auth/` - Vue components for auth pages
- `routes/auth.php` - Authentication routes

**Default Authentication Routes:**

```bash
php artisan route:list --name=auth
```

### 2. Install & Configure Sanctum

```bash
composer require laravel/sanctum
```

### 3. Create API Auth Controller

**Create Custom Auth Controller:**

```bash
php artisan make:controller Api/AuthController
```

**CustomAuthController: `app/Http/Controllers/Api/AuthController.php`**

```php
<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\ValidationException;

class AuthController extends Controller
{
    /**
     * User registration
     */
    public function register(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users',
            'password' => 'required|string|min:8|confirmed',
        ]);

        $user = User::create([
            'name' => $validated['name'],
            'email' => $validated['email'],
            'password' => Hash::make($validated['password']),
        ]);

        $token = $user->createToken('api-token')->plainTextToken;

        return response()->json([
            'user' => $user,
            'token' => $token,
        ], 201);
    }

    /**
     * User login
     */
    public function login(Request $request)
    {
        $credentials = $request->validate([
            'email' => 'required|string|email',
            'password' => 'required|string',
        ]);

        $user = User::where('email', $credentials['email'])->first();

        if (! $user || ! Hash::check($credentials['password'], $user->password)) {
            throw ValidationException::withMessages([
                'email' => 'The provided credentials are incorrect.',
            ]);
        }

        $token = $user->createToken('api-token')->plainTextToken;

        return response()->json([
            'user' => $user,
            'token' => $token,
        ]);
    }

    /**
     * User logout (revoke token)
     */
    public function logout(Request $request)
    {
        $request->user()->currentAccessToken()->delete();

        return response()->json(['message' => 'Logged out successfully']);
    }

    /**
     * Get authenticated user profile
     */
    public function profile(Request $request)
    {
        return response()->json($request->user());
    }
}
```

### 4. Define API Routes

In routes/api.php:

```php
<?php

use App\Http\Controllers\Api\AuthController;

Route::post('/register', [AuthController::class, 'register']);
Route::post('/login', [AuthController::class, 'login']);

Route::middleware('auth:sanctum')->group(function () {
    Route::get('/profile', [AuthController::class, 'profile']);
    Route::post('/logout', [AuthController::class, 'logout']);

    // Example protected resource
    Route::get('/posts', function () {
        return \App\Models\Post::with('user')->paginate(10);
    });
});
```

### 5. Testing with Postman / HTTP Client

**Register User: POST /api/register**

```json
{
  "name": "John Doe",
  "email": "john@example.com",
  "password": "password123",
  "password_confirmation": "password123"
}
```

**Login User: `POST /api/login`**

```json
{
  "email": "john@example.com",
  "password": "password123"
}
```

**Response:**

```json
{
  "user": { "id": 1, "name": "John Doe", "email": "john@example.com" },
  "token": "1|XyzAbcTokenString..."
}
```

**Use this token in request headers:**

```makefile
Authorization: Bearer <your_token>
```

**Access Protected Route: GET /api/profile**

**Response:**

```json
{
  "id": 1,
  "name": "John Doe",
  "email": "john@example.com"
}
```

**Logout: POST /api/logout**

### 6. Protecting API Resources

With Sanctum, you can secure routes using the auth:sanctum middleware.
Any request without a valid token will receive 401 Unauthorized.

**Example:**

```php
// Check if user is authenticated
Route::middleware('auth:sanctum')->get('/user-stats', function (Request $request) {
    return [
        'posts' => $request->user()->posts()->count(),
        'tags' => $request->user()->posts()->with('tags')->get()->pluck('tags')->flatten()->unique('id')->count(),
    ];
});

```

### 7. Session Management - Token & State Management (API Version)

Unlike web apps that use sessions and flash messages, APIs are stateless.
This means:

- No session storage on the server (beyond issued tokens).

- Clients (SPA, mobile, Postman) are responsible for storing tokens and state.

- Any user feedback is returned in the API response (JSON), not via flash messages.

**Understanding Sessions:**

```php
// Login API - return token and user info
public function login(Request $request)
{
    $credentials = $request->validate([
        'email' => 'required|string|email',
        'password' => 'required|string',
    ]);

    $user = User::where('email', $credentials['email'])->first();

    if (! $user || ! Hash::check($credentials['password'], $user->password)) {
        return response()->json([
            'message' => 'Invalid credentials'
        ], 401);
    }

    $token = $user->createToken('api-token')->plainTextToken;

    return response()->json([
        'message' => 'Login successful',
        'user' => $user,
        'token' => $token,
    ]);
}

```

**Logout Example:**

```php
public function logout(Request $request)
{
    $request->user()->currentAccessToken()->delete();

    return response()->json([
        'message' => 'Logged out successfully'
    ]);
}
```

**Resource Creation Example (with JSON response instead of flash session):**

```php
public function store(Request $request)
{
    $validated = $request->validate([
        'title' => 'required|max:255',
        'content' => 'required',
    ]);

    $post = $request->user()->posts()->create($validated);

    return response()->json([
        'message' => 'Post created successfully!',
        'post' => $post
    ], 201);
}
```

Key Differences from Session-based Apps

- No session()->put() or flash() → Use JSON response payloads.

- No redirect()->with() → Client handles redirection and shows messages.

- Security → API tokens are sent in headers (Authorization: Bearer <token>).

- Client-side state → The frontend (Vue/React/Mobile app) stores user preferences, last visited page, or UI state locally (localStorage, cookies, or mobile secure storage).

### 7. Practical Authentication Examples

**Create a simple dashboard that shows user's posts:**

```bash
php artisan make:controller DashboardController
```

**DashboardController: `app/Http/Controllers/DashboardController.php`**

```php
<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class DashboardController extends Controller
{
    public function index()
    {
        $user = auth()->user();

        // Get user's posts with eager loading
        $posts = $user->posts()
                     ->with('tags')
                     ->latest()
                     ->paginate(5);

        // Get some stats
        $stats = [
            'total_posts' => $user->posts()->count(),
            'published_posts' => $user->posts()->where('is_published', true)->count(),
            'draft_posts' => $user->posts()->where('is_published', false)->count(),
            'total_tags' => $user->posts()->with('tags')->get()->pluck('tags')->flatten()->unique('id')->count(),
        ];

        return response()->json('Dashboard', [
            'posts' => $posts,
            'stats' => $stats
        ]);
    }
}
```

**Update web routes:**

```php
Route::middleware('auth')->group(function () {
    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');
});
```

This completes our comprehensive guide to Laravel intermediate features covering One-to-Many relationships, Many-to-Many relationships, and Authentication basics with practical examples and code implementations suitable for absolute beginners.
