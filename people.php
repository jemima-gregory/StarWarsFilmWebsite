<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>All Star Wars Characters - Profiles and More</title>
    <meta name="description" content="Discover a comprehensive list of Star Wars characters, from Jedi knights to Sith lords. Click on any character to explore their profiles, backstories, and more.">
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

    <div class="main-content">

        <div class="row text-center carousel-outer">
            <?php
                try {
                    $open_review_s_db = new PDO("sqlite:resources/star_wars.db");
                    $open_review_s_db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
                } catch (PDOException $e) {
                    die($e->getMessage());
                }
            ?>

            <div id="carousel" class="carousel slide" data-ride="carousel" data-interval="4000">
                <div class="carousel-inner">

                    <?php
                    $res = $open_review_s_db->query("SELECT peopleID, people_name, people_height, people_mass, 
                                                                    people_hair_color, people_skin_color, people_eye_color, 
                                                                    people_birth_year, people_gender, people.image_url, 
                                                                    species_name, planet_name, speciesID, 
                                                                    planetID
                                                                FROM people, species, planet
                                                                WHERE people_homeworld_id = planetID
                                                                  and people_species_id = speciesID");
                    $first = true;

                    while($row = $res->fetch(PDO::FETCH_ASSOC)) {
                        //needs to be "active" for the first item
                        $activeClass = $first ? "active" : "";

                        echo "<div class='carousel-item $activeClass'>
                                <a href='person.php?id=" . $row['peopleID'] ."'>
                                    <div class='square-image'>
                                        <img class='d-block carousel-image' style='width: 300px; height: 300px;' src='" . getImageUrl($row['image_url']) . "' alt='" . $row['people_name'] . "'/>
                                    </div>
                                </a>

                                <div class='carousel-caption'>
                                    <br>
                                    <h3>" . $row['people_name'] . "</h3>
                                    <p>Height: " . $row['people_height'] . "<br/>
                                    Hair Colour: " . $row['people_eye_color'] .  "<br/>
                                    Skin Colour: " . $row['people_skin_color'] .  "<br/>
                                    Eye Colour: " . $row['people_eye_color'] .  "<br/>
                                    Species: <a href='species.php?id=" . $row['speciesID'] .  "'>" . $row["species_name"] .  "</a><br/>
                                    Home Planet: <a href='planet.php?id=" . $row['planetID'] .  "'>" . $row["planet_name"] .  "</a></p>
                                </div>
                              </div>";
                        $first = false; //done with first item
                    }
                    ?>
                </div>
            </div>
        </div>

        <div class="row text-center mt-5">
            <div class="col">
                <div class="row">
                    <?php
                    $res = $open_review_s_db->query("SELECT peopleID, people_name, image_url FROM people");

                    while($row = $res->fetch(PDO::FETCH_ASSOC)) {
                        echo "<div class='col-md-4'>
                            <a href='person.php?id=" . $row['peopleID'] ."'>
                                <img class='img-fluid square-image' src='" . getImageUrl($row['image_url']) . "' alt='" . $row['people_name'] . "'/>
                            </a>
                            <h5>" . $row['people_name'] . "</h5>
                          </div>";
                    }
                    ?>
                </div>
            </div>
        </div>

    </div>

</div>

</body>
</html>
