<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Edit Profile</title>
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
                <img src="" class="profile-picture" alt="">
                <span class="nav-profile-name">{{ auth()->user()->first_name }}</span>
              </a>
              <div class="dropdown-menu dropdown-menu-right" aria-labelledby="navbarDropdown">
                <a class="dropdown-item" href="{{ route('signout') }}">
                  <i class="mdi mdi-logout text-primary"></i>
                  Logout
                </a>
              </div>
            </li>
          </ul>
        </div>
    </div>
  </nav>

  <div class="mt-4">
    <div class="row m-2">
      <div class="offset-md-2 col-md-8">
        <div class="card">
          <div class="card-body">
            <h5 class="card-title">Posts</h5>
            <form action="{{ route('edit_user_rec') }}" method="POST">
              @csrf
              <div class="row">
                  <div class="col-md-6 mb-2">
                      <div class="form-outline">
                          <label class="form-label">First name</label>
                          <input type="text" name="first_name" class="form-control" value="{{ auth()->user()->first_name }}" />
                      </div>
                  </div>
                  <div class="col-md-6 mb-2">
                      <div class="form-outline">
                          <label class="form-label">Last name</label>
                          <input type="text" name="last_name" class="form-control" value="{{ auth()->user()->last_name }}" />
                      </div>
                  </div>
              </div>
              <div class="form-outline mb-2">
                  <label class="form-label">Email address</label>
                  <input type="email" name="email" class="form-control" value="{{ auth()->user()->email }}" />
              </div>
              <!-- Password field should be included only if changing password -->
              <!-- <div class="form-outline mb-2">
                  <label class="form-label">Password</label>
                  <input type="password" name="password" class="form-control" />
              </div> -->
              <div class="form-outline mb-2">
                  <label class="form-label">Phone Number</label>
                  <input type="text" name="phn_num" class="form-control" value="{{ auth()->user()->phn_num }}" />
              </div>
              <div class="form-outline mb-2">
                  <label class="form-label">Address</label>
                  <input type="text" name="address" class="form-control" value="{{ auth()->user()->address }}" />
              </div>
              <button type="submit" class="btn btn-primary btn-block mb-2">Edit Record</button>
          </form>          
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
