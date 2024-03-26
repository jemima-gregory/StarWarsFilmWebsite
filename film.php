<!DOCTYPE html>
<html lang="en">

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

        <!-- Exists in a row class so the errors have a specific place to show if required.-->
        <div class="row">
            <?php
            if (isset($_GET['id'])) {
                $film_id = $_GET['id'];
                try {
                    $open_review_s_db = new PDO("sqlite:resources/star_wars.db");
                    $open_review_s_db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
                } catch (PDOException $e) {
                    die($e->getMessage());
                }
                try {
                    //a placeholder for id so that it can be bound
                    $stmt = $open_review_s_db->prepare("SELECT film.filmID, film_title, film_episode_id, film_opening_crawl, film_director, film_release_date, film.image_url
                                                                FROM film
                                                                WHERE film.filmID = :id");
                    $stmt->bindParam(':id', $film_id, PDO::PARAM_INT);
                    $stmt->execute();

                    //getting the result into an assoc-array for easy access
                    $result = $stmt->fetch(PDO::FETCH_ASSOC);

                    if ($result) {
                        $film_title = $result['film_title'];
                    } else {
                        echo "Film not found.";
                    }

                    //getting the producer for the given film
                    $stmt3 = $open_review_s_db->prepare("SELECT producer_name, producer.image_url
                                                                FROM producer, film_producer, film
                                                                WHERE producer.producerID = film_producer.producerID
                                                                        and film_producer.filmID = film.filmID
                                                                        and film.filmID = :id;");
                    $stmt3->bindParam(':id', $film_id, PDO::PARAM_INT);
                    $stmt3->execute();
                    $prod_result = $stmt3->fetch(PDO::FETCH_ASSOC);


                } catch (PDOException $e) {
                    die($e->getMessage());
                }
            }
            ?>
        </div>


        <div class="row">
            <div class="col text-center">
                <?php
                echo "<img height='500' src='". getImageUrl($result['image_url']) . "' /><br />";
                ?>
            </div>
            <div class="col">
                <h2><?php echo $film_title ?></h2>
                <p>Release Date: <?php echo $result['film_release_date']?></p><br />
                <p>Episode: <?php echo $result['film_episode_id']?></p><br />
                <p>Director: <?php echo $result['film_director']?></p><br />
                <p>Producer: <?php echo $prod_result['producer_name']?></p><br />
                <p><?php echo $result['film_opening_crawl']?></p><br /><br />
            </div>
        </div>


        <div class="row">
            <h3>characters:</h3>
        </div>

        <div class="row text-center mt-5">
            <div class="col">
                <div class="row">
                    <?php
                    $character_stmt = $open_review_s_db->prepare("SELECT people_name, people.peopleID, people.image_url as people_image_url
                                                                FROM film, film_people, people 
                                                                WHERE people.peopleID = film_people.peopleID 
                                                                  and film_people.filmID = film.filmID 
                                                                  and film.filmID = :id");
                    $character_stmt->bindParam(':id', $film_id, PDO::PARAM_INT);
                    $character_stmt->execute();

                    while($row = $character_stmt->fetch(PDO::FETCH_ASSOC)) {
                        echo "<div class='col-md-4'>
                            <a href='person.php?id=" . $row['peopleID'] ."'>
                                <img class='img-fluid square-image' src='" . getImageUrl($row['people_image_url']) . "' alt='" . $row['people_name'] . "'/>
                            </a>
                            <h5>" . $row['people_name'] . "</h5>
                          </div>";
                    }
                    ?>
                </div>
            </div>
        </div>




        <div class="row">
            <h3>starships:</h3>
        </div>

        <div class="row text-center mt-5">
            <div class="col">
                <div class="row">
                    <?php
                    $character_stmt = $open_review_s_db->prepare("SELECT starship_name, starship.starshipID, starship.image_url as starship_image_url
                                                       FROM film, film_starships, starship
                                                       WHERE film.filmID = film_starships.filmID
                                                               and film_starships.starshipID = starship.starshipID
                                                               and film.filmID = :id;");
                    $character_stmt->bindParam(':id', $film_id, PDO::PARAM_INT);
                    $character_stmt->execute();


                    while($row = $character_stmt->fetch(PDO::FETCH_ASSOC)) {
                        echo "<div class='col-md-4'>
                   <a href='starship.php?id=" . $row['starshipID'] ."'>
                       <img class='img-fluid square-image' src='" . getImageUrl($row['starship_image_url']) . "' alt='" . $row['starship_name'] . "'/>
                   </a>
                   <h5>" . $row['starship_name'] . "</h5>
                 </div>";
                    }
                    ?>
                </div>
            </div>
        </div>

        <div class="row">
            <h3>vehicles:</h3>
        </div>

        <div class="row text-center mt-5">
            <div class="col">
                <div class="row">
                    <?php
                    $character_stmt = $open_review_s_db->prepare("SELECT vehicle_name, vehicle.vehicleID, vehicle.image_url as vehicle_image_url
                                                       FROM film, film_vehicles, vehicle
                                                       WHERE film.filmID = film_vehicles.filmID
                                                               and film_vehicles.vehicleID = vehicle.vehicleID
                                                               and film.filmID = :id;");
                    $character_stmt->bindParam(':id', $film_id, PDO::PARAM_INT);
                    $character_stmt->execute();


                    while($row = $character_stmt->fetch(PDO::FETCH_ASSOC)) {
                        echo "<div class='col-md-4'>
                   <a href='vehicle.php'?id=" . $row['vehicleID'] ."'>
                       <img class='img-fluid square-image' src='" . getImageUrl($row['vehicle_image_url']) . "' alt='" . $row['vehicle_name'] . "'/>
                   </a>
                   <h5>" . $row['vehicle_name'] . "</h5>
                 </div>";
                    }
                    ?>
                </div>
            </div>
        </div>



    </div>

</div>

</body>

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?php echo $result['film_title']; ?> - Characters, Director, and Trivia</title>
    <meta name="description" content="Explore the details of the epic Star Wars film, <?php echo $result['film_title']; ?>. Dive into the plot, cast, iconic moments, and behind-the-scenes insights that made this movie a part of cinematic history.">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-T3c6CoIi6uLrA9TneNEoa7RxnatzjcDSCmG1MXxSR1GAsXEV/Dwwykc2MPK8M2HN" crossorigin="anonymous">
    <link rel="stylesheet" href="css/style.css" />
</head>

</html>