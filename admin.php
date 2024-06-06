<?php
include 'includes/db.php';
session_start();

// Verifica se o usuário está logado e tem permissão de administrador
if (!isset($_SESSION['user_id']) || $_SESSION['role'] != 'admin') {
    header("Location: login.php");
    exit;
}

// Função para obter usuários
function get_users($conn) {
    $sql = "SELECT * FROM usuarios";
    return $conn->query($sql);
}

// Função para obter registros de trabalho
function get_work_records($conn) {
    $sql = "SELECT usuarios.nome, usuarios.codigo_cadastro, registros_trabalho.data, registros_trabalho.hora_entrada, registros_trabalho.hora_saida 
            FROM registros_trabalho 
            JOIN usuarios ON registros_trabalho.usuario_id = usuarios.id 
            ORDER BY registros_trabalho.data DESC";
    return $conn->query($sql);
}

$users = get_users($conn);
$work_records = get_work_records($conn);
?>

<!DOCTYPE html>
<html lang="ja">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>管理ページ</title>
    <link rel="stylesheet" href="css/estilo.css">
</head>
<body>
    <h2>管理ページ</h2>

    <section>
        <h3>ユーザー管理</h3>
        <table>
            <tr>
                <th>ID</th>
                <th>名前</th>
                <th>メール</th>
                <th>会社コード</th>
                <th>操作</th>
            </tr>
            <?php while ($user = $users->fetch_assoc()) { ?>
                <tr>
                    <td><?php echo $user['id']; ?></td>
                    <td><?php echo $user['nome']; ?></td>
                    <td><?php echo $user['email']; ?></td>
                    <td><?php echo $user['codigo_cadastro']; ?></td>
                    <td>
                        <a href="editar_usuario.php?id=<?php echo $user['id']; ?>">編集</a>
                        <a href="deletar_usuario.php?id=<?php echo $user['id']; ?>">削除</a>
                    </td>
                </tr>
            <?php } ?>
        </table>
        <a href="criar_usuario.php">新しいユーザーを作成する</a>
    </section>

    <section>
        <h3>勤務記録</h3>
        <table>
            <tr>
                <th>名前</th>
                <th>会社コード</th>
                <th>日付</th>
                <th>勤務開始時間</th>
                <th>勤務終了時間</th>
            </tr>
            <?php while ($record = $work_records->fetch_assoc()) { ?>
                <tr>
                    <td><?php echo $record['nome']; ?></td>
                    <td><?php echo $record['codigo_cadastro']; ?></td>
                    <td><?php echo $record['data']; ?></td>
                    <td><?php echo $record['hora_entrada']; ?></td>
                    <td><?php echo $record['hora_saida']; ?></td>
                </tr>
            <?php } ?>
        </table>
        <a href="exportar.php?formato=pdf">PDFにエクスポート</a>
        <a href="exportar.php?formato=xlsx">XLSXにエクスポート</a>
    </section>
</body>
</html>
