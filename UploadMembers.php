<?php

  print("<br/> Who I am:".exec('whoami'));
  print("<br/>  File: ".$_FILES['photo']['name']);

  //if they DID upload a file...
  if($_FILES['photo']['name'])
  {
    $valid_file =true;
    $temporary_file = $_FILES['photo']['tmp_name'];
    print("<br/> Temporary File:".$temporary_file);


    //Validating image extension
    /*
    $allowedTypes = array(IMAGETYPE_PNG, IMAGETYPE_JPEG);
    $detectedType = exif_imagetype($_FILES['photo']['tmp_name']);
    if(!in_array($detectedType, $allowedTypes)) {
      $valid_file = false;
      print("<br/><br/>  Ooops! Your file is not a png or jpeg.");
    }
    */
    
    //Another option to check the type of file
    $type = mime_content_type($temporary_file);
    print("<br/> Type File:".$type);

if (strstr($type, 'image/'))
{
   $valid_file = true;
}
else
{
   $valid_file = false;
}




    //Validating file size 5MB
    if($_FILES['photo']['size'] > 5242880) { 
      $valid_file = false;
      print("<br/> Size:".$isImageValid);
    }

    //if the file has passed the test
    if($valid_file)
    {
      
      $target_dir = $_SERVER['DOCUMENT_ROOT'] . "/uploads/";
      $target_file = $target_dir . basename($_FILES["photo"]["name"]);
      print("<br/> Target File:".$target_file);

      //move it to where we want it to be
      move_uploaded_file($temporary_file, $target_file);
      $message = '<br/> <br/>  Congratulations!  Your file was accepted.';
    }
    else
    {
      $message = '<br/><br/>  Ooops! Your file is too big. Maximum size 25Mb or it might not be png or jpeg.';
    }
  }
  //if there is an error...
  else
  {
    //set that to be the returned message
    $message = '<br/><br/>  Ooops!  Your upload triggered the following error:  '.$_FILES['photo']['error'];
  }

  print($message);

?>

