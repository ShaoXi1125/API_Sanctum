<!-- resources/views/viewProduct.blade.php -->

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>View Product</title>
</head>
<body>
    <h1>Product Details</h1>
    <div id="product-details">
        <!-- 产品详情会在这里展示 -->
    </div>
    <button id="edit-product">Edit Product</button>
    <button id="delete-product">Delete Product</button>

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const token = localStorage.getItem('token');
            const productId = new URLSearchParams(window.location.search).get('id');

            // 获取产品详情
            fetch(`{{ url('api/products') }}/${productId}`, {
                method: 'GET',
                headers: {
                    'Authorization': 'Bearer ' + token,
                    'Content-Type': 'application/json'
                }
            })
            .then(response => response.json())
            .then(data => {
                if (data.success) {
                    const product = data.data;
                    document.getElementById('product-details').innerHTML = `
                        <p>
                            <label><strong>Product Name:</strong></label>
                            <input type="text" id="product-name" value="${product.name}">
                        </p>
                        <p>
                            <label><strong>Product Detail:</strong></label>
                            <textarea id="product-detail">${product.detail}</textarea>
                        </p>
                    `;
                } else {
                    alert('Error fetching product: ' + data.message);
                }
            })
            .catch(error => console.error('Error:', error));

            // 编辑产品
            document.getElementById('edit-product').addEventListener('click', function() {
                const newName = document.getElementById('product-name').value;
                const newDetail = document.getElementById('product-detail').value;


                if (newName && newDetail) {
                    fetch(`{{ url('api/products') }}/${productId}`, {
                        method: 'PUT',
                        headers: {
                            'Authorization': 'Bearer ' + token,
                            'Content-Type': 'application/json'
                        },
                        body: JSON.stringify({
                            name: newName,
                            detail: newDetail
                        })
                    })
                    .then(response => response.json())
                    .then(data => {
                        if (data.success) {
                            alert('Product updated successfully');
                            window.location.reload();
                        } else {
                            alert('Error updating product: ' + data.message);
                        }
                    })
                    .catch(error => console.error('Error:', error));
                }
            });

            // 删除产品
            document.getElementById('delete-product').addEventListener('click', function() {
                if (confirm("Are you sure you want to delete this product?")) {
                    fetch(`{{ url('api/products') }}/${productId}`, {
                        method: 'DELETE',
                        headers: {
                            'Authorization': 'Bearer ' + token,
                            'Content-Type': 'application/json'
                        }
                    })
                    .then(response => response.json())
                    .then(data => {
                        if (data.success) {
                            alert('Product deleted successfully');
                            window.location.href = '{{ url('dashboard') }}';  // 返回产品列表页
                        } else {
                            alert('Error deleting product: ' + data.message);
                        }
                    })
                    .catch(error => console.error('Error:', error));
                }
            });
        });
    </script>
</body>
</html>
