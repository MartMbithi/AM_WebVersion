<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <!-- x-icon -->
    <link rel="shortcut icon" href="../public/images/x-icon.png" type="image/x-icon">
    <!-- Animate -->
    <link rel="stylesheet" href="../public/css/animate.css">
    <!-- Bootstrap -->
    <link rel="stylesheet" href="../public/css/bootstrap.min.css">
    <!-- Iconfont -->
    <link rel="stylesheet" href="../public/css/icofont.min.css">
    <!-- Swiper -->
    <link rel="stylesheet" href="../public/css/swiper.min.css">
    <!-- Application Css -->
    <link rel="stylesheet" href="../public/css/style.css">
    <!-- Load Alert-->
    <link rel="stylesheet" href="../public/plugins/toastr/toastr.min.css">
    <title>Asian Melodies - The Future Of Dating </title>
    <?php
    /* Alert Sesion Via Alerts */
    if (isset($_SESSION['success'])) {
        $success = $_SESSION['success'];
        unset($_SESSION['success']);
    }
    ?>
</head>