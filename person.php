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
                $person_id = $_GET['id'];

                try {
                    $open_review_s_db = new PDO("sqlite:resources/star_wars.db");
                    $open_review_s_db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
                } catch (PDOException $e) {
                    die($e->getMessage());
                }

                try {
                    //a placeholder for id so that it can be bound
                    $stmt = $open_review_s_db->prepare("SELECT people_name, people_height, people_mass, 
                                                                    people_hair_color, people_skin_color, people_eye_color, 
                                                                    people_birth_year, people_gender, people.image_url, 
                                                                    species_name, planet_name, speciesID, 
                                                                    planetID
                                                                FROM people, species, planet
                                                                WHERE people_homeworld_id = planetID
                                                                  and people_species_id = speciesID
                                                                  and people.peopleID = :id");
                    $stmt->bindParam(':id', $person_id, PDO::PARAM_INT);
                    $stmt->execute();

                    //getting the result into an assoc-array for easy access
                    $result = $stmt->fetch(PDO::FETCH_ASSOC);
                    if ($result) {
                        $name = $result['people_name'];
                    } else {
                        echo "Person not found.";
                    }

                } catch (PDOException $e) {
                    die($e->getMessage());
                }
            }
            ?>
        </div>

        <div class="row">
            <div class="col">
                <img height='300' src='<?php echo getImageUrl(($result['image_url']))?>' /><br />
            </div>

            <div class="col">
                <h2><?php echo $name ?></h2>
                <p>Height: <?php echo $result['people_height']?></p><br />
                <p>Hair Colour: <?php echo $result['people_eye_color']?></p><br />
                <p>Skin Colour: <?php echo $result['people_skin_color']?></p><br />
                <p>Eye Colour: <?php echo $result['people_eye_color']?></p><br />
                <p>Birth Year: <?php echo $result['people_birth_year']?></p><br />
                <p>Gender: <?php echo $result['people_gender']?></p><br />
                <p>Species: <a href='species.php?id=<?php echo $result['speciesID']?>'><?php echo $result["species_name"]?></a></p>
                <p>Home Planet: <a href='planet.php?id=<?php echo $result['planetID']?>'><?php echo $result["planet_name"]?></a></p>
            </div>
        </div>

        <?php
            //getting the starships for the given person
            $stmt1 = $open_review_s_db->prepare("SELECT starship_name, starship.starshipID
                                                        FROM people, people_starships, starship
                                                        WHERE people.peopleID = people_starships.peopleID
                                                                and people_starships.starshipID = starship.starshipID
                                                                and people.peopleID = :id;");
            $stmt1->bindParam(':id', $person_id, PDO::PARAM_INT);
            $stmt1->execute();

            $row = $stmt1->fetch(PDO::FETCH_ASSOC);
            if ($row):
        ?>

        <div class="row">
            <h3>starships:</h3>
        </div>

        <div class="row text-center mt-5">
            <div class="col">
                <div class="row">
                    <?php
                    //getting the starships for the given person
                    $stmt1 = $open_review_s_db->prepare("SELECT starship_name, starship.starshipID, starship.image_url as starship_image_url
                                                                FROM people, people_starships, starship
                                                                WHERE people.peopleID = people_starships.peopleID
                                                                        and people_starships.starshipID = starship.starshipID
                                                                        and people.peopleID = :id;");
                    $stmt1->bindParam(':id', $person_id, PDO::PARAM_INT);
                    $stmt1->execute();


                    while($row = $stmt1->fetch(PDO::FETCH_ASSOC)) {
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

        <?php
            endif;

            //getting the vehicles for the given person
            $stmt2 = $open_review_s_db->prepare("SELECT vehicle_name, vehicle.vehicleID, vehicle.image_url as vehicle_image_url
                                                                    FROM people, people_vehicles, vehicle
                                                                    WHERE people.peopleID = people_vehicles.peopleID
                                                                            and people_vehicles.vehicleID = vehicle.vehicleID
                                                                            and people.peopleID = :id;");
            $stmt2->bindParam(':id', $person_id, PDO::PARAM_INT);
            $stmt2->execute();
            $row = $stmt2->fetch(PDO::FETCH_ASSOC);
        if ($row):
        ?>

        <div class="row">
            <h3>vehicles:</h3>
        </div>

        <div class="row text-center mt-5">
            <div class="col">
                <div class="row">
                    <?php
                    //getting the vehicles for the given person
                    $stmt2 = $open_review_s_db->prepare("SELECT vehicle_name, vehicle.vehicleID, vehicle.image_url as vehicle_image_url
                                                                FROM people, people_vehicles, vehicle
                                                                WHERE people.peopleID = people_vehicles.peopleID
                                                                        and people_vehicles.vehicleID = vehicle.vehicleID
                                                                        and people.peopleID = :id;");
                    $stmt2->bindParam(':id', $person_id, PDO::PARAM_INT);
                    $stmt2->execute();



                    while($row = $stmt2->fetch(PDO::FETCH_ASSOC)) {
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

        <?php
        endif;
        ?>





    </div>

</div>

</body>

<head>
    <meta charset="UTF-8">
    <title><?php echo $result['people_name']; ?> - Star Wars Character Profile and Details</title>
    <meta name="description" content="Explore the rich history and background of the legendary Star Wars character, <?php echo $result['people_name']; ?>. Learn about their role in the saga, their biographical details and more!">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-T3c6CoIi6uLrA9TneNEoa7RxnatzjcDSCmG1MXxSR1GAsXEV/Dwwykc2MPK8M2HN" crossorigin="anonymous">
    <link rel="stylesheet" href="css/style.css" />
</head>

</html>