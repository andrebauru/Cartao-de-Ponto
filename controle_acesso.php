
<?php
// Lista de IPs permitidos
$allowed_ips = ['123.456.789.000', '234.567.890.123'];

// IP do usuário
$user_ip = $_SERVER['REMOTE_ADDR'];

// Função para registrar IPs não autorizados
function log_unauthorized_ip($ip) {
    $logfile = 'logs/unauthorized_ips.log';
    $date = date('Y-m-d H:i:s');
    $log_entry = "$date - Unauthorized IP: $ip\n";
    file_put_contents($logfile, $log_entry, FILE_APPEND);
}

// Verifica se o IP está na lista de permitidos
if (!in_array($user_ip, $allowed_ips)) {
    log_unauthorized_ip($user_ip);
    header('HTTP/1.0 403 Forbidden');
    echo 'Acesso negado. Seu IP não está na lista de IPs permitidos.';
    exit;
}

// Redireciona a requisição para o arquivo original solicitado
$request_uri = $_SERVER['REQUEST_URI'];
$query_string = $_SERVER['QUERY_STRING'];
$request_uri = preg_replace('/\?.*/', '', $request_uri); // Remove a query string do URI

if (file_exists($request_uri)) {
    include $request_uri;
} else {
    header("HTTP/1.0 404 Not Found");
    echo 'Arquivo não encontrado.';
}
?>
