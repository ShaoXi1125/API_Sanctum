<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard</title>
</head>
<body>
    <h1>Product List</h1>
    <h1>&#129313;</h1>
    <h1>&#129313;</h1>
    <h1>&#129313;</h1>
    <div id="product-list">
    
    </div>
 
   

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const token = localStorage.getItem('token');

            // console.log(token);

            if(!token){
                alert('You need to login first');
                window.location.href = '{{ url('') }}';
                return;
            }

            fetch('{{ url('api/products') }}',{
                method: 'GET',
                headers: {
                    'Authorization': 'Bearer '+token,
                    'Content-Type': 'application/json'
                },
            })
            .then(response => response.json())
            .then(data => {
                if(data.success){
                    const productList = data.data;
                    const productListDiv = document.getElementById('product-list');
                    productList.forEach(product => {
                        const productDiv = document.createElement('div');
                        productDiv.innerHTML =
                        `<p>Product Name : ${product.name}</p> <br>
                         <p>Product Detail : ${product.detail}</p><br>
                        `
                        productListDiv.appendChild(productDiv);
                    });
                }else{
                    alert('Error fetching products: ' + data.message);
                }
            });
            //.catch(error => console.error('Error:',error));
        });
    </script>
</body>
</html>