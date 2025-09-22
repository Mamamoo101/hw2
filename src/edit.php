<?php
ob_start(); 
include 'connect_db.php';

$id = intval($_GET['id']);

// อัปเดต todo
if ($_SERVER["REQUEST_METHOD"] === "POST" && isset($_POST['title'])) {
    $title = $conn->real_escape_string($_POST['title']);
    $conn->query("UPDATE todos SET title='$title' WHERE id=$id");
    header("Location: index.php");
    exit;
}

// ดึง todo เดิมมาแสดง
$result = $conn->query("SELECT * FROM todos WHERE id=$id");
$todo = $result->fetch_assoc();
?>

<!DOCTYPE html>
<html lang="th">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>แก้ไขงาน</title>
    <style>
        body {
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            background-color: #f7f9fc;
            margin: 0;
            padding: 0;
        }

        .container {
            max-width: 500px;
            margin: 80px auto;
            background: #fff;
            padding: 30px 40px;
            border-radius: 15px;
            box-shadow: 0 5px 15px rgba(0,0,0,0.1);
        }

        h1 {
            text-align: center;
            color: #333;
            margin-bottom: 25px;
        }

        form {
            display: flex;
            flex-direction: column;
        }

        input[type="text"] {
            padding: 12px 15px;
            font-size: 16px;
            border: 1px solid #ccc;
            border-radius: 10px;
            outline: none;
            margin-bottom: 20px;
            transition: border 0.3s;
        }

        input[type="text"]:focus {
            border-color: #007BFF;
        }

        button {
            padding: 12px;
            font-size: 16px;
            border: none;
            background-color: #28a745;
            color: white;
            border-radius: 10px;
            cursor: pointer;
            transition: background 0.3s;
        }

        button:hover {
            background-color: #218838;
        }

        .back-link {
            display: block;
            text-align: center;
            margin-top: 15px;
            color: #007BFF;
            text-decoration: none;
        }

        .back-link:hover {
            text-decoration: underline;
        }

        @media (max-width: 500px) {
            .container {
                margin: 20px;
                padding: 20px;
            }
        }
    </style>
</head>
<body>
    <div class="container">
        <h1>✏️ แก้ไขบันทึก</h1>
        <form method="post">
            <input type="text" name="title" value="<?= htmlspecialchars($todo['title']) ?>" required>
            <button type="submit">บันทึก</button>
        </form>
        <a class="back-link" href="index.php">⬅ กลับ</a>
    </div>
</body>
</html>
