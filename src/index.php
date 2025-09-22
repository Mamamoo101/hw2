<?php
ob_start(); 
include 'connect_db.php';

// ค้นหา
$search = '';
if (isset($_GET['search'])) {
    $search = $conn->real_escape_string($_GET['search']);
}

// เพิ่ม todo
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['title'])) {
    $title = $conn->real_escape_string($_POST['title']);
    $conn->query("INSERT INTO todos (title) VALUES ('$title')");
    header("Location: index.php");
    exit;
}

// ดึงรายการ todo (กรองตาม search ถ้ามี)
$sql = "SELECT * FROM todos";
if ($search !== '') {
    $sql .= " WHERE title LIKE '%$search%'";
}
$sql .= " ORDER BY created_at DESC";

$result = $conn->query($sql);
?>

<!DOCTYPE html>
<html lang="th">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>บันทึกส่วนตัว</title>
<style>
/* โค้ด CSS แบบเดิม + ปรับ search bar */
body { font-family: Arial, sans-serif; background: #f7f9fc; }
.container { max-width: 600px; margin: 50px auto; background: #fff; padding: 30px; border-radius: 15px; box-shadow: 0 5px 15px rgba(0,0,0,0.1); }
h1 { text-align: center; }
form { display: flex; margin-bottom: 20px; }
input[type="text"] { flex: 1; padding: 10px; border: 1px solid #ccc; border-radius: 8px 0 0 8px; outline: none; }
button { padding: 10px 20px; border: none; background: #007BFF; color: #fff; border-radius: 0 8px 8px 0; cursor: pointer; }
button:hover { background: #0056b3; }
ul { list-style: none; padding: 0; }
li { display: flex; justify-content: space-between; align-items: center; background: #f1f3f6; margin-bottom: 10px; padding: 10px; border-radius: 10px; }
a { color: #007BFF; text-decoration: none; margin-left: 10px; }
a:hover { text-decoration: underline; }
.search-bar { margin-bottom: 15px; }
</style>
</head>
<body>
<div class="container">
    <h1>📝 เพิ่มรายการเขียนบันทึก</h1>

    <!-- Search Form -->
    <form method="get" class="search-bar">
        <input type="text" name="search" placeholder="ค้นหางาน..." value="<?= htmlspecialchars($search) ?>">
        <button type="submit">ค้นหา</button>
    </form>

    <!-- Add Todo Form -->
    <form method="post">
        <input type="text" name="title" placeholder="เพิ่มงานใหม่..." required>
        <button type="submit">เพิ่ม</button>
    </form>

    <ul>
        <?php while ($row = $result->fetch_assoc()): ?>
            <li>
                <?= htmlspecialchars($row['title']) ?>
                <span>
                    <a href="edit.php?id=<?= $row['id'] ?>">แก้ไข</a>
                    <a href="delete.php?id=<?= $row['id'] ?>" onclick="return confirm('ลบจริงหรือไม่?')">ลบ</a>
                </span>
            </li>
        <?php endwhile; ?>
        <?php if ($result->num_rows == 0) echo "<li>ไม่พบงาน</li>"; ?>
    </ul>
</div>
</body>
</html>
