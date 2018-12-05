<?php
include 'include/header.php';

	if(!isset($_SESSION['username']))
	{
		header( 'Location: login.php' );
	}
	
$sid = $_SESSION['userid']; 
?>
<style>
.btn { padding: 10px 10px; }
.pay { float:left; }
.cancel { float:right; }
</style>
 
<header id="head" class="secondary">
    <div class="container">
        <h1>Request</h1>
        <p>Easy Learn Easy Life.</p>
    </div>
</header>

    
<div class="container">
<h3>Your Request</h3>

<?php

//Display classroom

echo getOrdersStudent($sid);


//Cancel Order
if(isset($_POST['cancel'])){
	$orderid = $_POST['order_id'];
	$classid = $_POST['class_id'];
	echo cancelOrders($orderid,$classid);
}

?>

</div>

	<!-- JavaScript libs are placed at the end of the document so the pages load faster -->
	<script type='text/javascript' src='assets/js/jquery.min.js'></script>
	<script src="assets/js/bootstrap.min.js"></script>
	<script src="assets/js/dataTables.min.js"></script>
	
	<script type="text/javascript">
		jQuery(document).ready(function(){
			jQuery('#orderTable').DataTable();
		});
	</script>
<?php
include 'include/footer.php';
?> 