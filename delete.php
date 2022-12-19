<?php 
    require_once "db.php";
    $dbtables = $_GET['dbtables']; 
    //$sql = $mysqli->prepare("DELETE FROM tbl_emp_details WHERE id=?");  
    $sql = $mysqli->prepare('DELETE FROM ' . $dbtables . ' WHERE id=?');  
    $sql->bind_param("i", $_GET["id"]); 
    $sql->execute();
    
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
    
    
    $sql->close(); 
    $mysqli->close();
    header('location:index.php');        
?>
