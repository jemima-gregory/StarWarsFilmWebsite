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
                $starship_id = $_GET['id'];
                try {
                    $open_review_s_db = new PDO("sqlite:resources/star_wars.db");
                    $open_review_s_db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
                } catch (PDOException $e) {
                    die($e->getMessage());
                }
                try {
                    //a placeholder for id so that it can be bound
                    $stmt = $open_review_s_db->prepare("SELECT starship_name, starship_model, starship_cost_in_credits,
                                                                       starship_length, starship_max_atmosphering_speed,starship_crew,
                                                                       starship_passengers, starship_cargo_capacity, starship_consumables,
                                                                       starship_hyperdrive_rating, starship_MGLT, starship.image_url as starship_img_url,
                                                                       starship_class, vehicle_manufacturer, manufacturer.image_url as manufacturer_img_url
                                                                FROM starship, starship_manufacturer, starshipclass, manufacturer
                                                                WHERE starshipclass.starshipclassID = starship.starshipclassID
                                                                      and manufacturer.manufacturerID = starship_manufacturer.manufacturerID
                                                                      and starship_manufacturer.starshipID = starship.starshipID
                                                                      and starship.starshipID = :id");
                    $stmt->bindParam(':id', $starship_id, PDO::PARAM_INT);
                    $stmt->execute();
                    //getting the result into an assoc-array for easy access
                    $result = $stmt->fetch(PDO::FETCH_ASSOC);

                } catch (PDOException $e) {
                    die($e->getMessage());
                }
            }
            ?>
        </div>

        <?php if ($result): ?>
            <div class="row">
                <div class="col">
                    <img height='300' src='<?php echo getImageUrl(($result['starship_img_url']))?>' /><br />
                </div>

                <div class="col">
                    <div class="row">
                        <div class="col">
                        <h1><?php echo $result['starship_name']; ?></h1><br/>
                        </div>
                        <div class="col manufacturer-logo">
                            <img height='50' src='<?php echo getImageUrl($result['manufacturer_img_url']); ?>' />
                        </div>
                    </div>
                   <p>Model: <?php echo $result['starship_model']; ?></p>
                   <p>Cost: <?php echo $result['starship_cost_in_credits']?> credits</p>
                   <p>Length: <?php echo $result['starship_length']; ?></p>
                   <p>Max Atmosphering Speed: <?php echo $result['starship_max_atmosphering_speed']; ?></p>
                   <p>Number of Crew: <?php echo $result['starship_crew']; ?></p>
                   <p>Number of Passengers: <?php echo $result['starship_passengers']; ?></p>
                   <p>Cargo Capacity: <?php echo $result['starship_cargo_capacity']; ?></p>
                   <p>Consumables: <?php echo $result['starship_consumables']; ?> credits</p>
                   <p>Hyperdrive Rating: <?php echo $result['starship_hyperdrive_rating']; ?></p>
                   <p>MGLT: <?php echo $result['starship_MGLT']; ?></p>
                   <p>Class: <?php echo $result['starship_class']; ?></p>
                   <p>Manufacturer: <?php echo $result['vehicle_manufacturer']; ?></p>
                </div>
            </div>
        <?php endif; ?>

    </div>

</div>

</body>

<head>
    <meta charset="UTF-8">
    <title><?php echo $result['starship_name']; ?> - Star Wars Starship Profile and Details</title>
    <meta name="description" content="Dive into the details of the remarkable Star Wars starship, <?php echo $result['starship_name']; ?>. Explore its technical specifications, design, capacities, and manufacturer.">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-T3c6CoIi6uLrA9TneNEoa7RxnatzjcDSCmG1MXxSR1GAsXEV/Dwwykc2MPK8M2HN" crossorigin="anonymous">
    <link rel="stylesheet" href="css/style.css" />
</head>

</html>
