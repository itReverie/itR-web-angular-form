<?php
if(isset($_POST['submit']))
{
  echo="Error, you need to submit a form."
}

  $clubName = $_POST['clubName'];
  $category = $_POST['category'];
  $country = $_POST['country'];
  $state = $_POST['state'];
  $firstName = $_POST['firstName'];
  $lastName = $_POST['lastName'];
  $email = $_POST['email'];

//Validate that the fields are not empty
if(empty($clubName)|| empty($firstName)|| empty($lastName)|| empty($email))
{
echo "Missing mandatory fields.";
exit;
}



  $email_subject = "New Club submission: $clubName";
  $email_body = "There is a new Club Subscription form with the following information:\n \n ".
		"Club Name: $clubName.\n ".
		"Category:  $category.\n ".
		"Country:  $country.\n ".
		"State:  $state.\n ".
		"Board member First Name:  $firstName.\n ".
		"Board member Last Name:  $lastName.\n ".
		"Board member email:  $email.\n  \n".
		"See attached their logo and members list.\n ".


  $to = "contact@dragonking.com.au";
  $headers = "";
  mail($to,$email_subject,$email_body,$headers);


header("Location:  https://www.bpoint.com.au/payments/SPORTSKING");

 ?>