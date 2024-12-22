<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Login admin Sahabat Group</title>
    <link href="{{ asset('assets/vendor/fontawesome-free/css/all.min.css') }}" rel="stylesheet" type="text/css">
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
</head>
<body>

    
    <div class="login-container">
        @if ($errors->get('password'))
            <div style="padding: 3px;background:rgba(255, 105, 50, 0.416); color:rgb(255, 94, 0);border-radius:5px;font-weight:bold;" class="alert alert-warning">
                <x-input-error :messages="$errors->get('password')"/>
            </div>         
        @elseif($errors->get('nik'))
            <div style="padding: 3px;background:rgba(255, 105, 50, 0.416); color:rgb(255, 94, 0);border-radius:5px;font-weight:bold;display: flex; align-items: center;" class="alert alert-warning">
                <x-input-error :messages="$errors->get('nik')" />
            </div>
        @else 
        @endif

        <h1>Login Admin Sahabat Group</h1>
         <form method="POST" action="{{ route('login_execute') }}">
        @method('POST')
        @csrf
        <!-- nik Address -->
        <div class="form-group">
            <x-input-label  :value="__('NIK')" />
            <x-text-input id="nik" class="block mt-1 w-full" type="text" name="nik" :value="old('nik')" required autofocus autocomplete="off" />
           
        </div>

        <!-- Password -->
        <div class="form-group">
           <label for="">Password</label>
            <input id="password" type="password" name="password" required autocomplete="current-password" />
        </div>

        <!-- Remember Me -->
        <div class="form-group">
            <label for="remember_me" class="inline-flex items-center">
                <input id="remember_me" type="checkbox" class="rounded dark:bg-gray-900 border-gray-300 dark:border-gray-700 text-indigo-600 shadow-sm focus:ring-indigo-500 dark:focus:ring-indigo-600 dark:focus:ring-offset-gray-800" name="remember">
                <span class="ms-2 text-sm text-gray-600 dark:text-gray-400">{{ __('Remember me') }}</span>
            </label>
        </div>

        <div class="flex items-center justify-end mt-4">
          
            <x-primary-button class="ms-3">
                {{ __('Log in') }}
            </x-primary-button>
        </div>

        <div class="form-group">
            <div style="margin-top: 10px;" class="forgot-password">
                @if (Route::has('tambah_users'))
                <a href="{{ route('tambah_users') }}">
                    {{ __('Forgot your password?') }}
                </a>
                @endif
            </div>
        </div>
    </form>
    <a href="{{route('password.request')}}">Lupa password?</a>
    

    </div>
    
</body>

@if (Session::has('failed_login'))
<script>
    Swal.fire({
        title: 'Gagal',
        text: "{{ Session::get('failed_login') }}",
        icon: "error",
        timer:6000,
        confirmButtonText: 'OK'
    });
</script>
    
@endif

<style>
    body {
    font-family: Inter, sans-serif;
    background-color: #f4f4f4;
    display: flex;
    justify-content: center;
    align-items: center;
    height: 100vh;
    margin: 0;
}

.login-container {
    background-color: #fff;
    padding: 40px;
    border-radius: 5px;
    box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
    width: 400px;
}
h1{
    font-size: 28px;
}

h2 {
    text-align: center;
    margin-bottom: 20px;
}

.form-group {
    margin-bottom: 15px;
}

label {
    display: block;
    margin-bottom: 5px;
    font-weight: bold;
}

input[type="text"],
input[type="password"] {
    width: 95%;
    padding: 10px;
    border: 1px solid #ccc;
    border-radius: 4px;
}

button {
    width: 100%;
    padding: 10px;
    background-color: #4600f7;
    color: white;
    border: none;
    font-weight: bold;
    border-radius: 4px;
    cursor: pointer;
}

button:hover {
    background-color: #3025f5;
}

.message {
    text-align: center;
    margin-top: 15px;
}

</style>
</html>