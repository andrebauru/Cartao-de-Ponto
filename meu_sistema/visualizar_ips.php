<?php
// Função para ler o arquivo de log e retornar os IPs não autorizados
function get_unauthorized_ips() {
    $logfile = 'logs/unauthorized_ips.log';
    if (!file_exists($logfile)) {
        return [];
    }

    $lines = file($logfile, FILE_IGNORE_NEW_LINES | FILE_SKIP_EMPTY_LINES);
    $ips = [];
    foreach ($lines as $line) {
        if (preg_match('/(\d{4}-\d{2}-\d{2} \d{2}:\d{2}:\d{2}) - Unauthorized IP: (\d{1,3}\.\d{1,3}\.\d{1,3}\.\d{1,3})/', $line, $matches)) {
            $ips[] = ['date' => $matches[1], 'ip' => $matches[2]];
        }
    }
    return $ips;
}

$unauthorized_ips = get_unauthorized_ips();
?>

<!DOCTYPE html>
<html lang="ja">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>不正アクセス試行IP一覧</title>
    <link rel="stylesheet" href="css/estilo.css">
</head>
<body>
    <h2>不正アクセス試行IP一覧</h2>
    <table>
        <tr>
            <th>日時</th>
            <th>IPアドレス</th>
        </tr>
        <?php if (empty($unauthorized_ips)) { ?>
            <tr>
                <td colspan="2">不正アクセス試行IPはありません。</td>
            </tr>
        <?php } else { ?>
            <?php foreach ($unauthorized_ips as $entry) { ?>
                <tr>
                    <td><?php echo htmlspecialchars($entry['date']); ?></td>
                    <td><?php echo htmlspecialchars($entry['ip']); ?></td>
                </tr>
            <?php } ?>
        <?php } ?>
    </table>
</body>
</html>
