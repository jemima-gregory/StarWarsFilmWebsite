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

        //form validation
        if ($username === "" || $email === "" || $password1 === "" || $password2 === "" || empty($username) || empty($email) || empty($password1) || empty($password2) || $password1 !== $password2) {
            header("Location: register.php?error=1");
            exit();
        }
        if ($password1 !== $password2) {
            header("Location: register.php?error=2");
            exit();
        }

        //hashing the password
        $hashedPassword = password_hash($password1, PASSWORD_BCRYPT);

        $success = insertUser($username, $email, $hashedPassword);

        if ($success) {
            header("Location: registration_success.php");
            exit();
        } else {
            header("Location: register.php?error=2");
            exit();
        }
    }
    ?>


    <div class="main-content">
        <div class="row text-center">
            <h3>Successfully Registered!</h3>
            <p>Please <a class='button' href='login.php'>login</a></p>
        </div>
    </div>
</div>

</body>
</html>