
<?php
include 'includes/db.php';
session_start();

if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit;
}

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $acao = $_POST['acao'];
    $usuario_id = $_SESSION['user_id'];

    if ($acao == 'inicio') {
        $sql = "INSERT INTO registros_trabalho (usuario_id, data, hora_entrada) VALUES (?, CURDATE(), CURTIME())";
    } else if ($acao == 'encerramento') {
        $sql = "UPDATE registros_trabalho SET hora_saida = CURTIME() WHERE usuario_id = ? AND data = CURDATE() AND hora_saida IS NULL";
    }

    $stmt = $conn->prepare($sql);
    $stmt->bind_param("i", $usuario_id);
    if (!$stmt->execute()) {
        file_put_contents('logs/error.log', "勤務時間登録エラー: " . $stmt->error . "
", FILE_APPEND);
    }
}
?>

<!DOCTYPE html>
<html lang="ja">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>勤務時間登録</title>
    <link rel="stylesheet" href="css/estilo.css">
</head>
<body>
    <h2>勤務時間登録</h2>
    <form method="POST">
        <button type="submit" name="acao" value="inicio">勤務開始</button>
        <button type="submit" name="acao" value="encerramento">勤務終了</button>
    </form>
</body>
</html>
