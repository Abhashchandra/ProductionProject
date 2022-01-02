<?php if($_settings->chk_flashdata('success')): ?>
	<?php 
session_start();
  $con = mysqli_connect('localhost','root','','expense_budget_db');
  if (isset($_POST['limit'])) {
  	$amount = $_POST['amount'];
  	$userid = $_POST['id'];
  	$sql = mysqli_query($con,"INSERT INTO expense_limit(user_id,amount) VALUES('$userid','$amount')");
  	if($sql == true){
  		 $_SESSION['Success']="Limit Added";
       header('Location: '.$_SERVER['REQUEST_URI']);
  	}
  	else{
       $_SESSION['error']="Limit Not Added";
       header('Location: '.$_SERVER['REQUEST_URI']);
  	}
  }






    ?>
<script>
	alert_toast("<?php echo $_settings->flashdata('success') ?>",'success')
</script>
<?php endif;?>
<div class="card card-outline card-primary">
	<div class="card-header">
		<h3 class="card-title">Expense Limit</h3>
		<div class="card-tools">
			<a href="javascript:void(0)" id="manage_limit" class="btn btn-flat btn-sm btn-primary"><span class="fas fa-plus"></span>  Set Your Limit</a>
		</div>
	</div>
	<div class="card-body">
		<div class="container-fluid">
        <div class="container-fluid">
    <?php 
               if(isset($_SESSION['Success']))
               {
                   echo "
                   <div class='alert alert-danger alert-dismissible' style='margin-top:20px;background:lightgreen;padding:20px;'>
                   <div  class='close fa fa-times-circle' data-dismiss='alert' aria-hidden='true'></div>
                   ".$_SESSION['Success']."
                   </div>
                   ";
                   unset($_SESSION['Success']);    
               }
               elseif(isset($_SESSION['error']))
               {
                   echo "
                   <div class='alert alert-danger alert-dismissible' style='margin-top:20px;background:red;color:white;padding:20px;'>
                   <div  class='close fa fa-times-circle' data-dismiss='alert' aria-hidden='true'></div>
                   ".$_SESSION['error']."
                   </div>
                   ";
                   unset($_SESSION['error']);       
               }
               ?>
			<table class="table table-bordered table-stripped">
			
				<thead>
					<tr>
						<th>#</th>
						<th>Expense on</th>
						<th>Total Expense</th>
						<th>Extra Expense</th>
					</tr>
				</thead>
				<tbody>
					<?php 
					$i = 1;
  $con = mysqli_connect('localhost','root','','expense_budget_db');
   $userid = $_settings->userdata('id');
   $lcheck = mysqli_query($con,"SELECT * FROM expense_limit where user_id = '$userid'");
   $l = mysqli_fetch_array($lcheck);
   if ($lcheck->num_rows == 1 ) {
   	$limit = $l['amount'];
   
    $sql = mysqli_query($con,"SELECT * from running_balance where balance_type = '2' and user_id = '$userid' and amount > '$limit' order by id DESC");
    while($row = mysqli_fetch_array($sql)){
      $amount = $row['amount'];
      $disamount = $amount - $limit;
      $catid = $row['category_id']; 
         $sqli = mysqli_query($con,"SELECT * from categories where id = '$catid'");
         $cat = mysqli_fetch_array($sqli);
         $catname = $cat['category']

        ?>
						<tr>
							<td class="text-center"><?php echo $i++; ?></td>
							<td><?php echo $catname; ?></td>
							<td><?php echo $amount ?></td>
							<td ><p class="m-0 text-right"><?php echo $disamount; ?></p></td>
							
						</tr>
					<?php 
      
    }
  }
    mysqli_close($con);
   ?>

				</tbody>
			</table>
		</div>
		</div>
	</div>
</div>
<script>
	$(document).ready(function(){
		$('#manage_limit').click(function(){
			uni_modal("<i class='fa fa-plus'></i> Set your Limit",'limit/manage_limit.php')
		})
		
	})
	
</script>