
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Add Product</title>
</head>
<body>
    <h1>Add New Product</h1>
    <form id="add-product-form" action="{{url('api/product')}}">
        <label for="name">Product Name:</label>
        <input type="text" id="name" name="name" required><br><br>

        <label for="detail">Product Detail:</label>
        <textarea id="detail" name="detail" required></textarea><br><br>

        <button type="submit">Add Product</button>
    </form>

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const token = localStorage.getItem('token');

            if(!token){
                alert('You need to login first');
                window.location.href = '{{ url('') }}';
                return;
            }

            document.getElementById('add-product-form').addEventListener('submit', function(e) {
                e.preventDefault();

                const name = document.getElementById('name').value;
                const detail = document.getElementById('detail').value;

                fetch('{{ url('api/products') }}', {
                    method: 'POST',
                    headers: {
                        'Authorization': 'Bearer ' + token,
                        'Content-Type': 'application/json'
                    },
                    body: JSON.stringify({
                        name: name,
                        detail: detail
                    })
                })
                .then(response => response.json())
                .then(data => {
                    if (data.success) {
                        alert('Product added successfully');
                        window.location.href = '{{ url('dashboard') }}';
                    } else {
                        alert('Error adding product: ' + data.message);
                    }
                })
                .catch(error => console.error('Error:', error));
            });
        });
    </script>
</body>
</html>
