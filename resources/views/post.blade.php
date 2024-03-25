<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Post</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
</head>
<body>
  <nav class="navbar navbar-expand-md navbar-dark bg-primary">
    <div class="container-fluid">
        <a class="navbar-brand" href="#">Facebook</a>
        <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>
        <div class="collapse navbar-collapse justify-content-end" id="navbarSupportedContent">
          <ul class="navbar-nav ml-auto">
            <li class="nav-item dropdown">
              <a class="nav-link dropdown-toggle" href="#" id="navbarDropdown" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                <img src="" class="profile-picture" alt="profile">
                <span class="nav-profile-name">User Name</span>
              </a>
              <div class="dropdown-menu dropdown-menu-right" aria-labelledby="navbarDropdown">
                <a class="dropdown-item" href="./logout.php">
                  <i class="mdi mdi-logout text-primary"></i>
                  Logout
                </a>
              </div>
            </li>
          </ul>
        </div>
    </div>
  </nav>

  <div class="container mt-4">
    <div class="row">
      <div class="col-md-3 px-0">
        <div class="card">
          <div class="card-body">
            <h5 class="card-title">Friends</h5>
            <ul class="list-group">
              <li class="list-group-item">Friend 1</li>
              <li class="list-group-item">Friend 2</li>
              <li class="list-group-item">Friend 3</li>
            </ul>
          </div>
        </div>
      </div>
      <div class="col-md-6">
        <div class="card">
          <div class="card-body">
            <h5 class="card-title">Posts</h5>
            <div class="text-center">
                @if (session('success'))
                <div class="alert alert-success">
                    {{ session('success') }}
                </div>
                @endif
                @if (session('error'))
                <div class="alert alert-danger">
                    {{ session('error') }}
                </div>
                @endif
            </div>
            <div class="card mb-3">
              <div class="card-body">
                <form action="{{ route('post_fun') }}" method="POST" enctype="multipart/form-data" class="p-4 border rounded bg-light">
                    @csrf
                    <div class="form-group mb-4">
                        <label for="postText" class="h5">Write something...</label>
                        <textarea class="form-control" name="post_text" id="postText" rows="3" placeholder="What's on your mind?"></textarea>
                        @error('post_text')
                            <div class="text-danger mt-2">{{ $message }}</div>
                        @enderror
                    </div>
                
                    <div class="form-group mb-4">
                        <label for="postImage" class="h5">Add photo</label>
                        <input type="file" class="form-control-file" name="post_img" id="postImage">
                        @error('post_img')
                            <div class="text-danger mt-2">{{ $message }}</div>
                        @enderror
                    </div>
                
                    <button type="submit" class="btn btn-primary btn-block">Create Post</button>
                </form>
              </div>
            </div>
            <div class="card mb-3">
                <div class="card-body">
                    @foreach($abc as $a1)
                        <div class="card mb-3">
                            <img src="{{ asset('upload/' . $a1->post_img) }}" class="card-img-top img-fluid" style="max-height: 350px;" alt="Post Image"> <!-- Add img-fluid class for responsiveness and set max-height -->
                            <div class="card-body">
                                <p class="card-text">{{ $a1->post_text }}</p>
                                <div class="text-muted small">Posted on {{ $a1->created_at->format('M d, Y') }}</div>
                            </div>
                        </div>
                    @endforeach
                </div>
            </div>                        
          </div>
        </div>
      </div>
      <div class="col-md-3">
        <div class="card">
          <div class="card-body">
            <h5 class="card-title">Ads</h5>
            <img src="https://via.placeholder.com/200x200" class="img-fluid" alt="Advertisement">
            <img src="https://via.placeholder.com/200x200" class="img-fluid mt-2" alt="Advertisement">
          </div>
        </div>
      </div>
    </div>
  </div>

  <footer class="bg-dark text-white text-center py-3 mt-5">
    &copy; 2024 Facebook-like Design
  </footer>

  <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
  <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.5.3/dist/umd/popper.min.js"></script>
  <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
</body>
</html>
