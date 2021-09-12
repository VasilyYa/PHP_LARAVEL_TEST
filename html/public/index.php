<h1>Hello World!!!</h1>

<?php
$host = 'mysql';
$user = 'dev';
$pass = 'dev';
$db = 'test';
?>

<h4>Testing MySQL connection from php via mysqli-driver...</h4>
<?php
$conn = new mysqli($host, $user, $pass);
if ($conn->connect_error) {
  echo "Connection failed: " . $conn->connect_error;
} else {
  echo "Connected to MySQL via mysqli-driver successfully!";
}
?>

<h4>Testing MySQL connection from php via pdo-driver...</h4>
<?php
$options = [
        PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
        PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC
];
$dsn = 'mysql:dbname='. $db . ';host=' . $host;
try {
$db = new PDO($dsn, $user, $pass, $options);
echo "Connected to MySQL via pdo-driver successfully!";
} catch (Exception $e) {
echo 'Connection failed: ' . $e->getMessage();
}


?>
