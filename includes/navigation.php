    <nav class="navbar navbar-expand-lg navbar-light p-0 m-0">
        <div class="container-fluid">
            <div class="collapse navbar-collapse" id="navbarSupportedContent">
                <ul class="navbar-nav mx-auto justify-content-between">
                    <li class="nav-item">
                        <a class="nav-link" href="index.php">Home</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="films.php">Films</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="planets.php">Planets</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="people.php">People</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="stats.php">Stats</a>
                    </li>

                    <?php
                    if (session_status() == PHP_SESSION_NONE) {
                        session_start();
                    }
                    if (isset($_SESSION['userID'])):
                        if ($_SESSION['username'] === 'admin'):
                    ?>
                        <li class="nav-item">
                            <a class="nav-link" href="submit-film.php">Submit a Film</a>
                        </li>
                    <?php endif; endif;?>

                    <li class="nav-item">
                        <a class="nav-link" href="login.php">Login</a>
                    </li>
                </ul>

            </div>
        </div>
    </nav>

