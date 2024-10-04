<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Welcome</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
</head>
<body>
    <div class="container mt-5">
        <h1>Welcome to Your Blog</h1>

        <!-- Display login and registration forms -->
        <div class="mb-4">
            <!-- Include your login and registration forms here -->
            @if (Route::has('login'))
                @auth
                    <form action="{{ route('logout') }}" method="POST" style="display: inline;">
                        @csrf
                        <button type="submit" class="btn btn-danger">Logout</button>
                    </form>
                @else
                    <a href="{{ route('login') }}" class="btn btn-primary">Log in</a>
                        @if (Route::has('register'))
                            <a href="{{ route('register') }}" class="btn btn-secondary">Register</a>
                        @endif
                @endauth
            @endif
        </div>

        <!-- Display all posts -->
        <h2>All Posts</h2>
        @if($posts->isEmpty())
            <p>No posts available.</p>
        @else
            <div class="list-group">
                @foreach($posts as $post)
                    <a href="{{ route('posts.show', $post->id) }}" class="list-group-item list-group-item-action">
                        <h5 class="mb-1">{{ $post->title }}</h5>
                        <p class="mb-1">{{ Str::limit($post->content, 100) }}</p>
                        <small>Posted on {{ $post->created_at->format('M d, Y') }}</small>
                    </a>
                @endforeach
            </div>
        @endif
    </div>

    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.9.2/dist/umd/popper.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
</body>
</html>
