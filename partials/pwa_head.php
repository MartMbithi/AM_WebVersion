<?php
/*Load System Settings On Header  */
$ret = "SELECT * FROM `system_settings` ";
$stmt = $mysqli->prepare($ret);
$stmt->execute(); //ok
$res = $stmt->get_result();
while ($sys = $res->fetch_object()) {
?>
    <!DOCTYPE html>
    <html lang="en">

    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="description" content="Affan - PWA Mobile HTML Template">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="theme-color" content="#0134d4">
        <meta name="apple-mobile-web-app-capable" content="yes">
        <meta name="apple-mobile-web-app-status-bar-style" content="black">
        <!-- Title-->
        <title><?php echo $sys->system_name; ?></title>
        <!-- Fonts-->
        <link rel="preconnect" href="https://fonts.gstatic.com/">
        <link href="https://fonts.googleapis.com/css2?family=Public+Sans:ital,wght@0,100;0,200;0,300;0,400;0,500;0,600;0,700;0,800;0,900;1,100;1,200;1,300;1,400;1,500;1,600;1,700;1,800;1,900&amp;display=swap" rel="stylesheet">
        <!-- Favicon-->
        <link rel="icon" href="img/core-img/favicon.ico">
        <link rel="apple-touch-icon" href="img/icons/icon-96x96.png">
        <link rel="apple-touch-icon" sizes="152x152" href="../public/images/<?php echo $sys->system_logo; ?>">
        <link rel="apple-touch-icon" sizes="167x167" href="../public/images/<?php echo $sys->system_logo; ?>">
        <link rel="apple-touch-icon" sizes="180x180" href="../public/images/<?php echo $sys->system_logo; ?>">
        <!-- Pwa Bootstrap-->
        <link rel="stylesheet" href="../public/css/pwa_bootstrap.css">
        <!-- Animate css -->
        <link rel="stylesheet" href="../public/css/animate.css">
        <!-- Owl Carousel -->
        <link rel="stylesheet" href="../public/css/owl.carousel.min.css">
        <!-- Font Awesome -->
        <link rel="stylesheet" href="../public/css/font-awesome.min.css">
        <!-- Bootstrap Icons -->
        <link rel="stylesheet" href="../public/css/bootstrap-icons.css">
        <!-- Magic POP -->
        <link rel="stylesheet" href="../public/css/magnific-popup.css">
        <!-- Range Slider -->
        <link rel="stylesheet" href="../public/css/ion.rangeSlider.min.css">
        <!-- Bootstrap Data Tables -->
        <link rel="stylesheet" href="../public/css/dataTables.bootstrap4.min.css">
        <!-- Apex Charts -->
        <link rel="stylesheet" href="../public/css/apexcharts.css">
        <!-- Core Stylesheet-->
        <link rel="stylesheet" href="../public/css/style.css">
        <!-- SweetAlert2 -->
        <link rel="stylesheet" href="../public/plugins/sweetalert2/bootstrap-4.min.css">
    </head>
<?php } ?>