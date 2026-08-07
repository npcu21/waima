@extends('admin.layouts.app')

@section('title', $language->login_title ?? 'Admin Login')

@section('content')
 <link href="{{ asset('styles/style.css') }}" rel="stylesheet">
<div class="container">
    <div class="row justify-content-center align-items-center" style="min-height: 100vh;">
        <div class="col-12 col-sm-10 col-md-8 col-lg-6 col-xl-5">

            <h1 class="text-center text-primary text-uppercase mb-4">{{ $language->site_name ?? 'Waima' }}</h1>   

            <div class="login-box mx-auto p-4 rounded shadow" style="background-color: #fff;">
                <h2 class="mb-4 text-center">{{ $language->login_heading ?? 'Admin Login' }}</h2>

                {{-- Display errors --}}
                @if($errors->any())
                    <div class="alert alert-danger">{{ $errors->first() }}</div>
                @endif

                <form action="{{ route('admin.login.submit') }}" method="POST">
                    @csrf

                    <!-- User Type Dropdown -->
                    <div class="mb-3">
                        <label for="userType" class="form-label">{{ $language->login_as ?? 'Login as' }}</label>
                        <select class="form-select" id="userType" name="usertype_id" required>
                            <option value="" disabled selected>{{ $language->select_user_type ?? 'Select User Type' }}</option>
                            @foreach($usertypes as $type)
                                <option value="{{ $type->id }}">
                                    {{ $type->{'type_name_'.$language->lang_code} ?? $type->type_name }}
                                </option>
                            @endforeach
                        </select>
                    </div>  

                    <!-- Email -->
                    <div class="mb-3">
                        <label for="email" class="form-label">{{ $language->email_label ?? 'Email' }}</label>
                        <input type="email" name="email" class="form-control" id="email" placeholder="{{ $language->email_placeholder ?? 'Enter your email' }}" required>
                    </div>

                    <!-- Password -->
                    <div class="mb-3">
                        <label for="password" class="form-label">{{ $language->password_label ?? 'Password' }}</label>
                        <input type="password" name="password" class="form-control" id="password" placeholder="{{ $language->password_placeholder ?? 'Enter your password' }}" required>
                    </div>

                    <button type="submit" class="btn btn-primary w-100">{{ $language->login_button ?? 'Login' }}</button>
                </form>

                {{-- Optional: Forgot password link --}}
                <div class="mt-3 text-center">
                    <a href="" class="small">{{ $language->forgot_password ?? 'Forgot Password?' }}</a>
                </div>
            </div>
        </div>
    </div>
</div>

<style>
    body {
        background-color: #f1f4f9;
    }
    .login-box {
        transition: all 0.3s ease-in-out;
    }
    .login-box:hover {
        transform: translateY(-5px);
        box-shadow: 0 8px 20px rgba(0,0,0,0.15);
    }
</style>
@endsection
