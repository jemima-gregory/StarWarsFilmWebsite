<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>All Star Wars Planets - Explore the Galactic Worlds</title>
    <meta name="description" content="Journey through the diverse worlds of the Star Wars galaxy. Browse a complete list of planets, each with its unique lore, geography, and significance in the epic saga.">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-T3c6CoIi6uLrA9TneNEoa7RxnatzjcDSCmG1MXxSR1GAsXEV/Dwwykc2MPK8M2HN" crossorigin="anonymous">

    <script src="https://code.jquery.com/jquery-3.3.1.slim.min.js" integrity="sha384-q8i/X+965DzO0rT7abK41JStQIAqVgRVzpbzo5smXKp4YfRvH+8abtTE1Pi6jizo" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/popper.js@1.14.3/dist/umd/popper.min.js" integrity="sha384-ZMP7rVo3mIykV+2+9J3UJ46jBk0WLaUAdn689aCwoqbBJiSnjAK/l8WvCWPIPm49" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@4.1.3/dist/js/bootstrap.min.js" integrity="sha384-ChfqqxuZUCnJSK3+MXmPNIyE6ZbWh2IMqE241rYiqJxyMiZ6OW/JmZQ5stwEULTy" crossorigin="anonymous"></script>

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


    <div class="main-content planet-content">
        <div class="row text-center">
            <?php
                try {
                    $open_review_s_db = new PDO("sqlite:resources/star_wars.db");
                    $open_review_s_db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
                } catch (PDOException $e) {
                    die($e->getMessage());
                }
            ?>

            <div class="col">

            </div>
            <div class="col">
                <div id="carousel" class="carousel slide" data-ride="carousel" data-interval="4000">
                    <div class="carousel-inner">

                        <?php
                        $res = $open_review_s_db->query("SELECT planetID, planet_name, image_url FROM planet");
                        $first = true;

                        while($row = $res->fetch(PDO::FETCH_ASSOC)) {
                            //needs to be "active" for the first item
                            $activeClass = $first ? "active" : "";

                            echo "<div class='carousel-item $activeClass'>
                                    <a href='planet.php?id=" . $row['planetID'] ."'><img class='d-block w-100' src='" . getImageUrl($row['image_url']) . "' alt='" . $row['planet_name'] . "'/></a>
                                    <div class='carousel-caption'>
                                        <h3>" . $row['planet_name'] . "</h3>
                                    </div>
                                  </div>";
                            $first = false; //done with first item
                        }
                        ?>
                    </div>
                </div>
            </div>

            <div class="col">

            </div>
        </div>

        <div class="row text-center mt-5">
            <div class="col">
                <div class="row justify-content-center">
                    <?php
                    $res = $open_review_s_db->query("SELECT planetID, planet_name, image_url FROM planet");
                    $count = 0;

                    while($row = $res->fetch(PDO::FETCH_ASSOC)) {
                        if ($count % 5 == 0) {
                            echo '</div><div class="row justify-content-center">';
                        }

                        echo "<div class='col-md-2'>
                            <a href='planet.php?id=" . $row['planetID'] ."'><img class='img-fluid' src='" . getImageUrl($row['image_url']) . "' alt='" . $row['planet_name'] . "'/></a>
                            <h5>" . $row['planet_name'] . "</h5>
                          </div>";
                        $count++;
                    }
                    ?>
                </div>
            </div>
        </div>

    </div>

</div>

</body>
</html>
