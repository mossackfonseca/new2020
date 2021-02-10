<?php include "header.php"; ?>


<h1>STORE</h1>
<?php
include "connection.php";
$sql = "SELECT * from items";
$result = mysqli_query($conn, $sql);

if (mysqli_num_rows($result) > 0) {
    // output data of each row
    while ($row = mysqli_fetch_assoc($result)) {
        echo "Hello";
    }
} else {
    echo "0 results";
}

?>

<style>
    @import url('https://fonts.googleapis.com/css?family=Nunito+Sans:300,400,600,700,800&display=swap');

    .product-list {
        padding: 20px 10px 20px;
        font-family: 'Nunito Sans', sans-serif;
    }

    .product-list>ul {
        margin: 0 -10px;
        padding: 0;
        list-style: none;
        display: flex;
    }

    .product-list>ul>li {
        width: 25%;
        padding: 10px;
    }

    .white-box {
        border-radius: 5px;
        box-shadow: 0 0 3px 0 rgba(0, 0, 0, 0.4);
        background-color: #ffffff;
        padding: 35px 20px;
        transition: all 0.5s ease-in-out;
        position: relative;
    }

    .wishlist-icon {
        position