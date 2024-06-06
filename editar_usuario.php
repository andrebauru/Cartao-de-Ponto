<?php
include 'includes/db.php';
session_start();

// Verifica se o usuário está logado e tem permissão de administrador
if (!isset($_SESSION['user_id']) || $_SESSION['role'] != 'admin') {
    header("Location: login.php");
    exit;
}

$user_id = $_GET['id'];

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $nome = $_POST['nome'];
    $email = $_POST['email'];
    $codigo_cadastro = $_POST['codigo_cadastro'];
    $role = $_POST['role'];

    $sql = "UPDATE usuarios SET nome = ?, email = ?, codigo_cadastro = ?, role = ? WHERE id = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("ssssi", $nome, $email, $codigo_cadastro, $role, $user_id);
    $stmt->execute();

    header("Location: admin.php");
    exit;
} else {
    $sql = "SELECT * FROM usuarios WHERE id = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("i", $user_id);
    $stmt->execute();
    $result = $stmt->get_result();
    $user = $result->fetch_assoc();
}
?>

<!DOCTYPE html>
<html lang="ja">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>ユーザー編集</title>
    <link rel="stylesheet" href="css/estilo.css">
</head>
<body>
    <h2>ユーザー編集</h2>
    <form method="POST">
        <label for="nome">名前:</label>
        <input type="text" name="nome" value="<?php echo htmlspecialchars($user['nome']); ?>" required>
        <label for="email">メール:</label>
        <input type="email" name="email" value="<?php echo htmlspecialchars($user['email']); ?>" required>
        <label for="codigo_cadastro">会社コード:</label>
        <input type="text" name="codigo_cadastro" value="<?php echo htmlspecialchars($user['codigo_cadastro']); ?>" required>
        <label for="role">ロール:</label>
        <select name="role">
            <option value="user" <?php if ($user['role'] == 'user') echo 'selected'; ?>>ユーザー</option>
            <option value="admin" <?php if ($user['role'] == 'admin') echo 'selected'; ?>>管理者</option>
        </select>
        <button type="submit">保存</button>
    </form>
</body>
</html>
