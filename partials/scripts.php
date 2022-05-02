<!-- Jquerry -->
<script src="../public/js/jquery.min.js"></script>
<script src="../public/js/jquery-ui.min.js"></script>
<!-- Bootstrap -->
<script src="../public/js/bootstrap.bundle.min.js"></script>
<!-- Mentis Menu -->
<script src="../public/js/metismenu.min.js"></script>
<!-- Waves -->
<script src="../public/js/waves.js"></script>
<!-- Feather Js -->
<script src="../public/js/feather.min.js"></script>
<!-- Slim Scroll -->
<script src="../public/js/jquery.slimscroll.min.js"></script>
<!-- IziToast An Alternative For Swal -->
<!-- <script src="../public/js/iziToast.min.js"></script> -->
<!-- Sweet Alerts -->
<script src="../public/plugins/sweetalert2/sweetalert2.min.js"></script>
<!-- Dashboard Init Js  -->
<script src="../public/js/pages/jquery.crm_dashboard.init.js"></script>
<!-- App Js -->
<script src="../public/js/app.js"></script>
<!-- Profile Page Init Js -->
<script src="../public/js/pages/jquery.profile.init.js"></script>
<!-- Dropify -->
<script src="../public/plugins/dropify/dropify.min.js"></script>
<!-- Moment Js -->
<script src="../public/plugins/moment/moment.js"></script>
<!-- Isotope Js -->
<script src="../public/plugins/filter/isotope.pkgd.min.js"></script>
<!-- Masonry Js -->
<script src="../plugins/filter/masonry.pkgd.min.js"></script>
<!-- Magic Pop Js -->
<script src="../plugins/filter/jquery.magnific-popup.min.js"></script>
<!-- Chart Js -->
<script src="../plugins/chartjs/chart.min.js"></script>
<script src="../plugins/chartjs/roundedBar.min.js"></script>
<!-- Light Pick Js -->
<script src="../plugins/lightpick/lightpick.js"></script>
<!-- Custom Select 2 Bootsrap -->
<script src="../public/plugins/select2/select2.min.js"></script>
<script src="../public/plugins/select2/custom-select2.js"></script>
<!-- Custom File  -->
<script src="../public/js/bs-custom-file-input.min.js"></script>
<!-- Data Tables CDN -->
<script type="text/javascript" src="https://cdn.datatables.net/v/dt/dt-1.10.25/datatables.min.js"></script>
<script type="text/javascript" src="https://cdn.datatables.net/buttons/1.7.1/js/dataTables.buttons.min.js"></script>
<script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/jszip/3.1.3/jszip.min.js"></script>
<script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.53/pdfmake.min.js"></script>
<script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.53/vfs_fonts.js"></script>
<script type="text/javascript" src="https://cdn.datatables.net/buttons/1.7.1/js/buttons.html5.min.js"></script>
<script type="text/javascript" src="https://cdn.datatables.net/buttons/1.7.1/js/buttons.print.min.js"></script>
<!-- Floara CDNS -->
<script type='text/javascript' src='https://cdn.jsdelivr.net/npm/froala-editor@4.0.8/js/froala_editor.pkgd.min.js'></script>
<!-- Spinner  -->
<script src="../public/js/spinner.js"></script>
<script>
    /* Init Feather Js */
    feather.replace()
    /* Init Custom Select */
    var ss = $(".basic").select2({
        tags: true,
    });
    /* Init Custom File Select */
    $(document).ready(function() {
        bsCustomFileInput.init();
    });
    /* Show Selected File Name */
    document.querySelector('.custom-file-input').addEventListener('change', function(e) {
        var fileName = document.getElementById("myInput").files[0].name;
        var nextSibling = e.target.nextElementSibling
        nextSibling.innerText = fileName
    })

    /* Stop Double Resubmission */
    if (window.history.replaceState) {
        window.history.replaceState(null, null, window.location.href);
    }
</script>
<script>
    /* Load Multiple Instances Of Froala Editor */
    new FroalaEditor('.summernote', {
        toolbarButtons: ['bold', 'italic'],
        height: 200
    });
</script>
<script>
    /* Initialize Data Tables */
    $(document).ready(function() {
        $('.table').DataTable();
    });

    $(document).ready(function() {
        $('#export-data-table').DataTable({
            dom: 'Bfrtip',
            buttons: [
                'csv', 'excel', 'pdf', 'print'
            ]
        });
    });
    $("input[type='number']").inputSpinner()
</script>
<!-- Init Sweet Alerts -->
<?php if (isset($success)) { ?>
    <script>
        const Toast = Swal.mixin({
            toast: true,
            position: 'top-end',
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
            position: 'top-end',
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
            position: 'top-end',
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
<script>
    /* Ajaxes On Mailers */
    function GetInstructorDetails(val) {
        $.ajax({
            type: "POST",
            url: "ajaxes.php",
            data: 'UserID=' + val,
            success: function(data) {
                $('#UserNumber').val(data);
            }
        });
        $.ajax({
            type: "POST",
            url: "ajaxes.php",
            data: 'UserNumber=' + val,
            success: function(data) {
                $('#UserEmail').val(data);
            }
        });
        $.ajax({
            type: "POST",
            url: "ajaxes.php",
            data: 'UserEmail=' + val,
            success: function(data) {
                $('#UserName').val(data);
            }
        });

    }

    /* Get Module Details */
    function GetModuleDetails(val) {
        $.ajax({
            type: "POST",
            url: "ajaxes.php",
            data: 'ModuleID=' + val,
            success: function(data) {
                $('#ModuleDetails').val(data);
            }
        });
    }
</script>