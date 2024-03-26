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
                $species_id = $_GET['id'];

                try {
                    $open_review_s_db = new PDO("sqlite:resources/star_wars.db");
                    $open_review_s_db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
                } catch (PDOException $e) {
                    die($e->getMessage());
                }

                try {
                    //a placeholder for id so that it can be bound
                    $stmt = $open_review_s_db->prepare("SELECT species_name, species_classification, species_designation, species_average_height, species_skin_colors, species_hair_colors, species_eye_colors, species_average_lifespan, species_language, species.image_url
                                                                FROM species 
                                                                WHERE speciesID = :id");
                    $stmt->bindParam(':id', $species_id, PDO::PARAM_INT);
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
                    <img height='300' src='<?php echo getImageUrl(($result['image_url']))?>' /><br />
                </div>

                <div class="col">
                    <h2><?php echo $result['species_name']; ?></h2><br />
                    <p>Classification: <?php echo $result['species_classification']; ?></p><br />
                    <p>Designation: <?php echo $result['species_designation']; ?></p><br />
                    <p>Average Height: <?php echo $result['species_average_height']; ?></p><br />
                    <p>Skin Colours: <?php echo $result['species_skin_colors']; ?></p><br />
                    <p>Hair Colours: <?php echo $result['species_hair_colors']; ?></p><br />
                    <p>Eye Colours: <?php echo $result['species_eye_colors']; ?></p><br />
                    <p>Language: <?php echo $result['species_language']; ?></p><br />
                </div>
            </div>
        <?php endif; ?>

    </div>

</div>
</body>

<head>
    <meta charset="UTF-8">
    <title><?php echo $result['species_name']; ?> - Star Wars Species Profile and Details</title>
    <meta name="description" content="Learn about the unique biology, culture, and history of the fascinating Star Wars species, <?php echo $result['species_name']; ?>. Explore their in-depth biography.">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-T3c6CoIi6uLrA9TneNEoa7RxnatzjcDSCmG1MXxSR1GAsXEV/Dwwykc2MPK8M2HN" crossorigin="anonymous">
    <link rel="stylesheet" href="css/style.css" />
</head>

</html>