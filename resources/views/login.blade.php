<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Login</title>
</head>
<body>
    <h1>Login</h1>

    <form action="{{ url('api/login') }}" method="POST" id='LoginForm'>
        @csrf
        <label for="email">Email</label>
        <input type="email" name="email" id="email" required><br>
        <label for="password">Password</label>
        <input type="password" name='password' id='password' required><br>

        <button type="submit">Login</button>
    </form>
    <a href="{{ route('RegisterForm') }}">Register</a>
    <script>
       document.getElementById('LoginForm').addEventListener('submit', function(event) {
        event.preventDefault(); // Prevent the default form submission

        const formData = new FormData(this); // Get form data

            fetch('{{ url('api/login') }}', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                },
                body: JSON.stringify({
                    email: formData.get('email'), // Get email from form data
                    password: formData.get('password'), // Get password from form data
                }),
            })
            .then(response => response.json()) // Parse the JSON response
            .then(data => {
                if (data.success) {
                    alert('Login Successful');
                    localStorage.setItem('token', data.data.token); // Store the token
                    window.location.href = '{{ url('dashboard') }}'; // Redirect to dashboard
                } else {
                    alert('Invalid Credentials: ' + data.message); // Show error message
                }
            })
            .catch(error => console.error('Error:', error)); // Handle any errors
        });
    </script>
</body>
</html>