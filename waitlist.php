<?php
include 'include/header.php';

	if(!isset($_SESSION['userid']))
	{
		header( 'Location: login.php' );
	}
?>
 
<header id="head" class="secondary">
    <div class="container">
        <h1>Waiting-List</h1>
        <p>Easy Learn Easy Life.</p>
    </div>
</header>

    
<div class="container">
<h3>Waiting List</h3>
<div class="alert alert-warning">
	<strong>Warning!</strong> Once the classroom is available, the system will automatically reserve for the classroom you desired.
</div>

<?php

//Display WaitList
echo getWaitList($_SESSION['userid']);

//Cancel SQL

if(isset($_POST['cancel'])){
	$wlid = $_POST['wlid'];
	echo deleteWaitList($wlid);
}

?>

</div>

	<!-- JavaScript libs are placed at the end of the document so the pages load faster -->
	<script type='text/javascript' src='assets/js/jquery.min.js'></script>
	<script src="assets/js/bootstrap.min.js"></script>
	<script src="assets/js/dataTables.min.js"></script>
	
	<script type="text/javascript">
		jQuery(document).ready(function(){
			jQuery('#wlTable').DataTable();
		});
	</script>
<?php
include 'include/footer.php';
?> 