<?php
include 'include/header.php';

if(isset($_SESSION['username']))
{
	header( 'Location: course.php' );
}

if(isset($_POST['register'])){
	
	$usernamelength = strlen($_POST['username']);
	$namelength = strlen($_POST['name']);
	$passwordlength = strlen($_POST['password']);
	
	if(!(trim($_POST['username'])) Or !(trim($_POST['password'])) Or !(trim($_POST['email'])) Or !(trim($_POST['name'])))
	{
		$message .= '  <div class="alert alert-danger">
						Please fill in your details.
					  </div>';
	}elseif($usernamelength < 6 or $namelength < 6 or $namelength < 6){
		$message .= '  <div class="alert alert-danger">
						The character must more than 5
					  </div>';
	}elseif(!filter_var($_POST['email'], FILTER_VALIDATE_EMAIL)){
		$message .= '  <div class="alert alert-danger">
						Invalid Email.
					  </div>';
	}
	else{
		$username=mysqli_real_escape_string($conn,trim($_POST['username']));
		$pass=md5(mysqli_real_escape_string($conn,trim($_POST['password'])));
		$email=mysqli_real_escape_string($conn,trim($_POST['email']));
		$name=mysqli_real_escape_string($conn,trim($_POST['name']));
		
		$sql='SELECT * FROM Student WHERE SUsername="' .$username. '" OR SEmail ="'.$email.'"';
		$usernameresult = mysqli_query($conn, $sql);
		
		if(mysqli_num_rows($usernameresult)>0)
		{
			$message = '  <div class="alert alert-danger">
							Username or Email already existed.
						</div>';
		}else{	
			$message = studentRegistration($username,$pass,$email,$name);
		}
	}
}
?>
<style>
body, html{
     height: 100%;
 	background-repeat: no-repeat;
 	background-color: #d3d3d3;
 	font-family: 'Oxygen', sans-serif;
}

.main{
 	margin-top: 70px;
}

h1.title { 
	font-size: 50px;
	font-weight: 400; 
}

hr{
	width: 10%;
	color: #fff;
}

.form-group{
	margin-bottom: 15px;
}

label{
	margin-bottom: 15px;
}

input,
input::-webkit-input-placeholder {
    font-size: 11px;
    padding-top: 3px;
}

.main-login{
 	background-color: #fff;
    /* shadows and rounded borders */
    -moz-border-radius: 2px;
    -webkit-border-radius: 2px;
    border-radius: 2px;
    -moz-box-shadow: 0px 2px 2px rgba(0, 0, 0, 0.3);
    -webkit-box-shadow: 0px 2px 2px rgba(0, 0, 0, 0.3);
    box-shadow: 0px 2px 2px rgba(0, 0, 0, 0.3);

}

.main-center{
 	margin-top: 30px;
 	margin: 0 auto;
 	max-width: 330px;
    padding: 40px 40px;

}

.login-button{
	margin-top: 5px;
}

.login-register{
	font-size: 11px;
	text-align: center;
}
</style>

    
		<div class="container">
			<div class="row main">
				<div class="panel-heading">
	               <div class="panel-title text-center">
	               		<h1 class="title">Student Registration</h1>
	               		<hr />
	               	</div>
	            </div> 
				<div class="main-login main-center">
					<form class="form-horizontal" method="post" action="register.php">
						
						<div class="form-group">
							<label for="name" class="cols-sm-2 control-label">Your Name</label>
							<div class="cols-sm-10">
								<div class="input-group">
									<span class="input-group-addon"><i class="fa fa-user fa" aria-hidden="true"></i></span>
									<input type="text" class="form-control" name="name" id="name"  placeholder="Enter your Name"/>
								</div>
							</div>
						</div>

						<div class="form-group">
							<label for="email" class="cols-sm-2 control-label">Your Email</label>
							<div class="cols-sm-10">
								<div class="input-group">
									<span class="input-group-addon"><i class="fa fa-envelope fa" aria-hidden="true"></i></span>
									<input type="text" class="form-control" name="email" id="email"  placeholder="Enter your Email"/>
								</div>
							</div>
						</div>

						<div class="form-group">
							<label for="username" class="cols-sm-2 control-label">Username</label>
							<div class="cols-sm-10">
								<div class="input-group">
									<span class="input-group-addon"><i class="fa fa-users fa" aria-hidden="true"></i></span>
									<input type="text" class="form-control" name="username" id="username"  placeholder="Enter your Username"/>
								</div>
							</div>
						</div>

						<div class="form-group">
							<label for="password" class="cols-sm-2 control-label">Password</label>
							<div class="cols-sm-10">
								<div class="input-group">
									<span class="input-group-addon"><i class="fa fa-lock fa-lg" aria-hidden="true"></i></span>
									<input type="password" class="form-control" name="password" id="password"  placeholder="Enter your Password"/>
								</div>
							</div>
						</div>

						<div class="form-group ">
							<input type="submit" value="Register" name="register" class="btn btn-primary btn-lg btn-block login-button"/>
						</div>
						<div class="login-register">
				            <a href="login.php">Login</a>
				         </div>
					</form>
					<?php echo $message; ?>
				</div>
			</div>
		</div>

<!-- JavaScript libs are placed at the end of the document so the pages load faster -->
	<script type='text/javascript' src='assets/js/jquery.min.js'></script>
	<script src="assets/js/bootstrap.min.js"></script>
<?php
include 'include/footer.php';
?>
