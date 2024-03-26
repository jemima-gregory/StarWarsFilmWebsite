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
                $vehicle_id = $_GET['id'];

                try {
                    $open_review_s_db = new PDO("sqlite:resources/star_wars.db");
                    $open_review_s_db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
                } catch (PDOException $e) {
                    die($e->getMessage());
                }

                try {
                    //a placeholder for id so that it can be bound
                    $stmt = $open_review_s_db->prepare("SELECT vehicle_name, vehicle_model, vehicle_cost_in_credits,
                                                                       vehicle_length, vehicle_max_atmosphering_speed,vehicle_crew,
                                                                       vehicle_passengers, vehicle_cargo_capacity, vehicle_consumables,
                                                                       vehicle.image_url as vehicle_img_url, vehicle_class, vehicle_manufacturer, 
                                                                       manufacturer.image_url as manufacturer_img_url
                                                                FROM vehicle, vehicle_manufacturer, vehicleclass, manufacturer
                                                                WHERE vehicleclass.vehicleclassID = vehicle.vehicleclassID
                                                                      and manufacturer.manufacturerID = vehicle_manufacturer.manufacturerID
                                                                      and vehicle_manufacturer.vehicleID = vehicle.vehicleID
                                                                      and vehicle.vehicleID = :id");
                    $stmt->bindParam(':id', $vehicle_id, PDO::PARAM_INT);
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
                    <img height='300' src='<?php echo getImageUrl(($result['vehicle_img_url']))?>' /><br />
                </div>

                <div class="col">
                    <div class="row">
                        <div class="col">
                            <h1><?php echo $result['vehicle_name']; ?></h1><br/>
                        </div>
                        <div class="col manufacturer-logo">
                            <img height='50' src='<?php echo getImageUrl($result['manufacturer_img_url']); ?>' />
                        </div>
                    </div>
                    <p>Model: <?php echo $result['vehicle_model']; ?></p>
                    <p>Cost: <?php echo $result['vehicle_cost_in_credits']?> credits</p>
                    <p>Length: <?php echo $result['vehicle_length']; ?></p>
                    <p>Max Atmosphering Speed: <?php echo $result['vehicle_max_atmosphering_speed']; ?></p>
                    <p>Number of Crew: <?php echo $result['vehicle_crew']; ?></p>
                    <p>Number of Passengers: <?php echo $result['vehicle_passengers']; ?></p>
                    <p>Cargo Capacity: <?php echo $result['vehicle_cargo_capacity']; ?></p>
                    <p>Consumables: <?php echo $result['vehicle_consumables']; ?></p>
                    <p>Class: <?php echo $result['vehicle_class']; ?></p>
                    <p>Manufacturer: <?php echo $result['vehicle_manufacturer']; ?></p>
                </div>
            </div>
        <?php endif; ?>

    </div>

</div>

</body>

<head>
    <meta charset="UTF-8">
    <title><?php echo $result['vehicle_name']; ?> - Star Wars Vehicle Profile and Details</title>
    <meta name="description" content="Explore the technical specifications of the legendary Star Wars vehicle, <?php echo $result['vehicle_name']; ?>. Learn about its design, capacities, and its manufacturer.">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-T3c6CoIi6uLrA9TneNEoa7RxnatzjcDSCmG1MXxSR1GAsXEV/Dwwykc2MPK8M2HN" crossorigin="anonymous">
    <link rel="stylesheet" href="css/style.css" />
</head>

</html>

