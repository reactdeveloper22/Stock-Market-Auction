<?php

@include 'config.php';

session_start();

$user_id = $_SESSION['user_id'];

if(!isset($user_id)){
   header('location:login.php');
};

?>

<!DOCTYPE html>
<html lang="en">
<head>
   <meta charset="UTF-8">
   <meta http-equiv="X-UA-Compatible" content="IE=edge">
   <meta name="viewport" content="width=device-width, initial-scale=1.0">
   <title>contact</title>

   <!-- font awesome cdn link  -->
   <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.1.1/css/all.min.css">

   <!-- custom css file link  -->
   <link rel="stylesheet" href="css/home.css">

</head>
<body>
 

<?php include 'header.php'; ?>
<div class="heading-team">
   <h3>Team Members</h3>
</div>

<h1 class="title">Our Team</h1>

<section class="teams">

<div class="Ateam">
   <h1 class="team">21UG1049<br>Sashen</h1>
   <h1 class="team">21UG1049<br>pamodya</h1>
   <h1 class="team">21UG1049<br>praveen</h1>
</div>
	</section>


<?php include 'footer.php'; ?> 

<script src="js/script.js"></script>

</body>
</html>