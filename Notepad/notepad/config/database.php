<?php
$host = 'localhost';//Host adı.
$db   = 'notpad'; //Veritabanı adı.
$user = 'root'; //Kullanıcı adı.
$pass = ''; //Varsa şifre yoksa boş.
$charset = 'utf8mb4'; //Veri tabanı charseti.

$dsn = "mysql:host=$host;dbname=$db;charset=$charset";
$options = [
    PDO::ATTR_ERRMODE            => PDO::ERRMODE_EXCEPTION,
    PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
    PDO::ATTR_EMULATE_PREPARES   => false,
];

try {
    $pdo = new PDO($dsn, $user, $pass, $options);
} catch (\PDOException $e) {
    throw new \PDOException($e->getMessage(), (int)$e->getCode());
}
?>
