
<?php
include 'includes/db.php';
session_start();

if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit;
}

$sql = "SELECT usuarios.nome, registros_trabalho.data, registros_trabalho.hora_entrada, registros_trabalho.hora_saida FROM registros_trabalho JOIN usuarios ON registros_trabalho.usuario_id = usuarios.id ORDER BY registros_trabalho.data DESC";
$result = $conn->query($sql);
?>

<!DOCTYPE html>
<html lang="ja">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>社員レポート</title>
    <link rel="stylesheet" href="css/estilo.css">
</head>
<body>
    <h2>社員レポート</h2>
    <table>
        <tr>
            <th>名前</th>
            <th>日付</th>
            <th>勤務開始時間</th>
            <th>勤務終了時間</th>
        </tr>
        <?php while($row = $result->fetch_assoc()) { ?>
        <tr>
            <td><?php echo $row['nome']; ?></td>
            <td><?php echo $row['data']; ?></td>
            <td><?php echo $row['hora_entrada']; ?></td>
            <td><?php echo $row['hora_saida']; ?></td>
        </tr>
        <?php } ?>
    </table>
</body>
</html>
