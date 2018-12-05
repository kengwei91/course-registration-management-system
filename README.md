# Course Registration & Management System

##  Degree Final Year Project

> Note: This project is no longer being maintained. :smile:

1) Copy the project folder into the htdocs:

Example: 
if your xampp folder was in C Drive, then the path should be look like this:

	C:\xampp\htdocs\

Therefore, this is how the path should look like.

	C:\xampp\htdocs\project\

----------------------------------------End of Project folder path---------------------------------------


2) To change MySQL Database Connection:

Open the "dbConnect.php" file in project directory > "include" folder.

Example: 
if your xampp folder was in C Drive, then the path should be look like this:

	C:\xampp\htdocs\project\include\dbConnect.php

Replace host with your host name, username with your username, and password with your password.

However, if you don't want to change the database name, then just use the default name.

In MySQL, create a new Database name called "project", then import the "project.sql" file.


--------------------------------------End of MySQL Database Connection---------------------------------------


3) To set up PHPMailer for localhost:

In order to use PHPMailer in localhost, we need to set code in the "php.ini" file.

First, open the php.ini file, then search for "[openssl]". (Search without QUOTES)

Once searched it, we need to activate the openssl and curl for cacert.pem.

To know where the cacert.pem file locate at, please follow the step at the following:

For Example:
 
if your xampp folder was in C Drive, then the path should be look like this:

	C:\xampp\htdocs\project\cacert.pem

Therefore, this is how the code should be look like.

	openssl.cafile = C:\xampp\htdocs\project\cacert.pem
	curl.cainfo = C:\xampp\htdocs\project\cacert.pem

Copy these 2 lines code under [openssl]

Close & Save it.

Completed! The Course Registration and Management System is available to send email in localhost server.

PS*: If it cannot work, you can refer to my "php.ini" file which I have uploaded it in Course Registration System folder.


--------------------------------------End of PHPMAILER for Localhost server----------------------------


4) To know where is the server email information:

Open the "mail.inc.php" file in project directory > "include" folder.

The default username & Password:

Username: uogfreecycle17@gmail.com
Password: freecycle

Therefore, when the visitor send an inquiry message, we can log in this gmail and read it.

---------------------------------------- Users Account -------------------------------------------------

------------------------------- Admin ---------------------------------

Username: admin
Password: admin

------------------------------- Lecturer ---------------------------------

Ms. Kumatha

Username: kumatha
Password: kumatha

Mr. Feroz

Username: feroz
Password: feroz

------------------------------- Student ---------------------------------

Keng Wei

Username: kengwei
Password: kengwei

Xuan

Username: xuan
Password: xuan

Chris

Username: chris
Password: chris


----------------------------------------------------THE END--------------------------------------------------


