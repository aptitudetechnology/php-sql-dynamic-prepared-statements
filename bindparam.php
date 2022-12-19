

<?php 

if (isset($_POST['submit'])) {

    echo 'submitted<br>';
    print_r($_POST);

    //https://phpdelusions.net/mysqli_examples/prepared_statement_with_in_clause
    $mysqli = new mysqli("localhost", "blog_samples", "password", "blog_samples"); 
    $array =  array('Finance', 'Joe', 'joe@test.com', 67, 1);
    print_r($array);
    $in  = str_repeat('?,', count($array) - 1) . '?';
    $sql = "INSERT INTO tbl_emp_details (department,name,email,age,retired) IN ($in)";
    $stmt  = $mysqli->prepare($sql);
    $types = str_repeat('s', count($array));
    $stmt->bind_param($types, ...$array);
    $Stmt->execute();
    //$result = $stmt->get_result(); // get the mysqli result
    //$data = $result->fetch_all(MYSQLI_ASSOC); // fetch data  

    /*if($Stmt->execute()) { echo '<br>win';

    $success_message = "Added Successfully";
    } else {
    $error_message = "Problem in Adding New Record ";
    echo '<br>fail';
    }*/
}


$form='<form name="frmUser" method="post" action="">

<table>
	<thead>
		<tr>
			<th colspan="2" class="table-header">Add New Employee</th>
		</tr>
	</thead>
	<tbody><tr class="table-row"><td><label>department</label></td><td><input type="text" name="department" class="txtField" maxlength="40"></td></tr><tr class="table-row"><td><label>name</label></td><td><input type="text" name="name" class="txtField" maxlength="50"></td></tr><tr class="table-row"><td><label>email</label></td><td><input type="text" name="email" class="txtField" maxlength="80"></td></tr><tr class="table-row"><td><label>age</label></td><td><input type="number" name="age" min="0" step="0.01" class="txtField"></td></tr><tr class="table-row"><td><label>retired</label></td><td><input type="hidden" name="retired" value="0"><input type="checkbox" value="1" name="retired"></td></tr><tr class="table-row">
			<td colspan="2"><input type="submit" name="submit" value="Submit" class="demo-form-submit"></td>
		</tr></tbody></table></form>sssii<br>(department,name,email,age,retired)';        
?>
<html><head><title>testing bindparam reflection class</title>
<link href="style.css" rel="stylesheet" type="text/css" />
</head>
<body>        
        <?php if(!empty($success_message)) { ?>
<div class="success message"><?php echo $success_message; ?></div>
        <?php } if(!empty($error_message)) { ?>
<div class="error message"><?php echo $error_message; ?></div>
        <?php } 


        echo $form;
        ?>
 

</body></html>
