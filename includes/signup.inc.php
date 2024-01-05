<?php

if ($_SERVER["REQUEST_METHOD"] === "POST") {

    $username = $_POST["username"];
    $pwd = $_POST["pwd"];
    $email = $_POST["email"];

    try {

        require_once "dbh.inc.php";
        require_once "signup_model.inc.php";
        require_once "signup_contr.inc.php";

        // ERROR HANDLERS
        $errors = [];

        if (is_input_empty($username, $pwd, $email)) {
            $errors["empty_input"] = "fill in all fields!";
        }
        if (is_email_invalid($email)) {
            $errors["invalid_email"] = "email is invalid!";
        }
        if (is_username_taken($pdo, $username)) {
            $errors["username_taken"] = "username is already taken!";
        } 
        if (is_email_registered($pdo, $email)) {
            $errors["email_registered"] = "email is already registered!";
        }

        require_once "config_session.inc.php";

        if ($errors) {
            $_SESSION["errors_signup"] = $errors;

            $signupData = [
                "username" => $username,
                "email" => $email
            ];
            $_SESSION["signup_data"] = $signupData;

            header("location: ../index.php");
            die();
        }

        create_user($pdo, $pwd, $username, $email);

        header("location: ../index.php?signup=success");

        $pdo = null;
        $stmt = null;

        die();

    } catch (PDOException $e) {
        die("Query failed: " . $e->getMessage());
    }

} else {
    header("location: ../index.php");
    die();
}
