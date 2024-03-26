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
    //processing the form once submitted
    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
        $username = $_POST['username'];
        $email = $_POST['email'];
        $password1 = $_POST['password1'];
        $password2 = $_POST['password2'];

        if (checkUsername($username)) {
            header("Location: register.php?error=1"); //username already in use
        } elseif (checkEmail($email)) {
            header("Location: register.php?error=2"); //email already in use
        } else {
            //hashing the password
            $hashedPassword = password_hash($password1, PASSWORD_BCRYPT);

            $success = insertUser($username, $email, $hashedPassword);

            if ($success) {
                header("Location: registration-success.php");
                exit();
            } else {
                exit();
            }
        }
    }
    ?>


    <div class="main-content">
        <div class="text-center"><h2>Register</h2></div>
        <div class="row ">
            <form action="register.php" method="post" onsubmit="return validateForm();">
                <script>
                    function validateForm() {
                        var password1 = document.getElementById('input-password1').value;
                        var password2 = document.getElementById('input-password2').value;
                        var username = document.getElementById('input-username').value;
                        var email = document.getElementById('input-email').value;

                        if (password1 !== password2) {
                            alert("Passwords must match");
                            return false;
                        }

                        if (password1 === "" || password2 === "" || username === "" || email === "") {
                            alert("Please fill in all fields");
                            return false;
                        }

                        return true;

                    }
                </script>

                <br /><br />
                <div class="form-group">
                    <label for="input-username">Username:</label>
                    <input id="input-username" class="form-control" type="text" name="username" value="">
                </div>

                <?php
                //only display if there is a related error
                if (isset($_GET['error'])) {
                    $errorCode = $_GET['error'];
                    if ($errorCode == 1) {
                        echo "<div class='error-message'> <p>Error: username already in use, please choose another</p> </div>";
                    }
                }
                ?>

                <div class="form-group">
                    <label for="input-email">Email:</label>
                    <input id="input-email" class="form-control" type="text" name="email" value="">
                </div>

                <?php
                //only display if there is a related error
                if (isset($_GET['error'])) {
                    $errorCode = $_GET['error'];
                    if ($errorCode == 2) {
                        echo "<div class='error-message'> <p>Error: email already in use, <a href='login.php'>login here</a></p> </div>";
                    }
                }
                ?>

                <div class="form-group">
                    <label for="input-password1">Password:</label>
                    <input id="input-password1" class="form-control" type="text" name="password1" value="">
                </div>

                <div class="form-group">
                    <label for="input-password2">Password Again:</label>
                    <input id="input-password2" class="form-control" type="text" name="password2" value="">
                </div>

                <br/>
                <input type="submit" class="btn btn-primary" value="Register">
                <br/>
                <br/>
                <p>Already Registered? <a href="login.php">Login here</a></p>

            </form>
        </div>
    </div>
</div>

</body>
</html>