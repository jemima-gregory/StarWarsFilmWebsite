<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Add New Star Wars Film - Submit Movie Details</title>
    <meta name="description" content="Contribute to the Star Wars legacy! Add a new film to our database and share its details with the Star Wars community. Join us in expanding our galaxy far, far away.">


    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-T3c6CoIi6uLrA9TneNEoa7RxnatzjcDSCmG1MXxSR1GAsXEV/Dwwykc2MPK8M2HN" crossorigin="anonymous">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-datepicker@1.9.0/dist/css/bootstrap-datepicker.min.css" rel="stylesheet">

    <link rel="stylesheet" href="css/style.css" />
</head>
<body>


<?php
    session_start();

    if (!isset($_SESSION['userID'])) {
        //not logged in, send to login
        header("Location: login.php?error=3");
        exit();
    }

    if ($_SESSION['username'] !== 'admin') {
        //not admin, so access denied
        header("Location: access-denied.php");
        exit();
    }

?>

<div class="container-fluid">

    <div class="row text-center main-header">
        <h1>star wars film universe</h1>
    </div>

    <div class="row">
        <!-- Navigation -->
        <?php include "includes/navigation.php";?>
    </div>

    <div class="main-content">
        <div class="row">
            <h2>Submit a Film</h2>
        </div>

        <div class="row">
            <form action="submitted-film.php" method="post" onsubmit="return validateForm();">
                <script>
                    function validateForm() {
                        var film_title = document.getElementById('input-film-title').value;
                        var film_episode_id = document.getElementById('input-episode-number').value;
                        var film_opening_crawl = document.getElementById('input-opening-crawl').value;
                        var film_director = document.getElementById('input-director').value;
                        var film_release_date = document.getElementById('input-release-date').value;
                        var producer = document.getElementById('input-producer').value;

                        if (film_title === "" || film_episode_id === "" || film_opening_crawl === "" || film_director === "" || film_release_date === "" || producer === "") {
                            alert("Please fill in all fields");
                            return false;
                        }

                        if (isNaN(Number(film_episode_id))){
                            alert("Episode Id must be an integer.");
                            return false;
                        }

                        var date_split = film_release_date.split('/');

                        if (date_split.length !== 3){
                            alert("Please write the date in DD/MM/YYYY format.");
                            return false;
                        }

                        var day = parseInt(date_split[0], 10);
                        var month = parseInt(date_split[1], 10);
                        var year = parseInt(date_split[2], 10);

                        if (isNaN(day) || isNaN(month) || isNaN(year)) {
                            alert("Please write the date in DD/MM/YYYY format.");
                            return false;
                        }

                        if (day < 1 || day > 31 || month < 1 || month > 12) {
                            alert("Please write the date in DD/MM/YYYY format.");
                            return false;
                        }

                        var release_date = new Date(year, month - 1, day); //month - 1 because months are 0-based

                        if (isNaN(release_date)) {
                            alert("Release Date must be a valid date");
                            return false;
                        }

                        return true;
                    }
                </script>

                <br /><br />
                <div class="form-group">
                    <label for="input-film-title">Film Title:</label>
                    <input id="input-film-title" class="form-control" type="text" name="film_title" value="">
                </div>
                <div class="form-group">
                    <label for="input-episode-number">Episode Number:</label>
                    <input id="input-episode-number" class="form-control" type="text" name="film_episode_id" value="">
                </div>
                <div class="form-group">
                    <label for="input-opening-crawl">Opening Crawl:</label>
                    <input id="input-opening-crawl" class="form-control" type="text" name="film_opening_crawl" value="">
                </div>
                <div class="form-group">
                    <label for="input-director">Director:</label>
                    <input id="input-director" class="form-control" type="text" name="film_director" value="">
                </div>
                <div class="form-group">
                    <label for="input-release-date">Release Date:</label>
                    <input id="input-release-date" class="form-control datepicker" type="text" name="film_release_date" value="" placeholder="DD/MM/YYYY">
                </div>
                <div class="form-group">
                    <label for="input-image_url">Film Poster Image URL:</label>
                    <input id="input-image_url" class="form-control" type="text" name="image_url" value="">
                </div>

                <div class="form-group">
                    <label for="input-producer">Producer:</label>
                    <select id="input-producer" class="form-select" name="producer">
                        <option value="" disabled selected>Select a Producer</option>
                        <?php
                        $open_review_s_db = new PDO("sqlite:resources/star_wars.db");
                        $open_review_s_db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
                        $res = $open_review_s_db->query("SELECT producerID, producer_name FROM producer");

                        while ($row = $res->fetch(PDO::FETCH_ASSOC)) {
                            echo "<option value='" . $row['producerID'] . "'>" . $row['producer_name'] . "</option>";
                        }
                        ?>
                    </select>
                </div>




                <div class="form-group">
                    <label for="characters">Characters:</label>
                    <div class="row">
                        <?php
                        $open_review_s_db = new PDO("sqlite:resources/star_wars.db");
                        $open_review_s_db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

                        $res = $open_review_s_db->query("SELECT peopleID, people_name, image_url FROM people");

                        while ($row = $res->fetch(PDO::FETCH_ASSOC)) {
                            echo "<div class='col-6 col-md-4 col-lg-3'>";
                            echo "<div class='form-check'>
                    <input class='form-check-input' type='checkbox' name='characters[]' id='" . $row['peopleID'] . "' value='" . $row['peopleID'] . "'>
                    <label class='form-check-label' for='character_" . $row['peopleID'] . "'>" . $row['people_name'] . "</label>
                  </div>";
                            echo "</div>";
                        }
                        ?>
                    </div>
                </div>

                <div class="form-group">
                    <label for="vehicles">Vehicles:</label>
                    <div class="row">
                        <?php
                        $open_review_s_db = new PDO("sqlite:resources/star_wars.db");
                        $open_review_s_db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

                        $res = $open_review_s_db->query("SELECT vehicleID, vehicle_name, image_url FROM vehicle");

                        while ($row = $res->fetch(PDO::FETCH_ASSOC)) {
                            echo "<div class='col-6 col-md-4 col-lg-3'>";
                            echo "<div class='form-check'>
                                    <input class='form-check-input' type='checkbox' name='vehicles[]' id='" . $row['vehicleID'] . "' value='" . $row['vehicleID'] . "'>
                                    <label class='form-check-label' for='" . $row['vehicleID'] . "'>" . $row['vehicle_name'] . "</label>
                                  </div>";
                            echo "</div>";
                        }
                        ?>
                    </div>
                </div>


                <div class="form-group">
                    <label for="starships">Starships:</label>
                    <div class="row">
                        <?php
                        $open_review_s_db = new PDO("sqlite:resources/star_wars.db");
                        $open_review_s_db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

                        $res = $open_review_s_db->query("SELECT starshipID, starship_name, image_url FROM starship");

                        while ($row = $res->fetch(PDO::FETCH_ASSOC)) {
                            echo "<div class='col-6 col-md-4 col-lg-3'>";
                            echo "<div class='form-check'>
                                    <input class='form-check-input' type='checkbox' name='starships[]' id='" . $row['starshipID'] . "' value='" . $row['starshipID'] . "'>
                                    <label class='form-check-label' for='" . $row['starshipID'] . "'>" . $row['starship_name'] . "</label>
                                  </div>";
                            echo "</div>";
                        }
                        ?>
                    </div>
                </div>


                <br />
                <input type="submit" class="btn btn-primary" value="Submit">

            </form>

        </div>
    </div>
</div>


<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap-datepicker@1.9.0/dist/js/bootstrap-datepicker.min.js"></script>

<script>
    $(document).ready(function () {
        $('.datepicker').datepicker({
            format: 'dd/mm/yyyy',
            autoclose: true,
        });
    });
</script>

</body>
</html>
