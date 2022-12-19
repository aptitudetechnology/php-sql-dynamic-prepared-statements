<?php 
require_once "db.php";

$dbtables = $_POST['dbtables'];


function outputMySQLToHTMLTable(mysqli $mysqli, string $table)
{
    // Make sure that the table exists in the current database!
    $tableNames = array_column($mysqli->query('SHOW TABLES')->fetch_all(), 0);
    if (!in_array($table, $tableNames, true)) {
        throw new UnexpectedValueException('Unknown table name provided!');
    }
    $res = $mysqli->query('SELECT * FROM '.$table);
    $data = $res->fetch_all(MYSQLI_ASSOC);
    
    echo '<table class="tbl-qa">';
    // Display table header
    echo '<thead>';
    echo '<tr>';
    foreach ($res->fetch_fields() as $column) {
        echo '<th class="table-header" width="5%">'.htmlspecialchars($column->name).'</th>';
    }
    echo '</tr>';
    echo '</thead>';
    // If there is data then display each row
    if ($data) {
        foreach ($data as $row) {
            echo '<tr class="table-row">';
            foreach ($row as $cell) {
                echo '<td class="table-row">'.htmlspecialchars($cell).'</td>';
            }
            
            echo '<td class="table-row" colspan="2"><a href="edit.php?id=';
            echo $row['id'] . '&dbtables=' . $table . '" ';
            echo' class="link"><img title="Edit" src="icon/edit.png"/></a> <a href="delete.php?id=';
            echo $row['id'] . '&dbtables=' . $table . '" ';
            echo 'class="link"><img name="delete" id="delete" title="Delete" onclick="return confirm(\'Are you sure you want to delete\?\')" src="icon/delete.png"/></a>';
         
            echo '</td></tr>';
        }
    } else {
        echo '<tr class="table-row"><td class="table-row" colspan="'.$res->field_count.'">No records in the table!</td></tr>';
    }
    echo '</table>';
}
?>
<html>
<head>
    <link href="style.css" rel="stylesheet" type="text/css" />
    <title>Employee</title>
</head>
<body>
<?php
echo '<div class="button_link"><a href="add.php?dbtables=';
echo $dbtables;
echo '">Add New</a></div>';
outputMySQLToHTMLTable($mysqli, $dbtables);

?>
</body></html>


