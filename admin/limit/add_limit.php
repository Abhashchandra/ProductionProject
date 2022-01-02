<?php 
session_start();
  $con = mysqli_connect('localhost','root','','expense_budget_db');
  if (isset($_POST['limit'])) {
  	$amount = $_POST['amount'];
  	$userid = $_POST['id'];
    $sql_check = mysqli_query($con,"SELECT * from expense_limit where user_id = '$userid'");
  if ($sql_check->num_rows < 1) {
  	$sql = mysqli_query($con,"INSERT INTO expense_limit(user_id,amount) VALUES('$userid','$amount')");
  	if($sql == true){
  		 $_SESSION['Success']="Limit Added";
       header('Location: ' . $_SERVER['HTTP_REFERER']);
  	}
  	else{
       $_SESSION['error']="Limit Not Added";
      header('Location: ' . $_SERVER['HTTP_REFERER']);
  	}
  }
  else{
      $_SESSION['error']="Limit Already Added";
      header('Location: ' . $_SERVER['HTTP_REFERER']);

  }
}

if (isset($_POST['limit_update'])) {
    $amount = $_POST['amount'];
    $userid = $_POST['id'];
    $sql_check = mysqli_query($con,"SELECT * from expense_limit where user_id = '$userid'");
  if ($sql_check->num_rows == 1) {
    $sql = mysqli_query($con,"UPDATE expense_limit set amount = '".$amount."' where user_id = '$userid'");
    if($sql == true){
       $_SESSION['Success']="Limit Updated";
       header('Location: ' . $_SERVER['HTTP_REFERER']);
    }
    else{
       $_SESSION['error']="Limit Not Updated";
      header('Location: ' . $_SERVER['HTTP_REFERER']);
    }
  }
  else{
      $_SESSION['error']="Add Limit";
      header('Location: ' . $_SERVER['HTTP_REFERER']);

  }
}






    ?>