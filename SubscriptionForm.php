<?php
include 'Classes/PHPExcel/IOFactory.php';

function validateExcelFile($temporary_file)
{
    $valid = false;
    $types = array('Excel2007', 'Excel5');//,'application/vnd.ms-excel','text/xls','text/xlsx'

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











  if(isset($_POST['submit']))
  {
    echo="Error, you need to submit a form."
  }

  $message = loadFile('Image', 'logo');

  if($message ){
   $message = loadFile('Excel', 'members');
  }



if($message == '')
{


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
  print ("Missing mandatory fields.");
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

print ($email_body);

  $to = "contact@dragonking.com.au";
  $headers = "";
  mail($to,$email_subject,$email_body,$headers);


//header("Location:  https://www.bpoint.com.au/payments/SPORTSKING");

}



 ?>
