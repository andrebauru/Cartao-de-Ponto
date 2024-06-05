
<?php
include 'includes/db.php';
session_start();

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $email = $_POST['email'];
    $senha = $_POST['senha'];

    $sql = "SELECT * FROM usuarios WHERE email = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("s", $email);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows > 0) {
        $user = $result->fetch_assoc();
        if (password_verify($senha, $user['senha'])) {
            $_SESSION['user_id'] = $user['id'];
            header("Location: index.php");
            exit;
        } else {
            $error = "パスワードが間違っています!";
        }
    } else {
        $error = "ユーザーが見つかりません!";
    }
}
?>

<!DOCTYPE html>
<html lang="ja">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>ログイン</title>
    <link rel="stylesheet" href="css/estilo.css">
</head>
<body>
    <h2>ログイン</h2>
    <?php if(isset($error)) { echo "<p>$error</p>"; } ?>
    <form method="POST">
        <label for="email">メールアドレス:</label>
        <input type="email" name="email" required>
        <label for="senha">パスワード:</label>
        <input type="password" name="senha" required>
        <button type="submit">ログイン</button>
    </form>
</body>
</html>
