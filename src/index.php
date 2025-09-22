<?php
ob_start(); 
include 'connect_db.php';

// เพิ่ม todo
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['title'])) {
    $title = $conn->real_escape_string($_POST['title']);
    $conn->query("INSERT INTO todos (title) VALUES ('$title')");
    header("Location: index.php");
    exit;
}
// ดึงรายการ todo ทั้งหมด
$result = $conn->query("SELECT * FROM todos ORDER BY created_at DESC");
?>

<!DOCTYPE html>
<html lang="th">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>สมุดบันทึกความจำ</title>
    <style>
        /* ตั้งค่าพื้นฐาน */
        body {
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            background-color: #f7f9fc;
            margin: 0;
            padding: 0;
        }

        .container {
            max-width: 600px;
            margin: 50px auto;
            background: #fff;
            padding: 30px 40px;
            border-radius: 15px;
            box-shadow: 0 5px 15px rgba(0,0,0,0.1);
        }

        h1 {
            text-align: center;
            color: #333;
        }

        form {
            display: flex;
            margin-bottom: 20px;
        }

        input[type="text"] {
            flex: 1;
            padding: 10px 15px;
            font-size: 16px;
            border: 1px solid #ccc;
            border-radius: 8px 0 0 8px;
            outline: none;
            transition: border 0.3s;
        }

        input[type="text"]:focus {
            border-color: #007BFF;
        }

        button {
            padding: 10px 20px;
            font-size: 16px;
            border: none;
            background-color: #007BFF;
            color: white;
            border-radius: 0 8px 8px 0;
            cursor: pointer;
            transition: background 0.3s;
        }

        button:hover {
            background-color: #0056b3;
        }

        ul {
            list-style: none;
            padding: 0;
        }

        li {
            display: flex;
            justify-content: space-between;
            align-items: center;
            background-color: #f1f3f6;
            margin-bottom: 10px;
            padding: 10px 15px;
            border-radius: 10px;
            transition: background 0.2s;
        }

        li:hover {
            background-color: #e2e6ea;
        }

        a {
            text-decoration: none;
            color: #007BFF;
            margin-left: 10px;
        }

        a:hover {
            text-decoration: underline;
        }

        @media (max-width: 500px) {
            .container {
                margin: 20px;
                padding: 20px;
            }

            form {
                flex-direction: column;
            }

            input[type="text"], button {
                border-radius: 8px;
                margin: 5px 0;
            }
        }
    </style>
</head>
<body>
    <div class="container">
        <h1>📝 สมุดบันทึกความจำ</h1>
        <form method="post">
            <input type="text" name="title" placeholder="เพิ่มบันทึกใหม่..." required>
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
        </ul>
    </div>
</body>
</html>
