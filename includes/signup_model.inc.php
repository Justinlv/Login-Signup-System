<?php

declare(strict_types=1);

function get_username(object $pdo, string $username) 
{
    $query = "SELECT username from users WHERE username = :username;";
    $stmt = $pdo->prepare($query);
    $stmt->bindparam(":username", $username);
    $stmt->execute();

    $result = $stmt->fetch(PDO::FETCH_ASSOC);
    return $result;
}

function get_email(object $pdo, string $email) 
{
    $query = "SELECT username from users WHERE email = :email;";
    $stmt = $pdo->prepare($query);
    $stmt->bindparam(":email", $email);
    $stmt->execute();

    $result = $stmt->fetch(PDO::FETCH_ASSOC);
    return $result;
}

function set_user(object $pdo, string $pwd, string $username, string $email) 
{
    $query = "INSERT INTO users (username, pwd, email) VALUES (:username, :pwd, :email)";
    $stmt = $pdo->prepare($query);

    $options = [
        'cost' => 12
    ];
    $hashedPwd = password_hash($pwd, PASSWORD_BCRYPT, $options);

    $stmt->bindparam(":username", $username);
    $stmt->bindparam(":pwd", $hashedPwd);
    $stmt->bindparam(":email", $email);
    $stmt->execute();
}