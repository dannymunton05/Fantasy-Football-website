<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Fantasy Football WorldCup </title>
    <link rel="stylesheet" href="ff.css">
</head>
<body>
                 <!--Main section-->
    <div class="main">
        <div class="main__container">
            <div class="main__content">
                <h1>Welcome to Fantasy Football World Cup,<?php session_start(); echo htmlspecialchars($_SESSION["username"]); ?></h1>
                <h2>Manage your team to victory</h2>
                <p1></p1>
                <button class="main_button1"><a href="team.php">Create your team</a></button>
            </div>
            <div class="main__img--container">
                <img src="images/worldcup.PNG"
                 alt="pic" id="main__img">
            </div>
        </div>
    </div>
    <html>
        <?php
        // Check if the user is logged in, if not then redirect him to login page
        if(!isset($_SESSION["loggedin"]) || $_SESSION["loggedin"] !== true){
            header("location: login.php");
            exit;
        }
        ?>

