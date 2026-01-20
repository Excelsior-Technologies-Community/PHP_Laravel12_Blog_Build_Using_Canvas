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
