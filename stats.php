<!DOCTYPE html>
<html lang="en" xmlns:mso="urn:schemas-microsoft-com:office:office" xmlns:msdt="uuid:C2F41010-65B3-11d1-A29F-00AA00C14882">
<head>
    <meta charset="UTF-8">
    <title>Star Wars Film Stats - Detailed graphs and stats about the Star Wars films</title>
    <meta name="description" content="Explore in-depth statistics and visual representations of the Star Wars film universe. Discover fascinating insights into Star Wars planets, starships, and characters. Get detailed data on populations, sizes, and more. Join our community of Star Wars enthusiasts and dive into the galaxy far, far away.">

    <script src="js/script.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-T3c6CoIi6uLrA9TneNEoa7RxnatzjcDSCmG1MXxSR1GAsXEV/Dwwykc2MPK8M2HN" crossorigin="anonymous">
    <link rel="stylesheet" href="css/style.css" />

</head>
<body>

<?php
    include "includes/functions.php";

    try {
        $open_review_s_db = new PDO("sqlite:resources/star_wars.db");
        $open_review_s_db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    } catch (PDOException $e) {
        die($e->getMessage());
    }

    //getting the data for all aspects of each planet
    $planetStmt = $open_review_s_db->prepare("SELECT planet_name, planet_population FROM planet");
    $planetStmt->execute();
    //getting the result into an assoc-array for easy access
    $planetData = $planetStmt->fetchAll(PDO::FETCH_ASSOC);
    $planetNames = [];
    $planetPopulations = [];
    foreach ($planetData as $planet) {
        if (is_numeric($planet['planet_population'])) {
            $planetNames[] = $planet['planet_name'];
            $planetPopulations[] = intval($planet['planet_population']);
        }
    }

    //getting the data for all aspects of each starship
    $starshipStmt = $open_review_s_db->prepare("SELECT starship_name, starship_length FROM starship");

    $starshipStmt->execute();
    //getting the result into an assoc-array for easy access
    $starshipData = $starshipStmt->fetchAll(PDO::FETCH_ASSOC);
    $starshipNames = [];
    $starshipLengths = [];
    foreach ($starshipData as $starship) {
        $starshipNames[] = $starship['starship_name'];
        $starshipLengths[] = intval($starship['starship_length']);
    }


    //getting the colour and count of eye colours
    $EyeColoursStmt = $open_review_s_db->prepare("SELECT people_eye_color as colour , COUNT(*) as count FROM people GROUP BY people_eye_color");
    $EyeColoursStmt->execute();
    //getting the result into an assoc-array for easy access
    $EyeColours = $EyeColoursStmt->fetchAll(PDO::FETCH_ASSOC);
    $eyeColours = [];
    $eyeColourAmounts = [];
    foreach ($EyeColours as $row) {
        $eyeColours[] = $row['colour'];
        $eyeColourAmounts[] = $row['count'];
    }

    //getting the colour and count of hair colours
    $HairColoursStmt = $open_review_s_db->prepare("SELECT people_hair_color as colour , COUNT(*) as count FROM people GROUP BY people_hair_color");
    $HairColoursStmt->execute();
    //getting the result into an assoc-array for easy access
    $HairColours = $HairColoursStmt->fetchAll(PDO::FETCH_ASSOC);
    $hairColours = [];
    $hairColourAmounts = [];
    foreach ($HairColours as $row) {
        $hairColours[] = $row['colour'];
        $hairColourAmounts[] = $row['count'];
    }


    $speciesHeightStmt = $open_review_s_db->prepare("SELECT species_name, species_average_height FROM species");

    $speciesHeightStmt->execute();
    //getting the result into an assoc-array for easy access
    $speciesHeightData = $speciesHeightStmt->fetchAll(PDO::FETCH_ASSOC);
    $speciesNames = [];
    $speciesAverageHeights = [];
    foreach ($speciesHeightData as $species) {
        if (is_numeric($species['species_average_height'])){
            $speciesNames[] = $species['species_name'];
            $speciesAverageHeights[] = intval($species['species_average_height']);
        }

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

        <div class="row graph-outer text-center">
            <h3>population of planets</h3>
            <canvas id="populationGraph"></canvas>
        </div>

        <div class="row graph-outer text-center">
            <h3>length of starships</h3>
            <canvas id="starshipSizeGraph"></canvas>
        </div>

        <div class="row graph-outer">
            <div class="col graph-inner">
                <h3>people eye colour amounts</h3>
                <canvas id="PersonEyeColour"></canvas>
            </div>

            <div class="col carousel-inner">
                <h3>people hair colour amounts</h3>
                <canvas id="PersonHairColour"></canvas>
            </div>
        </div>

        <div class="row graph-outer text-center">
            <h3>average height of species</h3>
            <canvas id="speciesAverageHeight"></canvas>
        </div>

    </div>
</div> <!--container-->


<script>
    new Chart(document.getElementById('populationGraph'), {
        type: 'bar',
        data: {
            labels: <?php echo json_encode($planetNames); ?>,
            datasets: [{
                label: 'Population',
                data: <?php echo json_encode($planetPopulations); ?>,
                backgroundColor: '#f55742',
                borderColor: 'red',
                borderWidth: 1,
            }]
        },
        options: {
            scales: {
                x: {
                    beginAtZero: true,
                    ticks: {
                        color: 'DarkSlateGray'
                    }
                },
                y: {
                    type: 'logarithmic',
                    ticks: {
                        color: 'DarkSlateGray',
                        callback: function (value, index, values) {
                            if (value === 1e6) return '1 Million';
                            if (value === 1e9) return '1 Billion';
                            if (value === 1e12) return '1 Trillion';
                            return '';
                        }
                    }
                }
            },
            plugins: {
                legend: {
                    display: false,
                },
                title: {
                    display: false,
                },
            }
        }
    });



    new Chart(document.getElementById('starshipSizeGraph'), {
        type: 'bar',
        data: {
            labels: <?php echo json_encode($starshipNames); ?>,
            datasets: [{
                label: 'Ship Length',
                data: <?php echo json_encode($starshipLengths); ?>,
                backgroundColor: '#f55742',
                borderColor: 'red',
                borderWidth: 1,
            }]
        },
        options: {
            scales: {
                x: {
                    beginAtZero: true,
                    ticks: {
                        color: 'DarkSlateGray'
                    }
                },
                y: {
                    beginAtZero: true,
                    type: 'logarithmic',
                    ticks: {
                        color: 'DarkSlateGray',
                        callback: function (value) {
                            return value + ' m';
                        }
                    }
                }
            },
            plugins: {
                legend: {
                    display: false,
                },
                title: {
                    display: false,
                },
            }
        }
    });


    new Chart(ctx = document.getElementById('PersonEyeColour').getContext('2d'), {
        type: 'pie',
        data: {
            labels: <?php echo json_encode($eyeColours); ?>,
            datasets: [{
                data: <?php echo json_encode($eyeColourAmounts); ?>,
                //hard coding the colours because many of the colours in the database aren't actually colours that can be applied here
                backgroundColor: ['black','blue','gray','Sienna','gray','gold','green','brown','orange','pink','red','purple', 'Gainsboro','white','yellow'],
                borderColor: '#4a4a4a',

            }]
        },
        options: {
            plugins: {
                title: {
                    display: false,
                },
            },

        }

    });

    new Chart(ctx = document.getElementById('PersonHairColour').getContext('2d'), {
        type: 'pie',
        data: {
            labels: <?php echo json_encode($hairColours); ?>,
            datasets: [{
                data: <?php echo json_encode($hairColourAmounts); ?>,
                //hard coding the colours because many of the colours in the database aren't actually colours that can be applied here
                backgroundColor: ['DarkRed','RosyBrown','IndianRed','Black','Khaki','Khaki','Sienna','Tan','Gray','Gainsboro','Gainsboro','Gainsboro', 'White','yellow'],
                borderColor: '#4a4a4a',
            }]
        },
        options: {
            plugins: {
                title: {
                    display: false,
                },
            },

        }

    });


    new Chart(document.getElementById('speciesAverageHeight'), {
        type: 'bar',
        data: {
            labels: <?php echo json_encode($speciesNames); ?>,
            datasets: [{
                label: 'Species Average Height',
                data: <?php echo json_encode($speciesAverageHeights); ?>,
                backgroundColor: '#f55742',
                borderColor: 'red',
                borderWidth: 1,
            }]
        },
        options: {
            scales: {
                x: {
                    beginAtZero: true,
                    ticks: {
                        color: 'DarkSlateGray'
                    }
                },
                y: {
                    beginAtZero: true,
                    ticks: {
                        color: 'DarkSlateGray',
                        callback: function (value) {
                            return value + ' cm';
                        }
                    }
                }
            },
            plugins: {
                legend: {
                    display: false,
                },
                title: {
                    display: false,
                },
            }
        }
    });

</script>

</body>
</html>

