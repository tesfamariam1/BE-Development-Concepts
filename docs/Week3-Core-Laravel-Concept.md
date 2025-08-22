### Practice Exercises

1. **Create Students Table**: Build a students table with first_name, last_name, email, grade_level, and enrollment_date
2. **Create Teachers Table**: Build a teachers table with name, email, subject, and hire_date
3. **Add Phone Numbers**: Create a migration to add phone numbers to the students table
4. **Create Grades Table**: Build a grades table that connects students to their test scores
5. **Practice Rollbacks**: Create a migration, run it, then practice rolling it back

---# Laravel Beginner - Sessions 7-9

## Session 7: Controllers & Views

### Learning Objectives

By the end of this session, you will be able to:

- Create and structure Laravel controllers
- Understand controller methods and parameters
- Pass data from controllers to views
- Use basic Blade directives for dynamic content

### 1. Introduction to Controllers

Controllers are PHP classes that handle the logic for your web application. They act as the middleman between your routes and views.

#### What is a Controller?

- A controller is a PHP class that groups related request handling logic
- Controllers live in the `app/Http/Controllers` directory
- They contain methods (called actions) that handle specific requests

#### Creating a Controller

```bash
# Create a basic controller
php artisan make:controller WelcomeController

# Create a resource controller (with CRUD methods)
php artisan make:controller BookController --resource
```

### 2. Controller Methods and Parameters

#### Basic Controller Structure

```php
<?php
// app/Http/Controllers/WelcomeController.php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class WelcomeController extends Controller
{
    public function index()
    {
        return view('welcome');
    }

    public function about()
    {
        return view('about');
    }
}
```

#### Controller Methods with Parameters

```php
<?php
// app/Http/Controllers/StudentController.php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class StudentController extends Controller
{
    // Method with route parameter - Show student profile
    public function show($id)
    {
        return view('student.profile', ['studentId' => $id]);
    }

    // Method with multiple parameters - Edit student grade in a subject
    public function editGrade($studentId, $subject)
    {
        return view('student.edit-grade', [
            'studentId' => $studentId,
            'subject' => $subject
        ]);
    }

    // Method with Request object - Add new student
    public function store(Request $request)
    {
        $name = $request->input('name');
        $email = $request->input('email');
        $grade = $request->input('grade');

        return view('student.success', [
            'name' => $name,
            'email' => $email,
            'grade' => $grade
        ]);
    }
}
```

#### Connecting Routes to Controllers

```php
// routes/web.php

use App\Http\Controllers\WelcomeController;
use App\Http\Controllers\StudentController;

Route::get('/', [WelcomeController::class, 'index']);
Route::get('/about', [WelcomeController::class, 'about']);
Route::get('/student/{id}', [StudentController::class, 'show']);
Route::get('/student/{id}/grade/{subject}', [StudentController::class, 'editGrade']);
```

### 3. Passing Data to Views

#### Method 1: Array Parameter

```php
public function index()
{
    $welcomeMessage = "Welcome to Our School Website";
    $students = ['Alice', 'Bob', 'Charlie', 'Diana'];
    $totalStudents = 150;

    return view('welcome', [
        'message' => $welcomeMessage,
        'students' => $students,
        'total' => $totalStudents
    ]);
}
```

#### Method 2: Compact Function

```php
public function index()
{
    $welcomeMessage = "Welcome to Our School Website";
    $students = ['Alice', 'Bob', 'Charlie', 'Diana'];
    $totalStudents = 150;

    return view('welcome', compact('welcomeMessage', 'students', 'totalStudents'));
}
```

#### Method 3: With Method

```php
public function index()
{
    return view('welcome')
        ->with('welcomeMessage', 'Welcome to Our School Website')
        ->with('students', ['Alice', 'Bob', 'Charlie', 'Diana'])
        ->with('totalStudents', 150);
}
```

### 4. Basic Blade Directives

Blade is Laravel's templating engine that makes it easy to create dynamic views.

#### @if Directive

```blade
{{-- resources/views/welcome.blade.php --}}
@if($students)
    <h2>We have students enrolled!</h2>
    <p>Total students: {{ count($students) }}</p>
@else
    <h2>No students enrolled yet</h2>
    <p>Be the first to enroll!</p>
@endif

{{-- Multiple conditions for student grades --}}
@if($studentGrade >= 90)
    <p class="text-green">Excellent! Grade A</p>
@elseif($studentGrade >= 75)
    <p class="text-blue">Good job! Grade B</p>
@elseif($studentGrade >= 60)
    <p class="text-yellow">You passed! Grade C</p>
@else
    <p class="text-red">Need improvement. Please study more.</p>
@endif
```

#### @foreach Directive

```blade
{{-- Display list of students --}}
<h3>Our Students:</h3>
<ul>
@foreach($students as $student)
    <li>{{ $student }}</li>
@endforeach
</ul>

{{-- Display students with their student numbers --}}
<h3>Student Directory:</h3>
@foreach($students as $studentNumber => $studentName)
    <div class="student-card">
        <strong>Student #:</strong> {{ $studentNumber + 1 }} -
        <strong>Name:</strong> {{ $studentName }}
    </div>
@endforeach

{{-- Check if we have any students to display --}}
<h3>Class List:</h3>
@forelse($students as $student)
    <div class="student-item">{{ $student }}</div>
@empty
    <p>No students in this class yet.</p>
@endforelse
```

#### @extends Directive

```blade
{{-- resources/views/layouts/school.blade.php --}}
<!DOCTYPE html>
<html>
<head>
    <title>@yield('title', 'School Management System')</title>
    <style>
        body { font-family: Arial, sans-serif; margin: 0; padding: 20px; }
        header { background: #4CAF50; color: white; padding: 1rem; }
        main { padding: 2rem 0; }
        footer { background: #333; color: white; padding: 1rem; margin-top: 2rem; }
    </style>
</head>
<body>
    <header>
        <h1>🏫 ABC School</h1>
        <nav>
            <a href="/" style="color: white; margin-right: 1rem;">Home</a>
            <a href="/students" style="color: white; margin-right: 1rem;">Students</a>
            <a href="/teachers" style="color: white;">Teachers</a>
        </nav>
    </header>

    <main>
        @yield('content')
    </main>

    <footer>
        @yield('footer', '© 2024 ABC School. All rights reserved.')
    </footer>
</body>
</html>

{{-- resources/views/welcome.blade.php --}}
@extends('layouts.school')

@section('title', 'Welcome to ABC School')

@section('content')
    <h1>{{ $welcomeMessage }}</h1>

    <div class="stats">
        <p><strong>Total Students:</strong> {{ $totalStudents }}</p>
    </div>

    @if($students)
        <h2>Featured Students:</h2>
        <ul>
        @foreach($students as $student)
            <li>🎓 {{ $student }}</li>
        @endforeach
        </ul>
    @else
        <p>No featured students this month.</p>
    @endif

    <div class="info-box" style="background: #f0f8ff; padding: 1rem; margin: 1rem 0; border-radius: 5px;">
        <h3>📚 About Our School</h3>
        <p>We provide quality education and help students achieve their dreams!</p>
    </div>
@endsection
```

### Practice Exercises

1. **Basic Controller**: Create a `LibraryController` with methods for books, members, and borrowed-books pages
2. **Student Data**: Create a controller that passes student information (names, grades, subjects) to a view
3. **School Layout**: Create a layout file for a school website and extend it in multiple views (home, about, contact)
4. **Grade Display**: Use @if to show different messages based on student grades (A, B, C, F)

---

## Session 8: Database Migrations

### Learning Objectives

By the end of this session, you will be able to:

- Understand what database migrations are and why they're important
- Create and run migrations
- Build database schemas using migration methods
- Perform rollbacks and modify existing migrations

### 1. What are Migrations?

Migrations are like version control for your database. They allow you to:

- Define database structure in code
- Share database changes with team members
- Keep database schema in sync across environments
- Roll back changes if needed

### 2. Creating Migrations

#### Basic Migration Creation

```bash
# Create a migration for students table
php artisan make:migration create_students_table

# Create a migration to add phone number to students table
php artisan make:migration add_phone_to_students_table --table=students

# Create migration with model for books
php artisan make:model Book -m
```

#### Migration File Structure

```php
<?php
// database/migrations/2024_01_01_000000_create_students_table.php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        // Define what should happen when migration runs (create table)
    }

    public function down()
    {
        // Define what should happen when migration is rolled back (drop table)
    }
};
```

### 3. Database Schema Building

#### Creating a Students Table (Complete Example)

```php
public function up()
{
    Schema::create('students', function (Blueprint $table) {
        $table->id(); // Student ID (primary key, auto-increment)
        $table->string('first_name'); // Student's first name
        $table->string('last_name'); // Student's last name
        $table->string('email')->unique(); // Email (must be unique)
        $table->string('phone_number')->nullable(); // Phone (optional)
        $table->date('date_of_birth'); // Birth date
        $table->string('grade_level'); // Grade: 1st, 2nd, 3rd, etc.
        $table->decimal('gpa', 3, 2)->default(0.00); // GPA: 0.00 to 4.00
        $table->boolean('is_active')->default(true); // Is student currently enrolled?
        $table->text('address')->nullable(); // Home address (optional)
        $table->date('enrollment_date'); // When student enrolled
        $table->timestamps(); // created_at and updated_at
    });
}

public function down()
{
    Schema::dropIfExists('students'); // Remove table if rolling back
}
```

#### Common Column Types (With Simple Examples)

```php
// Text Information
$table->string('student_name'); // VARCHAR(255) - for names, titles
$table->string('grade_level', 10); // VARCHAR(10) - for short text like "Grade 5"
$table->text('essay'); // TEXT - for long text like essays
$table->longText('biography'); // LONGTEXT - for very long text

// Numbers
$table->integer('age'); // INT - for whole numbers like age: 18
$table->bigInteger('student_id_number'); // BIGINT - for large numbers
$table->decimal('test_score', 5, 2); // DECIMAL(5,2) - for scores like 95.50
$table->float('height', 5, 2); // FLOAT(5,2) - for measurements like 165.5 cm

// Dates and Times
$table->date('birth_date'); // DATE - for dates like 2005-03-15
$table->time('class_start_time'); // TIME - for times like 09:30:00
$table->datetime('exam_datetime'); // DATETIME - for specific date+time
$table->timestamp('last_login'); // TIMESTAMP - for tracking when something happened

// True/False and Special Data
$table->boolean('is_present'); // BOOLEAN - true/false for attendance
$table->json('subjects'); // JSON - for storing lists like ["Math", "Science"]

// Special Laravel Columns
$table->id(); // Primary key - unique identifier for each record
$table->timestamps(); // created_at and updated_at - Laravel tracks these automatically
$table->softDeletes(); // deleted_at - for "soft" deletion (hide instead of delete)
```

#### Column Modifiers (Make Columns Special)

```php
$table->string('email')->unique(); // Email must be unique (no duplicates)
$table->string('middle_name')->nullable(); // Middle name is optional
$table->integer('attendance_count')->default(0); // Start with 0 if not provided
$table->string('status')->default('enrolled'); // Default status is "enrolled"
$table->text('notes')->nullable()->default(null); // Optional notes field
```

#### Foreign Keys (Connecting Tables)

```php
// Creating a table for student grades that connects to students
public function up()
{
    Schema::create('student_grades', function (Blueprint $table) {
        $table->id();
        $table->string('subject'); // Math, Science, English, etc.
        $table->decimal('grade', 5, 2); // Grade like 95.50
        $table->string('semester'); // Fall 2024, Spring 2025

        // Connect this grade to a specific student
        $table->foreignId('student_id')->constrained(); // References students.id

        $table->timestamps();
    });
}

// Alternative way to create foreign keys
$table->unsignedBigInteger('teacher_id');
$table->foreign('teacher_id')->references('id')->on('teachers');

// Example: Library books borrowed by students
Schema::create('borrowed_books', function (Blueprint $table) {
    $table->id();
    $table->foreignId('student_id')->constrained('students'); // Which student
    $table->foreignId('book_id')->constrained('books'); // Which book
    $table->date('borrowed_date');
    $table->date('due_date');
    $table->date('returned_date')->nullable(); // Null if not returned yet
    $table->timestamps();
});
```

#### Indexes (Make Searches Faster)

```php
// Make searching by email faster
$table->string('email')->index();

// Make sure emails are unique (no two students can have same email)
$table->string('student_email')->unique();

// Speed up searches that use both student_id and subject together
$table->index(['student_id', 'subject']);

// Make sure each student can only have one grade per subject per semester
$table->unique(['student_id', 'subject', 'semester']);
```

### 4. Running Migrations

```bash
# Run all pending migrations
php artisan migrate

# Check migration status
php artisan migrate:status

# Run migrations and seed data
php artisan migrate --seed

# Force run migrations (in production)
php artisan migrate --force
```

### 5. Rollbacks and Modifications

#### Rolling Back Migrations

```bash
# Rollback the last batch of migrations
php artisan migrate:rollback

# Rollback last 3 batches
php artisan migrate:rollback --step=3

# Rollback all migrations
php artisan migrate:reset

# Rollback all and re-run all migrations
php artisan migrate:refresh

# Refresh with seeding
php artisan migrate:refresh --seed
```

#### Modifying Existing Tables (Adding New Columns)

```php
// database/migrations/2024_01_02_000000_add_phone_to_students_table.php

public function up()
{
    Schema::table('students', function (Blueprint $table) {
        // Add phone number column after the email column
        $table->string('phone_number')->nullable()->after('email');

        // Add emergency contact information
        $table->string('emergency_contact_name')->nullable();
        $table->string('emergency_contact_phone')->nullable();
    });
}

public function down()
{
    Schema::table('students', function (Blueprint $table) {
        // Remove the columns if we rollback
        $table->dropColumn([
            'phone_number',
            'emergency_contact_name',
            'emergency_contact_phone'
        ]);
    });
}
```

#### Dropping Columns and Constraints (Removing Things)

```php
public function up()
{
    Schema::table('students', function (Blueprint $table) {
        // Remove a column we no longer need
        $table->dropColumn('old_student_number');

        // Remove unique constraint from email (allow duplicate emails)
        $table->dropUnique(['email']);

        // Remove index from name field
        $table->dropIndex(['name']);

        // Remove connection to teachers table
        $table->dropForeign(['teacher_id']);
    });
}
```

### Practice Exercises

1. **Create User Migration**: Build a users table with name, email, password, and timestamps
2. **Create Posts Migration**: Build a posts table with foreign key to users
3. **Modify Table**: Add a new column to an existing table
4. **Practice Rollbacks**: Create and rollback migrations

---

## Session 9: Eloquent Models

### Learning Objectives

By the end of this session, you will be able to:

- Create and configure Eloquent models
- Perform basic CRUD operations using Eloquent
- Use Laravel Tinker for testing and experimentation
- Understand the relationship between models and database tables

### 1. Introduction to Eloquent Models

Eloquent is Laravel's Object-Relational Mapping (ORM) system. It provides a simple and elegant way to interact with your database using PHP objects.

#### What is an Eloquent Model?

- A PHP class that represents a database table
- Provides methods to interact with table data
- Handles database operations like create, read, update, delete
- Located in the `app/Models` directory

### 2. Creating Models

#### Basic Model Creation

```bash
# Create a basic model
php artisan make:model Post

# Create model with migration
php artisan make:model Post -m

# Create model with migration and controller
php artisan make:model Post -mc

# Create model with all related files
php artisan make:model Post -a
```

#### Basic Model Structure

```php
<?php
// app/Models/Post.php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Post extends Model
{
    use HasFactory;

    // The table associated with the model (optional if following conventions)
    protected $table = 'posts';

    // The primary key for the model (default is 'id')
    protected $primaryKey = 'id';

    // Indicates if the model should be timestamped (default is true)
    public $timestamps = true;

    // The attributes that are mass assignable
    protected $fillable = [
        'title',
        'content',
        'slug',
        'is_published'
    ];

    // The attributes that should be hidden for arrays
    protected $hidden = [
        'created_at',
        'updated_at'
    ];

    // The attributes that should be cast to native types
    protected $casts = [
        'is_published' => 'boolean',
        'published_at' => 'datetime'
    ];
}
```

### 3. Basic CRUD Operations with Eloquent

#### Create (Insert) Operations

**Method 1: Create and Save**

```php
// Create new instance and save
$post = new Post();
$post->title = 'My First Post';
$post->content = 'This is the content of my first post.';
$post->slug = 'my-first-post';
$post->is_published = true;
$post->save();
```

**Method 2: Mass Assignment with Create**

```php
// Using create method (requires fillable attributes)
$post = Post::create([
    'title' => 'My Second Post',
    'content' => 'Content for my second post.',
    'slug' => 'my-second-post',
    'is_published' => false
]);
```

**Method 3: First or Create**

```php
// Create only if it doesn't exist
$post = Post::firstOrCreate(
    ['slug' => 'unique-post'], // Search criteria
    [
        'title' => 'Unique Post',
        'content' => 'This post is unique.',
        'is_published' => true
    ] // Attributes to set if creating
);
```

#### Read (Select) Operations

**Retrieving All Records**

```php
// Get all posts
$posts = Post::all();

// Get all posts with specific columns
$posts = Post::select('title', 'slug')->get();
```

**Finding Specific Records**

```php
// Find by primary key
$post = Post::find(1);

// Find or fail (throws exception if not found)
$post = Post::findOrFail(1);

// Find by other attributes
$post = Post::where('slug', 'my-first-post')->first();
$post = Post::where('is_published', true)->first();
```

**Advanced Queries**

```php
// Multiple conditions
$posts = Post::where('is_published', true)
             ->where('created_at', '>', '2024-01-01')
             ->get();

// Order results
$posts = Post::orderBy('created_at', 'desc')->get();
$posts = Post::latest()->get(); // Shortcut for orderBy('created_at', 'desc')

// Limit results
$posts = Post::take(5)->get();
$latestPosts = Post::latest()->limit(3)->get();

// Pagination
$posts = Post::paginate(10);
```

#### Update Operations

**Method 1: Find and Update**

```php
$post = Post::find(1);
$post->title = 'Updated Title';
$post->content = 'Updated content';
$post->save();
```

**Method 2: Mass Update**

```php
$post = Post::find(1);
$post->update([
    'title' => 'Updated Title',
    'content' => 'Updated content'
]);
```

**Method 3: Update Multiple Records**

```php
// Update all unpublished posts
Post::where('is_published', false)
    ->update(['is_published' => true]);
```

#### Delete Operations

**Delete Single Record**

```php
// Find and delete
$post = Post::find(1);
$post->delete();

// Delete by ID
Post::destroy(1);

// Delete multiple by ID
Post::destroy([1, 2, 3]);
Post::destroy(1, 2, 3);
```

**Delete with Conditions**

```php
// Delete all unpublished posts
Post::where('is_published', false)->delete();
```

### 4. Using Laravel Tinker

Tinker is Laravel's interactive shell that allows you to interact with your application directly from the command line.

#### Starting Tinker

```bash
php artisan tinker
```

#### Basic Tinker Commands

**Creating Records**

```php
// Create a new post
$post = new App\Models\Post();
$post->title = 'Test Post from Tinker';
$post->content = 'This post was created using Tinker.';
$post->slug = 'test-post-tinker';
$post->save();

// Or use mass assignment
$post = App\Models\Post::create([
    'title' => 'Another Test Post',
    'content' => 'Created with mass assignment.',
    'slug' => 'another-test-post',
    'is_published' => true
]);
```

**Reading Records**

```php
// Get all posts
$posts = App\Models\Post::all();

// Get specific post
$post = App\Models\Post::find(1);

// Display post attributes
$post->title;
$post->content;
$post->created_at;
```

**Updating Records**

```php
// Find and update
$post = App\Models\Post::find(1);
$post->title = 'Updated from Tinker';
$post->save();
```

**Deleting Records**

```php
// Delete a post
$post = App\Models\Post::find(1);
$post->delete();
```

**Useful Tinker Tips**

```php
// Check what's in a variable
$posts = App\Models\Post::all();
$posts->count(); // Get count
$posts->toArray(); // Convert to array

// Get model information
$post = new App\Models\Post();
$post->getTable(); // Get table name
$post->getFillable(); // Get fillable attributes

// Exit tinker
exit;
// or
quit;
```

### 5. Model Relationships (Preview for Future Sessions)

```php
// In Post model - belongs to User
public function user()
{
    return $this->belongsTo(User::class);
}

// In User model - has many Posts
public function posts()
{
    return $this->hasMany(Post::class);
}

// Usage in Tinker
$user = App\Models\User::find(1);
$user->posts; // Get all posts by this user

$post = App\Models\Post::find(1);
$post->user; // Get the user who created this post
```

### Practice Exercises

1. **Create a User Model**: Create a User model and practice CRUD operations in Tinker
2. **Blog Post Management**: Create, read, update, and delete blog posts using Eloquent
3. **Query Practice**: Practice different types of queries (where, orderBy, limit, etc.)
4. **Tinker Exploration**: Use Tinker to explore your models and database
5. **Mass Assignment**: Practice safe mass assignment with fillable attributes

### Common Pitfalls and Best Practices

#### Mass Assignment Protection

```php
// BAD - Vulnerable to mass assignment
$post = Post::create($request->all());

// GOOD - Define fillable attributes in model
protected $fillable = ['title', 'content', 'slug'];
$post = Post::create($request->only('title', 'content', 'slug'));
```

#### N+1 Query Problem (Preview)

```php
// BAD - Creates N+1 queries
$posts = Post::all();
foreach ($posts as $post) {
    echo $post->user->name; // Each iteration hits the database
}

// GOOD - Use eager loading
$posts = Post::with('user')->get();
foreach ($posts as $post) {
    echo $post->user->name; // User data already loaded
}
```

### Summary

By the end of these three sessions, students will have learned:

- How to create and structure controllers
- How to pass data between controllers and views
- Basic Blade templating with conditionals and loops
- Database migration creation and management
- Eloquent model creation and CRUD operations
- Using Tinker for testing and exploration

These fundamentals provide the foundation for building dynamic web applications with Laravel.
