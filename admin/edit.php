<?php

include('../connect.php');

// معالجة الطلبات
if ($_SERVER["REQUEST_METHOD"] == "GET") {
    $id = $_GET['id'];
    // استعلام للحصول على قائمة الموظفين
    $result = $conn->query("SELECT * FROM employees WHERE id='$id'");
}
if (isset($_POST['edit'])) {
    $employee_id = $_POST['employee_id'];
    $employee_name = $_POST['employee_name'];
    $employee_position = $_POST['employee_position'];
    $employee_email = $_POST['employee_email'];

    // تحديث معلومات الموظف
    $stmt = $conn->prepare("UPDATE employees SET username=?, password=? WHERE id=?");
    $stmt->bind_param("sssi", $employee_name, $employee_position, $employee_email, $employee_id);
    $stmt->execute();
    $stmt->close();
}

?>

<!DOCTYPE html>
<html lang="ar">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>إدارة الموظفين</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
</head>
<body>

<div class="container mt-5">
    <h2>قائمة الموظفين</h2>
    <table class="table table-bordered">
        <thead>
            <tr>
                <th>ID</th>
                <th>اسم الموظف</th>
                <th>المسمى الوظيفي</th>
                <th>البريد الإلكتروني</th>
                <th>الإجراءات</th>
            </tr>
        </thead>
        <tbody>
            <?php while ($row = $result->fetch_assoc()): ?>
                <tr>
                    <td><?php echo $row['id']; ?></td>
                    <td><?php echo $row['name']; ?></td>
                    <td><?php echo $row['position']; ?></td>
                    <td><?php echo $row['email']; ?></td>
                    <td>
                        <form style="display:inline;" method="post" action="manage_employees.php">
                            <input type="hidden" name="employee_id" value="<?php echo $row['id']; ?>">
                            <input type="hidden" name="employee_name" value="<?php echo $row['name']; ?>">
                            <input type="hidden" name="employee_position" value="<?php echo $row['position']; ?>">
                            <input type="hidden" name="employee_email" value="<?php echo $row['email']; ?>">
                            <button type="submit" name="edit" class="btn btn-warning btn-sm">تعديل</button>
                        </form>
                    </td>
                </tr>
            <?php endwhile; ?>
        </tbody>
    </table>
</div>

<script src="https://code.jquery.com/jquery-3.5.1.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.9.2/dist/umd/popper.min.js"></script>
<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
</body>
</html>

<?php
$conn->close();
?>
