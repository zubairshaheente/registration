<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Resend Verification Email</title>
  <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
  <style>
    body {
      background-color: #f8f9fa;
    }
    .container {
      height: 100vh;
      display: flex;
      justify-content: center;
      align-items: center;
    }
    .card {
      border: none;
      box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
      border-radius: 10px;
      padding: 30px;
      background-color: #fff;
    }
    .btn-resend {
      font-weight: bold;
      background-color: #007bff;
      border: none;
    }
    .btn-resend:hover {
      background-color: #0056b3;
    }
  </style>
</head>
<body>
  <div class="container">
    <div class="card text-center">
        <h2 class="card-title mb-4">Resend Verification Email</h2>
        <p class="card-text mb-4">If you didn't receive the verification email? <br> Click the button below to resend.</p>
        <form action="{{ route('resend_verification_email') }}" method="post">
            @csrf
            <input type="hidden" name="email" value="{{$user_email}}">
            <button type="submit" class="btn btn-primary btn-resend btn-lg">Resend Verification Email</button>
        </form>
    </div>
  </div>
</body>
</html>
