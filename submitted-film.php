<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Star Wars Film Submitted - Thank You!</title>
    <meta name="description" content="Thank you for submitting a new Star Wars film to our database. Your contribution is appreciated! Explore more of the Star Wars universe as we continue to expand our galaxy together.">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-T3c6CoIi6uLrA9TneNEoa7RxnatzjcDSCmG1MXxSR1GAsXEV/Dwwykc2MPK8M2HN" crossorigin="anonymous">
    <link rel="stylesheet" href="css/style.css" />
</head>
<body>

<div class="container-fluid">

    <div class="row text-center main-header">
        <h1>star wars film universe</h1>
    </div>


    <div class="row">
        <!-- Navigation -->
        <?php include "includes/navigation.php";?>
    </div>

    <div class="main-content">
        <div class="row text-center">

            <?php
            if (isset($_POST['film_title']) AND isset($_POST['film_episode_id']) AND isset($_POST['film_opening_crawl']) AND isset($_POST['film_director']) AND isset($_POST['film_release_date']) AND
                $_POST['film_title'] AND $_POST['film_episode_id'] AND $_POST['film_opening_crawl'] AND $_POST['film_director'] AND $_POST['film_release_date']) {
                $film_title = $_POST['film_title'];
                $film_episode_id = $_POST['film_episode_id'];
                $film_opening_crawl = $_POST['film_opening_crawl'];
                $film_director = $_POST['film_director'];
                $film_release_date = date($_POST['film_release_date']);




                //don't have to include an image, it is default null
                if (isset($_POST['image_url'])) {
                    $image_url = $_POST['image_url'];
                } else {
                    $image_url = Null; //setting it as null so the insert code can remain the same either way
                }

                try {
                    $open_review_s_db = new PDO("sqlite:resources/star_wars.db");
                    $open_review_s_db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
                } catch (PDOException $e) {
                    die($e->getMessage());
                }

                try {
                    $sql = $open_review_s_db->prepare("INSERT INTO film (filmID, film_title, film_episode_id, film_opening_crawl, film_director, film_release_date, image_url)
                        VALUES (null, :film_title, :film_episode_id, :film_opening_crawl, :film_director, :film_release_date, :image_url)");
                    $sql->bindParam(':film_title', $film_title, PDO::PARAM_STR);
                    $sql->bindParam(':film_episode_id', $film_episode_id, PDO::PARAM_INT);
                    $sql->bindParam(':film_opening_crawl', $film_opening_crawl, PDO::PARAM_STR);
                    $sql->bindParam(':film_director', $film_director, PDO::PARAM_STR);
                    $sql->bindParam(':film_release_date', $film_release_date, PDO::PARAM_STR);
                    $sql->bindParam(':image_url', $image_url, PDO::PARAM_STR);

                    if ($sql->execute()) {
                        $film_id = $open_review_s_db->lastInsertId();

                        $selectedProducer = isset($_POST['producer']) ? $_POST['producer'] : null;
                        if (!is_null($selectedProducer)) {
                            $producerInsert = $open_review_s_db->prepare("INSERT INTO film_producer (filmID, producerID) VALUES (:film_id, :producer_id)");
                            $producerInsert->bindParam(':film_id', $film_id, PDO::PARAM_INT);
                            $producerInsert->bindParam(':producer_id', $selectedProducer, PDO::PARAM_INT);
                            $producerInsert->execute();
                        }


                        if (isset($_POST['characters']) && is_array($_POST['characters'])) {
                            foreach ($_POST['characters'] as $character_id) {
                                $characterInsert = $open_review_s_db->prepare("INSERT INTO film_people (filmID, peopleID) VALUES (:film_id, :character_id)");
                                $characterInsert->bindParam(':film_id', $film_id, PDO::PARAM_INT);
                                $characterInsert->bindParam(':character_id', $character_id, PDO::PARAM_INT);
                                $characterInsert->execute();
                            }
                        }

                        if (isset($_POST['vehicles']) && is_array($_POST['vehicles'])) {
                            foreach ($_POST['vehicles'] as $vehicle_id) {
                                $vehicleInsert = $open_review_s_db->prepare("INSERT INTO film_vehicles (filmID, vehicleID) VALUES (:film_id, :vehicle_id)");
                                $vehicleInsert->bindParam(':film_id', $film_id, PDO::PARAM_INT);
                                $vehicleInsert->bindParam(':vehicle_id', $vehicle_id, PDO::PARAM_INT);
                                $vehicleInsert->execute();
                            }
                        }

                        if (isset($_POST['starships']) && is_array($_POST['starships'])) {
                            foreach ($_POST['starships'] as $starship_id) {
                                $starshipInsert = $open_review_s_db->prepare("INSERT INTO film_starships (filmID, starshipID) VALUES (:film_id, :starship_id)");
                                $starshipInsert->bindParam(':film_id', $film_id, PDO::PARAM_INT);
                                $starshipInsert->bindParam(':starship_id', $starship_id, PDO::PARAM_INT);
                                $starshipInsert->execute();
                            }
                        }

                        echo "<p>Successfully Added <a href='film.php?id=" . $film_id . "'>" . $film_title . "</a></p>";

                        echo "<a class='button' href='submit-film.php'>Submit Another!</a>";
                    } else {
                        echo "Unable to add film.";
                        echo "<a class='button' href='submit-film.php'>Try Again</a>";
                    }


                } catch (PDOException $e) {
                    die($e->getMessage());
                }
            } else {
                echo "Please fill out all fields (no image required)";
            }
            ?>

        </div>

    </div>

</div>

</body>
</html>
