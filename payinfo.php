<?php
include 'include/header.php';

	if(!isset($_SESSION['username']))
	{
		header( 'Location: login.php' );
	}

if(isset($_POST['order_id'])){
$sql= 'SELECT OrderID, Course.CourseName, OrderDate
FROM Orders
INNER JOIN Course ON Orders.CourseID = Course.CourseID
WHERE OrderID = '.$_POST['order_id'].';';

$result = mysqli_query($conn, $sql);
$row = mysqli_fetch_assoc($result);

$orderid = $row['OrderID'];
$orderdate = $row['OrderDate'];
$coursename = $row['CourseName'];
}

?>
<style>
*, *:before, *:after {
  -moz-box-sizing: border-box;
  -webkit-box-sizing: border-box;
  box-sizing: border-box;
}

html {
  font-family: Helvetica, Arial, sans-serif;
  font-size: 100%;
  background: #333;
  -webkit-font-smoothing: antialiased;
}

#page-wrapper {
  width: 640px;
  background: #FFFFFF;
  padding: 1em;
  margin: 1em auto;
  border-top: 5px solid #69c773;
  box-shadow: 0 2px 10px rgba(0,0,0,0.8);
}

h1 {
  margin-top: 0;
}

h2 {
  margin: 1em 0;
  font-size: 1em;
}

details {
  border-radius: 3px;
  background: #EEE;
  margin: 1em 0;
}

summary {
  background: #69c773;
  color: #FFF;
  border-radius: 3px;
  padding: 5px 10px;
  outline: none;
}

table {
  border: 0;
  width: 100%;
}

th, td {
  vertical-align: top;
  text-align: left;
  padding: 0.5em;
  border-bottom: 1px solid #E6E6E6;
}

th {
  width: 200px;
}

ul {
  list-style: none;
  margin: 0;
  padding: 10px;
}

li {
  display: inline;
  padding-right: 10px;
}

a {
  color: #08C;
  text-decoration: none;
}
</style>


    
<div class="container">

<div id="page-wrapper">
  <h1>Payment Details</h1>
  
  <!-- Specifying an 'open' attribute will make all the content visible when the page loads -->
    <summary>Course Details</summary>
    <table>
      <tr>
        <th scope="row">Order Date</th>
        <td><?php echo $orderdate; ?></td>
      </tr>
      <tr>
        <th scope="row">Order Number</th>
        <td>#<?php echo $orderid; ?></td>
      </tr>
      <tr>
        <th scope="row">Course Name</th>
        <td><?php echo $coursename; ?></td>
      </tr>
    </table>
  

    <summary>Payment Information</summary>
    <table>
      <tr>
        <th scope="row">Account Holder</th>
        <td>IT Academy Asia Malaysia Sdn. Bhd.</td>
      </tr>
      <tr>
        <th scope="row">Account Number</th>
        <td>1800755554444</td>
      </tr>
      <tr>
        <th scope="row">Bank Name</th>
        <td>MayBank</td>
      </tr>
      <tr>
        <th scope="row">Branch Code</th>
        <td>1337</td>
      </tr>
      <tr>
        <th scope="row" colspan="2">*Please notify us once the payment is transferred via SMS to 012-3868942 or email malaysiacourses@itacademyasia.com</th>
      </tr>
    </table>
	<a href="svieworder.php" class="btn btn-danger btn-lg active" role="button" aria-pressed="true">Back</a>
</div>

<!-- JavaScript libs are placed at the end of the document so the pages load faster -->
 	<script type='text/javascript' src='assets/js/jquery.min.js'></script>
	<script src="assets/js/bootstrap.min.js"></script>
<?php
include 'include/footer.php';
?> 