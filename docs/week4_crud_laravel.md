# Week 4: Building Your First CRUD Application

In this week, we will learn how to build a **CRUD** application in Laravel.  
CRUD stands for:  
- **C**reate  
- **R**ead  
- **U**pdate  
- **D**elete  

By the end of this week, you will know how to create forms, validate user input, and manage records in a database.

---

## Session 10: Forms & Validation

### 1. Creating Forms in Blade
In Laravel, forms are written in **Blade templates**.  
Here’s a simple form to add a new `Post`:

```blade
<!-- resources/views/posts/create.blade.php -->
@extends('layouts.app')

@section('content')
<div class="container">
    <h2>Create Post</h2>

    <form action="{{ route('posts.store') }}" method="POST">
        @csrf <!-- Security token -->
        
        <div>
            <label for="title">Title</label>
            <input type="text" name="title" id="title">
        </div>

        <div>
            <label for="body">Body</label>
            <textarea name="body" id="body"></textarea>
        </div>

        <button type="submit">Save</button>
    </form>
</div>
@endsection
```

✅ Always include `@csrf` in forms. This prevents CSRF attacks.

---

### 2. Form Validation Rules
In the controller, we validate input before saving it to the database:

```php
// app/Http/Controllers/PostController.php

public function store(Request $request)
{
    $validated = $request->validate([
        'title' => 'required|min:3|max:100',
        'body' => 'required|min:10',
    ]);

    Post::create($validated);

    return redirect()->route('posts.index');
}
```

---

### 3. Displaying Validation Errors
Show validation errors in Blade:

```blade
@if ($errors->any())
    <div style="color:red;">
        <ul>
            @foreach ($errors->all() as $error)
                <li>{{ $error }}</li>
            @endforeach
        </ul>
    </div>
@endif
```

Now, when validation fails, errors will be shown above the form.

---

## Session 11: CRUD Operations I

### 1. Creating Records (Store Method)
We already created the `store` method above. It saves new records into the database.

---

### 2. Reading Records (Index & Show Methods)
- **Index (list all posts):**

```php
public function index()
{
    $posts = Post::all();
    return view('posts.index', compact('posts'));
}
```

```blade
<!-- resources/views/posts/index.blade.php -->
<h2>All Posts</h2>
@foreach ($posts as $post)
    <h3>{{ $post->title }}</h3>
    <p>{{ $post->body }}</p>
    <a href="{{ route('posts.show', $post) }}">View</a>
@endforeach
```

- **Show (display single post):**

```php
public function show(Post $post)
{
    return view('posts.show', compact('post'));
}
```

```blade
<!-- resources/views/posts/show.blade.php -->
<h2>{{ $post->title }}</h2>
<p>{{ $post->body }}</p>
```

---

### 3. Route Model Binding
Notice in the `show` method we used:

```php
public function show(Post $post)
```

Laravel automatically finds the post by ID.  
This is called **Route Model Binding**.

---

## Session 12: CRUD Operations II

### 1. Updating Records (Edit & Update Methods)
- **Edit Form:**

```php
public function edit(Post $post)
{
    return view('posts.edit', compact('post'));
}
```

```blade
<!-- resources/views/posts/edit.blade.php -->
<h2>Edit Post</h2>

<form action="{{ route('posts.update', $post) }}" method="POST">
    @csrf
    @method('PUT') <!-- Method override -->

    <input type="text" name="title" value="{{ $post->title }}">
    <textarea name="body">{{ $post->body }}</textarea>

    <button type="submit">Update</button>
</form>
```

- **Update in Controller:**

```php
public function update(Request $request, Post $post)
{
    $validated = $request->validate([
        'title' => 'required|min:3|max:100',
        'body' => 'required|min:10',
    ]);

    $post->update($validated);

    return redirect()->route('posts.index');
}
```

---

### 2. Deleting Records (Destroy Method)
- **Delete Button:**

```blade
<form action="{{ route('posts.destroy', $post) }}" method="POST">
    @csrf
    @method('DELETE')
    <button type="submit">Delete</button>
</form>
```

- **Controller Method:**

```php
public function destroy(Post $post)
{
    $post->delete();
    return redirect()->route('posts.index');
}
```

---

### 3. Flash Messages & Redirects
After creating, updating, or deleting, we can show success messages:

```php
return redirect()->route('posts.index')
                 ->with('success', 'Post created successfully!');
```

In Blade:

```blade
@if (session('success'))
    <div style="color:green;">
        {{ session('success') }}
    </div>
@endif
```

---

## 🎯 Summary
- You learned how to create forms and validate user input.  
- You can now **Create, Read, Update, and Delete** posts.  
- You practiced **Route Model Binding** and **Flash Messages**.  

✅ Congratulations! You just built your first **CRUD Application in Laravel** 🎉
