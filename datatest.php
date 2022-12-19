<?php
require_once "db.php";
//$arr = [66,67];
$stmt = $mysqli->prepare('SELECT * FROM tbl_emp_details');
$stmt->execute($arr);


//$stmt->store_result();
//printf("Number of rows: %d.\n", $stmt->num_rows)

$result = $stmt->get_result();

if ($result->num_rows > 0) {

    while ($row = mysqli_fetch_array($result)) {
        foreach ($row as $key => $value) {
            echo $key . " = " . $value;
            echo "<br>";
        }
        echo "<br>";
    }


}
   

?>


