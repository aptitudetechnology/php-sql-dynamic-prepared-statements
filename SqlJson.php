  <?php
  require_once "db.php";
  function fsqljson()
  {
      echo 'about to render json<br>';
    
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
    
  }
    ?>
