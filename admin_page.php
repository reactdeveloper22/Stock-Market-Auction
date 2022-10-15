<?php

@include 'config.php';

session_start();

$admin_id = $_SESSION['admin_id'];

if (!isset($admin_id)) {
   header('location:login.php');
}

?>

<!DOCTYPE html>
<html lang="en">

<head>
   <meta charset="UTF-8">
   <meta http-equiv="X-UA-Compatible" content="IE=edge">
   <meta name="viewport" content="width=device-width, initial-scale=1.0">
   <title>admin page</title>

   <!-- font awesome cdn link  -->
   <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.1.1/css/all.min.css">
   <link rel="preconnect" href="https://fonts.googleapis.com">
   <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
   <link href="https://fonts.googleapis.com/css2?family=Anton&display=swap" rel="stylesheet">

   <!-- custom css file link  -->
   <link rel="stylesheet" href="css/admin_style.css">

</head>

<body>
   <?php include 'admin_header.php'; ?>

   <section class="dashboard">


      <h1 class="title">dashboard</h1>

      <div class="box-container">

         <div class="box">
            <?php
            $select_products = $conn->prepare("SELECT * FROM `stock`");
            $select_products->execute();
            $number_of_products = $select_products->rowCount();
            ?>
            <h3><?= $number_of_products; ?></h3>
            <p>Stocks added</p>
            <a href="admin_products.php" class="btn">see Stocks</a>
         </div>

         <div class="box">
            <?php
            $select_accounts = $conn->prepare("SELECT * FROM `biddingwins`");
            $select_accounts->execute();
            $number_of_accounts = $select_accounts->rowCount();
            ?>
            <h3><?= $number_of_accounts; ?></h3>
            <p>Bid End & Winner</p>
            <a href="admin_page.php" class="btn">Bid End & Winner</a>
         </div>

         <div class="box">
            <?php
            $select_messages = $conn->prepare("SELECT * FROM `bidding`");
            $select_messages->execute();
            $number_of_messages = $select_messages->rowCount();
            ?>
            <h3><?= $number_of_messages; ?></h3>
            <p>Total Bidding</p>
            <a href="admin_page.php" class="btn">See Bidding</a>
         </div>
         <div class="box">
            <?php
            $select_messages = $conn->prepare("SELECT * FROM `bidding`  WHERE bid_await = ?");
            $select_messages->execute(['await']);
            $number_of_messages = $select_messages->rowCount();
            ?>
            <h3><?= $number_of_messages; ?></h3>
            <p>Total Bid</p>
            <a href="admin_page.php" class="btn">See Bid</a>
         </div>

         <div class="box">
            <?php
            $select_users = $conn->prepare("SELECT * FROM `stock` WHERE bid_value = ?");
            $select_users->execute(['done']);
            $number_of_users = $select_users->rowCount();
            ?>
            <h3><?= $number_of_users; ?></h3>
            <p>Total Sell Stocks</p>
            <a href="admin_page.php" class="btn">Total Sell Stocks</a>
         </div>

         <div class="box">
            <?php
            $select_accounts = $conn->prepare("SELECT * FROM `users`");
            $select_accounts->execute();
            $number_of_accounts = $select_accounts->rowCount();
            ?>
            <h3><?= $number_of_accounts; ?></h3>
            <p>total accounts</p>
            <a href="admin_users.php" class="btn">see accounts</a>
         </div>

         <div class="box">
            <?php
            $select_users = $conn->prepare("SELECT * FROM `users` WHERE user_type = ?");
            $select_users->execute(['user']);
            $number_of_users = $select_users->rowCount();
            ?>
            <h3><?= $number_of_users; ?></h3>
            <p>total users</p>
            <a href="admin_users.php" class="btn">see accounts</a>
         </div>

         <div class="box">
            <?php
            $select_admins = $conn->prepare("SELECT * FROM `users` WHERE user_type = ?");
            $select_admins->execute(['admin']);
            $number_of_admins = $select_admins->rowCount();
            ?>
            <h3><?= $number_of_admins; ?></h3>
            <p>total admins</p>
            <a href="admin_users.php" class="btn">see accounts</a>
         </div>
         </div>
   </section>


   <section class="tables">

      <h1 class="title">Bid End & Winner</h1>

      <table>
         <thead>
            <tr>
               <th>No</th>
               <th>Bid User</th>
               <th>Symbol</th>
               <th>Bid Catch Price</th>
               <th>Bid Close Date</th>
            </tr>
         </thead>

         <?php

         $show_products = $conn->prepare("SELECT * FROM `biddingwins`");
         $show_products->execute();
         if ($show_products->rowCount() > 0) {
            while ($fetch_products = $show_products->fetch(PDO::FETCH_ASSOC)) {
               # code...
               //$max = $fetch_products['bid_value'];
               //echo $max[0];
               //echo max([$max]);
               echo "<tr><td>" . $fetch_products['id'] . "<td/<td>" . $fetch_products['bid_user'] . "<td/<td>" . $fetch_products['symbol'] . "<td/<td>" . $fetch_products['bid_value'] . "<td/<td>" . $fetch_products['date_created'];
            }
            echo "</table>";
         ?>
      </table>

   <?php
         } else {
            echo '<p class="empty">no products added yet!</p>';
         }
   ?>

   </section>

   <script src="js/script.js"></script>




</body>

</html>