<?php 
include 'include/header.php';

// If post is from vieworders page then run this function.
if(isset($_POST['order_id'])){
$sql= 'SELECT OrderID, Classroom.ClassID, Student.SID, Course.CourseID, Student.SName, Course.CourseName, BankBranch, Status, Classroom.ClassDate, PaymentDate
FROM Orders
INNER JOIN Student ON Orders.SID = Student.SID
INNER JOIN Classroom ON Orders.ClassID = Classroom.ClassID
INNER JOIN Course ON Orders.CourseID = Course.CourseID
WHERE OrderID = '.$_POST['order_id'].';';

$result = mysqli_query($conn, $sql);
$row = mysqli_fetch_assoc($result);

$orderid = $row['OrderID'];
$classid = $row['ClassID'];
$sid = $row['SID'];
$courseid = $row['CourseID'];
$crdate = $row['ClassDate'];
$studentname = $row['SName'];
$coursename = $row['CourseName'];
$bankbranch = $row['BankBranch'];
$status = $row['Status'];
$paymentdate = $row['PaymentDate'];
}

// If edit button is pressed then run this function
if(isset($_POST['editbutton'])){

$orderid = $_POST['orderid'];
$classid = $_POST['classid'];
$sid = $_POST['sid'];
$courseid = $_POST['courseid'];
$studentname = $_POST['hiddenstudentname'];
$coursename = $_POST['hiddencoursename'];
$crdate = $_POST['crdate'];
$bankbranch = $_POST['bankbranch'];
$status = $_POST['status'];
$paymentdate = $_POST['paymentdate'];


$msg = updateOrder($orderid,$classid,$courseid,$sid,$bankbranch,$status,$crdate,$paymentdate);
}
?>
	<link rel="stylesheet" href="//cdnjs.cloudflare.com/ajax/libs/bootstrap-datepicker/1.3.0/css/datepicker.min.css" />
	<link rel="stylesheet" href="//cdnjs.cloudflare.com/ajax/libs/bootstrap-datepicker/1.3.0/css/datepicker3.min.css" />
        <div id="page-wrapper">
            <div class="row">
                <div class="col-lg-6">
                    <h1 class="page-header">Edit Request Form</h1>
                </div>
                <!-- /.col-lg-12 -->
            </div>
            <!-- /.row -->
            <div class="row">
                <div class="col-lg-6">
                    <div class="panel panel-default">
                        <div class="panel-heading">
                            Edit Request
                        </div>
                        <div class="panel-body">
                            <div class="row">
                                <div class="col-lg-6">
									<form role="form" method="post">
									<fieldset>

									<?php if(isset($msg)){echo $msg;} ?>
									<!-- Text input-->
									<input type="hidden" name="orderid" value="<?php echo $orderid ?>"/>
									<input type="hidden" name="classid" value="<?php echo $classid ?>"/>
									<input type="hidden" name="courseid" value="<?php echo $courseid ?>"/>
									<input type="hidden" name="sid" value="<?php echo $sid ?>"/>
									<input type="hidden" name="hiddenstudentname" value="<?php echo $studentname ?>"/>
									<input type="hidden" name="hiddencoursename" value="<?php echo $coursename ?>"/>
									<input type="hidden" name="crdate" value="<?php echo $crdate ?>"/>
									
                                    <div class="form-group">
										<label>Student Name</label>
										<input id="studentname" name="studentname" type="text" value="<?php echo $studentname ?>" class="form-control input-md" disabled /> 
                                    </div>
									
                                    <div class="form-group">
										<label>Course Name</label>
										<input id="coursename" name="coursename" type="text" value="<?php echo $coursename ?>" class="form-control input-md" disabled /> 
                                    </div>
									
                                    <div class="form-group">
										<label>Bank Branch</label>
										<input id="bankbranch" name="bankbranch" type="text" value="<?php echo $bankbranch ?>" class="form-control input-md" required="">
                                    </div>
									
                                    <div class="form-group">
										<label>Payment Date</label>
										<div class="input-group input-append date" id="datePicker">
											<input type="text" class="form-control" name="paymentdate" value="<?php echo $paymentdate ?>" class="form-control input-md" required=""/>
											<span class="input-group-addon add-on"><span class="glyphicon glyphicon-calendar"></span></span>
										</div>
                                    </div>
									
									<div class="form-group">
										<label>Status</label>
										 <select name="status" class="form-control">
										  <option value="Pending" 
										  <?php 
											if($status == "Pending"){
												echo "selected";
											}
										  ?>
										  >Pending</option>
										  <option value="Approved" 
										  <?php 
											if($status == "Approved"){
												echo "selected";
											}
										  ?>
										  >Approved</option>
										  <option value="Cancel" 
										  <?php 
											if($status == "Cancel"){
												echo "selected";
											}
										  ?>
										  >Cancel</option>
										</select>
									</div>
									
									<button type="submit" id="editbutton" name="editbutton" class="btn btn-default">Edit</button>
									<a href="viewOrder.php" class="btn btn-default" role="button">View Order</a>
									  </div>
									</div>

									</fieldset>
									</form>
                                </div>
								
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

    </div>

    <script src="../vendor/jquery/jquery.min.js"></script>

    <script src="../vendor/bootstrap/js/bootstrap.min.js"></script>

    <script src="../vendor/metisMenu/metisMenu.min.js"></script>
	
	<script src="//cdnjs.cloudflare.com/ajax/libs/bootstrap-datepicker/1.3.0/js/bootstrap-datepicker.min.js"></script>

    <script src="../dist/js/sb-admin-2.js"></script>

	<script>
	$(document).ready(function() {
		var date = new Date();
		var today = new Date(date.getFullYear(), date.getMonth(), date.getDate());
		$('#datePicker')
			.datepicker({
				autoclose: true,
				format: 'mm/dd/yyyy'
			})
			.on('changeDate', function(e) {
				// Revalidate the date field
				$('#eventForm').formValidation('revalidateField', 'date');
			});

		$('#eventForm').formValidation({
			framework: 'bootstrap',
			icon: {
				valid: 'glyphicon glyphicon-ok',
				invalid: 'glyphicon glyphicon-remove',
				validating: 'glyphicon glyphicon-refresh'
			},
			fields: {
				name: {
					validators: {
						notEmpty: {
							message: 'The name is required'
						}
					}
				},
				date: {
					validators: {
						notEmpty: {
							message: 'The date is required'
						},
						date: {
							format: 'MM/DD/YYYY',
							message: 'The date is not a valid'
						}
					}
				}
			}
		});
	});
	</script>
</body>

</html>
