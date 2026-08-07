<!DOCTYPE html>
<html>
<head>
    <title>Reset Password</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
</head>

<body class="bg-light d-flex justify-content-center align-items-center" style="height:100vh">

<div class="card p-4 shadow" style="width:400px;">
    <h4 class="mb-3">Reset Password</h4>

    @if(session('error'))
        <div class="alert alert-danger">{{ session('error') }}</div>
    @endif

    <form action="{{ route('masteradmin.updatePassword') }}" method="POST">
        @csrf

        <input type="hidden" name="token" value="{{ $token }}">
        <input type="hidden" name="email" value="{{ $email }}">

        <div class="mb-3">
            <label>New Password</label>
            <input type="password" class="form-control" name="password" required>
        </div>

        <button class="btn btn-success w-100">Update Password</button>
    </form>
</div>

</body>
</html>
