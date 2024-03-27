<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <link rel="stylesheet" href="assets/css/style.css">
    <title>Facebook</title>
</head>
<body style="background-color: #F2F3F5;">
    <div class="container">
        <div class="row vertical-center">
            <div class="col-md-6">
                <h1 class="text-primary">facebook</h1>
                <p>Facebook helps you connect and share with the people in your life.</p>
            </div>
            <div class="col-md-6">
                <div class="signup-form">
                    <h2>Login</h2>
                    <form action="{{ route('loginsend') }}" method="POST">
                      @csrf
                      @if (session('error'))
                        <div id="errorMessage" class="alert alert-danger">
                            {{ session('error') }}
                        </div>
                      @endif
                      <div class="form-outline mb-4">
                        <label class="form-label" for="form2Example1">Email address</label>
                        <input type="email" name="email" id="form2Example1" class="form-control" />
                        @if($errors->has('email'))
                          <div class="text-danger">{{ $errors->first('email') }}</div>
                        @enderror
                      </div>
          
                      <div class="form-outline mb-4">
                        <label class="form-label" for="form2Example2">Password</label>
                        <input type="password" name="password" id="form2Example2" class="form-control" />
                        @if($errors->has('password'))
                          <div class="text-danger">{{ $errors->first('password') }}</div>
                        @enderror
                      </div>        
                      <input type="submit" class="btn btn-primary btn-block mb-4" />
  
                      <div class="form-outline mb-4">
                        <a href="{{ URL::to('googleLogin') }}">
                          <img height="50" src="img/google_login.jpg"></img>
                        </a>
                      </div>
                      <div class="form-outline mb-4">
                        <a href="{{ url('auth/facebook') }}">
                          <img height="50" src="img/facebook-login.png"></img>
                        </a>
                      </div>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <!-- Footer -->
    <footer>
        <div class="container">
            <div class="row">
                <div class="col-md-6">
                    <ul class="footer-links">
                        <li><a href="#">Terms of Service</a></li>
                        <li><a href="#">Privacy Policy</a></li>
                        <li><a href="#">Cookie Policy</a></li>
                    </ul>
                </div>
                <div class="col-md-6 text-md-right">
                    <p>&copy; 2024 Facebook. All Rights Reserved.</p>
                </div>
            </div>
        </div>
    </footer>

    <script>
      setTimeout(function() {
          document.getElementById('errorMessage').style.display = 'none';
      }, 5000);
    </script>

</body>
</html>