<?php
require_once "db.php";
$arr = [66,67];
$stmt = $mysqli->prepare('SELECT * FROM tbl_emp_details WHERE id IN ('.str_repeat('?,', count($arr) - 1) . '?)');
$datatype = 'sssi';

$stmt->execute($arr);


//$stmt->store_result();
//printf("Number of rows: %d.\n", $stmt->num_rows)

$result = $stmt->get_result();

if ($result->num_rows > 0) {

    while ($row = $result->fetch_assoc()) {


        printf($row['id']);
        printf($row['name']);
        printf($row['department']);
        printf($row['email']);
        printf($row['age']);
    }

}
   

?>
