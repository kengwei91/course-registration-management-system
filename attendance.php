<?php
include 'include/header.php';

	if(!isset($_SESSION['username']))
	{
		header( 'Location: lecturerlogin.php' );
	}
	
?>
<style>
.switch-field {
  font-family: "Lucida Grande", Tahoma, Verdana, sans-serif;
	overflow: hidden;
}

.switch-title {
  margin-bottom: 6px;
}

.switch-field input {
    position: absolute !important;
    clip: rect(0, 0, 0, 0);
    height: 1px;
    width: 1px;
    border: 0;
    overflow: hidden;
}

.switch-field label {
  float: left;
}

.switch-field label {
  display: inline-block;
  width: 60px;
  background-color: #e4e4e4;
  color: rgba(0, 0, 0, 0.6);
  font-size: 14px;
  font-weight: normal;
  text-align: center;
  text-shadow: none;
  padding: 6px 4px;
  border: 1px solid rgba(0, 0, 0, 0.2);
  -webkit-box-shadow: inset 0 1px 3px rgba(0, 0, 0, 0.3), 0 1px rgba(255, 255, 255, 0.1);
  box-shadow: inset 0 1px 3px rgba(0, 0, 0, 0.3), 0 1px rgba(255, 255, 255, 0.1);
  -webkit-transition: all 0.1s ease-in-out;
  -moz-transition:    all 0.1s ease-in-out;
  -ms-transition:     all 0.1s ease-in-out;
  -o-transition:      all 0.1s ease-in-out;
  transition:         all 0.1s ease-in-out;
}

.switch-field label:hover {
	cursor: pointer;
}

.switch-field input:checked + label {
  background-color: #A5DC86;
  -webkit-box-shadow: none;
  box-shadow: none;
}

.switch-field label:first-of-type {
  border-radius: 4px 0 0 4px;
}

.switch-field label:last-of-type {
  border-radius: 0 4px 4px 0;
}
</style>

<header id="head" class="secondary">
    <div class="container">
        <h1>Attendance</h1>
        <p>Easy Learn Easy Life.</p>
    </div>
</header>

    
<div class="container">
<h3>Student List</h3>
<p>
Student Attendance Record
</p>
<?php 

if(isset($_POST['class_id']) AND isset($_POST['crdate'])){
// To check classroom recorded attendance or not.
$sql= 'SELECT ClassID, CRDate 
FROM Attendance
WHERE ClassID = '.$_POST['class_id'].' AND CRDate = "'.$_POST['crdate'].'";';
$result = mysqli_query($conn, $sql);
	if($result){
		$classid = $_POST['class_id'];
		$crdate = $_POST['crdate'];
		
		// If this classroom is recorded then run this code
		if(mysqli_num_rows($result) > 0){
				echo getAttendanceLecturer($classid,$crdate);
		}else{
				echo getReservationLecturer($classid,$crdate);
		}
	}else{
		echo 'Query or Database server problem. Contact admin now!';
	}
}

// New or Edit record attendance
if(isset($_POST['record'])){
	if(isset($_POST['tableRow']) AND isset($_POST['lid'])){
		$tableRow = $_POST['tableRow'];
		if(strtotime($tableRow[0]['crdate']) == strtotime(date("m/d/Y"))){
			foreach($tableRow as $row){
				echo $message = insertAttendance($row['courseid'], $row['classid'], $row['sid'], $_POST['lid'], $row['attendance'], $row['crdate']);
			}
		}else{
				echo $message = '<div class="alert alert-warning">
									<strong>Warning!</strong> You cannot record attendance, as the session has not started yet!
								</div>';
		}
	}
}elseif(isset($_POST['edit'])){
	if(isset($_POST['tableRow'])){
		$tableRow = $_POST['tableRow'];
		foreach($tableRow as $row){
			$message = updateAttendance($row['sid'], $row['courseid'], $row['classid'], $row['attendance'], $row['crdate']);
		}	
		echo $message;
	}
}
?>


</div>

	<!-- JavaScript libs are placed at the end of the document so the pages load faster -->
	<script type='text/javascript' src='assets/js/jquery.min.js'></script>
	<script src="assets/js/bootstrap.min.js"></script>
	<script src="assets/js/dataTables.min.js"></script>
	
	<!--<script type="text/javascript">
		jQuery(document).ready(function(){
			jQuery('#attendanceTable').DataTable();
		});
	</script>-->

<?php
include 'include/footer.php';
?>
