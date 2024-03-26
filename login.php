<!DOCTYPE html>
<html lang="en" xmlns:mso="urn:schemas-microsoft-com:office:office" xmlns:msdt="uuid:C2F41010-65B3-11d1-A29F-00AA00C14882">
<head>
    <meta charset="UTF-8">
    <title>Star Wars Films - Register Join us today!</title>
    <meta name="description" content="Explore the Star Wars universe! Get detailed information about Star Wars films, characters, starships, planets, and more. Dive into the galaxy far, far away with in-depth analysis and trivia. Join our community of Star Wars enthusiasts today.">

    <script src="js/script.js"></script>

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-T3c6CoIi6uLrA9TneNEoa7RxnatzjcDSCmG1MXxSR1GAsXEV/Dwwykc2MPK8M2HN" crossorigin="anonymous">
    <link rel="stylesheet" href="css/style.css" />

</head>
<body>

<?php include "includes/functions.php";?>


<div class="container-fluid">

    <div class="row text-center main-header">
        <h1>star wars film universe</h1>
    </div>


    <div class="row">
        <!-- Navigation -->
        <?php include "includes/navigation.php";?>
    </div>

    <?php

    if (session_status() == PHP_SESSION_NONE) {
        session_start();
    }
    if (isset($_SESSION['userID'])) {
        header("Location: logged-in.php");
        exit();
    }


    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
        $usernameOrEmail = $_POST['usernameOrEmail'];
        $password = $_POST['hashedPassword'];

        //validate form
        if (empty($usernameOrEmail) || empty($password)) {
            echo "Please fill out both fields";
        }

        //checking that the username/email exists and getting their info
        $user = getUserByUsernameOrEmail($usernameOrEmail);

        //checking that the inputted password matches the stored hashed password
        if ($user) {
            if (password_verify($password, $user['hashedPassword'])) {
                //success, so getting session variables
                session_start();
                $_SESSION['userID'] = $user['userID'];
                $_SESSION['username'] = $user['username'];

                if (isset($_GET['error'])) {
                    $errorCode = $_GET['error'];
                    if ($errorCode == 3) {
                        header("Location: submit-film.php"); //success but take user back to submit film page
                        exit();
                    }
                } else {
                    header("Location: index.php"); //success take user to index page
                    exit();
                }

            } else {
                header("Location: login.php?error=2"); //password incorrect

            }
        } else {
            header("Location: login.php?error=1"); //username/email not in database

        }
    }
    ?>



    <div class="main-content">

        <div class="text-center"><h2>Login</h2></div>

        <div class="row">




            <?php
                $url =  "login.php";
                if (isset($_GET['error'])) {
                    $errorCode = $_GET['error'];
                    if ($errorCode == 3) {
                        $url = "login.php?error=3";
                    }
                }
            ?>

            <form action="<?php echo $url;?>" method="post" onsubmit="return validateLoginForm();">
                <script>
                    function validateLoginForm() {
                        var usernameOrEmail = document.getElementById('input-username-or-email').value;
                        var password = document.getElementById('input-password').value;

                        if (usernameOrEmail === "" || password === "") {
                            alert("Please fill out both fields");
                            return false;
                        }
                        return true;  //success
                    }

                </script>

                <br /><br />

                <div class="form-group">
                    <label for="input-username-or-email">Email or Username:</label>
                    <input id="input-username-or-email" class="form-control" type="text" name="usernameOrEmail" value="">
                </div>

                <?php
                    //only display if there is a related error
                    if (isset($_GET['error'])) {
                        $errorCode = $_GET['error'];
                        if ($errorCode == 1) {
                            echo "<div class='error-message'> <p>Error: username or email doesn't exist</p> </div>";
                        }
                    }
                ?>

                <div class="form-group">
                    <label for="input-password">Password:</label>
                    <input id="input-password" class="form-control" type="password" name="hashedPassword" value="">
                </div>

                <?php
                //only display if there is a related error
                if (isset($_GET['error'])) {
                    $errorCode = $_GET['error'];
                    if ($errorCode == 2) {
                        echo "<div class='error-message'> <p>Error: incorrect password</p> </div>";
                    }
                }
                ?>

                <br/>

                <input type="submit" class="btn btn-primary" value="Login">

                <br/><br/>

                <p>Not Registered? <a href="register.php">Register here</a></p>
            </form>
        </div>
    </div>
