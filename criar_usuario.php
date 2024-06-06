<?php
include 'includes/db.php';
session_start();

// Verifica se o usuário está logado e tem permissão de administrador
if (!isset($_SESSION['user_id']) || $_SESSION['role'] != 'admin') {
    header("Location: login.php");
    exit;
}

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $nome = $_POST['nome'];
    $email = $_POST['email'];
    $senha = password_hash($_POST['senha'], PASSWORD_DEFAULT);
    $codigo_cadastro = $_POST['codigo_cadastro'];
    $role = $_POST['role'];

    $sql = "INSERT INTO usuarios (nome, email, senha, codigo_cadastro, role) VALUES (?, ?, ?, ?, ?)";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("sssss", $nome, $email, $senha, $codigo_cadastro, $role);
    $stmt->execute();

    header("Location: admin.php");
    exit;
}
?>

<!DOCTYPE html>
<html lang="ja">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>ユーザー作成</title>
    <link rel="stylesheet" href="css/estilo.css">
</head>
<body>
    <h2>新しいユーザーを作成する</h2>
    <form method="POST">
        <label for="nome">名前:</label>
        <input type="text" name="nome" required>
        <label for="email">メール:</label>
        <input type="email" name="email" required>
        <label for="senha">パスワード:</label>
        <input type="password" name="senha" required>
        <label for="codigo_cadastro">会社コード:</label>
        <input type="text" name="codigo_cadastro" required>
        <label for="role">ロール:</label>
        <select name="role">
            <option value="user">ユーザー</option>
            <option value="admin">管理者</option>
        </select>
        <button type="submit">作成</button>
    </form>
</body>
</html>
