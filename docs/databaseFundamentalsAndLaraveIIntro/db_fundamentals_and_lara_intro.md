# Database Fundamentals & Laravel Introduction
**Laravel Version:** 12

---

## 📋 Session Agenda
1. **Database Fundamentals**
2. **Laravel Installation & Project Structure**
3. **Laravel Basics**
4. **Hands-on Practice**

---

# 🗄️ Part 1: Database Fundamentals

## What is a Database?
Think of a database like a **digital filing cabinet** that stores information in an organized way.

### Real-World Example:
- **Library** = Database
- **Bookshelves** = Tables
- **Books** = Records/Rows
- **Book Details** (Title, Author, ISBN) = Columns

---

## Database Structure

### Tables, Rows, and Columns
```
USERS TABLE:
+----+----------+-------------------+-----+
| id | name     | email             | age |
+----+----------+-------------------+-----+
| 1  | Alice    | alice@email.com   | 25  |
| 2  | Bob      | bob@email.com     | 30  |
| 3  | Charlie  | charlie@email.com | 28  |
+----+----------+-------------------+-----+
```

- **Table**: `users` (like a spreadsheet)
- **Columns**: `id`, `name`, `email`, `age` (the headers)
- **Rows**: Each person's data (the actual records)

---

## SQL Fundamentals - The Big Four Commands

### 1. SELECT - Reading Data
```sql
-- Get all users
SELECT * FROM users;

-- Get specific columns
SELECT name, email FROM users;

-- Get users with conditions
SELECT * FROM users WHERE age > 25;

-- Get users and sort them
SELECT * FROM users ORDER BY name;
```

**Think of SELECT as:** "Show me information from the filing cabinet"

### 2. INSERT - Adding New Data
```sql
-- Add a new user
INSERT INTO users (name, email, age) 
VALUES ('Diana', 'diana@email.com', 22);

-- Add multiple users at once
INSERT INTO users (name, email, age) VALUES 
('Eve', 'eve@email.com', 24),
('Frank', 'frank@email.com', 27);
```

**Think of INSERT as:** "Put new files in the cabinet"

### 3. UPDATE - Modifying Existing Data
```sql
-- Update one user's age
UPDATE users 
SET age = 26 
WHERE name = 'Alice';

-- Update multiple columns
UPDATE users 
SET email = 'alice.new@email.com', age = 26 
WHERE id = 1;
```

**Think of UPDATE as:** "Edit information in existing files"

### 4. DELETE - Removing Data
```sql
-- Delete a specific user
DELETE FROM users WHERE id = 3;

-- Delete users based on condition
DELETE FROM users WHERE age < 25;

-- ⚠️ DANGEROUS: Delete all users (be careful!)
DELETE FROM users;
```

**Think of DELETE as:** "Remove files from the cabinet"

---

## Database Design Principles

### 1. Primary Keys
Every table needs a unique identifier:
```sql
CREATE TABLE users (
    id INT AUTO_INCREMENT PRIMARY KEY,  -- Unique ID for each user
    name VARCHAR(100),
    email VARCHAR(100)
);
```

### 2. Data Types
Choose appropriate data types:
- **INT**: Numbers (age, quantity)
- **VARCHAR(n)**: Text with max length (name, email)
- **TEXT**: Long text (descriptions, articles)
- **DATE**: Dates (birth_date, created_at)
- **BOOLEAN**: True/False (is_active, is_admin)

### 3. Relationships Between Tables
```sql
-- Users table
CREATE TABLE users (
    id INT PRIMARY KEY,
    name VARCHAR(100)
);

-- Posts table (connected to users)
CREATE TABLE posts (
    id INT PRIMARY KEY,
    title VARCHAR(200),
    content TEXT,
    user_id INT,  -- This connects to users.id
    FOREIGN KEY (user_id) REFERENCES users(id)
);
```

---

# 🚀 Part 2: Laravel Installation & Project Structure

## What is Laravel?
Laravel is a **PHP framework** that makes web development easier and faster. Think of it as a **toolkit** with pre-built components.

### Why Use Laravel?
- **Faster Development**: Pre-built features
- **Clean Code**: Organized structure
- **Security**: Built-in protection
- **Community**: Huge support community

---

## Installing Laravel v12

### Prerequisites
```bash
# Check if you have PHP 8.2+
php --version

# Check if you have Composer
composer --version
```

### Installation Steps
```bash
# Method 1: Via Composer (Recommended)
composer create-project laravel/laravel my-first-app

# Method 2: Via Laravel Installer
composer global require laravel/installer
laravel new my-first-app

# Navigate to project
cd my-first-app

# Start development server
php artisan serve
```

**Visit:** `http://localhost:8000` - You should see Laravel welcome page!

---

## Understanding MVC Architecture

### MVC = Model-View-Controller
Think of MVC like a **restaurant**:

```
USER REQUEST
     ↓
CONTROLLER (Waiter)
   ↙     ↘
MODEL     VIEW
(Chef)    (Menu)
   ↘     ↙
RESPONSE TO USER
```

### Real Example:
1. **User** visits `/users` (wants to see all users)
2. **Controller** (UserController) handles the request
3. **Model** (User) gets data from database
4. **View** (users.blade.php) displays the data
5. **Response** sent back to user's browser

---

## Laravel Directory Structure

```
my-first-app/
├── app/                    
│   ├── Http/
│   │   └── Controllers/    
│   ├── Models/             
│   └── ...
├── resources/
│   └── views/              
├── routes/
│   └── web.php            
├── database/
│   └── migrations/         
├── public/                 
├── .env                   
└── artisan               
```

### Key Directories Explained:
- **`app/`**: Your main application logic
- **`resources/views/`**: HTML templates
- **`routes/web.php`**: URL definitions
- **`public/`**: Files accessible via browser
- **`.env`**: Configuration (database, app settings)

---

# ⚡ Part 3: Laravel Basics

## 1. Routing Fundamentals

### What are Routes?
Routes define **which URL shows which page**. Like a **GPS for your website**.

### Basic Routes (`routes/web.php`)
```php
<?php
use Illuminate\Support\Facades\Route;

// Simple route
Route::get('/', function () {
    return 'Hello World!';
});

// Route that returns a view
Route::get('/about', function () {
    return view('about');
});

// Route with parameters
Route::get('/user/{id}', function ($id) {
    return "User ID: " . $id;
});

// Route with optional parameters
Route::get('/posts/{id?}', function ($id = null) {
    if ($id) {
        return "Showing post: " . $id;
    }
    return "Showing all posts";
});

// Route with constraints
Route::get('/user/{id}', function ($id) {
    return "User: " . $id;
})->where('id', '[0-9]+');  // Only numbers allowed
```

### Testing Routes
- Visit: `http://localhost:8000/`
- Visit: `http://localhost:8000/about`
- Visit: `http://localhost:8000/user/123`

---

## 2. Creating Your First Controller

### Why Use Controllers?
Instead of putting logic in routes, controllers keep code **organized** and **reusable**.

### Create a Controller
```bash
# Create UserController
php artisan make:controller UserController
```

### Edit Controller (`app/Http/Controllers/UserController.php`)
```php
<?php
namespace App\Http\Controllers;

use Illuminate\Http\Request;

class UserController extends Controller
{
    // Show all users
    public function index()
    {
        $users = ['Alice', 'Bob', 'Charlie'];
        return view('users.index', compact('users'));
    }
    
    // Show single user
    public function show($id)
    {
        $users = ['Alice', 'Bob', 'Charlie'];
        $user = $users[$id - 1] ?? 'User not found';
        
        return view('users.show', compact('user', 'id'));
    }
    
    // Show create form
    public function create()
    {
        return view('users.create');
    }
    
    // Handle form submission
    public function store(Request $request)
    {
        $name = $request->input('name');
        return "User {$name} created successfully!";
    }
}
```

### Update Routes (`routes/web.php`)
```php
<?php
use App\Http\Controllers\UserController;

Route::get('/', function () {
    return view('welcome');
});

// Controller routes
Route::get('/users', [UserController::class, 'index']);
Route::get('/users/{id}', [UserController::class, 'show']);
Route::get('/users/create', [UserController::class, 'create']);
Route::post('/users', [UserController::class, 'store']);

// Or use resource routes (creates all CRUD routes automatically)
// Route::resource('users', UserController::class);
```

---

## 3. Blade Templating Basics

### What is Blade?
Blade is Laravel's **templating engine** that makes HTML dynamic. Think of it as **HTML with superpowers**.

### Create Layout (`resources/views/layouts/app.blade.php`)
```html
<!DOCTYPE html>
<html>
<head>
    <title>My Laravel App - @yield('title')</title>
    <style>
        body { font-family: Arial, sans-serif; margin: 40px; }
        .header { background: #f8f9fa; padding: 20px; border-radius: 5px; }
        .content { margin-top: 20px; }
        .user-card { border: 1px solid #ddd; padding: 15px; margin: 10px 0; border-radius: 5px; }
    </style>
</head>
<body>
    <div class="header">
        <h1>My Laravel App</h1>
        <nav>
            <a href="/">Home</a> | 
            <a href="/users">Users</a> | 
            <a href="/users/create">Add User</a>
        </nav>
    </div>
    
    <div class="content">
        @yield('content')
    </div>
</body>
</html>
```

### Users Index View (`resources/views/users/index.blade.php`)
```html
@extends('layouts.app')

@section('title', 'All Users')

@section('content')
<h2>All Users</h2>

@if(count($users) > 0)
    @foreach($users as $index => $user)
        <div class="user-card">
            <h3>{{ $user }}</h3>
            <p>User ID: {{ $index + 1 }}</p>
            <a href="/users/{{ $index + 1 }}">View Details</a>
        </div>
    @endforeach
@else
    <p>No users found.</p>
@endif

<a href="/users/create">Add New User</a>
@endsection
```

### User Show View (`resources/views/users/show.blade.php`)
```html
@extends('layouts.app')

@section('title', 'User Details')

@section('content')
<h2>User Details</h2>

<div class="user-card">
    <h3>{{ $user }}</h3>
    <p><strong>ID:</strong> {{ $id }}</p>
    
    @if($user === 'User not found')
        <p style="color: red;">This user doesn't exist!</p>
    @else
        <p>Welcome to {{ $user }}'s profile!</p>
    @endif
</div>

<a href="/users">← Back to All Users</a>
@endsection
```

### User Create Form (`resources/views/users/create.blade.php`)
```html
@extends('layouts.app')

@section('title', 'Add New User')

@section('content')
<h2>Add New User</h2>

<form action="/users" method="POST">
    @csrf
    <div style="margin-bottom: 15px;">
        <label for="name">Name:</label><br>
        <input type="text" id="name" name="name" required style="padding: 8px; width: 300px;">
    </div>
    
    <div style="margin-bottom: 15px;">
        <label for="email">Email:</label><br>
        <input type="email" id="email" name="email" required style="padding: 8px; width: 300px;">
    </div>
    
    <button type="submit" style="padding: 10px 20px; background: #007bff; color: white; border: none; border-radius: 3px;">
        Add User
    </button>
</form>

<a href="/users">← Back to All Users</a>
@endsection
```

### Blade Syntax Summary
```html
<!-- Variables -->
{{ $variable }}

<!-- Raw HTML (be careful!) -->
{!! $htmlContent !!}

<!-- Conditionals -->
@if($condition)
    <!-- content -->
@elseif($otherCondition)
    <!-- content -->
@else
    <!-- content -->
@endif

<!-- Loops -->
@foreach($items as $item)
    {{ $item }}
@endforeach

<!-- Template inheritance -->
@extends('layouts.app')
@section('content')
    <!-- content -->
@endsection
```

---

# 🏋️ Part 4: Hands-on Practice

## Quick Exercise: Build a Simple Blog

### Task:
Create a simple blog system with:
1. Route to show all blog posts
2. Controller to handle blog logic
3. View to display posts

### Step 1: Create Controller
```bash
php artisan make:controller BlogController
```

### Step 2: Add Blog Logic
```php
<?php
// app/Http/Controllers/BlogController.php
namespace App\Http\Controllers;

class BlogController extends Controller
{
    public function index()
    {
        $posts = [
            ['id' => 1, 'title' => 'My First Post', 'content' => 'This is my first blog post!'],
            ['id' => 2, 'title' => 'Learning Laravel', 'content' => 'Laravel is amazing!'],
            ['id' => 3, 'title' => 'Database Basics', 'content' => 'SQL is powerful!']
        ];
        
        return view('blog.index', compact('posts'));
    }
}
```

### Step 3: Create Route
```php
// routes/web.php
Route::get('/blog', [BlogController::class, 'index']);
```

### Step 4: Create View
```html
<!-- resources/views/blog/index.blade.php -->
@extends('layouts.app')

@section('title', 'My Blog')

@section('content')
<h2>My Blog Posts</h2>

@foreach($posts as $post)
    <article class="user-card">
        <h3>{{ $post['title'] }}</h3>
        <p>{{ $post['content'] }}</p>
        <small>Post ID: {{ $post['id'] }}</small>
    </article>
@endforeach
@endsection
```

**Test it:** Visit `http://localhost:8000/blog`

---

## 📚 Session Summary

### What We Learned Today:

#### Database Fundamentals:
- ✅ **Tables, Rows, Columns** - Basic database structure
- ✅ **SQL Commands** - SELECT, INSERT, UPDATE, DELETE
- ✅ **Database Design** - Primary keys, data types, relationships

#### Laravel Setup:
- ✅ **Installation** - Via Composer
- ✅ **MVC Architecture** - Model-View-Controller pattern
- ✅ **Directory Structure** - Where files go

#### Laravel Basics:
- ✅ **Routing** - URL to function mapping
- ✅ **Controllers** - Organized business logic
- ✅ **Blade Templates** - Dynamic HTML

### Key Commands to Remember:
```bash
# Create new Laravel project
composer create-project laravel/laravel project-name

# Start development server
php artisan serve

# Create controller
php artisan make:controller ControllerName
```

### Next Steps:
1. **Practice**: Build more controllers and views
2. **Database**: Connect Laravel to actual database
3. **Models**: Create Eloquent models for data
4. **Forms**: Handle user input and validation

---

## 🎯 Quick Quiz
1. What does MVC stand for?
2. Which file defines your routes?
3. What is the Blade syntax for displaying a variable?
4. What SQL command do you use to get data?

**Congratulations! You've completed your introduction to Database Fundamentals and Laravel!** 🎉

*Ready to build amazing web applications!* 🚀