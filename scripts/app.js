document.addEventListener('DOMContentLoaded', () => {
    // check employees status 
    setInterval(function() {
        
        $.ajax({
            url: './check_employee_status.php',
            method: 'GET',
            dataType: 'json',
            success: function(response) {                
                if (response.status === 'close') {                    
                    window.location.href = './closed_account.php';
                }
            },
            error: function(xhr, status, error) {
                console.error("Error occurred: ", error);
            }
        });
    }, 5000);

    // get varibles
    const menuItems = document.querySelectorAll('.add-to-cart');
    const orderList = document.getElementById('order-list');
    const totalPriceEl = document.getElementById('total-price');
    let totalPrice = 0;
    let currentItem = null;

    menuItems.forEach(button => {
        button.addEventListener('click', (event) => {
            const itemName = event.target.dataset.name;
            const itemPrice = parseInt(event.target.dataset.price);
            const itemId = parseInt(event.target.dataset.id);
            
            // تعيين العنصر الحالي وإظهار النافذة
            currentItem = { name: itemName, price: itemPrice , id: itemId };
            $('#quantityModal').modal('show');
        });
    });

    // حفظ الكمية وإضافة المنتج إلى السلة
    document.getElementById('save-quantity').addEventListener('click', () => {        
        const quantity = parseInt(document.getElementById('quantity').value);
        const totalItemPrice = currentItem.price * quantity;

        // إنشاء عنصر الطلب
        const orderItem = document.createElement('li');
        orderItem.className = 'list-group-item d-flex justify-content-between align-items-center';
        orderItem.innerHTML = `${currentItem.name} - ${totalItemPrice} دينار كويتي (الكمية: ${quantity}) <button class="btn btn-danger btn-sm remove-item">إزالة</button>`;
        orderItem.dataset.id = currentItem.id;
        orderItem.dataset.cost = totalItemPrice;
        orderItem.dataset.name = currentItem.name;
        orderItem.dataset.quantity = quantity;
        
        orderList.appendChild(orderItem);
        totalPrice += totalItemPrice;
        totalPriceEl.textContent = totalPrice;
        
        // إضافة حدث لإزالة العنصر
        orderItem.querySelector('.remove-item').addEventListener('click', () => {
            totalPrice -= totalItemPrice;
            totalPriceEl.textContent = totalPrice;
            orderItem.remove();
        });        
        document.getElementById('quantity').value = 1;
        $('#quantityModal').modal('hide');
    });

    // submit order code
    document.getElementById('submit-order').addEventListener('click', () => {
        let orderData = [];
    
        // جمع بيانات الطلب
        document.querySelectorAll('.list-group-item').forEach((order) => {
            let item = {
                id: order.getAttribute('data-id'),
                name: order.getAttribute('data-name'),
                quantity: order.getAttribute('data-quantity'),
                cost: order.getAttribute('data-cost'), // اسم متغير cost
            };
            orderData.push(item);
        });
    
        // تحقق مما إذا كان هناك بيانات للطلب
        if (orderData.length === 0) {
            console.error('لا توجد بيانات للطلب.');
            return;
        }
    
        fetch('process_order.php', {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json; charset=utf-8',
            },
            body: JSON.stringify(orderData)
        })
        .then(response => response.json())
        .then(data => {
            const alertBox = document.getElementById('order-alert');

            if (data.success) {
                alertBox.classList.remove('d-none');
                alertBox.classList.add('show');

                setTimeout(() => {
                    location.reload();
                }, 1000);
            } else {
                alertBox.classList.remove('show');
                alertBox.classList.add('d-none'); // أخفاء الرسالة السابقة
                console.error('حدث خطأ أثناء إرسال الطلب: ', data.message || 'خطأ غير معروف.');
            }
        })
        .catch(error => {
            console.error('حدث خطأ أثناء الطلب: ', error);
        });
    });        
});