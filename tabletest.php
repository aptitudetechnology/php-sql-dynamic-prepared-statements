<?php

// create global connection using mysqli
mysqli_report(MYSQLI_REPORT_ERROR | MYSQLI_REPORT_STRICT);
$mysqli = mysqli_connect("localhost", "blog_samples", "Feat4321Belmont", "blog_samples", "3306");
$mysqli->set_charset('utf8mb4'); // always set the charset

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
        echo '<th class="table-header" width="20%">'.htmlspecialchars($column->name).'</th>';
    }
    echo '</tr>';
    echo '</thead>';
    // If there is data then display each row
    if ($data) {
        foreach ($data as $row) {
            echo '<tr>';
            foreach ($row as $cell) {
                echo '<td>'.htmlspecialchars($cell).'</td>';
            }
            echo '</tr>';
        }
    } else {
        echo '<tr><td colspan="'.$res->field_count.'">No records in the table!</td></tr>';
    }
    echo '</table>';
}

<html>
<head>
    <link href="style.css" rel="stylesheet" type="text/css" />
    <title>Employee</title>
</head>
<body>

outputMySQLToHTMLTable($mysqli, 'tbl_emp_details');
</body></html>




