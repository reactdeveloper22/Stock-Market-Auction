<?php

@include 'config.php';

session_start();

if (isset($_POST['update_product'])) {

    $pid = $_POST['pid'];
    $name = $_POST['symbol'];
    $name = filter_var($name, FILTER_SANITIZE_STRING);
    $price = $_POST['price'];
    $price = filter_var($price, FILTER_SANITIZE_STRING);
    $category = $_POST['security'];
    $category = filter_var($category, FILTER_SANITIZE_STRING);
    $details = $_POST['profit'];
    $details = filter_var($details, FILTER_SANITIZE_STRING);
    $bid_user = $_POST['bid_user'];
    $bid_user = filter_var($bid_user, FILTER_SANITIZE_STRING);
    $bid_value = $_POST['bid_value'];
    $bid_value = filter_var($bid_value, FILTER_SANITIZE_STRING);
    $bid_end_datetime = $_POST['bid_end_datetime'];
    $bid_end_datetime = filter_var($bid_end_datetime, FILTER_SANITIZE_STRING);

    $select = $conn->prepare("SELECT * FROM `bidding` WHERE bid_value = ?");
    $select->execute([$bid_value]);

    if ($select->rowCount() > 0) {
        # code...
        $message[3] = 'Bid value Already Exits';
    } else {
        if ($bid_value > $details) {
            # code...
            $update_product = $conn->prepare("INSERT INTO `bidding`(symbol, price, security, profit, bid_user, bid_value, bid_end_datetime) VALUES(?,?,?,?,?,?,?)");
            $update_product->execute([$name, $price, $category, $details, $bid_user, $bid_value, $bid_end_datetime]);

            $message[1] = 'Stock bid successfully!';
        } else {
            $message[2] = "Your stock bid price is low";
        }
    }
}

?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>update products</title>

    <!-- CSS only -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.0-beta1/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-0evHe/X+R7YkIZDRvuzKMRqM+OrBnVFBL6DOitfPri4tjfHxaWutUpFmBp4vmVor" crossorigin="anonymous">

    <!-- custom css file link  -->
    <link rel="stylesheet" href="css/bit.css">

</head>

<body>

    <?php

    if (isset($message[2])) {
        foreach ($message as $message) {
            echo '
      <div class="messages">
      <img src="./assets/error.png" alt="">
      <h2>Sorry!</h2>
         <span>' . $message . '</span>
         <button type="button" onclick="this.parentElement.remove();">Ok</button>
      </div>
      ';
        }
    } else if (isset($message[1])) {
        foreach ($message as $message) {
            echo '
      <div class="messages">
      <img src="./assets/404-tick.png" alt="">
      <h2>Successfully!</h2>
         <span>' . $message . '</span>
         <a href="home.php">
         <button type="button" onclick="this.parentElement.remove();">Ok</button>
         </a>
      </div>
      ';
        }
    } else if (isset($message[3])) {
        # code...
        foreach ($message as $message) {
            echo '
      <div class="messages">
      <img src="./assets/error.png" alt="">
      <h2>Sorry!</h2>
         <span>' . $message . '</span>
         <button type="button" onclick="this.parentElement.remove();">Ok</button>
      </div>
      ';
        }
    }

    ?>

    <section class="update-product">

        <h1 class="title">quick view</h1>

        <?php
        $update_id = $_GET['update'];
        $select_products = $conn->prepare("SELECT * FROM `stock` WHERE id = ?");
        $select_products->execute([$update_id]);
        if ($select_products->rowCount() > 0) {
            while ($fetch_products = $select_products->fetch(PDO::FETCH_ASSOC)) {
        ?>
                <div class="card" style="width: 60rem;">
                    <div class="card-body">
                        <h3 class="card-title"><?= $fetch_products['symbol']; ?></h3>
                        <br>
                        <form action="" method="post">


                            <input type="hidden" name="pid" value="<?= $fetch_products['id']; ?>">
                            <input type="hidden" name="symbol" placeholder="Enter Stock Name" required class="box" value="<?= $fetch_products['symbol']; ?>">
                            <input type="hidden" name="price" min="0" placeholder="Enter Stock security" required class="box" value="<?= $fetch_products['price']; ?>">
                            <input type="hidden" name="security" min="0" placeholder="Enter Stock security" required class="box" value="<?= $fetch_products['security']; ?>">
                            <input type="hidden" name="profit" min="0" placeholder="Enter Stock Profit" required class="box" value="<?= $fetch_products['profit']; ?>">

                            <input type="hidden" name="bid_end_datetime" min="0" placeholder="Bidding End Date/Time" required class="box" value="<?= $fetch_products['bid_end_datetime']; ?>">
                            <input type="hidden" name="pid" value="<?= $fetch_products['id']; ?>">

                            <label for="" class="control-label">Price:
                                <h5 class="card-tit"><?= $fetch_products['price']; ?></h5>
                            </label>

                            <label for="" class="control-label">Security:
                                <h5 class="card-tit"><?= $fetch_products['security']; ?></h5>
                            </label>

                            <label for="" class="control-label">Profit:
                                <h5 class="card-tit"><?= $fetch_products['profit']; ?></h5>
                            </label>

                            <label for="" class="control-label">Bid Create Date:
                                <h5 class="card-tit"><?= $fetch_products['date_created']; ?></h5>
                            </label>

                            <label for="" class="control-label">Bid End Date & Time:
                                <h5 class="card-tit"><?= $fetch_products['bid_end_datetime']; ?></h5>
                            </label>
                            <br>

                            <div class="input-group mb-3">
                                <span class="input-group-text spanOne" id="inputGroup-sizing-default">Enter Your Name</span>
                                <input type="text" name="bid_user" class="form-control" aria-label="Sizing example input" aria-describedby="inputGroup-sizing-default">
                            </div>

                            <div class="input-group mb-3">
                                <span class="input-group-text" id="inputGroup-sizing-default">Enter Your Bid Value</span>
                                <input type="number" name="bid_value" class="form-control" aria-label="Sizing example input" aria-describedby="inputGroup-sizing-default">
                            </div>

                            <br>
                            <br>

                            <div class="flex-btn">
                                <input type="submit" class="btn btn-primary" value="BID" name="update_product">
                                <a href="home.php">
                                    <button type="button" class="btn btn-warning">Go Back</button>
                                </a>
                            </div>



                        </form>
                    </div>
            <?php
            }
        } else {
            echo '<p class="empty">no products found!</p>';
        }
            ?>

    </section>













    <script src="js/script.js"></script>

</body>

</html>