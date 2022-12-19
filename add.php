<?php

function RemovePar($StripValue)
{
        //echo 'preg_match found: ';
    if(preg_match('!\(([^\)]+)\)!', $StripValue, $match) ) {
        $text = $match[1];
    }
            return $text;
}    

      
if (isset($_POST['submit'])) {
    include_once "db.php";
        
    $dbtables = $_GET['dbtables'];    
    //$fields = ['department', 'name', 'email', 'age'];
    //$values = [ 'golf', 'lee', 'lee@golf.com', 66];
    

       $values = array_values($_POST);
       array_pop($values);
       $fields = array_keys($_POST);
       array_pop($fields);
        
       echo 'values<br>';
       print_r($values);
       echo 'fields<br>';
       print_r($fields);
        
    
    $stmt = $mysqli->prepare('INSERT INTO  ' . $dbtables . ' (' . implode(", ", $fields) . ')' . ' VALUES ' . '('.str_repeat('?,', count($fields) - 1) . '?)');
       
    //echo 'about to execute stmt<br>';
    $stmt->execute($values);
    echo 'executed stmt<br>'; 
    // echo 'about to render json<br>';
    
    $sqljson = "select * from " . $dbtables;
    $result = mysqli_query($mysqli, $sqljson) or die("Error in Selecting " . mysqli_error($connection));
    
    
    //create an array
    $emparray = array();
    while($row =mysqli_fetch_assoc($result))
    {
        $emparray[] = $row;
    }
    //echo json_encode($emparray);

   
    //write to json file
    $fp = fopen('json/' . $dbtables . '.json', 'w');
    fwrite($fp, json_encode($emparray));
    fclose($fp);


    //close the db connection
       
    $stmt->close();    
        
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
<link href="style.css" rel="stylesheet" type="text/css" />
    
  <title>Add New Record</title>     
</head>
<body>
<?php if(!empty($success_message)) { ?>
<div class="success message"><?php echo $success_message; ?></div>
<?php } if(!empty($error_message)) { ?>
<div class="error message"><?php echo $error_message; ?></div>
<?php } ?>


<?php
$dbtables = $_GET['dbtables'];
require_once "db.php";
$result = $mysqli->query("describe " . $dbtables);

$form = '<form name="frmUser" method="post" action="add.php?dbtables=';
$form .= $dbtables;
$form .= '">';
$form .= '<div class="button_link"><a href="index.php"> Back to List </a></div>
<table class="tbl-qa">
	<thead>
		<tr>
			<th colspan="2" class="table-header">Add New Record</th>
		</tr>
	</thead>
	<tbody>';
    

if ($result->num_rows > 0) {

    while ($row = $result->fetch_assoc()) {
        if ($row["Field"] != "id") {
            
        
            //testing associative array build
            $Fields[$row['Field']] = $row['Type'];

            $form .= '<tr class="table-row">';
            $form .= '<td><label>' . $row["Field"] . '</label></td>';
            
            switch ($row["Type"]) {
            case 'tinyint(1)':
                    // $dataparam .= 'i';
                     $form .= '<td><input type="hidden" name="' . $row["Field"] . '" value="0">'; 
                     $form .= '<input type="checkbox" value="1" name="' . $row["Field"] . '"></td>';
                break;
            case str_contains($row["Type"], 'varchar'):
                   //  $dataparam .= 's';
                     $text = RemovePar($row["Type"]);
                          
                if ($text >= 100) {
                          
                    $form .= '<td><input type="hidden" name="' . $row["Field"] . '" value="NULL">'; 
                    $form .= '<textarea name="' . $row["Field"] . '" rows="' .  (ceil($text / 23)) . '" cols="50">';
                        
                    $form .= '</textarea></td>';
                }
                else
                     {
                    $form .= '<td><input type="hidden" name="' . $row["Field"] . '" value="NULL">'; 
                    $form .= '<input type="text" name="' . $row["Field"] . '" class="txtField" maxlength="';
                    $form .= $text;
                    $form .= '"></td>';
                }
                break;
            case str_contains($row["Type"], 'decimal'):
                   // $dataparam .= 'i';
                    $num = RemovePar($row["Type"]);
                   // $form .= '<td><input type="hidden" name="' . $row["Field"] . '" value=0>'; 
                    $form .= '<td><input type="number" required name="' . $row["Field"] . '" min="0" step="0.01" class="txtField';
                    $form .= '"></td>';
                break;  
                 
            } //end switch
                        
            $form .= "</tr>";
        } // end if
    } // end while (fetch)

    
  
    $form .= '<tr class="table-row">';
    $form .= '<td colspan="2">';
    $form .= '<input type="submit" name="submit" value="Submit" class="demo-form-submit"></td></tr>';
    $form .= '</tbody></table></form>';
    
  

    echo $form;


}
$mysqli->close();

?>

</body>
</html>

