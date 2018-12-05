<?php
	$mail = new PHPMailer;									// New mail object

	//$mail->SMTPDebug = 4;                               	// Enable verbose debug output
	$mail->isSMTP();                                    	// Set mailer to use SMTP

	$mail->Host = 'smtp.gmail.com';  						// Specify main and backup SMTP servers

	$mail->SMTPAuth = true;                            	 	// Enable SMTP authentication

	$mail->Username = 'uogfreecycle17@gmail.com';               		// SMTP username

	$mail->Password = 'freecycle';                	// SMTP password

	$mail->SMTPSecure = 'tls';                          	// Enable TLS encryption, `ssl` also accepted
	$mail->Port = 587;                                  	// TCP port to connect to
	$mail->setFrom('uogfreecycle17@gmail.com', 'IT Academy Asia');
	$mail->addReplyTo('uogfreecycle17@gmail.com', 'Information');
	$mail->isHTML(true);                                 	// Set email format to HTML

?>