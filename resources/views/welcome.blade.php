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
                    <h2>Sign Up</h2>
                    <form action="{{ route('indexsend') }}" method="POST">
                      @csrf
                              {{-- @foreach ($errors->all() as $error)
                                  <div>{{ $error }}</div>
                              @endforeach --}}
                  
                              <div class="row">
                                  <div class="col-md-6 mb-2">
                                      <div class="form-outline">
                                          <label class="form-label" for="form3Example1">First name</label>
                                          <input type="text" name="first_name" id="form3Example1" class="form-control" value="{{ old('first_name') }}" />
                                          @if($errors->has('first_name'))
                                              <div class="text-danger">{{ $errors->first('first_name') }}</div>
                                          @enderror
                                      </div>
                                  </div>
                                  <div class="col-md-6 mb-2">
                                      <div class="form-outline">
                                          <label class="form-label" for="form3Example2">Last name</label>
                                          <input type="text" name="last_name" id="form3Example2" class="form-control" value="{{ old('last_name') }}" />
                                          @if($errors->has('last_name'))
                                            <div class="text-danger">{{ $errors->first('last_name') }}</div>
                                          @enderror
                                      </div>
                                  </div>
                              </div>
                              <div class="form-outline mb-2">
                                  <label class="form-label" for="form3Example3">Email address</label>
                                  <input type="email" name="email" id="form3Example3" class="form-control" value="{{ old('email') }}"/>
                                  @if($errors->has('email'))
                                    <div class="text-danger">{{ $errors->first('email') }}</div>
                                  @enderror
                              </div>
                              <div class="form-outline mb-2">
                                  <label class="form-label" for="form3Example4">Password</label>
                                  <input type="password" name="password" id="form3Example4" class="form-control" />
                                  @if($errors->has('password'))
                                    <div class="text-danger">{{ $errors->first('password') }}</div>
                                  @enderror
                              </div>
                              <div class="form-outline mb-2">
                                  <label class="form-label" for="form3Example5">Phone Number</label>
                                  <input type="text" name="phn_num" id="form3Example5" class="form-control" value="{{ old('phn_num') }}" />
                                  @if($errors->has('phn_num'))
                                    <div class="text-danger">{{ $errors->first('phn_num') }}</div>
                                  @enderror
                              </div>
                              <div class="form-outline mb-2">
                                  <label class="form-label" for="form3Example6">Address</label>
                                  <input type="text" name="address" id="form3Example6" class="form-control" value="{{ old('address') }}" />
                                  @if($errors->has('address'))
                                    <div class="text-danger">{{ $errors->first('address') }}</div>
                                  @enderror
                              </div>
                      <button type="submit" class="btn btn-primary btn-block mb-2"> Sign up </button>
                      <button type="submit" class="btn btn-primary btn-block mb-2"> <a class="text-white" href="{{ route('login') }}">Login</a> </button>
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
</body>
<div id="errorMessages"></div>
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script>
    $(document).ready(function () {
        $('#signupForm').submit(function (event) {
            event.preventDefault(); // Prevent default form submission
            // Get form data
            var formData = $(this).serialize();
            // Perform AJAX request to handle form submission
            $.ajax({
                type: 'POST',
                url: 'your_signup_endpoint',
                data: formData,
                success: function (response) {
                    // Handle success response
                    // For example, redirect user to a success page
                    window.location.href = 'success_page_url';
                },
                error: function (xhr, status, error) {
                    // Handle error response
                    // Display error message without clearing form data
                    $('#errorMessages').html(xhr.responseText);
                }
            });
        });
    });
</script>
</html>