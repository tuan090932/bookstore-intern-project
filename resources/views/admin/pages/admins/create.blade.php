@extends('admin.layouts.base')
@section('title', 'Create Admin')
@section('content')
<h1 class="h3 mb-2 text-gray-800">Create Admin</h1>
<hr class="my-12" />
<div class="row">
    <div class="col-md-12">
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

        <form action="{{ route('admins.store') }}" method="POST">
            @csrf
            <div class="form-group">
                <label for="admin_name">Name</label>
                <input type="text" class="form-control" id="admin_name" name="admin_name" value="{{ old('admin_name') }}" required>
                @if ($errors->has('admin_name'))
                    <span class="text-danger">{{ $errors->first('admin_name') }}</span>
                @endif
            </div>
            <div class="form-group">
                <label for="email">Email</label>
                <input type="email" class="form-control" id="email" name="email" value="{{ old('email') }}" required>
                @if ($errors->has('email'))
                    <span class="text-danger">{{ $errors->first('email') }}</span>
                @endif
            </div>
            <div class="form-group">
                <label for="password">Password</label>
                <div class="input-group">
                    <input type="password" class="form-control" id="password" name="password" required>
                    <div class="input-group-append">
                        <button class="btn btn-outline-secondary" type="button" id="togglePassword">
                            <i class="fa fa-eye" aria-hidden="true"></i>
                        </button>
                    </div>
                </div>
                @if ($errors->has('password'))
                    <span class="text-danger">{{ $errors->first('password') }}</span>
                @endif
            </div>
            <div class="form-group">
                <label for="password_confirmation">Confirm Password</label>
                <div class="input-group">
                    <input type="password" class="form-control" id="password_confirmation" name="password_confirmation" required>
                    <div class="input-group-append">
                        <button class="btn btn-outline-secondary" type="button" id="togglePasswordConfirmation">
                            <i class="fa fa-eye" aria-hidden="true"></i>
                        </button>
                    </div>
                </div>
                @if ($errors->has('password_confirmation'))
                    <span class="text-danger">{{ $errors->first('password_confirmation') }}</span>
                @endif
            </div>
            <div class="form-group">
                <label for="role_id">Role</label>
                <select class="form-control" id="role_id" name="role_id">
                    @foreach($roles as $role)
                        <option value="{{ $role->role_id }}">{{ $role->role_name }}</option>
                    @endforeach
                </select>
                @if ($errors->has('role_id'))
                    <span class="text-danger">{{ $errors->first('role_id') }}</span>
                @endif
            </div>
            <button type="submit" class="btn btn-primary">Create</button>
        </form>
    </div>
</div>

<style>
    input[type=password]::-ms-reveal,
    input[type=password]::-ms-clear
    {
        display: none;
    }
</style>

<script>
    document.addEventListener('DOMContentLoaded', function()
    {
        const authorNameInput = document.getElementById('admin_name');

        authorNameInput.addEventListener('input', function()
        {
            let words = authorNameInput.value.split(' ');
            for (let i = 0; i < words.length; i++)
            {
                words[i] = words[i].charAt(0).toUpperCase() + words[i].slice(1).toLowerCase();
            }
            authorNameInput.value = words.join(' ');
        });

        function togglePasswordVisibility(toggleButton, passwordField) {
            toggleButton.addEventListener('click', function () {
                const type = passwordField.getAttribute('type') === 'password' ? 'text' : 'password';
                passwordField.setAttribute('type', type);
                this.querySelector('i').classList.toggle('fa-eye');
                this.querySelector('i').classList.toggle('fa-eye-slash');
            });
        }

        togglePasswordVisibility(document.querySelector('#togglePassword'), document.querySelector('#password'));
        togglePasswordVisibility(document.querySelector('#togglePasswordConfirmation'), document.querySelector('#password_confirmation'));
    });
</script>
@endsection
