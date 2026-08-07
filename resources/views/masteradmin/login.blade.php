<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <title>Waima</title>
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <link rel="apple-touch-icon" sizes="180x180" href="{{ asset('fabicon/apple-touch-icon.png') }}">
  <link rel="icon" type="image/png" sizes="32x32" href="{{ asset('fabicon/favicon-32x32.png') }}">
  <link rel="icon" type="image/png" sizes="16x16" href="{{ asset('fabicon/favicon-16x16.png') }}">
  <link rel="manifest" href="{{ asset('images/site.webmanifest') }}">
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
  <link href="https://fivoflow.com/wclm/public/css/style.css" rel="stylesheet">
  <style>
    body {
      background-color: #f1f4f9;
      min-height: 100vh;
      display: flex;
      align-items: center;
      justify-content: center;
      flex-direction: column;
      background-image: linear-gradient(rgba(17, 107, 172, 0.8), rgba(17, 107, 172, 0.8)), url('{{ asset('fabicon/farmer.jpeg') }}');
      background-size: cover;
      background-position: center;
      background-repeat: no-repeat;
    }
    .brand-title {
      font-size: 2.5rem;
      font-weight: bold;
      color: #ffffff;
      margin-bottom: 10px;
      text-align: center;
      text-transform: uppercase;
    }
    .login-box {
      background: #fff;
      padding: 40px;
      border-radius: 10px;
      box-shadow: 0 0 20px rgba(0,0,0,0.15);
      width: 100%;
      max-width: 450px;
    }
    .login-box h2 {
      margin-bottom: 25px;
      text-align: left;
      font-weight: 600;
    }
  </style>
</head>
<body>

<div class="col-12 col-sm-10 col-md-8 col-lg-6 col-xl-5">
  <!-- Brand Title -->
  <h1 class="brand-title mt-3">Waima</h1>   

  <div class="login-box mx-auto mb-4">
    <h2>Admin Login</h2>

    <!-- Session Messages -->
    @if(session('error'))
      <div class="alert alert-danger">{{ session('error') }}</div>
    @endif
    @if(session('message'))
      <div class="alert alert-success">{{ session('message') }}</div>
    @endif

    <form action="{{ route('masteradmin.login') }}" method="POST">
      @csrf

      <!-- Email -->
      <div class="mb-3">
        <label for="email" class="form-label">Email</label>
        <input type="email" class="form-control" id="email" name="email" value="{{ old('email') }}" placeholder="Enter your email" required>
      </div>

      <!-- Password -->
      <div class="mb-3">
        <label for="password" class="form-label">Password</label>
        <input type="password" class="form-control" id="password" name="password" placeholder="Enter your password" required>
      </div>

      <button type="submit" class="btn btn-primary w-100">Login</button>
      <div class="mt-3 text-center">
      <a href="{{ url('masteradmin/register-admin') }}" class="btn pc-reset-btn w-100">Signup</a>
    </div>
    </form>
    <div class="text-end mt-2">
    <a href="{{ route('masteradmin.forgot') }}" class="theme-color">Forgot Password?</a>
</div>

  </div>
</div>

</body>
</html>
