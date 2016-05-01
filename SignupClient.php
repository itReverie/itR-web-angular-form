<html>
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
    <meta content="True" name="HandheldFriendly">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=0">
    <meta name="keywords" content="Paddling">
    <title>Sign Up Form</title>
    
    <link href="./dk/css" rel="stylesheet" type="text/css">
    <link href="./dk/css/bootstrap.min.css" rel="stylesheet">
    <link href="./dk/css/dk_style.css" rel="stylesheet">
</head>

<body>




<form action="SubscriptionForm.php" method="post" enctype="multipart/form-data" >


<!-- Landing     -->
<div class="container landing-page ">
<div class="row">

<!-----------------------------------CLUB INFORMATION-------------------------------------------->
<div class="col-xs-12">

<hr />

</div>
<div class="col-xs-12">
<h1 class="text-align-center">Club Information</h1>
</div>
<div class="col-xs-12 text-align-center space-between"><input class="text-align-center" style="width: 350px;" type="text" placeholder="Club Name" name="clubName"/></div>
<div class="col-xs-12 text-align-center space-between"><select style="width: 375px;height:40px;" name="category">
<option value="Local">Local</option>
<option value="State">State</option>
<option value="National">National</option>
</select></div>
<div class="col-xs-12 text-align-center space-between">
<select style="width: 375px;height:40px;" name="country">
<option value="AUS">Australia</option>
</select></div>
<div class="col-xs-12 text-align-center space-between">
<select style="width: 375px;height:40px;" name="state">
<option value="NSW">NSW</option>
<option value="ACT">ACT</option>
<option value="VIC">VIC</option>
<option value="QLD">QLD</option>
<option value="SA">SA</option>
<option value="WA">WA</option>
<option value="NT">NT</option>
<option value="TAS">TAS</option>
</select></div>

<div class="col-xs-12 text-align-center space-between">
    Upload your logo (.jpg,.png): 
    <input type="file" class="text-align-center" name="logo"/>
</div>

<div class="col-xs-12 text-align-center space-between">
    Upload you list of members (Excel .xls) : 
    <input type="file" class="text-align-center"  name="members"/>
</div>



<!-----------------------------------MAIN BOARD MEMBER-------------------------------------------->
<div class="col-xs-12">

<hr />

</div>
<div class="col-xs-12">
<h1 class="text-align-center">Main Board Member</h1>
</div>
<div class="col-xs-12 text-align-center space-between"><input class="text-align-center" style="width: 350px;" type="text" placeholder="First Name" name="firstName"/></div>
<div class="col-xs-12 text-align-center space-between"><input class="text-align-center" style="width: 350px;" type="text" placeholder="Last Name" name="lastName"/></div>
<div class="col-xs-12 text-align-center space-between"><input class="text-align-center" style="width: 350px;" type="email" placeholder="Email" name="email"/></div>
<div class="col-xs-12 text-align-center space-between">
<input  type="submit" value="submit" name="submit" alt="Submit" />
</div>

</div>

<div class="row"></div>
</div>





<div class="col-xs-12 text-align-center space-between">
  <span><?php print (base64_decode($_GET['msg'])); ?> </span>
</div>



</form>



<script src="./dk/js/jquery-2.2.0.min.js"></script>
<script src="./dk/js/bootstrap.min.js"></script>

</body>
</html>