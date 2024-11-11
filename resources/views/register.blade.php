<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Register</title>
</head>
<body>
    <h1>Register</h1>
    <form action="{{ url('api/register') }}" method='POST' id='register-form'>
        @csrf
        <label for="name">Name</label>
        <input type="text" name='name' id='name' required><br>
        <label for="email">Email</label>
        <input type="email" name='email' id='email' required><br>
        <label for="password">Password</label>
        <input type="password" name="password" id='password' required><br>
        <label for="c_password">Confirm Password</label>
        <input type="password" name="c_password" id='c_password' required><br>
        <button type='submit'>Register</button>
    </form>

    <a href="{{ route('LoginForm') }}">Login</a>
    <script>
        document.getElementById('register-form').addEventListener('submit', function(event) {
            event.preventDefault();

            const formData = new FormData(this); //{"name":"Yang123","email":"mail@mail.com".......}

            fetch('{{ url('api/register') }}',{
                method: "POST",
                headers: {
                    'Content-Type' : 'application/json',
                },
                body: JSON.stringify({
                    name: formData.get('name'),
                    email: formData.get('email'),
                    password: formData.get('password'),
                    c_password: formData.get('c_password'),
                }),
            })
            .then(response => response.json())
            .then(data => {
                if (data.success) {
                    alert('Login Successful');
                    localStorage.setItem('token', data.data.token); // Accessing the token correctly
                    window.location.href = '{{ url('dashboard') }}'; // Redirecting to dashboard
                } else {
                    alert('Invalid Credentials: ' + data.message); // Correctly accessing the message
                }
            })
            .catch(error => console.error('Error:', error));
        });
    </script>
</body>
</html>

