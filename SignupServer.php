<?php
include 'Classes/PHPExcel/IOFactory.php';
require_once('PHPMailer/class.phpmailer.php');
include("PHPMailer/class.smtp.php");




function validateExcelFile($temporary_file)
{
    $valid = false;
    $types = array('Excel2007', 'Excel5','application/vnd.openxmlformats-officedocument.spreadsheetml.sheet','text/xls','text/xlsx');//

foreach ($types as $type) {
      print("<br/> Type File:".$type);
      $reader = PHPExcel_IOFactory::createReader($type);
      if ($reader->canRead($temporary_file)) {
        $valid = true;
        break;
    }
  }    
  return $valid ;
}




function validateImageFile($temporary_file)
{
    $valid = false;
    $type = mime_content_type($temporary_file);
    print("<br/> Type File:".$type);
    if (strstr($type, 'image/')){
     $valid = true;
   }

  return $valid ;
}





function loadFile($typeFile, $elementName ) 
{
$file_name = $_FILES[$elementName]['name'];
$file_size = $_FILES[$elementName]['size'];
$file_error = $_FILES[$elementName]['error'];
$file_tmp= $_FILES[$elementName]['tmp_name'];

$target_dir = $_SERVER['DOCUMENT_ROOT'] . "/uploads/";
$target_file = $target_dir . $file_name;//basename($_FILES["photo"]["name"]);
print("<br/> Target File:".$target_file);

  //if they DID upload a file...
  if($file_name)
  {
    $valid_file =false;
    
    //Check the type of file
    if(strcmp($typeFile , 'Image')==0){
      $valid_file=validateImageFile($file_tmp);
    }
    if(strcmp($typeFile , 'Excel')==0){
       $valid_file=validateExcelFile($file_tmp);
    }
    print("<br/> Vailid File:".$valid_file);

    //if the file format has passed the test
    if($valid_file)
    {
      //Validating file size 5MB
        if($file_size <= 5242880)
        { 
          print("<br/> Vailid Size:".$file_size);
          //move it to where we want it to be
          move_uploaded_file($file_tmp, $target_file);
          $message = '';
        }
        else
        {
          $message = '<br/><br/>  Ooops! Your file is too big. Maximum size 5Mb.';
        }
    }
    else
    {
        $message = '<br/><br/>  Ooops!  Your file is not in the correct format.';
    }
}
//if there is an error...
else
{
    //set that to be the returned message
    $message = '<br/><br/>  Ooops!  Your upload triggered the following error:  '.$file_error;
}

  return $message ;

}// end of function loadLogo


    



function sendEmail($clubName, $category, $country, $state, $firstName, $lastName, $email, $logo, $members)
{


$host = "smtp.gmail.com";//ssl://
$username = "brendadhk@gmail.com";
$password = "ITz3L123@@";
$Port = 587;
$file_dir  = $_SERVER['DOCUMENT_ROOT'] . "/uploads/";


$to = "contact@dragonking.com.au";
$company = "Sports King Applications";
$email_subject = "New Club Subscription: $clubName";
$email_body =  "Hello, \n  \n".
    "There is a new club subscription form with the following information:\n \n ".
    "Club Name: $clubName.\n ".
    "Category:  $category.\n ".
    "Country:  $country.\n ".
    "State:  $state.\n ".
    "Executive member First Name:  $firstName.\n ".
    "Executive member Last Name:  $lastName.\n ".
    "Executive member email:  $email.\n  \n".
    "See attached their logo and members list.\n \n".
    "Regards, \n".
    "Sports King Applications (website) ";



//Create a new PHPMailer instance
$mail = new PHPMailer();
$mail->isSMTP();
$mail->Host = $host;
$mail->Port = $Port;
//$mail->SMTPDebug  = 1; 


$mail->SMTPSecure = 'ssl'; 
$mail->SMTPAuth = true;
$mail->Username = $username;
$mail->Password = $password;


$mail->SetFrom( $username, $username);
$mail->Subject   = $email_subject;
$mail->Body      = $email_body;
$mail->AddAddress( $to , $company );
$mail->AddAttachment( $file_dir.$logo);
$mail->AddAttachment( $file_dir.$members);

if(!$mail->Send()) {
    echo "<br/>  Mailer Error: " . $mail->ErrorInfo;
} else {
    echo "<br/>  Message sent!";
}


}


  if(!isset($_POST['submit']))
  {
    echo "Error, you need to submit a form.";
  }


    //$_POST = json_decode(file_get_contents('php://input'), true);


  //$data = file_get_contents("php://input");
  //$dataJsonDecode     = json_decode($data);
  //$clubName = $dataJsonDecode->clubName;
  //$category = $dataJsonDecode->category;
  //$country = $dataJsonDecode->country;
  //$state = $dataJsonDecode->state;
  //$firstName = $dataJsonDecode->firstName;
  //$lastName = $dataJsonDecode->lastName;
  //$email = $dataJsonDecode->email;
  //$logo = $dataJsonDecode->logo;
  //$members = $dataJsonDecode->members;




  //Getting the information

  $clubName = $_POST['clubName'];
  $category = $_POST['category'];
  $country = $_POST['country'];
  $state = $_POST['state'];
  $firstName = $_POST['firstName'];
  $lastName = $_POST['lastName'];
  $email = $_POST['email'];
  $logo = $_FILES[logo]['name'];
  $members = $_FILES[members]['name'];

    //Loading the files into the server
    $message = loadFile('Image', 'logo');
    $message = loadFile('Excel', 'members');

  //Validate that the fields are not empty. It is validated in the client side. Double validation just in case.
  //if(empty($firstName)|| empty($lastName)|| empty($email))
  //{ exit;  }


  //Send Email
  sendEmail( $clubName, $category, $country, $state, $firstName, $lastName, $email, $logo, $members );


  //header("Location:  https://www.bpoint.com.au/payments/SPORTSKING");

 ?>
