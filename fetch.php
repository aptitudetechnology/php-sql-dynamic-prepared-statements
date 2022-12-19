<html><head></head><body>
<?php
$link = mysqli_connect("localhost", "blog_samples", "Anml1234Asct", "blog_samples");

/* check connection */
if (mysqli_connect_errno()) {
    printf("Connect failed: %s\n", mysqli_connect_error());
    exit();
}

$query = "SELECT * FROM tbl_emp_details";

if ($result = mysqli_query($link, $query)) {

    /* Get field information for all fields */
    while ($finfo = mysqli_fetch_field($result)) {

        printf("<br>Name:     %s", $finfo->name);
        printf("<br>Table:    %s", $finfo->table);
        printf("<br>max. Len: %d", $finfo->max_length);
        printf("<br>Flags:    %d", $finfo->flags);
        printf("<br>Type:     %d", $finfo->type);
        echo "<br>";
    }
    mysqli_free_result($result);
}

/* close connection */
mysqli_close($link);
?>
</body>
</html>
