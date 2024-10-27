<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <style>
    .nav-link {
        color: black;
        transition: color 0.4s ease;
    }
    .nav-link.active {
        color: #ff6347 !important;
        font-weight: bold;

    }
    .nav-link:hover {
        color: #007bff;
    }
    </style>
</head>
<body>
    
<nav class="navbar navbar-expand-md navbar-light bg-light">
    <div class="container">
        <a class="navbar-brand" href="#">رحيه</a>
        <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="تبديل التنقل">
            <span class="navbar-toggler-icon"></span>
        </button>
        <div class="collapse navbar-collapse" id="navbarNav">
            <ul class="navbar-nav ml-auto">
                <li class="nav-item">
                    <a class="nav-link" href="../home.php">الرئيسية</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="./dashboard.php">لوحة التحكم</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="manage_products.php">إدارة المنتجات</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="manage_employees.php">إدارة الموظفين</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="./logout.php">تسجيل الخروج</a>
                </li>
            </ul>
        </div>
    </div>
</nav>

<script>
    const navLinks = document.querySelectorAll('.nav-link');
    
    const currentLocation = window.location.pathname;
    navLinks.forEach(link => {
        const href = link.getAttribute('href');
        const hrefEnd = href.split('/').pop();

        if(currentLocation.endsWith(hrefEnd)) {
            link.classList.add('active');
        }
    });
</script>
</body>
</html>