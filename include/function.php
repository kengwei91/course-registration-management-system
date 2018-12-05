<?php 
session_start();
require 'dbConnect.php';

// Contact Mail
function contactmail($name, $email, $subject, $message){
	require 'PHPMailerAutoload.php';
	require 'mail.inc.php';
	
	$companyemail = 'uogfreecycle17@gmail.com';
	
	$mail->Subject = $subject;

	$mail->Body    = '<html>
					<body>
					<h1>Contact Message</h1>
					<p>From Email: '.$email.'</p>
					<p>Name: '.$name.'</p>
					<p>Message: ' . $message . '</p>
					</body>
					</html> 
					';

	$mail->AltBody = 'Contact Message Template';

	$mail->addAddress($companyemail);
	

	if($mail->send()){
		
		$msg = '<div class="alert alert-success">
				Your message has been sent.
			  </div>';
	}else{
		$msg = $mail->ErrorInfo;
	}
	return $msg;
} 

// Student Member Registration
function studentRegistration($username,$pass,$email,$name){
require 'dbConnect.php';	
     
	$insertsql='INSERT INTO Student (SName,SUsername,SPassword,SEmail) VALUES
		  ("'.$name.'","'.$username.'","'.$pass.'","'.$email.'");';
	$insertresult = mysqli_query($conn, $insertsql);

	if($insertresult){
		 
	$message =  sendverificationmail($username,$email);
	}else{
	$message =	'<div class="alert alert-danger">
				  Please Contact Admin! Something Went Wrong!
				</div>';
	}
	return $message;
}

function sendverificationmail($username,$email){
	require 'PHPMailerAutoload.php';
	require 'mail.inc.php';
	
	//Generate Activation Code - 5 digits
    $activationCode = substr(str_shuffle('0123456789'), 0, 5);
	
	// Set session at the following in order to let user activate their login account
	$_SESSION['activation-username'] = $username;
	$_SESSION['email'] = $email;
	$_SESSION['activationcode'] = $activationCode;
	
	$mail->Subject = 'Register Notification - IT Academy Asia Malaysia. ';

	$mail->Body    = '<html>
					<body>
					<h1>Register Verification</h1>
					<p>Thank you for register</p>
					<p>Activation code at the following:</p>
					<p>ACTIVATION CODE: ' . $_SESSION['activationcode'] . '</p>
					</body>
					</html> 
					';

	$mail->AltBody = 'Verification Template';

	$mail->addAddress($email);
	

	if($mail->send()){
		
		$msg = ("<script LANGUAGE='JavaScript'>
				window.alert('Verification Code Sent!');
				window.location ='./registerVerification.php';
				</script>");
	}else{
		$msg = $mail->ErrorInfo;
	}
	return $msg;
} 

// Student Login
function studentLogin($username,$password){
require 'dbConnect.php';
		
        $sqlstudent = 'SELECT * FROM Student WHERE SUsername="'.$username.'" AND SPassword="'.$password.'"';
		
		$resultstudent = mysqli_query($conn,$sqlstudent);
			if (mysqli_num_rows($resultstudent)==1){
				$row = mysqli_fetch_assoc($resultstudent);
				
				$activationstatus = $row['SActivation'];
				$email = $row['SEmail'];
				
				if($activationstatus == 0 ){
					$msg = sendverificationmail($username,$email);
				}else{
					
					$_SESSION['username'] = $row['SName'];
					$_SESSION['userid'] = $row['SID'];
					
					header( 'Location: course.php' );
				}
			}else{
				$errormsg = 'Username or Password incorrect!';
				$_SESSION['errorstudent'] = $errormsg;
			}
			return $msg;
}

// Student - Edit Student
 function seditprofile($sid,$sname,$spw){
	include 'dbConnect.php';

	$updatesql = 'UPDATE Student 
				SET SName = "'.$sname.'", SPassword = "'.$spw.'"
				WHERE SID = '.$sid.';';
	$update = mysqli_query($conn, $updatesql);
	
	if($update){

		$msg =  ' <div class="alert alert-success">
					<strong>Success!</strong> Successfully Edited.
				  </div>';
	}else{
		$msg = '  <div class="alert alert-danger">
					<strong>Danger!</strong> Please Contact Admin! Something went wrong.
				  </div>';
	}	
	echo $msg;
}

// Lecturer Login
function lecturerLogin($username,$password){
require 'dbConnect.php';
		
        $sqlLecturer = 'SELECT * FROM Lecturer WHERE LUsername="'.$username.'" AND LPassword="'.$password.'"';
		
		$resultLecturer = mysqli_query($conn,$sqlLecturer);
			if (mysqli_num_rows($resultLecturer)==1){
				$row = mysqli_fetch_assoc($resultLecturer);
					
					$_SESSION['username'] = $row['LName'];
					$_SESSION['Luserid'] = $row['LID'];
					
					header( 'Location: course.php' );
				
			}else{
				$errormsg = 'Username or Password incorrect!';
				$_SESSION['errorstudent'] = $errormsg;
			}
}

// Lecturer - Edit Lecturer
 function leditprofile($lid,$lname,$lpw){
	include 'dbConnect.php';

	$updatesql = 'UPDATE Lecturer 
				SET LName = "'.$lname.'", LPassword = "'.$lpw.'"
				WHERE LID = '.$lid.';';
	$update = mysqli_query($conn, $updatesql);
	
	if($update){

		$msg =  ' <div class="alert alert-success">
					<strong>Success!</strong> Successfully Edited.
				  </div>';
	}else{
		$msg = '  <div class="alert alert-danger">
					<strong>Danger!</strong> Please Contact Admin! Something went wrong.
				  </div>';
	}	
	echo $msg;
}

// Admin Login
function adminLogin($username,$password){
require 'dbConnect.php';
		
        $sqladmin = 'SELECT * FROM Admin WHERE AUsername="'.$username.'" AND APassword="'.$password.'"';
		
		$resultadmin = mysqli_query($conn,$sqladmin);
			if (mysqli_num_rows($resultadmin)==1){
				$row = mysqli_fetch_assoc($resultadmin);
					
					$_SESSION['Aname'] = $row['AName'];
					$_SESSION['Ausername'] = $username;
					$_SESSION['Auserid'] = $row['AID'];
					
					header( 'Location: index.php' );
				
			}else{
				$errormsg = 'Username or Password incorrect!';
				$_SESSION['erroradmin'] = $errormsg;
			}
}

// Admin - Edit Profile
 function aeditprofile($aid,$aname,$ausername,$apw){
	include 'dbConnect.php';

	$updatesql = 'UPDATE Admin 
				SET AName = "'.$aname.'", AUsername = "'.$ausername.'", APassword = "'.$apw.'"
				WHERE AID = '.$aid.';';
	$update = mysqli_query($conn, $updatesql);
	
	if($update){

		$msg =  ' <div class="alert alert-success">
					<strong>Success!</strong> Successfully Edited.
				  </div>';
	}else{
		$msg = '  <div class="alert alert-danger">
					<strong>Danger!</strong> Please Contact Admin! Something went wrong.
				  </div>';
	}	
	echo $msg;
}

// Get Course from Database
function getCourse($start_from,$per_page){
include 'dbConnect.php';
$sql= 'SELECT * FROM course LIMIT '.$start_from.','.$per_page.';';
$result = mysqli_query($conn, $sql);
if(isset($result)){
	if(mysqli_num_rows($result) > 0){
		echo '<div id="products" class="row list-group">';
		while($row = mysqli_fetch_assoc($result)){	
			echo '<div class="item  col-xs-4 col-lg-4">
				<div class="thumbnail">
					<img class="group list-group-image" src="http://placehold.it/400x250/000/fff&text='.$row["CourseName"].'" />
					<div class="caption">
						<h4 class="group inner list-group-item-heading">
							'.$row["CourseName"].'</h4>
						<p class="group inner list-group-item-text">
							'.$row["CourseDesc"].'</p>
						<div class="row">
							<div class="col-xs-12 col-md-6">
								<p class="lead">
									MYR '.$row["CoursePrice"].'</p>
							</div>
							<div class="col-xs-12 col-md-6">
							<form method="post" action="classroom.php">
							<div><input type="hidden" name="course_id" value="'.$row["CourseID"].'"/></div>
							<input class="btn btn-success" type="submit" name="view" value="View Sessions"/>
							</form>
							</div>
						</div>
					</div>
				</div>
			</div>';
			}
			echo '</div>';
			
			//Now select all from table
			$querypage = "SELECT * FROM Course;";

			$resultpage = mysqli_query($conn, $querypage);

			// Count the total records
			$total_records = mysqli_num_rows($resultpage);

			//Using ceil function to divide the total records on per page
			$total_pages = ceil($total_records / $per_page);
			
			//first page
			echo "<ul class='pagination'>
				 <li class='page-item'><a href='course.php?page=1'>".'<<'."</a></li>";

			for ($i=1; $i<=$total_pages; $i++) {

			echo "<li class='page-item'><a href='course.php?page=".$i."'>".$i."</a></li>";
			};
			// last page
			echo "<li class='page-item'><a href='course.php?page=$total_pages'>".'>>'."</a></li>
				</ul>";
		}
	}else{
		echo 'Error Database!';
	}
}

// Get Classroom from Database
function getClass($courseid){
include 'dbConnect.php';
$sql= 'SELECT ClassID, Course.CourseID, Course.CourseName, Slot, Capacity, Course.CoursePrice, Course.Session, Course.Hours, Location, StartTime, EndTime, ClassDate 
FROM Classroom
INNER JOIN Course ON Classroom.CourseID = Course.CourseID
WHERE Classroom.CourseID = '.$courseid.' And Classroom.ClassDate >= DATE_FORMAT(CURDATE(), "%m/%d/%Y");';
$result = mysqli_query($conn, $sql);
if(isset($result)){
	if(mysqli_num_rows($result) > 0){
		$view = '<table id="classroomTable" class="table table-striped custab">
				<thead>
					<tr>
						<th>Classroom ID</th>
						<th>Course Name</th>
						<th>Price</th>
						<th>Capacity</th>
						<th>Session</th>
						<th>Hours</th>
						<th>Location</th>
						<th>Start Time</th>
						<th>End Time</th>
						<th>Class Date</th>
						<th class="text-center">Action</th>
					</tr>
				</thead><tbody>';


		while($row = mysqli_fetch_assoc($result))
		{
		$view.= '<tr>
                <td>'.$row['ClassID'].'</td>
                <td width="30%">'.$row['CourseName'].'</td>
				<td>'.$row['CoursePrice'].'</td>
				<td>'.$row['Slot'].' / '.$row['Capacity'].'</td>
				<td>'.$row['Session'].'</td>
				<td>'.$row['Hours'].'</td>
				<td>'.$row['Location'].'</td>
				<td>'.$row['StartTime'].'</td>
				<td>'.$row['EndTime'].'</td>
				<td>'.$row['ClassDate'].'</td>
                <td width="50%">
				<form method="post" action="classroom.php">
				<div><input type="hidden" name="class_id" value="'.$row["ClassID"].'"/></div>
				<div><input type="hidden" name="course_id" value="'.$row["CourseID"].'"/></div>
				<div><input type="hidden" name="course_price" value="'.$row["CoursePrice"].'"/></div>
				<input class="btn btn-warning" type="submit" name="register" value="Register Class"/>&nbsp;';
		if($row['Capacity'] <= $row['Slot']){	
		$view.=	'<input class="btn btn-success" type="submit" name="waitlist" value="Waiting List"/>';
		}
		$view.=	'</form>
				</td>
				</tr>';
		}
		$view.= '</tbody></table>';
	}else{
		$view = '<div class="alert alert-danger">
				  No Class Available!
				</div>';
	}
}
else{$view = 'Database Connection Error.';
}
	return $view;
}

// Student - Insert classroom into orders table - Register Classroom
function insertOrders($classid,$courseid,$sid,$price){
	include 'dbConnect.php';
	
	// Turn off autocommit, in order to make every query run successfully
	mysqli_autocommit($conn,FALSE);
	
	// To validate whether the classroom is full or not
	$sql = 'SELECT * FROM Classroom
			WHERE ClassID = '.$classid.';';
	$result = mysqli_query($conn, $sql);
	$validate = mysqli_fetch_assoc($result);
	
	if($validate['Capacity'] > $validate['Slot']){
		$today = date("m/d/Y"); 
		$insertsql = 'INSERT INTO Orders (ClassID, CourseID, SID, Price, Status, BankBranch, OrderDate) 
		VALUES ('.$classid.', '.$courseid.', '.$sid.', "'.$price.'", "Pending", "Maybank", "'.$today.'")';
		$insert = mysqli_query($conn, $insertsql);
		
		if($insert){
			// Update classroom slot - Sum + 1
			$updatesql = 'UPDATE Classroom
						 SET Slot = Slot + 1
						 WHERE ClassID = '.$classid.';';
			$update = mysqli_query($conn, $updatesql);
			if($update){
			mysqli_commit($conn);
			$msg =  ("<script LANGUAGE='JavaScript'>
					window.alert('Succesfully Registered!');
					window.location ='./svieworder.php';
					</script>");
			}else{
			mysqli_rollback($conn);
			$msg = '  <div class="alert alert-danger">
						<strong>Warning!</strong> Failed to update the classroom. Please contact admin!
					  </div>';
			}
		}else{
			mysqli_rollback($conn);
			$msg = '  <div class="alert alert-danger">
						<strong>Danger!</strong> Please Contact Admin! Something went wrong.
					  </div>';
		}
	}else{
		$msg = '<div class="alert alert-warning">
					<strong>Warning!</strong> Classroom is already full!
				</div>';
	}
	echo $msg;
}

// Student - Cancel classroom from orders table - Register Classroom
function cancelOrders($orderid,$classid){
	include 'dbConnect.php';
	// Turn off autocommit, in order to make every query run successfully
	mysqli_autocommit($conn,FALSE);
	$message = '';
	// Delete selected record from class reservation
	$deletesql = 'DELETE FROM Orders
				  WHERE OrderID = '.$orderid.';';
	$deleteresult = mysqli_query($conn, $deletesql);
	if($deleteresult){
		// Update Classroom slot - Minus - 1
		$updatesql = 'UPDATE Classroom
					SET Slot = Slot - 1
					WHERE ClassID = '.$classid.';';
		$update = mysqli_query($conn, $updatesql);
		
		if($update){
			
			// WaitList
			$sqlclass = 'SELECT * FROM Classroom
						WHERE ClassID = '.$classid.';';
			$resultclass = mysqli_query($conn, $sqlclass);
			$rowclass = mysqli_fetch_assoc($resultclass);
			
			// If there are any free space for this session, run this function
			if($rowclass['Capacity'] > $rowclass['Slot']){	
				$sqlwl = 'SELECT WLID, Student.SID, Classroom.ClassID, Course.CourseID, Course.CoursePrice
						FROM waitinglist
						INNER JOIN Student ON waitinglist.SID = Student.SID
						INNER JOIN Classroom ON waitinglist.ClassID = Classroom.ClassID
						INNER JOIN Course ON waitinglist.CourseID = Course.CourseID
						WHERE Classroom.ClassID = '.$classid.' LIMIT 1;';
				$resultwl = mysqli_query($conn, $sqlwl);
				
				// To check is there any waiting list record for this session
				if(mysqli_num_rows($resultwl) > 0){	
					$rowwl = mysqli_fetch_assoc($resultwl);
					$today = date("m/d/Y");
					$insertsql = 'INSERT INTO Orders (SID, ClassID, CourseID, Price, Status, BankBranch, OrderDate) 
					VALUES ('.$rowwl['SID'].', '.$rowwl['ClassID'].', '.$rowwl['CourseID'].', "'.$rowwl['CoursePrice'].'", "Pending", "Maybank", "'.$today.'")';
					$insert = mysqli_query($conn, $insertsql);
					
					
					if ($insert){
						// Update Classroom slot - Plus 1
						$updatesql = 'UPDATE Classroom
									SET Slot = Slot + 1
									WHERE ClassID = '.$classid.';';
						$update = mysqli_query($conn, $updatesql);
						
						if($update){
							$deletesql = 'DELETE FROM Waitinglist
									WHERE WLID = '.$rowwl['WLID'].';';
							$delete = mysqli_query($conn, $deletesql);
							if($delete){
								mysqli_commit($conn);
								$message .=  ("<script LANGUAGE='JavaScript'>
									window.alert('Succesfully cancelled this order! (Other student has taken your place!)');
									window.location ='./svieworder.php';
									</script>");
							}else{
							mysqli_rollback($conn);
								$message .= '<div class="alert alert-danger">
											   Failed to delete waiting list
											</div>';
							} // Failed to delete waiting list
						}else{
							mysqli_rollback($conn);
							$message .= '<div class="alert alert-danger">
										   Failed to update waiting list
										</div>';
						} // Failed to update waiting list
					}else{
						mysqli_rollback($conn);
						$message .= '<div class="alert alert-danger">
									   Failed to insert new order
									</div>';
					} // Failed to insert the new order
				}else{
					mysqli_commit($conn);
					$message .=  ("<script LANGUAGE='JavaScript'>
						window.alert('Succesfully cancelled this order!');
						window.location ='./svieworder.php';
						</script>");
				} // Cancel Success but no waiting list for this session
			}else{
				mysqli_commit($conn);
				$message .=  ("<script LANGUAGE='JavaScript'>
					window.alert('Succesfully cancelled this order! (No Space Available for this session)');
					window.location ='./svieworder.php';
					</script>");
			} // Cancel Success but no more Space for this session
		}else{
		mysqli_rollback($conn);
		$message = '<div class="alert alert-danger">
					   Update Classroom failed! Contact admin immediately! - Cancel
					</div>';
		} // Failed to update the classroom	
	}else{
		mysqli_rollback($conn);
		$message = '<div class="alert alert-danger">
					   Cancel Order Failed! Contact admin immediately! - Cancel
					</div>';
	} // Failed to delete the order
	return $message;
}

// Student - Insert wait listing into orders table - Register Classroom
function insertWaitList($classid,$courseid,$sid){
	include 'dbConnect.php';
	// To validate whether the classroom is full or not
	$sql = 'SELECT * FROM Classroom
			WHERE ClassID = '.$classid.';';
	$result = mysqli_query($conn, $sql);
	$validate = mysqli_fetch_assoc($result);
			$today = date("m/d/Y"); 
			$insertsql = 'INSERT INTO waitinglist (SID, ClassID, CourseID, WLDate) 
			VALUES ('.$sid.', '.$classid.', '.$courseid.', "'.$today.'")';
			$insert = mysqli_query($conn, $insertsql);
		
		if($insert){

			$msg =  ("<script LANGUAGE='JavaScript'>
					window.alert('Succesfully Added to Waiting List');
					window.location ='./waitlist.php';
					</script>");
		}else{
			$msg = '  <div class="alert alert-danger">
						<strong>Danger!</strong> Please Contact Admin! Something went wrong.
					  </div>';
		}
		
	echo $msg;
}

// Student - Insert wait listing into orders table - Register Classroom
function deleteWaitList($wlid){
	include 'dbConnect.php';
	// To validate whether the classroom is full or not
	$deletesql = 'DELETE FROM Waitinglist
			WHERE WLID = '.$wlid.';';
	$delete = mysqli_query($conn, $deletesql);
	
		if($delete){
			$msg =  ("<script LANGUAGE='JavaScript'>
					window.alert('Succesfully Deleted Waiting List');
					window.location ='./waitlist.php';
					</script>");
					  
		}else{
			$msg = '  <div class="alert alert-danger">
						<strong>Danger!</strong> Please Contact Admin! Something went wrong.
					  </div>';
		}
		
	echo $msg;
}

// Get Class Reservation from Database * STUDENT VIEW TIMETABLE
function getReservation($studentid){
include 'dbConnect.php';
$sql= 'SELECT Student.SName, Course.CourseName, Course.Session, Course.Hours, Classroom.Location, Classroom.StartTime, Classroom.EndTime, Classroom.ClassDate, CRDate 
FROM ClassReservation
INNER JOIN Student ON ClassReservation.SID = Student.SID
INNER JOIN Classroom ON ClassReservation.ClassID = Classroom.ClassID
INNER JOIN Course ON ClassReservation.CourseID = Course.CourseID
WHERE ClassReservation.SID = '.$studentid.' And Classroom.ClassDate >= DATE_FORMAT(CURDATE(), "%m/%d/%Y");';
$result = mysqli_query($conn, $sql);
if(isset($result)){
	if(mysqli_num_rows($result) > 0){
		$view = '<table id="scheduleTable" class="table table-striped custab">
				<thead>
					<tr>
						<th>Student Name</th>
						<th>Course Name</th>
						<th>Session</th>
						<th>Hours</th>
						<th>Location</th>
						<th>Start Time</th>
						<th>End Time</th>
						<th>Class Date</th>
					</tr>
				</thead><tbody>';


		while($row = mysqli_fetch_assoc($result))
		{
		$view.= '<tr>
                <td>'.$row['SName'].'</td>
                <td>'.$row['CourseName'].'</td>
				<td>'.$row['Session'].'</td>
				<td>'.$row['Hours'].'</td>
				<td>'.$row['Location'].'</td>
				<td>'.$row['StartTime'].'</td>
				<td>'.$row['EndTime'].'</td>
				<td>'.$row['CRDate'].'</td>
            </tr>';
		}
		$view.= '</tbody></table>';
	}else{
		$view = '<div class="alert alert-danger">
				  Not yet register class!
				</div>';
	}
}else{
	$view = 'Database Connection Error.';
}
	return $view;
}

// Student - view orders 
function getOrdersStudent($sid){
include 'dbConnect.php';
$todayDate = date("m/d/Y");
$sql= 'SELECT OrderID, Classroom.ClassID, Student.SName, Course.CourseName, Price, BankBranch, Status, OrderDate, Classroom.ClassDate
FROM Orders
INNER JOIN Student ON Orders.SID = Student.SID
INNER JOIN Classroom ON Orders.ClassID = Classroom.ClassID
INNER JOIN Course ON Orders.CourseID = Course.CourseID
WHERE Orders.SID = '.$sid.' And Classroom.ClassDate >= DATE_FORMAT(CURDATE(), "%m/%d/%Y")
ORDER BY Orders.OrderDate DESC;';
$result = mysqli_query($conn, $sql);
	if(isset($result)){
		$view = '<table id="orderTable" class="table table-striped custab">
				<thead>
					<tr>
						<th>Student Name</th>
						<th>Course Name</th>
						<th>Price</th>
						<th>Bank Branch</th>
						<th>Status</th>
						<th>Class Date</th>
						<th>OrderDate</th>
						<th>Action</th>
					</tr>
				</thead><tbody>';

		while($row = mysqli_fetch_assoc($result))
		{
		$dt = strtotime($row['OrderDate']);
		$day = date("l", $dt);
		$view.= '<tr>
                <td>'.$row['SName'].'</td>
                <td>'.$row['CourseName'].'</td>
				<td>'.$row['Price'].'</td>
				<td>'.$row['BankBranch'].'</td>
				<td>'.$row['Status'].'</td>
				<td>'.$row['ClassDate'].'</td>
				<td>'.$row['OrderDate'].' / ('.$day.')</td>
				<td>';
		if($row['Status'] == "Pending"){
		$view.=	'<form method="post" action="payinfo.php" class="pay form-inline pull-left">
				<div><input type="hidden" name="order_id" value="'.$row["OrderID"].'"/></div>
				<input class="btn btn-success" type="submit" name="pay_now" value="Pay Now!"/>
				</form>
				<form method="post" action="svieworder.php" class="cancel form-inline pull-left">
				<div><input type="hidden" name="order_id" value="'.$row["OrderID"].'"/></div>
				<div><input type="hidden" name="class_id" value="'.$row["ClassID"].'"/></div>
				<input class="btn btn-danger" type="submit" name="cancel" value="Cancel"/>
				</form>';
		}
		$view.=	'</td>
            </tr>';
		}
		$view.= '</tbody></table>';
	}else{
	$view = 'Database Connection Error.';
}
	return $view;
}

// Student - view waitlist 
function getWaitList($sid){
include 'dbConnect.php';
$todayDate = date("m/d/Y");
$sql= 'SELECT WLID, Student.SName, Course.CourseName, Course.Session, Course.Hours, Classroom.Location, Classroom.StartTime, Classroom.EndTime, Classroom.ClassDate, Course.CoursePrice, WLDate
FROM Waitinglist
INNER JOIN Student ON Waitinglist.SID = Student.SID
INNER JOIN Classroom ON Waitinglist.ClassID = Classroom.ClassID
INNER JOIN Course ON Waitinglist.CourseID = Course.CourseID
WHERE Waitinglist.SID = '.$sid.' And Classroom.ClassDate >= DATE_FORMAT(CURDATE(), "%m/%d/%Y");';
$result = mysqli_query($conn, $sql);
	if(isset($result)){
		$view = '<table id="wlTable" class="table table-striped custab">
				<thead>
					<tr>
						<th>Student Name</th>
						<th>Course Name</th>
						<th>Price</th>
						<th>Session</th>
						<th>Hours</th>
						<th>Location</th>
						<th>Start Time</th>
						<th>End Time</th>
						<th>WaitList Date</th>
						<th>Action</th>
					</tr>
				</thead><tbody>';

		while($row = mysqli_fetch_assoc($result))
		{
		$dt = strtotime($row['WLDate']);
		$day = date("l", $dt);
		$view.= '<tr>
                <td>'.$row['SName'].'</td>
                <td>'.$row['CourseName'].'</td>
				<td>'.$row['CoursePrice'].'</td>
				<td>'.$row['Session'].'</td>
				<td>'.$row['Hours'].'</td>
				<td>'.$row['Location'].'</td>
				<td>'.$row['StartTime'].'</td>
				<td>'.$row['EndTime'].'</td>
				<td>'.$row['WLDate'].' / ('.$day.')</td>
				<td>
				<form method="post" action="waitlist.php">
				<div><input type="hidden" name="wlid" value="'.$row["WLID"].'"/></div>
				<input class="btn btn-danger" type="submit" name="cancel" value="Cancel"/>
				</form>
				</td>
            </tr>';
		}
		$view.= '</tbody></table>';
	}else{
	$view = 'Database Connection Error.';
}
	return $view;
}

// Get Course from Database - Lecturer
function getCourseLecturer($lecturerid,$start_from,$per_page){
include 'dbConnect.php';
$sql= 'SELECT * FROM course WHERE LID = '.$lecturerid.' LIMIT '.$start_from.','.$per_page.';';
$result = mysqli_query($conn, $sql);
if(isset($result)){
	if(mysqli_num_rows($result) > 0){
		echo '<div id="products" class="row list-group">';
		while($row = mysqli_fetch_assoc($result)){	
			echo '<div class="item  col-xs-4 col-lg-4">
				<div class="thumbnail">
					<img class="group list-group-image" src="http://placehold.it/400x250/000/fff&text='.$row["CourseName"].'" />
					<div class="caption">
						<h4 class="group inner list-group-item-heading">
							'.$row["CourseName"].'</h4>
						<p class="group inner list-group-item-text">
							'.$row["CourseDesc"].'</p>
						<div class="row">
							<div class="col-xs-12 col-md-6">
								<p class="lead">
									MYR '.$row["CoursePrice"].'</p>
							</div>
							<div class="col-xs-12 col-md-6">
							<form method="post" action="classroom.php">
							<div><input type="hidden" name="course_id" value="'.$row["CourseID"].'"/></div>
							<input class="btn btn-success" type="submit" name="view" value="View Sessions"/>
							</form>
							</div>
						</div>
					</div>
				</div>
			</div>';
			}
			echo '</div>';
			
			//Now select all from table
			$querypage = 'SELECT * FROM Course WHERE LID = '.$lecturerid.';';

			$resultpage = mysqli_query($conn, $querypage);

			// Count the total records
			$total_records = mysqli_num_rows($resultpage);

			//Using ceil function to divide the total records on per page
			$total_pages = ceil($total_records / $per_page);
			
			//first page
			echo "<ul class='pagination'>
				 <li class='page-item'><a href='course.php?page=1'>".'<<'."</a></li>";

			for ($i=1; $i<=$total_pages; $i++) {

			echo "<li class='page-item'><a href='course.php?page=".$i."'>".$i."</a></li>";
			};
			// last page
			echo "<li class='page-item'><a href='course.php?page=$total_pages'>".'>>'."</a></li>
				</ul>";
		}
	}else{
		echo 'Error Database!';
	}
}

// Get Classroom from Database - Lecturer
function getClassLecturer($courseid){
include 'dbConnect.php';
$sql= 'SELECT ClassID, Course.CourseName, Slot, Capacity, Course.CoursePrice, Course.Session, Course.Hours, Location, StartTime, EndTime, ClassDate 
FROM Classroom
INNER JOIN Course ON Classroom.CourseID = Course.CourseID
WHERE Classroom.CourseID = '.$courseid.' And Classroom.ClassDate >= DATE_FORMAT(DATE_SUB(NOW(), INTERVAL 7 DAY), "%m/%d/%Y");';
$result = mysqli_query($conn, $sql);
if(isset($result)){
	if(mysqli_num_rows($result) > 0){
		$view = '<table id="classroomTable" class="table table-striped custab">
				<thead>
					<tr>
						<th>Classroom ID</th>
						<th>Course Name</th>
						<th>Capacity</th>
						<th>Day/s</th>
						<th>Hours</th>
						<th>Location</th>
						<th>Start Time</th>
						<th>End Time</th>
						<th>Class Date</th>
						<th class="text-center">Action</th>
					</tr>
				</thead>
				<tbody>';


		while($row = mysqli_fetch_assoc($result))
		{
		$view.= '<tr>
                <td>'.$row['ClassID'].'</td>
                <td>'.$row['CourseName'].'</td>
				<td>'.$row['Slot'].' / '.$row['Capacity'].'</td>
				<td>'.$row['Session'].'</td>
				<td>'.$row['Hours'].'</td>
				<td>'.$row['Location'].'</td>
				<td>'.$row['StartTime'].'</td>
				<td>'.$row['EndTime'].'</td>
				<td>'.$row['ClassDate'].'</td>
				<td>
				<input class="btn btn-success view_data" type="button" name="view" id="'.$row['ClassID'].'" value="Record Attendance"/>
				</td>
            </tr>';
		}
		$view.= '</tbody></table>';
	}else{
		$view = '<div class="alert alert-danger">
				  No Class Available!
				</div>';
	}
}else{$view = 'Database Connection Error.';
}
	return $view;
}

// Insert Attendance
function insertAttendance($courseid,$classid,$sid,$lid,$attendance,$crdate){
	include 'dbConnect.php';
	$insertsql = 'INSERT INTO Attendance (SID, LID, ClassID, CourseID, CRDate, Attendance_Status) 
	VALUES ('.$sid.', '.$lid.', '.$classid.', '.$courseid.', "'.$crdate.'", "'.$attendance.'")';
	$insert = mysqli_query($conn, $insertsql);
	
	if($insert){
		$message = '<div class="alert alert-success">
						<strong>Success!</strong> Attendance Recorded!
					  </div>
					<div><a href="course.php" class="btn btn-danger btn-lg active" role="button" aria-pressed="true">View Course</a></div>  
					  ';
	}else{
		$message = '<div class="alert alert-danger">
						<strong>Danger!</strong> Please Contact Admin! Something went wrong.
					  </div>';
	}
	return $message;
}

// Update Attendance
function updateAttendance($sid,$courseid,$classid,$attendance,$crdate){
	include 'dbConnect.php';
	$updatesql = 'UPDATE Attendance
	SET Attendance_Status = "'.$attendance.'"
	WHERE ClassID = '.$classid.' AND CourseID = '.$courseid.' AND SID = '.$sid.' AND CRDate = "'.$crdate.'";';
	$update = mysqli_query($conn, $updatesql);
	
	if($update){
		$message = '<div class="alert alert-success">
						<strong>Success!</strong> Attendance Edited!
					  </div>
					<div><a href="course.php" class="btn btn-danger btn-lg active" role="button" aria-pressed="true">View Course</a></div>  
					  ';
	}else{
		$message = '<div class="alert alert-danger">
						<strong>Danger!</strong> Please Contact Admin! Something went wrong.
					  </div>';
	}
	return $message;
}

// Lecturer - Get Reservation from database - For lecturer to view student list and make attendance record
function getAttendanceLecturer($classid,$crdate){
include 'dbConnect.php';
$sql= 'SELECT Student.SID, Classroom.ClassID, Course.CourseID, Student.SName, Course.CourseName, Classroom.Location, Classroom.StartTime, Classroom.EndTime, CRDate, Attendance_Status 
FROM Attendance
INNER JOIN Student ON Attendance.SID = Student.SID
INNER JOIN Classroom ON Attendance.ClassID = Classroom.ClassID
INNER JOIN Course ON Attendance.CourseID = Course.CourseID
WHERE Classroom.ClassID = '.$classid.'
AND CRDate = "'.$crdate.'";';
$result = mysqli_query($conn, $sql);
$table = 'Attendance';
$link = exportToCsv($sql,$table,$conn);
if(isset($result)){
	if(mysqli_num_rows($result) > 0){
		$view = '<div class="alert alert-warning">
						<strong>Warning!</strong> You have recorded this classroom before. You can only edit this attendance!
				</div>
				<form method="post" action="attendance.php">
				<table id="attendanceTable" class="table table-striped custab">
				<thead>
					<tr>
						<th>Student Name</th>
						<th>Course Name</th>
						<th>Location</th>
						<th>Start Time</th>
						<th>End Time</th>
						<th>Class Date</th>
						<th>Attendance</th>
					</tr>
				</thead><tbody>';
		$count = 0;
		while($row = mysqli_fetch_assoc($result))
		{
		$dt = strtotime($row['CRDate']);
		$day = date("l", $dt);
		
		$view.= '<tr>
                <td>'.$row['SName'].'</td>
                <td>'.$row['CourseName'].'</td>
				<td>'.$row['Location'].'</td>
				<td>'.$row['StartTime'].'</td>
				<td>'.$row['EndTime'].'</td>
				<td>'.$row['CRDate'].' / ('.$day.')</td>
				<td>
				<div class="switch-field">';
		if($row['Attendance_Status'] == 'Present'){
			$view.= '<input type="radio" id="switch_left'.$count.'" name="tableRow['.$count.'][attendance]" value="Present" checked/>';
		}else{
			$view.= '<input type="radio" id="switch_left'.$count.'" name="tableRow['.$count.'][attendance]" value="Present" />';
		}
		$view.=	'<label for="switch_left'.$count.'">Present</label>';
		if($row['Attendance_Status'] == 'Absent'){
			$view.=	'<input type="radio" id="switch_right'.$count.'" name="tableRow['.$count.'][attendance]" value="Absent" checked/>';
		}else{
			$view.=	'<input type="radio" id="switch_right'.$count.'" name="tableRow['.$count.'][attendance]" value="Absent" />';
		}
		$view.=	'<label for="switch_right'.$count.'">Absent</label>
				</div>
				</td>
				</tr>
				<div><input type="hidden" name="tableRow['.$count.'][sid]" value="'.$row["SID"].'"/></div>
				<div><input type="hidden" name="tableRow['.$count.'][classid]" value="'.$row["ClassID"].'"/></div>
				<div><input type="hidden" name="tableRow['.$count.'][courseid]" value="'.$row["CourseID"].'"/></div>
				<div><input type="hidden" name="tableRow['.$count.'][crdate]" value="'.$row["CRDate"].'"/></div>';
		$count++;
		}
		$view.= '</tbody></table>
				<input class="btn btn-warning" type="submit" name="edit" value="Edit Attendance"/>
				</form>
				</br>
				<a class="btn btn-success" href='.$link.'>Export to Excel</a>
				';
				
	}else{
		$view = '<div class="alert alert-danger">
				  No student register this class yet!
				</div>';
	}
}else{
	$view = 'Database Connection Error.';
}
	return $view;
}

function exportToCsv($query,$table, $conn)
{
	$conn->set_charset("utf8");
	$csv  = $table . "-" . date('d-m-Y-his') . '.csv';
	$file = fopen($csv, 'w');
	// Get the table
	if (!$mysqli_result = mysqli_query($conn, $query))
		printf("Error: %s\n", $conn->error);
		// Get column names 
		while ($column = mysqli_fetch_field($mysqli_result)) {
			$column_names[] = $column->name;
		}
	// Write column names in csv file
	if (!fputcsv($file, $column_names))
		die('Can\'t write column names in csv file');
	
	// Get table rows
	while ($row = mysqli_fetch_row($mysqli_result)) {
		// Write table rows in csv files
		if (!fputcsv($file, $row))
			die('Can\'t write rows in csv file');
	}
	fclose($file);
	return $csv;
}

// Lecturer - Get Reservation from database - For lecturer to view student list and make attendance record
function getReservationLecturer($classid,$crdate){
include 'dbConnect.php';
$sql= 'SELECT Student.SID, Classroom.ClassID, Course.CourseID, Student.SName, Course.CourseName, Classroom.Location, Classroom.StartTime, Classroom.EndTime, CRDate 
FROM ClassReservation
INNER JOIN Student ON ClassReservation.SID = Student.SID
INNER JOIN Classroom ON ClassReservation.ClassID = Classroom.ClassID
INNER JOIN Course ON ClassReservation.CourseID = Course.CourseID
WHERE Classroom.ClassID = '.$classid.'
AND CRDate = "'.$crdate.'";';
$result = mysqli_query($conn, $sql);
if(isset($result)){
	if(mysqli_num_rows($result) > 0){
		$view = '<form method="post" action="attendance.php">
				<table class="table table-striped custab">
				<thead>
					<tr>
						<th>Student Name</th>
						<th>Course Name</th>
						<th>Location</th>
						<th>Start Time</th>
						<th>End Time</th>
						<th>Class Date</th>
						<th>Attendance</th>
					</tr>
				</thead><tbody>';

		$count = 0;
		while($row = mysqli_fetch_assoc($result))
		{
		$dt = strtotime($row['CRDate']);
		$day = date("l", $dt);
		
		$view.= '<tr>
                <td>'.$row['SName'].'</td>
                <td>'.$row['CourseName'].'</td>
				<td>'.$row['Location'].'</td>
				<td>'.$row['StartTime'].'</td>
				<td>'.$row['EndTime'].'</td>
				<td>'.$row['CRDate'].' / ('.$day.')</td>
				<td>
				<div class="switch-field">
				  <input type="radio" id="switch_left'.$count.'" name="tableRow['.$count.'][attendance]" value="Present" checked/>
				  <label for="switch_left'.$count.'">Present</label>
				  <input type="radio" id="switch_right'.$count.'" name="tableRow['.$count.'][attendance]" value="Absent" />
				  <label for="switch_right'.$count.'">Absent</label>
				</div>
				</td>
				</tr>
				<div><input type="hidden" name="tableRow['.$count.'][sid]" value="'.$row["SID"].'"/></div>
				<div><input type="hidden" name="tableRow['.$count.'][classid]" value="'.$row["ClassID"].'"/></div>
				<div><input type="hidden" name="tableRow['.$count.'][courseid]" value="'.$row["CourseID"].'"/></div>
				<div><input type="hidden" name="tableRow['.$count.'][crdate]" value="'.$row["CRDate"].'"/></div>';
		$count++;
		}
		$view.= '</tbody></table>
				<div><input type="hidden" name="lid" value="'.$_SESSION["Luserid"].'"/></div>
				<input class="btn btn-success" type="submit" name="record" value="Record Attendance"/>
				</form>';
	}else{
		$view = '<div class="alert alert-danger">
				  No student register this class yet!
				</div>';
	}
}else{
	$view = 'Database Connection Error.';
}
	return $view;
}

// Lecturer - Display Modal Session
if(isset($_POST["class_session_id"]))  
{  
$classid = $_POST["class_session_id"];
$sql= 'SELECT Classroom.ClassID, Course.CourseName, Course.Session, Course.Hours, Classroom.Location, Classroom.StartTime, Classroom.EndTime, CRDate 
FROM ClassReservation
INNER JOIN Student ON ClassReservation.SID = Student.SID
INNER JOIN Classroom ON ClassReservation.ClassID = Classroom.ClassID
INNER JOIN Course ON ClassReservation.CourseID = Course.CourseID
WHERE Classroom.ClassID = '.$classid.'
GROUP BY CRDate;';
$result = mysqli_query($conn, $sql);
if(isset($result)){
	if(mysqli_num_rows($result) > 0){
		$view = '<table class="table table-striped custab">
				<thead>
					<tr>
						<th>Course Name</th>
						<th>Location</th>
						<th>Start Time</th>
						<th>End Time</th>
						<th>Class Date</th>
						<th>Action</th>
					</tr>
				</thead><tbody>';
		while($row = mysqli_fetch_assoc($result))
		{
		$dt = strtotime($row['CRDate']);
		$day = date("l", $dt);
		$view.= '<tr>
                <td>'.$row['CourseName'].'</td>
				<td>'.$row['Location'].'</td>
				<td>'.$row['StartTime'].'</td>
				<td>'.$row['EndTime'].'</td>
				<td>'.$row['CRDate'].' / ('.$day.')</td>
				<td>
				<form method="post" action="attendance.php">
				<div><input type="hidden" name="class_id" value="'.$row["ClassID"].'"/></div>
				<div><input type="hidden" name="crdate" value="'.$row["CRDate"].'"/></div>
				<input class="btn btn-success" type="submit" name="view" value="View Student"/>
				</form>
				</td>
            </tr>';
		}
		$view.= '</tbody></table>';
	}else{
		$view = '<div class="alert alert-danger">
				  No students register yet.
				</div>';
	}
}else{
	$view = 'Database Connection Error.';
}
	echo $view;
 }

// Admin - Add Course
function insertCourse($coursename,$courseprice,$coursedesc,$lecturer,$session,$hour){
	include 'dbConnect.php';
	// To validate whether the course name is duplicate or not
	$sql = 'SELECT * FROM Course
			WHERE CourseName = "'.$coursename.'";';
	$result = mysqli_query($conn, $sql);
	
	if(mysqli_num_rows($result)>0){
		$msg = '  <div class="alert alert-danger">
			<strong>Danger!</strong> This course name already added!
		  </div>';
	}else{
		$insertsql = 'INSERT INTO Course (CourseName, CoursePrice, CourseDesc, LID, Session, Hours) 
		VALUES ("'.$coursename.'", "'.$courseprice.'", "'.$coursedesc.'", '.$lecturer.', "'.$session.'", "'.$hour.'")';
		$insert = mysqli_query($conn, $insertsql);
		
		if($insert){

			$msg =  ("<script LANGUAGE='JavaScript'>
					window.alert('Course successfully added!');
					window.location ='./viewCourse.php';
					</script>");
		}else{
			$msg = '  <div class="alert alert-danger">
						<strong>Danger!</strong> Please Contact Admin! Something went wrong.
					  </div>';
		}
	}
	
	mysqli_close($conn);
	
	echo $msg;
}

// Admin - Edit Course
function editCourse($courseid,$coursename,$courseprice,$coursedesc,$lecturer,$session,$hour){
	include 'dbConnect.php';
	
	$updatesql = 'UPDATE Course 
				SET CourseName = "'.$coursename.'", CoursePrice = "'.$courseprice.'", CourseDesc = "'.$coursedesc.'", LID = '.$lecturer.', Session = "'.$session.'", Hours = "'.$hour.'"
				WHERE CourseID = '.$courseid.';';
	$update = mysqli_query($conn, $updatesql);

	if($update){

		$msg =  ' <div class="alert alert-success">
					<strong>Success!</strong> Successfully Edited.
				  </div>';
	}else{
		$msg = '  <div class="alert alert-danger">
					<strong>Danger!</strong> Please Contact Admin! Something went wrong.
				  </div>';
	}
	
	mysqli_close($conn);
	
	echo $msg;
}

// Admin - Delete Course
function deleteCourse($courseid){
	include 'dbConnect.php';
	// Delete Course
	$deletesql = 'DELETE FROM Course
			WHERE CourseID = '.$courseid.';';
	$delete = mysqli_query($conn, $deletesql);
	
		if($delete){

			$msg =  ' <div class="alert alert-success">
						<strong>Success!</strong> You have successfully delete!
					  </div>';
					  
		}else{
			$msg = '  <div class="alert alert-danger">
						<strong>Danger!</strong> Please Contact Admin! Something went wrong.
					  </div>';
		}
		
	echo $msg;
}


// Admin - View Course
function getCourseAdmin(){
include 'dbConnect.php';
$sql= 'SELECT CourseID, CourseName, CoursePrice, Lecturer.LName, CourseDesc, Session, Hours
FROM Course
INNER JOIN Lecturer ON Course.LID = Lecturer.LID;';
$result = mysqli_query($conn, $sql);
if(isset($result)){
	if(mysqli_num_rows($result) > 0){
		$view = '<table id="courseTable" class="table">
				<thead>
					<tr>
						<th>Course ID</th>
						<th>Course Name</th>
						<th>Price</th>
						<th>Lecturer</th>
						<th>Course Desc</th>
						<th>Session</th>
						<th>Hours</th>
						<th>Action</th>
					</tr>
				</thead><tbody>';


		while($row = mysqli_fetch_assoc($result))
		{
		$view.= '<tr>
                <td>'.$row['CourseID'].'</td>
                <td>'.$row['CourseName'].'</td>
				<td>'.$row['CoursePrice'].'</td>
				<td>'.$row['LName'].'</td>
				<td>'.$row['CourseDesc'].'</td>
				<td>'.$row['Session'].'</td>
				<td>'.$row['Hours'].'</td>
                <td>
				<form method="post" action="editCourse.php" class="form-inline pull-left">
				<div><input type="hidden" name="courseid" value="'.$row["CourseID"].'"/></div>
				<input class="btn btn-info" type="submit" name="edit" value="Edit"/>
				</form>
				<form method="post" action="viewCourse.php" class="form-inline pull-left">
				<div><input type="hidden" name="courseid" value="'.$row["CourseID"].'"/></div>
				<input class="btn btn-danger" type="submit" name="delete" value="Delete"/>
				</form>
				</td>
				</tr>';
		}
		$view.= '</tbody></table>';
	}else{
		$view = '<div class="alert alert-danger">
				  No Class Available!
				</div>';
	}
}else{$view = 'Database Connection Error.';
}
	return $view;
}

// Admin - Add Classroom
function insertClassroom($courseid,$capacity,$location,$starttime,$endtime,$classdate){
	include 'dbConnect.php';
	// To validate whether the classroom is full or not
	$sql = 'SELECT * FROM Classroom
			WHERE CourseID = "'.$courseid.'" AND ClassDate = "'.$classdate.'";';
	$result = mysqli_query($conn, $sql);
	if(mysqli_num_rows($result)>0){
		$msg = '  <div class="alert alert-danger">
			<strong>Danger!</strong> This course and class date already added!
		  </div>';
	}else{
		$insertsql = 'INSERT INTO Classroom (CourseID, Slot, Capacity, Location, StartTime, EndTime, ClassDate) 
		VALUES ("'.$courseid.'", "0", "'.$capacity.'", "'.$location.'", "'.$starttime.'", "'.$endtime.'", "'.$classdate.'")';
		$insert = mysqli_query($conn, $insertsql);
		
		if($insert){

			$msg =  ("<script LANGUAGE='JavaScript'>
					window.alert('Classroom successfully added!');
					window.location ='./viewClass.php';
					</script>");
		}else{
			$msg = '  <div class="alert alert-danger">
						<strong>Danger!</strong> Please Contact Admin! Something went wrong.
					  </div>';
		}
	}		
	echo $msg;
}


// Admin - Edit Classroom
function editClassroom($classid,$courseid,$capacity,$location,$starttime,$endtime,$classdate){
	include 'dbConnect.php';
	
	$updatesql = 'UPDATE Classroom 
				SET CourseID = "'.$courseid.'", Capacity = "'.$capacity.'", Location = "'.$location.'", StartTime = "'.$starttime.'", EndTime = "'.$endtime.'", ClassDate = "'.$classdate.'"
				WHERE ClassID = '.$classid.';';
	$update = mysqli_query($conn, $updatesql);
	
	if($update){

		$msg =  ' <div class="alert alert-success">
					<strong>Success!</strong> Successfully Edited.
				  </div>';
	}else{
		$msg = '  <div class="alert alert-danger">
					<strong>Danger!</strong> Please Contact Admin! Something went wrong.
				  </div>';
	}
	echo $msg;
}

// Admin - Delete Classroom
function deleteClassroom($classid){
	include 'dbConnect.php';
	// To validate whether the classroom is full or not
	$deletesql = 'DELETE FROM Classroom
			WHERE ClassID = '.$classid.';';
	$delete = mysqli_query($conn, $deletesql);
	
		if($delete){

			$msg =  '  <div class="alert alert-success">
						<strong>Success!</strong> You have successfully delete!
					  </div>';
					  
		}else{
			$msg = '  <div class="alert alert-danger">
						<strong>Danger!</strong> Please Contact Admin! Something went wrong.
					  </div>';
		}
		
	echo $msg;
}

// Admin - View Classroom
function getClassAdmin(){
include 'dbConnect.php';
$sql= 'SELECT ClassID, Course.CourseID, Course.CourseName, Slot, Capacity, Course.CoursePrice, Course.Session, Course.Hours, Location, StartTime, EndTime, ClassDate 
FROM Classroom
INNER JOIN Course ON Classroom.CourseID = Course.CourseID
WHERE ClassDate >= DATE_FORMAT(CURDATE(), "%m/%d/%Y")
ORDER BY Classroom.ClassDate DESC';
$result = mysqli_query($conn, $sql);
if(isset($result)){
	if(mysqli_num_rows($result) > 0){
		$view = '<table id="classroomTable" class="table">
				<thead>
					<tr>
						<th>Classroom ID</th>
						<th>Course Name</th>
						<th>Price</th>
						<th>Capacity</th>
						<th>Location</th>
						<th>Start Time</th>
						<th>End Time</th>
						<th>Class Date</th>
						<th>Action</th>
					</tr>
				</thead>
				<tbody>';


		while($row = mysqli_fetch_assoc($result))
		{
		$view.= '<tr>
                <td>'.$row['ClassID'].'</td>
                <td>'.$row['CourseName'].'</td>
				<td>'.$row['CoursePrice'].'</td>
				<td>'.$row['Slot'].' / '.$row['Capacity'].'</td>
				<td>'.$row['Location'].'</td>
				<td>'.$row['StartTime'].'</td>
				<td>'.$row['EndTime'].'</td>
				<td>'.$row['ClassDate'].'</td>
                <td>
				<form method="post" action="editClass.php" class="form-inline pull-left" >
				<div><input type="hidden" name="classid" value="'.$row["ClassID"].'" /></div>
				<input class="btn btn-info" type="submit" name="edit" value="Edit"/>
				</form>
				<form method="post" action="viewClass.php" class="form-inline pull-left" >
				<div><input type="hidden" name="classid" value="'.$row["ClassID"].'"/></div>
				<input class="btn btn-danger" type="submit" name="delete" value="Delete" />
				</form>
				</td>
				</tr>';
		}
		$view.= '</tbody></table>';
	}else{
		$view = '<div class="alert alert-danger">
				  No Class Available!
				</div>';
	}
}else{$view = 'Database Connection Error.';
}
	return $view;
}

// Admin - View Expired Classroom
function getExpiredClassAdmin(){
include 'dbConnect.php';
$sql= 'SELECT ClassID, Course.CourseID, Course.CourseName, Slot, Capacity, Course.CoursePrice, Course.Session, Course.Hours, Location, StartTime, EndTime, ClassDate 
FROM Classroom
INNER JOIN Course ON Classroom.CourseID = Course.CourseID
WHERE ClassDate <= DATE_FORMAT(CURDATE(), "%m/%d/%Y")
ORDER BY Classroom.ClassDate DESC';
$result = mysqli_query($conn, $sql);
if(isset($result)){
	if(mysqli_num_rows($result) > 0){
		$view = '<table id="classroomTable" class="table">
				<thead>
					<tr>
						<th>Classroom ID</th>
						<th>Course Name</th>
						<th>Price</th>
						<th>Capacity</th>
						<th>Location</th>
						<th>Start Time</th>
						<th>End Time</th>
						<th>Class Date</th>
						<th>Action</th>
					</tr>
				</thead>
				<tbody>';


		while($row = mysqli_fetch_assoc($result))
		{
		$view.= '<tr>
                <td>'.$row['ClassID'].'</td>
                <td>'.$row['CourseName'].'</td>
				<td>'.$row['CoursePrice'].'</td>
				<td>'.$row['Slot'].' / '.$row['Capacity'].'</td>
				<td>'.$row['Location'].'</td>
				<td>'.$row['StartTime'].'</td>
				<td>'.$row['EndTime'].'</td>
				<td>'.$row['ClassDate'].'</td>
                <td>
				<form method="post" action="viewExpiredClass.php">
				<div><input type="hidden" name="classid" value="'.$row["ClassID"].'"/></div>
				<input class="btn btn-danger" type="submit" name="delete" value="Delete" />
				</form>
				</td>
				</tr>';
		}
		$view.= '</tbody></table>';
	}else{
		$view = '<div class="alert alert-danger">
				  No Class Available!
				</div>';
	}
}else{$view = 'Database Connection Error.';
}
	return $view;
}

// Admin - Add Admin
 function insertAdmin($aname,$ausername,$apassword){
	include 'dbConnect.php';
	$insertsql = 'INSERT INTO Admin (AName, AUsername, APassword) 
	VALUES ("'.$aname.'", "'.$ausername.'", "'.$apassword.'")';
	$insert = mysqli_query($conn, $insertsql);

	if($insert){
		$msg =  ("<script LANGUAGE='JavaScript'>
				window.alert('Admin successfully added!');
				window.location ='./index.php';
				</script>");
	}else{
		$msg = '  <div class="alert alert-danger">
					<strong>Danger!</strong> Please Contact Admin! Something went wrong.
				  </div>';
	}	
	echo $msg;
}

// Admin - Add Lecturer
 function insertLecturer($lname,$lusername,$lpw){
	include 'dbConnect.php';
	$insertsql = 'INSERT INTO Lecturer (LName, LUsername, LPassword) 
	VALUES ("'.$lname.'", "'.$lusername.'", "'.$lpw.'")';
	$insert = mysqli_query($conn, $insertsql);

	if($insert){

		$msg =  ("<script LANGUAGE='JavaScript'>
				window.alert('Lecturer successfully added!');
				window.location ='./viewLecturer.php';
				</script>");
	}else{
		$msg = '  <div class="alert alert-danger">
					<strong>Danger!</strong> Please Contact Admin! Something went wrong.
				  </div>';
	}	
	echo $msg;
}

// Admin - Edit Student
 function editStudent($sid,$sname,$susername,$spw){
	include 'dbConnect.php';

	$updatesql = 'UPDATE Student 
				SET SName = "'.$sname.'", SUsername = "'.$susername.'", SPassword = "'.$spw.'"
				WHERE SID = '.$sid.';';
	$update = mysqli_query($conn, $updatesql);
	
	if($update){

		$msg =  ' <div class="alert alert-success">
					<strong>Success!</strong> Successfully Edited.
				  </div>';
	}else{
		$msg = '  <div class="alert alert-danger">
					<strong>Danger!</strong> Please Contact Admin! Something went wrong.
				  </div>';
	}	
	echo $msg;
}

// Admin - Delete Student
function deleteStudent($sid){
	include 'dbConnect.php';
	$deletesql = 'DELETE FROM Student
			WHERE SID = '.$sid.';';
	$delete = mysqli_query($conn, $deletesql);
	
		if($delete){

			$msg =  '  <div class="alert alert-success">
						<strong>Success!</strong> You have successfully delete!
					  </div>';
					  
		}else{
			$msg = '  <div class="alert alert-danger">
						<strong>Danger!</strong> Please Contact Admin! Something went wrong.
					  </div>';
		}
		
	echo $msg;
}

// Admin - View Student
function getStudentAdmin(){
include 'dbConnect.php';
$sql= 'SELECT * FROM Student;';
$result = mysqli_query($conn, $sql);
if(isset($result)){
	if(mysqli_num_rows($result) > 0){
		$view = '<table id="studentTable" class="table">
				<thead>
					<tr>
						<th>Student ID</th>
						<th>Student Name</th>
						<th>Student Username</th>
						<th>Student Password</th>
						<th>Action</th>
					</tr>
				</thead><tbody>';


		while($row = mysqli_fetch_assoc($result))
		{
		$view.= '<tr>
                <td>'.$row['SID'].'</td>
                <td>'.$row['SName'].'</td>
				<td>'.$row['SUsername'].'</td>
				<td>'.$row['SPassword'].'</td>
                <td>
				<form method="post" action="editStudent.php" class="form-inline pull-left">
				<div><input type="hidden" name="sid" value="'.$row["SID"].'"/></div>
				<input class="btn btn-info" type="submit" name="edit" value="Edit"/>
				</form>
				<form method="post" action="viewStudent.php" class="form-inline pull-left">
				<div><input type="hidden" name="sid" value="'.$row["SID"].'"/></div>
				<input class="btn btn-danger" type="submit" name="delete" value="Delete"/>
				</form>
				</td>
				</tr>';
		}
		$view.= '</tbody></table>';
	}else{
		$view = '<div class="alert alert-danger">
				  No Student!
				</div>';
	}
}else{$view = 'Database Connection Error.';
}
	return $view;
}

// Admin - Edit Lecturer
 function editLecturer($lid,$lname,$lusername,$lpw){
	include 'dbConnect.php';

	$updatesql = 'UPDATE Lecturer 
				SET LName = "'.$lname.'", LUsername = "'.$lusername.'", LPassword = "'.$lpw.'"
				WHERE LID = '.$lid.';';
	$update = mysqli_query($conn, $updatesql);
	
	if($update){

		$msg =  ' <div class="alert alert-success">
					<strong>Success!</strong> Successfully Edited.
				  </div>';
	}else{
		$msg = '  <div class="alert alert-danger">
					<strong>Danger!</strong> Please Contact Admin! Something went wrong.
				  </div>';
	}	
	echo $msg;
}

// Admin - Delete Lecturer
function deleteLecturer($lid){
	include 'dbConnect.php';
	$deletesql = 'DELETE FROM Lecturer
			WHERE LID = '.$lid.';';
	$delete = mysqli_query($conn, $deletesql);
	
		if($delete){

			$msg =  '  <div class="alert alert-success">
						<strong>Success!</strong> You have successfully delete!
					  </div>';
					  
		}else{
			$msg = '  <div class="alert alert-warning">
						<strong>Warning!</strong> This lecturer still handling some courses. Therefore, it cannot be delete.
					  </div>';
		}
		
	echo $msg;
}

// Admin - View Lecturer
function getLecturerAdmin(){
include 'dbConnect.php';
$sql= 'SELECT * FROM Lecturer;';
$result = mysqli_query($conn, $sql);
if(isset($result)){
	if(mysqli_num_rows($result) > 0){
		$view = '<table id="lecturerTable" class="table">
				<thead>
					<tr>
						<th>Lecturer ID</th>
						<th>Lecturer Name</th>
						<th>Lecturer Username</th>
						<th>Lecturer Password</th>
						<th>Action</th>
					</tr>
				</thead><tbody>';


		while($row = mysqli_fetch_assoc($result))
		{
		$view.= '<tr>
                <td>'.$row['LID'].'</td>
                <td>'.$row['LName'].'</td>
				<td>'.$row['LUsername'].'</td>
				<td>'.$row['LPassword'].'</td>
                <td>
				<form method="post" action="editLecturer.php" class="form-inline pull-left">
				<div><input type="hidden" name="lid" value="'.$row["LID"].'"/></div>
				<input class="btn btn-info" type="submit" name="edit" value="Edit"/>
				</form>
				<form method="post" action="viewLecturer.php" class="form-inline pull-left">
				<div><input type="hidden" name="lid" value="'.$row["LID"].'"/></div>
				<input class="btn btn-danger" type="submit" name="delete" value="Delete"/>
				</form>
				</td>
				</tr>';
		}
		$view.= '</tbody></table>';
	}else{
		$view = '<div class="alert alert-danger">
				  No Lecturer!
				</div>';
	}
}else{$view = 'Database Connection Error.';
}
	return $view;
}

// Admin - view orders 
function getOrdersAdmin(){
include 'dbConnect.php';
$todayDate = date("m/d/Y");
$sql= 'SELECT OrderID, Student.SUsername, Student.SName, Course.CourseName, Price, BankBranch, Status, OrderDate, Classroom.ClassDate
FROM Orders
INNER JOIN Student ON Orders.SID = Student.SID
INNER JOIN Classroom ON Orders.ClassID = Classroom.ClassID
INNER JOIN Course ON Orders.CourseID = Course.CourseID
WHERE Classroom.ClassDate >= DATE_FORMAT(CURDATE(), "%m/%d/%Y")
ORDER BY Orders.OrderDate DESC';
$result = mysqli_query($conn, $sql);
	if(isset($result)){
		$view = '<table id="orderTable" class="table">
				<thead>
					<tr>
						<th>Student Username</th>
						<th>Student Name</th>
						<th>Course Name</th>
						<th>Price</th>
						<th>Bank Branch</th>
						<th>Status</th>
						<th>Class Date</th>
						<th>Order Date</th>
						<th>Action</th>
					</tr>
				</thead><tbody>';

		while($row = mysqli_fetch_assoc($result))
		{
		$dt = strtotime($row['OrderDate']);
		$day = date("l", $dt);
		$view.= '<tr>
				<td>'.$row['SUsername'].'</td>
                <td>'.$row['SName'].'</td>
                <td>'.$row['CourseName'].'</td>
				<td>'.$row['Price'].'</td>
				<td>'.$row['BankBranch'].'</td>
				<td>'.$row['Status'].'</td>
				<td>'.$row['ClassDate'].'</td>
				<td>'.$row['OrderDate'].' / ('.$day.')</td>
				<td>
				<form method="post" action="editorder.php">
				<div><input type="hidden" name="order_id" value="'.$row["OrderID"].'"/></div>
				<input class="btn btn-success edit_data" type="submit" name="view" value="Edit Status"/>
				</form>
				</td>
            </tr>';
		}
		$view.= '</tbody></table>';
	}else{
	$view = 'Database Connection Error.';
}
	return $view;
}

// Admin - view expired orders 
function getExpiredOrdersAdmin(){
include 'dbConnect.php';
$todayDate = date("m/d/Y");
$sql= 'SELECT OrderID, Student.SUsername, Student.SName, Course.CourseName, Price, BankBranch, Status, OrderDate, Classroom.ClassDate
FROM Orders
INNER JOIN Student ON Orders.SID = Student.SID
INNER JOIN Classroom ON Orders.ClassID = Classroom.ClassID
INNER JOIN Course ON Orders.CourseID = Course.CourseID
WHERE Classroom.ClassDate <= DATE_FORMAT(CURDATE(), "%m/%d/%Y")
ORDER BY Orders.OrderDate DESC';
$result = mysqli_query($conn, $sql);
	if(isset($result)){
		$view = '<table id="orderTable" class="table">
				<thead>
					<tr>
						<th>Student Username</th>
						<th>Student Name</th>
						<th>Course Name</th>
						<th>Price</th>
						<th>Bank Branch</th>
						<th>Status</th>
						<th>Class Date</th>
						<th>Order Date</th>
						<th>Action</th>
					</tr>
				</thead><tbody>';

		while($row = mysqli_fetch_assoc($result))
		{
		$dt = strtotime($row['OrderDate']);
		$day = date("l", $dt);
		$view.= '<tr>
				<td>'.$row['SUsername'].'</td>
                <td>'.$row['SName'].'</td>
                <td>'.$row['CourseName'].'</td>
				<td>'.$row['Price'].'</td>
				<td>'.$row['BankBranch'].'</td>
				<td>'.$row['Status'].'</td>
				<td>'.$row['ClassDate'].'</td>
				<td>'.$row['OrderDate'].' / ('.$day.')</td>
				<td>
				<form method="post" action="viewExpiredOrder.php">
				<div><input type="hidden" name="order_id" value="'.$row["OrderID"].'"/></div>
				<input class="btn btn-danger" type="submit" name="delete" value="Delete"/>
				</form>
				</td>
            </tr>';
		}
		$view.= '</tbody></table>';
	}else{
	$view = 'Database Connection Error.';
}
	return $view;
}

// Admin - Delete Expired Order
function deleteOrder($oid){
	include 'dbConnect.php';
	$deletesql = 'DELETE FROM Orders
			WHERE OrderID = '.$oid.';';
	$delete = mysqli_query($conn, $deletesql);
	
		if($delete){

			$msg =  '  <div class="alert alert-success">
						<strong>Success!</strong> You have successfully delete!
					  </div>';
					  
		}else{
			$msg = '  <div class="alert alert-danger">
						<strong>Danger!</strong> Please Contact Admin! Something went wrong.
					  </div>';
		}
		
	echo $msg;
}


// Insert or Delete classroom into reservation table - Classroom Approved
function updateOrder($orderid,$classid,$courseid,$sid,$bankbranch,$status,$CRDate,$paymentdate){
	require 'dbConnect.php';
	// Turn off autocommit, in order to make every query run successfully
	mysqli_autocommit($conn,FALSE);
	
	if($status == 'Approved'){
		$updatesql = 'UPDATE orders set Status = "Approved", BankBranch = "'.$bankbranch.'", PaymentDate = "'.$paymentdate.'"
				  WHERE OrderID = '.$orderid.';';
		$updateresult = mysqli_query($conn, $updatesql);
		
		// Once approved, then insert into class reservation
		if($updateresult){
			// Check whether class reservation inserted
			$sqlcr = 'SELECT * FROM ClassReservation
					WHERE CourseID = '.$courseid.' AND ClassID = '.$classid.' AND SID = '.$sid.' AND CRDate = "'.$CRDate.'";';
			$resultcr = mysqli_query($conn, $sqlcr);
			
			if(!mysqli_num_rows($resultcr)>0){
				
				// Select course query to check how many session
				$sql = 'SELECT * FROM Course
						WHERE CourseID = '.$courseid.';';
				$result = mysqli_query($conn, $sql);
				$row = mysqli_fetch_assoc($result);
				
				$insertsql = 'INSERT INTO ClassReservation (ClassID, CourseID, SID, CRDate) VALUES ';
				// For loop - the number of inserting the class reservation is depend on the session (How many days for this training session)
				for ($x = 1; $x <= $row['Session']; $x++) {
					$insertsql .= '('.$classid.', '.$courseid.', '.$sid.', "'.$CRDate.'")';
					if($x < ($row['Session'])){
						$CRDate = date('m/d/Y',strtotime($CRDate . "+1 days"));
						$insertsql .=",";
					}
				}
				$insert = mysqli_query($conn, $insertsql);
				
				if($insert){ // Insert Session Success!
					mysqli_commit($conn);
					$sql= 'SELECT Student.SEmail, Course.CourseName, Course.CoursePrice
					FROM ClassReservation
					INNER JOIN Student ON ClassReservation.SID = Student.SID
					INNER JOIN Classroom ON ClassReservation.ClassID = Classroom.ClassID
					INNER JOIN Course ON ClassReservation.CourseID = Course.CourseID
					WHERE ClassReservation.CourseID = '.$courseid.' AND ClassReservation.ClassID = '.$classid.' AND ClassReservation.SID = '.$sid.' AND ClassReservation.CRDate = "'.$CRDate.'";';
					$result = mysqli_query($conn, $sql);
					$row = mysqli_fetch_assoc($result);
					
					$coursename = $row['CourseName'];
					$price = $row['CoursePrice'];
					$todaydate = date('Y-m-d');
					$email = $row['SEmail'];
					
					$message = '<div class="alert alert-success">
								   Update successfully with insert student record into session - Approved
								</div>';
					$message .=	sendreceiptmail($coursename,$price,$orderid,$todaydate,$email,$paymentdate);
				}else{
					mysqli_rollback($conn);
					$message = '<div class="alert alert-danger">
								   Unable to insert student record into session. Please contact admin immediately!
								</div>';	
				} // Insert Session Failed!
			}else{
				mysqli_commit($conn);
				$message = '<div class="alert alert-success">
								Update successfully without insert student record into session (The student has been added into the session) - Approved
							</div>';
			} // Updated success without insert session of student
		}else{
			mysqli_rollback($conn);
			$message = '<div class="alert alert-danger">
						   Update Order Status Failed! Contact admin immediately! - Approved
						</div>';
		} // Failed to update the order
	// When admin selected pending, proceed this function
	}elseif($status == 'Pending'){
		$updatesql = 'UPDATE orders set Status = "Pending", BankBranch = "'.$bankbranch.'"
					  WHERE OrderID = '.$orderid.';';
		$updateresult = mysqli_query($conn, $updatesql);
		
		if($updateresult){
			// Check whether class reservation inserted
			$sqlcr = 'SELECT * FROM ClassReservation
					WHERE CourseID = '.$courseid.' AND ClassID = '.$classid.' AND SID = '.$sid.' AND CRDate = "'.$CRDate.'";';
			$resultcr = mysqli_query($conn, $sqlcr);
	
			if(mysqli_num_rows($resultcr)>0){
				
				// Select course query to check how many session
				$sql = 'SELECT Session FROM Course
						WHERE CourseID = '.$courseid.';';
				$result = mysqli_query($conn, $sql);
				$row = mysqli_fetch_assoc($result);
				
				// For loop - the number of deleting the class reservation is depend on the session (How many days for this training session)
				$deletesql = 'DELETE FROM ClassReservation
				WHERE (ClassID, CourseID, SID, CRDate) IN (';
				for ($x = 1; $x <= $row['Session']; $x++) {
					// if row exist then delete class reservation
					$deletesql .= '('.$classid.', '.$courseid.', '.$sid.', "'.$CRDate.'")';
					if($x < ($row['Session'])){
						$CRDate = date('m/d/Y',strtotime($CRDate . "+1 days"));
						$deletesql .=",";
					}
				}
				$deletesql .= ')';
				$delete = mysqli_query($conn, $deletesql);
				if($delete){ // Success Delete
					mysqli_commit($conn);
					$message = '<div class="alert alert-success">
								   Update Successfully - Deleted student record from session - Pending
								</div>';
				}else{
					mysqli_rollback($conn);
					$message = '<div class="alert alert-success">
								   Failed to process, as it unable to delete student record from session . Please contact admin immediately!
								</div>';
				} // Failed to delete the session of student.				
			}else{
				mysqli_commit($conn);
				$message = '<div class="alert alert-success">
								Update successfully without delete student record from session (The student has been deleted from session) - Pending
							</div>';
			} // Update success without delete student's session
		}else{
			mysqli_rollback($conn);
			$message = '<div class="alert alert-success">
						   Failed to update to pending. Please contact admin immediately!
						</div>';
		} // Failed to update the order
	}elseif($status == 'Cancel'){
	// Delete selected record from class reservation
	$deletesql = 'DELETE FROM Orders
				  WHERE OrderID = '.$orderid.';';
	$deleteresult = mysqli_query($conn, $deletesql);
		if($deleteresult){
			// Update Classroom slot - Minus - 1
			$updatesql = 'UPDATE Classroom
						SET Slot = Slot - 1
						WHERE ClassID = '.$classid.';';
			$update = mysqli_query($conn, $updatesql);
			
			if($update){				
				// Check whether class reservation inserted
				$sqlcr = 'SELECT * FROM ClassReservation
						WHERE CourseID = '.$courseid.' AND ClassID = '.$classid.' AND SID = '.$sid.' AND CRDate = "'.$CRDate.'";';
				$resultcr = mysqli_query($conn, $sqlcr);
		
				if(mysqli_num_rows($resultcr)>0){
					// Select course query to check how many session
					$sql = 'SELECT Session FROM Course
							WHERE CourseID = '.$courseid.';';
					$result = mysqli_query($conn, $sql);
					$row = mysqli_fetch_assoc($result);
					
					// For loop - the number of deleting the class reservation is depend on the session (How many days for this training session)
					$deletesql = 'DELETE FROM ClassReservation
					WHERE (ClassID, CourseID, SID, CRDate) IN (';
					for ($x = 1; $x <= $row['Session']; $x++) {
						// if row exist then delete class reservation
						$deletesql .= '('.$classid.', '.$courseid.', '.$sid.', "'.$CRDate.'")';
						if($x < ($row['Session'])){
							$CRDate = date('m/d/Y',strtotime($CRDate . "+1 days"));
							$deletesql .=",";
						}
					}
					$deletesql .= ')';
					$delete = mysqli_query($conn, $deletesql);
					
					if($delete){
						// Success Delete
					}else{
						mysqli_rollback($conn);
						$message = '<div class="alert alert-danger">
									   Failed to delete student session, as it unable to delete student record from session. Please contact admin immediately!
									</div>';
					}
				}else{
					// Success Update, but don't have class reservation in this particular order.
				}
				
				// Wait List
				$sqlclass = 'SELECT * FROM Classroom
							WHERE ClassID = '.$classid.';';
				$resultclass = mysqli_query($conn, $sqlclass);
				$rowclass = mysqli_fetch_assoc($resultclass);
				if($rowclass['Capacity'] > $rowclass['Slot']){	
					$sqlwl = 'SELECT WLID, Student.SID, Classroom.ClassID, Course.CourseID, Course.CoursePrice
							FROM waitinglist
							INNER JOIN Student ON waitinglist.SID = Student.SID
							INNER JOIN Classroom ON waitinglist.ClassID = Classroom.ClassID
							INNER JOIN Course ON waitinglist.CourseID = Course.CourseID
							WHERE Classroom.ClassID = '.$classid.' LIMIT 1;';
							
					$resultwl = mysqli_query($conn, $sqlwl);
					// To check is there any waiting list record
					if(mysqli_num_rows($resultwl) > 0){	
					$rowwl = mysqli_fetch_assoc($resultwl);
					$today = date("m/d/Y");
					$insertsql = 'INSERT INTO Orders (SID, ClassID, CourseID, Price, Status, BankBranch, OrderDate) 
					VALUES ('.$rowwl['SID'].', '.$rowwl['ClassID'].', '.$rowwl['CourseID'].', "'.$rowwl['CoursePrice'].'", "Pending", "Maybank", "'.$today.'")';
					$insert = mysqli_query($conn, $insertsql);
					
						if($insert){
							// Update Classroom slot - Plus 1
							$updatesql = 'UPDATE Classroom
										SET Slot = Slot + 1
										WHERE ClassID = '.$classid.';';
							$update = mysqli_query($conn, $updatesql);
							
							if($update){ // Update classroom success
								$deletesql = 'DELETE FROM Waitinglist
										WHERE WLID = '.$rowwl['WLID'].';';
								$delete = mysqli_query($conn, $deletesql);
								if($delete){
									mysqli_commit($conn);
									$message =  ("<script LANGUAGE='JavaScript'>
											window.alert('Succesfully cancelled the order! Successfully proceed the waiting list.');
											window.location ='./vieworder.php';
											</script>");
								}
							}else{
								mysqli_rollback($conn);
								$message = '<div class="alert alert-danger">
											   Cancel Order Failed! Contact admin immediately! - Failed to proceed waiting list - (Update Classroom).
											</div>';
							}//Failed to update classroom
						}else{
							mysqli_rollback($conn);
							$message = '<div class="alert alert-danger">
										   Cancel Order Failed! Contact admin immediately! - Failed to proceed waiting list - (Insert Order).
										</div>';
						}//Failed to insert order
					}else{
						mysqli_commit($conn);
						$message =  ("<script LANGUAGE='JavaScript'>
								window.alert('Succesfully cancelled the order! No waiting list record for this session.');
								window.location ='./vieworder.php';
								</script>");
					}//No Wait List record
				}else{
					mysqli_commit($conn);
					$message =  ("<script LANGUAGE='JavaScript'>
							window.alert('Succesfully cancelled the order! Session is still unavailable');
							window.location ='./vieworder.php';
							</script>");
				}//Class is still unavailable
			}else{
				mysqli_rollback($conn);
				$message = '<div class="alert alert-danger">
							   Cancel Order Failed! Contact admin immediately! - Failed to update classroom capacity.
							</div>';
			}//Update classroom failed
		}else{
			mysqli_rollback($conn);
			$message = '<div class="alert alert-danger">
						   Cancel Order Failed! Contact admin immediately! - Delete Order.
						</div>';
		}// Failed to delete order
	}
			
	return $message;
}

function sendreceiptmail($coursename,$price,$orderid,$date,$email,$paymentdate){
	require '../../PHPMailerAutoload.php';
	require 'mail.inc.php';
	
	$date = date('m/d/Y',strtotime($date));
	
	$mail->Subject = 'Receipt Notification - IT Academy Asia Malaysia. ';

	$mail->Body    = '<html>
	<head>
	<style>
	#customers {
		font-family: "Trebuchet MS", Arial, Helvetica, sans-serif;
		border-collapse: collapse;
		width: 100%;
	}

	#headerword {
		font-family: "Trebuchet MS", Arial, Helvetica, sans-serif;
	}

	#customers td, #customers th {
		border: 1px solid #ddd;
		padding: 8px;
	}

	#customers tr:nth-child(even){background-color: #f2f2f2;}

	#customers tr:hover {background-color: #ddd;}

	#customers th {
		padding-top: 12px;
		padding-bottom: 12px;
		text-align: left;
		background-color: #4CAF50;
		color: white;
	}

	.header {
		display: flex;
		justify-content: space-between;
	}

	</style>
	</head>
	<body>

	  <div>
		<div>
		  <address>
			<strong>IT Academy Asia Malaysia</strong>
			<br>
			109-3, Jalan Dwitasik 1, Bandar Sri
			<br>
			Permaisuri, 56000, Kuala Lumpur.
			<br>
			<abbr title="Phone">HP Number:</abbr> 012-3868942
		  </address>
		</div>
		<div align="right">
		  <p>
			<em>Payment Date: '.$paymentdate.'</em>
		  </p>
		  <p>
			<em>Approved Date: '.$date.'</em>
		  </p>
		  <p>
			<em>Receipt #: '.$orderid.'</em>
		  </p>
		</div>
	  </div>
	<center><h1 id="customers">(APPROVED)</h1></center>
	<center><h1 id="customers">Receipt</h1></center>

	<table id="customers">
	  <tr>
		<th>Product</th>
		<th>Quantity</th>
		<th>Price</th>
		<th>Total</th>
	  </tr>
	  <tr>
		<td>'.$coursename.'</td>
		<td>1 </td>
		<td> RM '.$price.'</td>
		<td> RM '.$price.'</td>
	  </tr>
	   <tr>
		<td></td>
		<td></td>
		<td>Total: </td>
		<td> RM '.$price.'</td>
	  </tr>
	</table>
	<center><h1 id="customers">THANK YOU!</h1></center>
	</body>
	</html>
	';

	$mail->AltBody = 'Receipt Template';

	$mail->addAddress($email);


	if($mail->send()){
		
		$msg = 'Success';
	}else{
		$msg = $mail->ErrorInfo;
	}
	return $msg;
} 

?>
