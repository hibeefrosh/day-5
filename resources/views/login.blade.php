<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login</title>
    <style>
        body {
            background-color: #f9f9f9;
            font-family: Arial, sans-serif;
        }

        .container {
            max-width: 400px;
            margin: 0 auto;
            border: 1px solid #ccc;
            padding: 20px;
            border-radius: 5px;
            background-color: #ffffff;
        }

        h2 {
            color: #333;
            text-align: center;
        }

        label {
            color: #555;
        }

        input[type="email"],
        input[type="password"] {
            width: 92%;
            padding: 10px;
            margin-bottom: 15px;
            border: 1px solid #ccc;
            border-radius: 3px;
        }

        button {
            background-color: #007bff;
            color: #fff;
            border: none;
            padding: 10px 20px;
            border-radius: 3px;
            cursor: pointer;
        }

        button:hover {
            background-color: #0056b3;
        }

        a {
            display: block;
            text-align: center;
            margin-top: 15px;
            color: #007bff;
            text-decoration: none;
        }

        a:hover {
            text-decoration: underline;
        }

        .error-message {
            color: #dc3545;
            font-size: 14px;
        }
    </style>
</head>

<body>
    <div class="container mt-5">
        <h2>Login</h2>
        @if(session('error'))
        <div>{{ session('error') }}</div>
        @endif
        <form action="{{ route('login') }}" method="post">
            @csrf
            <label for="email">Email:</label>
            <input type="email" name="email" required class="form-control mb-3">
            @error('email')
            <div class="error-message">{{ $message }}</div>
            @enderror

            <label for="password">Password:</label>
            <input type="password" name="password" required class="form-control mb-3">
            @error('password')
            <div class="error-message">{{ $message }}</div>
            @enderror

            <button type="submit">Login</button>
        </form>
    </div>
</body>

</html>