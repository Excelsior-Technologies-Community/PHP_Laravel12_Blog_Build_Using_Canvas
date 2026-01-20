# PHP_Laravel12_Blog_Build_Using_Canvas


## Project Overview:

This project is a simple and beginner-friendly Blog Application built in Laravel 12 using Canvas package. It includes an Admin Authentication system (Register, Login, Logout, Dashboard) and a Frontend Blog section where users can view blog posts.


## The main purpose of this project is to understand:

Laravel 12 project structure

MVC (Model-View-Controller) pattern

Authentication system

Database migration and models

Routing and Controllers

Blade templating

Integration of Canvas package for frontend layout


## Technology Used:

Backend: Laravel 12 (PHP 8+)

Frontend: Blade Templates + Bootstrap 5

Database: MySQL

Package: coliving/canvas


## Modules Included:
 Admin Module:

Register

Login

Dashboard (After Login)

Logout

##  Blog Module:

View all blog posts

View single blog post by slug

Display post title, content, and published date


---



# Step-by-Step Laravel Canvas Blog Setup



---

## STEP 1: Create Laravel 12 Project

### Command:

```
composer create-project laravel/laravel PHP_Laravel12_Blog_Build_Using_Canvas "12.*"

```

### Go inside project:
```
cd PHP_Laravel12_Blog_Build_Using_Canvas

```


## STEP 2: Configure .env File

### Open .env file and set database.

```
DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=laravel_canvas_blog
DB_USERNAME=root
DB_PASSWORD=

```

### Create database laravel12_cashier_fastspring in phpMyAdmin or via CLI:

```
 Create database laravel_canvas_blog in phpMyAdmin.

```



## STEP 3: Install Canvas

### Run:

```
composer require coliving/canvas

```

### Then install Canvas:

```
php artisan canvas:install
php artisan storage:link
php artisan migrate

```




## STEP 4: Install Auth (Login/Register)

### Laravel 12 does not have auth built-in. Run:

```
composer require laravel/ui
php artisan ui bootstrap --auth
npm install
npm run dev
php artisan migrate

```

Now you can register/login for admin.



## STEP 6: Add Routes

### Edit routes/web.php:

```

<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\BlogController;
use App\Http\Controllers\AuthController;

// Home page
Route::get('/', function () {
    return view('welcome');
});

// Frontend Blog
Route::get('/blog', [BlogController::class, 'index'])->name('blog.index');
Route::get('/blog/{slug}', [BlogController::class, 'show'])->name('blog.show');

// ------------------------
// Admin Login & Dashboard
// ------------------------



Route::get('/register', [AuthController::class, 'showRegister'])->name('register');
Route::post('/register', [AuthController::class, 'register'])->name('register.post');

Route::get('/login', [AuthController::class, 'showLogin'])->name('login');
Route::post('/login', [AuthController::class, 'login'])->name('login.post');

Route::get('/dashboard', [AuthController::class, 'dashboard'])->middleware('auth')->name('dashboard');
Route::post('/logout', [AuthController::class, 'logout'])->name('logout');

```




## STEP 7 — Create Model + Migration

### Run this command:

```
php artisan make:model Post -m

```

This will create:

app/Models/Post.php

database/migrations/xxxx_create_posts_table.php




## STEP 8 — Update Migration (posts table)

### database/migrations/xxxx_create_posts_table.php

```

<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
   public function up()
{
    Schema::create('posts', function (Blueprint $table) {
        $table->id();
        $table->string('title');
        $table->string('slug')->unique();
        $table->text('body_html');
        $table->string('cover_img')->nullable();
        $table->timestamp('published_at')->nullable();
        $table->timestamps();
    });
}


    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('posts');
    }
};

```

### File: app/Models/Post.php

```

<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Post extends Model
{
    use HasFactory;

    protected $fillable = [
        'title',
        'slug',
        'body_html',
        'cover_img',
        'published_at',
    ];

    protected $dates = [
        'published_at',
    ];
}

```


### Replace File: app/Models/User.php

```

<?php

namespace App\Models;

use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class User extends Authenticatable
{
    use Notifiable;

    protected $fillable = [
        'name',
        'email',
        'password',
    ];
}


```

### Run Command :

```
php artisan migrate

```



## Step 9: Create Controller

### Run Command :

```
php artisan make:controller AuthController

php artisan make:controller BlogController

```


### Open app/Http/Controllers/AuthController.php and update:

```

<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class AuthController extends Controller
{
    // Show Register Form
 public function showRegister()
{
    return view('auth.register');
}

    // Handle Registration
    public function register(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:users,email',
            'password' => 'required|string|min:8|confirmed',
        ]);

        User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->password), // important
        ]);

        return redirect()->route('login')->with('success', 'Registration successful! Please login.');
    }

    // Show Login Form
   public function showLogin()
{
    return view('auth.login');
}


    // Handle Login
    public function login(Request $request)
    {
        $request->validate([
            'email' => 'required|email',
            'password' => 'required|string',
        ]);

        $credentials = $request->only('email', 'password');

        if (Auth::attempt($credentials)) {
            $request->session()->regenerate();
            return redirect()->route('dashboard');
        }

        return back()->withErrors([
            'email' => 'Invalid email or password',
        ]);
    }

    

    // Logout
    public function dashboard()
{
    return view('auth.dashboard');
}

public function logout(Request $request)
{
    Auth::logout();
    $request->session()->invalidate();
    $request->session()->regenerateToken();
    return redirect()->route('login');
}

}

```


### Open app/Http/Controllers/BlogController.php and update:

```

<?php

namespace App\Http\Controllers;

use App\Models\Post;

class BlogController extends Controller
{
    public function index()
    {
        $posts = Post::orderBy('published_at', 'desc')->get();
        return view('blog.index', compact('posts'));
    }

    public function show($slug)
    {
        $post = Post::where('slug', $slug)->firstOrFail();
        return view('blog.show', compact('post'));
    }
}


```



## STEP 10: Create Blade Views

### resources/views/auth/register.blade.php

```

<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>Register - Laravel Canvas Blog</title>
<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body class="bg-light">

<div class="container mt-5">
    <div class="row justify-content-center">
        <div class="col-md-5">
            <div class="card shadow-sm">
                <div class="card-header text-center bg-primary text-white">
                    Register
                </div>
                <div class="card-body">
                    <!-- Validation Errors -->
                    @if ($errors->any())
                        <div class="alert alert-danger">
                            <ul class="mb-0">
                                @foreach ($errors->all() as $error)
                                    <li>{{ $error }}</li>
                                @endforeach
                            </ul>
                        </div>
                    @endif

                    <!-- Success Message -->
                    @if (session('success'))
                        <div class="alert alert-success">{{ session('success') }}</div>
                    @endif

                    <form method="POST" action="{{ route('register.post') }}">
                        @csrf
                        <div class="mb-3">
                            <label>Name</label>
                            <input type="text" name="name" class="form-control" placeholder="Enter your name" required>
                        </div>
                        <div class="mb-3">
                            <label>Email</label>
                            <input type="email" name="email" class="form-control" placeholder="Enter your email" required>
                        </div>
                        <div class="mb-3">
                            <label>Password</label>
                            <input type="password" name="password" class="form-control" placeholder="Enter password" required>
                        </div>
                        <div class="mb-3">
                            <label>Confirm Password</label>
                            <input type="password" name="password_confirmation" class="form-control" placeholder="Confirm password" required>
                        </div>
                        <button type="submit" class="btn btn-primary w-100">Register</button>
                    </form>

                    <p class="mt-3 text-center">
                        Already have an account? <a href="{{ route('login') }}">Login</a>
                    </p>
                </div>
            </div>
        </div>
    </div>
</div>

</body>
</html>

```


### resources/views/auth/login.blade.php

```

<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>Login - Laravel Canvas Blog</title>
<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body class="bg-light">

<div class="container mt-5">
    <div class="row justify-content-center">
        <div class="col-md-5">
            <div class="card shadow-sm">
                <div class="card-header text-center bg-primary text-white">
                    Login
                </div>
                <div class="card-body">
                    <!-- Login Errors -->
                    @if ($errors->any())
                        <div class="alert alert-danger">{{ $errors->first() }}</div>
                    @endif

                    <!-- Success Message -->
                    @if (session('success'))
                        <div class="alert alert-success">{{ session('success') }}</div>
                    @endif

                    <form method="POST" action="{{ route('login.post') }}">
                        @csrf
                        <div class="mb-3">
                            <label>Email</label>
                            <input type="email" name="email" class="form-control" placeholder="Enter your email" required>
                        </div>
                        <div class="mb-3">
                            <label>Password</label>
                            <input type="password" name="password" class="form-control" placeholder="Enter your password" required>
                        </div>
                        <button type="submit" class="btn btn-primary w-100">Login</button>
                    </form>

                    <p class="mt-3 text-center">
                        Don't have an account? <a href="{{ route('register') }}">Register</a>
                    </p>
                    
                </div>
            </div>
        </div>
    </div>
</div>

</body>
</html>
 
```


### resources/views/auth/dashboard.blade.php

```

<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>Dashboard - Laravel Canvas Blog</title>
<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body class="bg-light">

<div class="container mt-5">
    <div class="row justify-content-center">
        <div class="col-md-6">
            <div class="card shadow-sm">
                <div class="card-header text-center bg-primary text-white">
                    Dashboard
                </div>
                <div class="card-body text-center">
                    <h3>Welcome, {{ Auth::user()->name }}!</h3>
                    <p class="mb-4">You are logged in to Laravel Canvas Blog.</p>

                    <form method="POST" action="{{ route('logout') }}">
                        @csrf
                        <button type="submit" class="btn btn-danger">Logout</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>

</body>
</html>

```

### resources/views/welcome.blade.php

```
<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>Laravel Canvas Blog</title>
<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body class="bg-light">
<div class="container mt-5">
    <div class="row justify-content-center">
        <div class="col-md-6">
            <div class="card shadow-sm text-center">
                <div class="card-body">
                    <h1 class="mb-4">Welcome to Laravel Canvas Blog</h1>
                    <a href="{{ route('login') }}" class="btn btn-primary me-2">Admin Login</a>
                    <a href="{{ route('blog.index') }}" class="btn btn-success">View Blog</a>
                </div>
            </div>
        </div>
    </div>
</div>
</body>
</html>

```



### resources/views/blog/index.blade.php

```

@extends('canvas::frontend.layout')

@section('content')
<div class="container mt-5">
    <h1>Blog Posts</h1>

    <div class="row">
        @foreach($posts as $post)
        <div class="col-md-4">
            <div class="card mb-3">

                @if($post->cover_img)
                <img src="{{ $post->cover_img }}" class="card-img-top" alt="{{ $post->title }}">
                @endif

                <div class="card-body">
                    <h5 class="card-title">{{ $post->title }}</h5>
                    <p class="card-text">{!! Str::limit($post->body_html, 100) !!}</p>

                    <a href="{{ route('blog.show', $post->slug) }}" class="btn btn-primary">
                        Read More
                    </a>
                </div>
            </div>
        </div>
        @endforeach
    </div>
</div>
@endsection

```


### resources/views/blog/show.blade.php

```

@extends('canvas::frontend.layout')

@section('content')
<div class="container mt-5">

    <h1>{{ $post->title }}</h1>

    @if($post->published_at)
    <p>
        <p><small>Published on {{ \Carbon\Carbon::parse($post->published_at)->format('d M Y') }}</small></p>

    </p>
    @endif

    @if($post->cover_img)
    <img src="{{ $post->cover_img }}" class="img-fluid mb-3" alt="{{ $post->title }}">
    @endif

    <div>{!! $post->body_html !!}</div>

    <a href="{{ route('blog.index') }}" class="btn btn-secondary mt-3">
        Back to Blog
    </a>

</div>
@endsection


```


### resources/views/vendor/canvas/frontend/layout.blade.php

```

<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>Laravel Canvas Blog</title>
<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>
@yield('content')
</body>
</html>

```


## STEP 10:Running the App

### Finally run the development server:

```
php artisan serve

```

### Visit in browser:

```
http://localhost:8000

```


# So You can see this type Output:

### Main Page:


<img width="1919" height="964" alt="Screenshot 2026-01-20 103932" src="https://github.com/user-attachments/assets/ed880063-4f69-4732-b021-62cc7da8a24b" />


### Admin Register Page:


<img width="1918" height="965" alt="Screenshot 2026-01-20 103440" src="https://github.com/user-attachments/assets/64db3a1b-3758-4437-a01e-dc590084a750" />


### Admin Login Page:


<img width="1919" height="966" alt="Screenshot 2026-01-20 103643" src="https://github.com/user-attachments/assets/61fb354c-e243-4405-afdd-5ac204ea3483" />


### Dashboard Page:


<img width="1919" height="971" alt="Screenshot 2026-01-20 103700" src="https://github.com/user-attachments/assets/054e4178-c881-4275-af20-cef4b29b1e85" />


### Blog Page:


<img width="1919" height="964" alt="Screenshot 2026-01-20 105040" src="https://github.com/user-attachments/assets/2a01f104-b936-419a-a170-b53fa19694ec" />


### Blog Show Page:


<img width="1919" height="964" alt="Screenshot 2026-01-20 105055" src="https://github.com/user-attachments/assets/09385ae0-caa5-42b5-8afd-2ed43c315aab" />




---

# Project Folder Structure:

```

PHP_Laravel12_Blog_Build_Using_Canvas/
│
├── app/
│   ├── Http/
│   │   ├── Controllers/
│   │   │   ├── AuthController.php
│   │   │   └── BlogController.php
│   │
│   ├── Models/
│   │   ├── User.php
│   │   └── Post.php
│
├── bootstrap/
│
├── config/
│
├── database/
│   ├── migrations/
│   │   ├── xxxx_xx_xx_create_users_table.php
│   │   ├── xxxx_xx_xx_create_posts_table.php    (your Post migration)
│   │   └── other default migrations...
│   │
│   └── seeders/
│
├── public/
│   ├── storage/         (created after php artisan storage:link)
│   └── index.php
│
├── resources/
│   ├── views/
│   │   ├── auth/
│   │   │   ├── register.blade.php
│   │   │   ├── login.blade.php
│   │   │   └── dashboard.blade.php
│   │   │
│   │   ├── blog/
│   │   │   ├── index.blade.php
│   │   │   └── show.blade.php
│   │   │
│   │   ├── vendor/
│   │   │   └── canvas/
│   │   │       └── frontend/
│   │   │           └── layout.blade.php    (your Canvas layout)
│   │   │
│   │   └── welcome.blade.php
│
├── routes/
│   └── web.php    (your all routes are here)
│
├── storage/
│   ├── app/
│   ├── framework/
│   └── logs/
│
├── vendor/    (created after composer install)
│
├── .env       (your database settings here)
├── artisan
├── composer.json
├── package.json
├── package-lock.json
├── README.md    (this file you shared)
└── phpunit.xml


```
