<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Star Wars Films List - Posters, Release Dates</title>
    <meta name="description" content="Explore the complete list of Star Wars films, from the original trilogy to the latest releases. Get release dates, posters, and in-depth details about each movie in the iconic saga.">

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-T3c6CoIi6uLrA9TneNEoa7RxnatzjcDSCmG1MXxSR1GAsXEV/Dwwykc2MPK8M2HN" crossorigin="anonymous">
    <link rel="stylesheet" href="css/style.css" />

    <script src="https://code.jquery.com/jquery-3.3.1.slim.min.js" integrity="sha384-q8i/X+965DzO0rT7abK41JStQIAqVgRVzpbzo5smXKp4YfRvH+8abtTE1Pi6jizo" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/popper.js@1.14.3/dist/umd/popper.min.js" integrity="sha384-ZMP7rVo3mIykV+2+9J3UJ46jBk0WLaUAdn689aCwoqbBJiSnjAK/l8WvCWPIPm49" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@4.1.3/dist/js/bootstrap.min.js" integrity="sha384-ChfqqxuZUCnJSK3+MXmPNIyE6ZbWh2IMqE241rYiqJxyMiZ6OW/JmZQ5stwEULTy" crossorigin="anonymous"></script>
</head>
<body>

<?php include "includes/functions.php";?>

<div class="container-fluid">

    <div class="row text-center main-header">
        <h1>star wars film universe</h1>
    </div>

    <div class="row">
        <!-- Navigation -->
        <?php
            include "includes/navigation.php";

            if (isset($_POST['search'])) {
            $search_term = $_POST['search'];
            $results = searchFilms($search_term);
            }

        ?>

    </div>


    <div class="main-content">
        <div class="row text-center">
            <?php
            try {
                $open_review_s_db = new PDO("sqlite:resources/star_wars.db");
                $open_review_s_db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
            } catch (PDOException $e) {
                die($e->getMessage());
            }
            ?>
        </div>

        <div class="row text-center">
            <div class="col film-carousel">
                <div id="carousel" class="carousel slide film-carousel" data-ride="carousel" data-interval="4000">
                    <div class="carousel-inner">

                        <?php
                        $res = $open_review_s_db->query("SELECT filmID, film_title, film_release_date, image_url FROM film");
                        $first = true;

                        while($row = $res->fetch(PDO::FETCH_ASSOC)) {
                            //needs to be "active" for the first item
                            $activeClass = $first ? "active" : "";

                            echo "<div class='carousel-item $activeClass'>
                                    <a href='film.php?id=" . $row['filmID'] ."'><img class='d-block w-100' src='" . getImageUrl($row['image_url']) . "' alt='" . $row['film_title'] . " Movie Poster'/></a>
                                  </div>";
                            $first = false; //done with first item
                        }
                        ?>
                    </div>
                </div>
            </div>



            <div class="col search">

                <div class="row search-bar">
                    <h3>search for a film</h3>
                    <!-- Search -->
                    <form action="films.php" method="post">
                        <label for="search-bar">Search:</label>
                        <input type="text" id="search-bar" name="search">
                        <input type="submit" value="Search">
                    </form>
                </div>

                <div class="row search-results">
                    <?php
                    if (isset($results)) {
                        if (!empty($results)) {
                            echo "<p>Search Results:</p>";
                            foreach ($results as $result) {
                                echo "<a href='film.php?id=" . $result['filmID'] . "'>" . $result['film_title'] . "</a><br><br>";
                            }
                        } else {
                            echo "<p>No results found.</p>";
                        }
                    }
                    ?>
                </div>

            </div>

        </div>

        <div class="row text-center mt-5">
            <div class="col">
                <div class="row">
                    <?php
                    $res = $open_review_s_db->query("SELECT filmID, film_title, film_release_date, image_url FROM film");

                    while($row = $res->fetch(PDO::FETCH_ASSOC)) {
                        echo "<div class='col-md-4'>
                            <a href='film.php?id=" . $row['filmID'] ."'><img class='img-fluid' src='" . getImageUrl($row['image_url']) . "' alt='" . $row['film_title'] . " Movie Poster'/></a>
                            <h3>" . $row['film_title'] . "</h3>
                            <p>" . $row['film_release_date'] . "</p>
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

