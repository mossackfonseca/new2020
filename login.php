<?php
session_start();

//check if a button named login was clicked
if (isset($_POST["login"])) {


    //connect to the database
    include "connection.php";

    //get information from input fields
    $email = $_POST["email"];
    $password = $_POST["password"];

    $sql = "SELECT * FROM users WHERE users.email = '$email'";
    $result = mysqli_query($conn, $sql);

    if (mysqli_num_rows($result) > 0) {
        // output data of each row
        while ($row = mysqli_fetch_assoc($result)) {
            echo "found email";

            //get information from the database
            $db_password = $row["password"];

            if (password_verify($password, $db_password)) {
                echo "Welcome";

                $_SESSION["user_id"] = $row["user_id"];
                $_SESSION["first_name"] = $row["first_name"];
                $_SESSION["last_name"] = $row["last_name"];
                $_SESSION["email"] = $row["email"];
                $_SESSION["user_type"] = $row["user_type"];

                header("location: homepage.php");
                exit();
            } else {
                echo "Please try again";
            }
        }
    } else {
        echo "Incorrect information";
    }
}




include "header.php"; ?>

<h1>Login</h1>



<form action="login.php" method="post">

    <p>Enter your email</p>
    <p><input type="text" name="email"></p>

    <p>Enter your password</p>
    <p><input type="text" name="password"></p>

    <p><input type="submit" name="login"></p>



</form>



<?php include "footer.php"; ?>