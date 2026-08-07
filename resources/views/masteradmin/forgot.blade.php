<!DOCTYPE html>
<html>
<head>
    <title>Forgot Password</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body class="bg-light d-flex justify-content-center align-items-center" style="height:100vh">

<div class="card p-4 shadow" style="width:400px;">
    <h4 class="mb-3">Forgot Password</h4>

    @if(session('message'))
        <div class="alert alert-success">{{ session('message') }}</div>
    @endif
    @if(session('error'))
        <div class="alert alert-danger">{{ session('error') }}</div>
    @endif

    <form action="{{ route('masteradmin.sendResetLink') }}" method="POST">
        @csrf
        <div class="mb-3">
            <label>Email Address</label>
            <input type="email" name="email" class="form-control" required>
        </div>

        <button class="btn btn-primary w-100">Send Reset Link</button>
    </form>
</div>

</body>
</html>
