<!DOCTYPE html>
<html lang="en">


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
        <!-- Exists in a row class so the errors have a specific place to show if required.-->
        <div class="row">
            <?php
            if (isset($_GET['id'])) {
                $planet_id = $_GET['id'];

                try {
                    $open_review_s_db = new PDO("sqlite:resources/star_wars.db");
                    $open_review_s_db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
                } catch (PDOException $e) {
                    die($e->getMessage());
                }

                try {
                    //a placeholder for id so that it can be bound
                    $stmt = $open_review_s_db->prepare("SELECT planet_name, planet_rotation_period, planet_orbital_period, planet_diameter, planet_gravity, planet_surface_water, planet_population, planet.image_url as planet_image_url, planetclimateID, planet_climate, planetterrainID, planet_terrain, terrain.image_url as terrain_image_url
                                                                FROM planet, planet_terrain, planet_climate, terrain, climate
                                                                WHERE terrain.planetterrainID = planet_terrain.terrainID
                                                                    and planet_terrain.planetID = planet.planetID
                                                                    and climate.planetclimateID = planet_climate.climateID
                                                                    and planet_climate.planetID = planet.planetID
                                                                    and planet.planetID = :id");

                    $stmt->bindParam(':id', $planet_id, PDO::PARAM_INT);
                    $stmt->execute();

                    //getting the result into an assoc-array for easy access
                    $result = $stmt->fetch(PDO::FETCH_ASSOC);

                    if ($result) {
                        $planet_name = $result['planet_name'];
                    } else {
                        echo "Planet not found.";
                    }

                } catch (PDOException $e) {
                    die($e->getMessage());
                }
            }
            ?>
        </div>

        <div class="row">
            <div class="col">
                <img height='500' src='<?php echo getImageUrl(($result['planet_image_url']))?>' /><br />
            </div>

            <div class="col">
                <h2><?php echo $planet_name; ?></h2>
                <p>Rotation Period: <?php echo $result['planet_rotation_period']; ?></p><br />
                <p>Orbital Period: <?php echo $result['planet_orbital_period']; ?></p><br />
                <p>Diameter: <?php echo $result['planet_diameter']; ?></p><br />
                <p>Gravity: <?php echo $result['planet_gravity']; ?></p><br />
                <p>Surface Water: <?php echo $result['planet_surface_water']; ?></p><br />
                <p>Population: <?php echo $result['planet_population']; ?></p><br />
                <p>Climate: <?php echo $result['planet_climate']; ?></p><br />
            </div>

        </div>

        <div class="row">
            <h4>Terrain: </h4>
            <img height='300' src='<?php echo getImageUrl($result['terrain_image_url'])?>' /><br />
        </div>

    </div>

</div>


</body>

<head>
    <meta charset="UTF-8">
    <title><?php echo $result['planet_name']; ?> - Star Wars Planet Profile and Details</title>
    <meta name="description" content="Delve into the mysteries of <?php echo $result['planet_name']; ?> in the Star Wars universe. Learn about its climate, terrain, civilizations, and its role in shaping the galaxy's fate.">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-T3c6CoIi6uLrA9TneNEoa7RxnatzjcDSCmG1MXxSR1GAsXEV/Dwwykc2MPK8M2HN" crossorigin="anonymous">
    <link rel="stylesheet" href="css/style.css" />
</head>

</html>
