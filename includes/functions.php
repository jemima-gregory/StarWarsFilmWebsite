<?php
function getImageUrl($image_url)
{
    if ($image_url == Null) {
        return './img/default_image.png';
    } else {
        $url = $image_url;
        $url = str_replace("/revision/latestt", "", $url);
        $url = str_replace("/revision/latest", "", $url);
        return $url;
    }
}

function insertUser($username, $email, $hashedPassword)
{
    try {
        $open_review_s_db = new PDO("sqlite:resources/star_wars.db");
        $open_review_s_db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    } catch (PDOException $e) {
        die($e->getMessage());
        return false;
    }

    $sql = $open_review_s_db->prepare("INSERT INTO user (username, email, hashedPassword)
                                                VALUES (:username, :email, :hashedPassword)");
    $sql->bindParam(':username', $username, PDO::PARAM_STR);
    $sql->bindParam(':email', $email, PDO::PARAM_STR);
    $sql->bindParam(':hashedPassword', $hashedPassword, PDO::PARAM_STR);
    if ($sql->execute()) {
        return true;
    } else {
        return false;
    }
}


function getUserByUsernameOrEmail($input)
{
    try {
        $open_review_s_db = new PDO("sqlite:resources/star_wars.db");
        $open_review_s_db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    } catch (PDOException $e) {
        die($e->getMessage());
        return false;
    }

    $sql = $open_review_s_db->prepare("SELECT userID, username, email, hashedPassword
                                                FROM user
                                                WHERE username = :input OR email = :input");
    $sql->bindParam(':input', $input, PDO::PARAM_STR);

    if ($sql->execute()) {
        return $sql->fetch(PDO::FETCH_ASSOC);
    } else {
        return false;
    }
}


function checkUsername($username)
{
    try {
        $open_review_s_db = new PDO("sqlite:resources/star_wars.db");
        $open_review_s_db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    } catch (PDOException $e) {
        die($e->getMessage());
        return false;
    }

    $sql = $open_review_s_db->prepare("SELECT username FROM user");
    $sql->execute();

    $usernames = [];
    while ($row = $sql->fetch(PDO::FETCH_ASSOC)) {
        $usernames[] = $row['username'];
    }

    if (in_array($username, $usernames)) {
        return true;
    } else {
        return false;
    }
}

function checkEmail($email)
{
    try {
        $open_review_s_db = new PDO("sqlite:resources/star_wars.db");
        $open_review_s_db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    } catch (PDOException $e) {
        die($e->getMessage());
        return false;
    }

    $sql = $open_review_s_db->prepare("SELECT email FROM user");
    $sql->execute();

    $emails = [];
    while ($row = $sql->fetch(PDO::FETCH_ASSOC)) {
        $emails[] = $row['email'];
    }

    if (in_array($email, $emails)) {
        return true;
    } else {
        return false;
    }
}


function searchFilms($search_term)
{
    try {
        $open_review_s_db = new PDO("sqlite:resources/star_wars.db");
        $open_review_s_db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    } catch (PDOException $e) {
        die($e->getMessage());
        return [];
    }

    $sql = $open_review_s_db->prepare("SELECT filmID, film_title FROM film WHERE film_title LIKE :search_term");
    $search_term = '%' . $search_term . '%';
    $sql->bindParam(':search_term', $search_term, PDO::PARAM_STR);
    $sql->execute();

    $results = [];
    while ($row = $sql->fetch(PDO::FETCH_ASSOC)) {
        $results[] = $row;
    }

    return $results;
}
