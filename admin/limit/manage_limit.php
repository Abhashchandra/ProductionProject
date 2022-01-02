<?php
require_once("../../config.php");
 $userid = $_settings->userdata('id');
$user = $conn->query("SELECT * FROM users where id ='".$_settings->userdata('id')."'");
foreach($user->fetch_array() as $k =>$v){
    $meta[$k] = $v;
}

?>
<style type="text/css">
    #submit{
        display: none;
    }
</style>
<div class="conteiner-fluid">
<?php 

  $con = mysqli_connect('localhost','root','','expense_budget_db');
$lcheck = mysqli_query($con,"SELECT * FROM expense_limit where user_id = '$userid'");

if ($lcheck->num_rows < 1) {?>
    <form action="limit/add_limit.php" method="post" >
    <input type="hidden" name ="id" value="<?php echo $userid; ?>">
    <div class="form-group">
        <label for="amount" class="control-label">Amount</label>
        <input type="number" name="amount"  class="form-control form text-right number" >
    </div>
    <input type="submit" name="limit" value="Save" style="color:white;background: blue;">
</form>
<?php }
else{
    $l = mysqli_fetch_array($lcheck);
$limit = $l['amount'];
?>
<form action="limit/add_limit.php" method="post" >
    <input type="hidden" name ="id" value="<?php echo $userid; ?>">
    <div class="form-group">
        <label for="amount" class="control-label">Amount</label>
        <input type="number" name="amount" value="<?php echo $limit; ?>"  class="form-control form text-right number" >
    </div>
    <input type="submit" name="limit_update" value="Save" style="color:white;background: blue;">
</form>

<?php }

 ?>    

</div>
