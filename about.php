<?php

@include 'config.php';

session_start();

$user_id = $_SESSION['user_id'];

if (!isset($user_id)) {
	header('location:login.php');
}

?>

<!DOCTYPE html>
<html lang="en">

<head>
	<meta charset="UTF-8">
	<meta http-equiv="X-UA-Compatible" content="IE=edge">
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	<title>about</title>

	<!-- font awesome cdn link  -->
	<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.1.1/css/all.min.css">

	<!-- custom css file link  -->
	<link rel="stylesheet" href="css/home.css">

</head>

<body>

	<?php include 'header.php'; ?>

	<div class="heading">
		<h3>About Us</h3>
		<p> <a href="home.php">Home</a> / About </p>
	</div>



	<section class="about">

		<div class="row">

			<div class="box">
				<img src="https://i.postimg.cc/5NV15gDn/Clipart-Key-540347.png" alt="">
				<h3>why choose us?</h3>
				<p>Our Group is committed to helping its clients reach their goals, to personalising their event experiences, to providing an innovative environment, and to making a difference.This sense of identification also means we value and promote seamless interaction with clients’ own teams, and ensure the best value is obtained from their event budget.</p>
				<a href="contact.php" class="readbtn">contact us</a>
			</div>

			<div class="box">
				<img src="https://www.inoidsolutions.com/resources/images/why-choose-us-second-section-img.svg" alt="">
				<h3>what we provide?</h3>
				<p>We’ve designed a new way for you to invest in companies that share your vision of the future. We call it, stock baskets.Put simply, they’re a portfolio of company stocks that share similar characteristics, and they’re based on sectors that are trying to make a difference</p>
				<a href="home.php" class="proceed-btn">Our Market</a>
			</div>

		</div>

	</section>

	<section class="review" id="review">

		<h1 class="headin"> customer's <span>review</span> </h1>

		<div class="box-container">

			<div class="box">
				<div class="stars">
					<i class="fas fa-star"></i>
					<i class="fas fa-star"></i>
					<i class="fas fa-star"></i>
					<i class="fas fa-star"></i>
					<i class="fas fa-star"></i>
				</div>
				<p>discipline whose activity consists in projecting visual communications intended to transmit specific messages to social groups, with specific objectives</p>
				<div class="user">
					<img src="https://images.unsplash.com/photo-1566753323558-f4e0952af115?ixlib=rb-1.2.1&ixid=MnwxMjA3fDB8MHxzZWFyY2h8MXx8bWFsZXxlbnwwfHwwfHw%3D&w=1000&q=80" alt="">
					<div class="user-info">
						<h3>Daniel Jacob</h3>
						<span>happy customer</span>
					</div>
				</div>
				<span class="fas fa-quote-right"></span>
			</div>

			<div class="box">
				<div class="stars">
					<i class="fas fa-star"></i>
					<i class="fas fa-star"></i>
					<i class="fas fa-star"></i>
					<i class="fas fa-star"></i>
					<i class="fas fa-star"></i>
				</div>
				<p>discipline whose activity consists in projecting visual communications intended to transmit specific messages to social groups, with specific objectives</p>
				<div class="user">
					<img src="https://ksassets.timeincuk.net/wp/uploads/sites/46/2015/12/iStock-000072270117-Medium-Output.jpg" alt="">
					<div class="user-info">
						<h3>Nora Hazel</h3>
						<span>happy customer</span>
					</div>
				</div>
				<span class="fas fa-quote-right"></span>
			</div>

			<div class="box">
				<div class="stars">
					<i class="fas fa-star"></i>
					<i class="fas fa-star"></i>
					<i class="fas fa-star"></i>
					<i class="fas fa-star"></i>
					<i class="fas fa-star"></i>
				</div>
				<p>discipline whose activity consists in projecting visual communications intended to transmit specific messages to social groups, with specific objectives</p>
				<div class="user">
					<img src="https://images.unsplash.com/photo-1570295999919-56ceb5ecca61?ixlib=rb-1.2.1&ixid=MnwxMjA3fDB8MHxzZWFyY2h8MTd8fHByb2ZpbGV8ZW58MHx8MHx8&w=1000&q=80" alt="">
					<div class="user-info">
						<h3>Axel Nolan</h3>
						<span>happy customer</span>
					</div>
				</div>
				<span class="fas fa-quote-right"></span>
			</div>

		</div>

	</section>









	<?php include 'footer.php'; ?>

	<script src="js/script.js"></script>

</body>

</html>