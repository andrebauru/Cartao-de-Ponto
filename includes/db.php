
<?php
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "sistema_trabalho";

$conn = new mysqli($servername, $username, $password, $dbname);

if ($conn->connect_error) {
    file_put_contents('logs/error.log', "接続に失敗しました: " . $conn->connect_error . "\n", FILE_APPEND);
    die("接続に失敗しました: " . $conn->connect_error);
}
?>
