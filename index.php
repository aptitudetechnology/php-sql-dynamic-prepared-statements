<?php
require_once "db1.php";

$sql ="SELECT TABLE_NAME FROM information_schema.TABLES WHERE TABLE_SCHEMA = 'blog_samples'"; 
$result = $mysqli->query($sql);

?>
<html>
<head>
        <link href="style.css" rel="stylesheet" type="text/css" />
        <title>Database</title>
</head>
<body>
<?php


echo '<label for="dbtables">Choose a database table to edit:</label>';
echo '<br>';
echo '<form action="list.php" method="post">';
echo '<select name="dbtables" id="dbtables">';
echo '<option value="none" selected disabled hidden>Select an Option</option>';

while($table = mysqli_fetch_array($result, MYSQLI_ASSOC))

 { // go through each row that was returned in $result
  
    echo '<option value="';
    echo $table['TABLE_NAME'];
    echo '">';
    echo $table['TABLE_NAME'];
    echo '</option>';
    
}

echo '</select>';
echo ' <input type="submit" name="submit"/>';
echo '</form>';
// Free memory by clearing result
$result->free();

// close connection 

$mysqli->close();

?>
</body>
</html>
                                         
