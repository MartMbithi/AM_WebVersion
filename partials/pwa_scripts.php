<!-- Bootstrp Bundle -->
<script src="../public/js/pwa_bootstrap.js"></script>
<!-- Jquerry -->
<script src="../public/js/jquery.min.js"></script>
<!-- Internet Status -->
<script src="../public/js/default/internet-status.js"></script>
<!-- Waypoint Js -->
<script src="../public/js/waypoints.min.js"></script>
<!-- Jquerry Easing -->
<script src="../public/js/jquery.easing.min.js"></script>
<!-- Wow Js -->
<script src="../public/js/wow.min.js"></script>
<!-- Carousel -->
<script src="../public/js/owl.carousel.min.js"></script>
<!-- Counter Up -->
<script src="../public/js/jquery.counterup.min.js"></script>
<!-- Count Down -->
<script src="../public/js/jquery.countdown.min.js"></script>
<!-- Images Loded -->
<script src="../public/js/imagesloaded.pkgd.min.js"></script>
<!-- Isotope -->
<script src="../public/js/isotope.pkgd.min.js"></script>
<!-- Magnific -->
<script src="../public/js/jquery.magnific-popup.min.js"></script>
<!-- Dark Mode Switc -->
<script src="../public/js/default/dark-mode-switch.js"></script>
<!-- Range Slider -->
<script src="../public/js/ion.rangeSlider.min.js"></script>
<!-- Data Tables -->
<script src="../public/js/jquery.dataTables.min.js"></script>
<!-- Active Js -->
<script src="../public/js/default/active.js"></script>
<!-- Clipboard Js -->
<script src="../public/js/default/clipboard.js"></script>
<!-- PWA-->
<script src="../public/js/pwa.js"></script>
<!-- Sweet Alerts -->
<script src="../public/plugins/sweetalert2/sweetalert2.min.js"></script>
<?php if (isset($success)) { ?>
    <script>
        const Toast = Swal.mixin({
            toast: true,
            position: 'center',
            showConfirmButton: false,
            timer: 3000
        });
        Toast.fire({
            type: 'success',
            title: '<?php echo $success; ?>',
        })
    </script>

<?php }
if (isset($err)) { ?>
    <script>
        const Toast = Swal.mixin({
            toast: true,
            position: 'center',
            showConfirmButton: false,
            timer: 3000
        });
        Toast.fire({
            type: 'error',
            title: '<?php echo $err; ?>',
        })
    </script>

<?php }
if (isset($info)) { ?>
    <script>
        const Toast = Swal.mixin({
            toast: true,
            position: 'center',
            showConfirmButton: false,
            timer: 3000
        });
        Toast.fire({
            type: 'info',
            title: '<?php echo $info; ?>',
        })
    </script>

<?php }
?>