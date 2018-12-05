<?php
include 'include/header.php';


if($_POST){
	if(isset($_POST['btn_send'])){
    $name   = mysqli_real_escape_string($conn,trim($_POST['name']));
	$email  = mysqli_real_escape_string($conn,trim($_POST['email']));
	$subject  = mysqli_real_escape_string($conn,trim($_POST['subject']));
	$message  = mysqli_real_escape_string($conn,trim($_POST['message']));
	}
}
?>
 	<header id="head" class="secondary">
            <div class="container">
                    <h1>Contact Us</h1>
                </div>
    </header>


    <!-- container -->
	<div class="container">
				<div class="row">
					<div class="col-md-8">
						
						<h3>Please do not hesitate to contact us!</h3>
						
						<form class="form-light mt-20" method="post" role="form">
							<div class="form-group">
								<label>Name</label>
								<input type="text" name="name" class="form-control" placeholder="Your name">
							</div>
							<div class="row">
								<div class="col-md-6">
									<div class="form-group">
										<label>Email</label>
										<input type="email" name="email" class="form-control" placeholder="Email address">
									</div>
								</div>
							</div>
							<div class="form-group">
								<label>Subject</label>
								<input type="text" name="subject" class="form-control" placeholder="Subject">
							</div>
							<div class="form-group">
								<label>Message</label>
								<textarea name="message" class="form-control" id="message" placeholder="Write you message here..." style="height:100px;"></textarea>
							</div>
							<button type="submit" name="btn_send" class="btn btn-two">Send message</button><p><br/></p>
						</form>
						<?php
							if(isset($_POST['btn_send'])){
								if(!($name) OR !($email) OR !($subject) OR !($message) ){
									echo $message = '  <div class="alert alert-danger">
														Please fill in your details.
													  </div>';
								}else{
									echo contactmail($name, $email, $subject, $message);
								}
							}
						?>
					</div>
					<div class="col-md-4">
						<div class="row">
							<div class="col-md-6">
								<h3 class="section-title">Address</h3>
								<div class="contact-info">
									<h5>Address</h5>
									<p>109-3, Jalan Dwitasik 1, Bandar Sri Permaisuri, 56000, Kuala Lumpur.</p>
									
									<h5>Email</h5>
									<p>info@itacademyasia.com</p>
									
									<h5>Phone</h5>
									<p>+6 (012) 3868932</p>
								</div>
								<div class="contact-info">
								<div id="googleMap" style="width:200%;height:200px;"></div>
								</div>
							</div> 
						</div> 						
					</div>
				</div>
			</div>
  <script type='text/javascript' src='assets/js/jquery.min.js'></script> 
<script src="assets/js/bootstrap.min.js"></script>   

<script>
function myMap() {
var latlng = new google.maps.LatLng(3.100868,101.712374);
var mapProp= {
    center:latlng,
    zoom:15,
};
var map=new google.maps.Map(document.getElementById("googleMap"),mapProp);

var marker = new google.maps.Marker({position: latlng,map: map})
}

</script>

<script src="https://maps.googleapis.com/maps/api/js?key=AIzaSyCFJxjhXZDArCNxfVWbdrw_tQSpdQgPG0g&callback=myMap"></script>

<?php
include 'include/footer.php';
?>