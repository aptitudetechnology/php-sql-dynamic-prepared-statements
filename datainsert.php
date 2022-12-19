<?php
require_once "db.php";
$fields = ['department', 'name', 'email', 'age'];
$values = [ 'fishing', 'ben', 'ben@ben.com', 42];

$stmt = $mysqli->prepare('INSERT INTO tbl_emp_details ' . '(' . implode(", ", $fields) . ')' . ' VALUES ' . '('.str_repeat('?,', count($fields) - 1) . '?)');


$stmt->execute($values);


?>
