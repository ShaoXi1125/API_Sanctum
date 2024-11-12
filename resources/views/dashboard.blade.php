<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard</title>
</head>
<body>
    <h1>Product List</h1>
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
                    const table = document.createElement('table');
                    table.border = "1";
                    table.innerHTML = `
                        <tr>
                            <th>Product Name</th>
                            <th>Product Detail</th>
                            <th>View Product</th>
                        </tr>
                    `;

                    // 遍历 productList，为每个产品创建一行
                    productList.forEach(product => {
                        const row = document.createElement('tr');
                        row.innerHTML = `
                            <td>${product.name}</td>
                            <td>${product.detail}</td>
                           <td><a href="{{ url('viewProduct') }}?id=${product.id}">View Product</a></td>
                        `;
                        table.appendChild(row);
                    });

                    document.getElementById('product-list').appendChild(table);
                }else{
                    alert('Error fetching products: ' + data.message);
                }
            });
            //.catch(error => console.error('Error:',error));
        });
    </script>
</body>
</html>