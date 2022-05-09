<?php
require_once('../config/app_config.php');
/* Add Mailing List */
if (isset($_POST['add_mailing'])) {
    $email = mysqli_real_escape_string($mysqli, $_POST['email']);
    /* Validate Email */
    if (filter_var($email, FILTER_VALIDATE_EMAIL)) {
        /* Check If Email Already Exists On Mailing Lists */
        $sql = mysqli_query($mysqli, "SELECT * FROM newsletter WHERE email = '{$email}'");
        if (mysqli_num_rows($sql) > 0) {
            $err = "You Are Already In Our Mailing List";
        } else {
            $unsubcsribe = $unsubcribe_mail . $email;
            $sql = "INSERT INTO newsletter (email) VALUES('{$email}')";
            $prepare = $mysqli->prepare($sql);
            $prepare->execute();
            /* Load Mailer */
            require_once('../mailers/mailing_list.php');
            if ($prepare && $mail->send()) {
                $success = "You Have Joined Our Mailing List";
            } else {
                $err = "Failed!, Please Try Again";
            }
        }
    } else {
        $err = "Enter Correct Email Address";
    }
}
?>
<footer class="footer-section">
    <div class="footer-top">
        <div class="container">
            <div class="row g-3 justify-content-center g-lg-0">
                <div class="col-lg-4 col-sm-6 col-12">
                    <div class="footer-top-item lab-item">
                        <div class="lab-inner">
                            <div class="lab-thumb">
                                <img src="../public//images/footer/icons/01.png" alt="Phone-icon">
                            </div>
                            <div class="lab-content quick-kiss">
                                <span>Phone Number : +254 737 229776 </span>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-lg-4 col-sm-6 col-12">
                    <div class="footer-top-item lab-item">
                        <div class="lab-inner">
                            <div class="lab-thumb">
                                <img src="../public//images/footer/icons/02.png" alt="email-icon">
                            </div>
                            <div class="lab-content quick-kiss">
                                <span>Email : info@asianmelodies.com</span>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-lg-4 col-sm-6 col-12">
                    <div class="footer-top-item lab-item">
                        <div class="lab-inner">
                            <div class="lab-thumb">
                                <img src="../public//images/footer/icons/03.png" alt="location-icon">
                            </div>
                            <div class="lab-content quick-kiss">
                                <span>Address : 127.0.0.1 Localhost</span>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="footer-middle padding-tb" style="background-image: url(../public//images/footer/bg.png);">
        <div class="container">
            <div class="row">
                <div class="col-lg-6 col-md-6 col-12">
                    <div class="footer-middle-item-wrapper">
                        <div class="footer-middle-item mb-lg-0">
                            <div class="fm-item-title">
                                <h4 class="bite-chocolate">Asian Melodies</h4>
                            </div>
                            <div class="fm-item-content">
                                <p class="mb-4">
                                    We are an online dating and geosocial networking platform,
                                    which connects your lone self to your partner. <br>
                                    Asian Melodies - The Future Of Dating
                                </p>
                                <img src="../public//images/footer/about.jpg" alt="about-image" class="footer-abt-img">
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-lg-6 col-md-6 col-12">
                    <div class="footer-middle-item-wrapper">
                        <div class="footer-middle-item-3 mb-lg-0">
                            <div class="fm-item-title">
                                <h4 class="bite-chocolate">Our Newsletter</h4>
                            </div>
                            <div class="fm-item-content">
                                <p>By subscribing to our mailing list you will always
                                    be updated with the latest news from us.</p>
                                <form method="post">
                                    <div class="form-group">
                                        <input type="email" required name="email" class="form-control" placeholder="Enter email">
                                    </div>
                                    <button type="submit" name="add_mailing" class="lab-btn">Submit <i class="icofont-paper-plane"></i></button>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="footer-bottom">
        <div class="container">
            <div class="row">
                <div class="col-12">
                    <div class="footer-bottom-content text-center quick-kiss">
                        <p>&copy; 2022 - <?php echo date('Y'); ?> <a href="index">Asian Melodies </a> - The Future Of Dating</p>
                    </div>
                </div>
            </div>
        </div>
    </div>
</footer>