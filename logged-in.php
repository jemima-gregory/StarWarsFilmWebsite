<!DOCTYPE html>
<html lang="en" xmlns:mso="urn:schemas-microsoft-com:office:office" xmlns:msdt="uuid:C2F41010-65B3-11d1-A29F-00AA00C14882">
<head>
    <meta charset="UTF-8">
    <title>Star Wars Films - Account</title>
    <meta name="description" content="Explore the Star Wars universe! Get detailed information about Star Wars films, characters, starships, planets, and more. Dive into the galaxy far, far away with in-depth analysis and trivia. View Your account today">

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

    <div class="main-content text-center">

        <p>You're already logged in!</p>
        </br>
        <p>Click here to <a href="logout.php">logout</a></p>

        <?php
        if (session_status() == PHP_SESSION_NONE) {
            session_start();
        }

        ?>

    </div>

</div>
</body>
</html>
