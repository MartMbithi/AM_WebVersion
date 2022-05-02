<?php
/*
 * Created on Mon Dec 20 2021
 *
 *  Devlan - devlan.co.ke 
 *
 * hello@devlan.info
 *
 *
 * The Devlan End User License Agreement
 *
 * Copyright (c) 2021 Devlan
 *
 * 1. GRANT OF LICENSE
 * Devlan hereby grants to you (an individual) the revocable, personal, non-exclusive, and nontransferable right to
 * install and activate this system on two separated computers solely for your personal and non-commercial use,
 * unless you have purchased a commercial license from Devlan. Sharing this Software with other individuals, 
 * or allowing other individuals to view the contents of this Software, is in violation of this license.
 * You may not make the Software available on a network, or in any way provide the Software to multiple users
 * unless you have first purchased at least a multi-user license from Devlan.
 *
 * 2. COPYRIGHT 
 * The Software is owned by Devlan and protected by copyright law and international copyright treaties. 
 * You may not remove or conceal any proprietary notices, labels or marks from the Software.
 *
 * 3. RESTRICTIONS ON USE
 * You may not, and you may not permit others to
 * (a) reverse engineer, decompile, decode, decrypt, disassemble, or in any way derive source code from, the Software;
 * (b) modify, distribute, or create derivative works of the Software;
 * (c) copy (other than one back-up copy), distribute, publicly display, transmit, sell, rent, lease or 
 * otherwise exploit the Software.  
 *
 * 4. TERM
 * This License is effective until terminated. 
 * You may terminate it at any time by destroying the Software, together with all copies thereof.
 * This License will also terminate if you fail to comply with any term or condition of this Agreement.
 * Upon such termination, you agree to destroy the Software, together with all copies thereof.
 *
 * 5. NO OTHER WARRANTIES. 
 * Devlan  DOES NOT WARRANT THAT THE SOFTWARE IS ERROR FREE. 
 * Devlan SOFTWARE DISCLAIMS ALL OTHER WARRANTIES WITH RESPECT TO THE SOFTWARE, 
 * EITHER EXPRESS OR IMPLIED, INCLUDING BUT NOT LIMITED TO IMPLIED WARRANTIES OF MERCHANTABILITY, 
 * FITNESS FOR A PARTICULAR PURPOSE AND NONINFRINGEMENT OF THIRD PARTY RIGHTS. 
 * SOME JURISDICTIONS DO NOT ALLOW THE EXCLUSION OF IMPLIED WARRANTIES OR LIMITATIONS
 * ON HOW LONG AN IMPLIED WARRANTY MAY LAST, OR THE EXCLUSION OR LIMITATION OF 
 * INCIDENTAL OR CONSEQUENTIAL DAMAGES,
 * SO THE ABOVE LIMITATIONS OR EXCLUSIONS MAY NOT APPLY TO YOU. 
 * THIS WARRANTY GIVES YOU SPECIFIC LEGAL RIGHTS AND YOU MAY ALSO 
 * HAVE OTHER RIGHTS WHICH VARY FROM JURISDICTION TO JURISDICTION.
 *
 * 6. SEVERABILITY
 * In the event of invalidity of any provision of this license, the parties agree that such invalidity shall not
 * affect the validity of the remaining portions of this license.
 *
 * 7. NO LIABILITY FOR CONSEQUENTIAL DAMAGES IN NO EVENT SHALL DEVLAN  OR ITS SUPPLIERS BE LIABLE TO YOU FOR ANY
 * CONSEQUENTIAL, SPECIAL, INCIDENTAL OR INDIRECT DAMAGES OF ANY KIND ARISING OUT OF THE DELIVERY, PERFORMANCE OR 
 * USE OF THE SOFTWARE, EVEN IF DEVLAN HAS BEEN ADVISED OF THE POSSIBILITY OF SUCH DAMAGES
 * IN NO EVENT WILL DEVLAN  LIABILITY FOR ANY CLAIM, WHETHER IN CONTRACT 
 * TORT OR ANY OTHER THEORY OF LIABILITY, EXCEED THE LICENSE FEE PAID BY YOU, IF ANY.
 */


session_start();
require_once('../config/config.php');
require_once('../config/checklogin.php');
check_login();
require_once('../config/codeGen.php');

/* Add Important Dates */
if (isset($_POST['add_date'])) {
    $date_calendar_id = $_POST['date_calendar_id'];
    $start_date  = $_POST['start_date'];
    $end_date  = $_POST['end_date'];
    $date_details = $_POST['date_details'];

    /* Persist */
    $sql = "INSERT INTO important_dates (date_calendar_id, start_date, end_date, date_details) VALUES(?,?,?,?)";
    $prepare = $mysqli->prepare($sql);
    $bind = $prepare->bind_param(
        'ssss',
        $date_calendar_id,
        $start_date,
        $end_date,
        $date_details
    );
    $prepare->execute();
    if ($prepare) {
        $success = "Important Dates Registered To School Calendar";
    } else {
        $err = "Failed!, Please Try Again";
    }
}

/* Update Important Dates */
if (isset($_POST['upate_date'])) {
    $date_calendar_id = $_POST['date_calendar_id'];
    $start_date  = $_POST['start_date'];
    $end_date  = $_POST['end_date'];
    $date_details = $_POST['date_details'];
    $date_id  = $_POST['date_id'];

    /* Persist */
    $sql = "UPDATE important_dates SET date_calendar_id =?, start_date =?, end_date =?, date_details =? WHERE date_id =?";
    $prepare = $mysqli->prepare($sql);
    $bind = $prepare->bind_param(
        'sssss',
        $date_calendar_id,
        $start_date,
        $end_date,
        $date_details,
        $date_id
    );
    $prepare->execute();
    if ($prepare) {
        $success = "Important Dates Updated";
    } else {
        $err = "Failed!, Please Try Again";
    }
}

/* Delete Impotant Dates */
if (isset($_POST['delete'])) {
    $date_id = $_POST['date_id'];

    /* Persist */
    $sql = "DELETE FROM important_dates WHERE date_id = ?";
    $prepare = $mysqli->prepare($sql);
    $bind = $prepare->bind_param('s', $date_id);
    $prepare->execute();
    if ($prepare) {
        $success = "Dates Deleted From School Calendar";
    } else {
        $err = "Failed!, Please Try Again Later";
    }
}
require_once('../partials/head.php');
?>

<body>
    <!-- leftbar-tab-menu -->
    <?php require_once('../partials/sidebar.php'); ?>
    <!-- end leftbar-tab-menu-->

    <!-- Top Bar Start -->
    <?php require_once('../partials/topbar.php'); ?>
    <!-- Top Bar End -->

    <div class="page-wrapper">

        <!-- Page Content-->
        <div class="page-content-tab">

            <div class="container-fluid">
                <!-- Page-Title -->
                <div class="row">
                    <div class="col-sm-12">
                        <div class="page-title-box">
                            <div class="float-right">
                                <ol class="breadcrumb">
                                    <li class="breadcrumb-item"><a href="dashboard">Home</a></li>
                                    <li class="breadcrumb-item"><a href="">Faculties</a></li>
                                    <li class="breadcrumb-item active">School Calendar</li>
                                </ol>
                            </div>
                            <h4 class="page-title">Important Dates</h4>
                        </div>
                        <!--end page-title-box-->

                        <div class="text-right">
                            <button type="button" data-toggle="modal" data-target="#add_modal" class="btn btn-primary">Add New Important Dates</button>
                        </div>
                        <hr>
                    </div>
                    <!--end col-->
                </div>
                <!-- end page title end breadcrumb -->
                <!-- Add Modal -->
                <div class="modal fade" id="add_modal">
                    <div class="modal-dialog  modal-xl">
                        <div class="modal-content">
                            <div class="modal-header">
                                <h4 class="modal-title">Fill All Required Fields</h4>
                                <button type="button" class="close" data-dismiss="modal">
                                    <span>&times;</span>
                                </button>
                            </div>
                            <div class="modal-body">
                                <form method="post" enctype="multipart/form-data">
                                    <div class="form-row">
                                        <div class="form-group col-md-4">
                                            <label>Academic Year & Semester</label>
                                            <select name="date_calendar_id" style="width: 100%;" required class="basic form-control">
                                                <?php
                                                /* Pop All Academic Calendar Details  */
                                                $ret = "SELECT * FROM academic_calendar";
                                                $stmt = $mysqli->prepare($ret);
                                                $stmt->execute(); //ok
                                                $res = $stmt->get_result();
                                                while ($calendar = $res->fetch_object()) {
                                                ?>
                                                    <option value="<?php echo $calendar->calendar_id; ?>"><?php echo $calendar->calendar_year . ' ' . $calendar->calendar_semester; ?> - <?php echo $calendar->calendar_status; ?></option>
                                                <?php } ?>
                                            </select>
                                        </div>
                                        <div class="form-group col-md-4">
                                            <label>Start Date</label>
                                            <input type="date" name="start_date" required class="form-control">
                                        </div>
                                        <div class="form-group col-md-4">
                                            <label>End Date </label>
                                            <input type="date" name="end_date" required class="form-control">
                                        </div>
                                        <div class="form-group col-md-12">
                                            <label>Important Dates Details</label>
                                            <textarea rows="3" name="date_details" required class="summernote form-control"></textarea>
                                        </div>
                                    </div>
                                    <div class="text-right">
                                        <button name="add_date" class="btn btn-primary" type="submit">
                                            Save Event
                                        </button>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- End Modal -->
                <div class="row">
                    <div class="col-lg-12">
                        <div class="card">
                            <div class="card-body">
                                <div class="">

                                    <fieldset class="border border-primary p-2">
                                        <legend class="w-auto text-primary font-weight-light">Overall School Calendar - Important Dates</legend>
                                        <table class="table table-bordered dt-responsive nowrap" style="border-collapse: collapse; border-spacing: 0; width: 100%;">
                                            <thead>
                                                <tr>
                                                    <th>Event Dates</th>
                                                    <th>Description</th>
                                                    <th>Manage</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                <?php
                                                $ret = "SELECT * FROM important_dates id
                                                INNER JOIN academic_calendar ac ON
                                                ac.calendar_id = id.date_calendar_id";
                                                $stmt = $mysqli->prepare($ret);
                                                $stmt->execute(); //ok
                                                $res = $stmt->get_result();
                                                while ($dates = $res->fetch_object()) {
                                                ?>
                                                    <tr>
                                                        <td>Academic Calendar : <?php echo $dates->calendar_year . ' - ' . $dates->calendar_semester; ?> <br>
                                                            From : <?php echo date('d M Y', strtotime($dates->start_date)) . '<br> To: ' . date('d M Y', strtotime($dates->end_date)); ?></td>
                                                        <td><?php echo substr($dates->date_details, 0, 50,); ?></td>
                                                        <td>
                                                            <a data-toggle="modal" href="#update_<?php echo $dates->date_id; ?>" class="badge badge-primary"><i class="fas fa-edit"></i> Edit</a>
                                                            <a data-toggle="modal" href="#delete_<?php echo $dates->date_id; ?>" class="badge badge-danger"><i class="fas fa-trash"></i> Delete</a>
                                                        </td>
                                                        <!-- Udpate Modal -->
                                                        <div class="modal fade" id="update_<?php echo $dates->date_id; ?>">
                                                            <div class="modal-dialog  modal-xl">
                                                                <div class="modal-content">
                                                                    <div class="modal-header">
                                                                        <h4 class="modal-title">Fill All Required Fields</h4>
                                                                        <button type="button" class="close" data-dismiss="modal">
                                                                            <span>&times;</span>
                                                                        </button>
                                                                    </div>
                                                                    <div class="modal-body">
                                                                        <form method="post" enctype="multipart/form-data">
                                                                            <div class="form-row">
                                                                                <div class="form-group col-md-6">
                                                                                    <label>Start Date</label>
                                                                                    <input type="date" value="<?php echo $dates->start_date; ?>" name="start_date" required class="form-control">
                                                                                    <input type="hidden" value="<?php echo $dates->date_id; ?>" name="date_id" required class="form-control">
                                                                                </div>
                                                                                <div class="form-group col-md-6">
                                                                                    <label>End Date </label>
                                                                                    <input type="date" value="<?php echo $dates->end_date; ?>" name="end_date" required class="form-control">
                                                                                </div>
                                                                                <div class="form-group col-md-12">
                                                                                    <label>Important Dates Details</label>
                                                                                    <textarea rows="3" name="date_details" required class="summernote form-control"><?php echo $dates->date_details; ?></textarea>
                                                                                </div>
                                                                            </div>
                                                                            <div class="text-right">
                                                                                <button name="upate_date" class="btn btn-primary" type="submit">
                                                                                    Save Event
                                                                                </button>
                                                                            </div>
                                                                        </form>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </div>
                                                        <!-- End Modal -->

                                                        <!-- Delete Modal -->
                                                        <div class="modal fade" id="delete_<?php echo $dates->date_id; ?>" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
                                                            <div class="modal-dialog modal-dialog-centered" role="document">
                                                                <div class="modal-content">
                                                                    <div class="modal-header">
                                                                        <h5 class="modal-title" id="exampleModalLabel">CONFIRM DELETE</h5>
                                                                        <button type="button" class="close" data-dismiss="modal">
                                                                            <span>&times;</span>
                                                                        </button>
                                                                    </div>
                                                                    <form method="POST">
                                                                        <div class="modal-body text-center text-danger">
                                                                            <h4>Delete These Dates</h4>
                                                                            <br>
                                                                            <!-- Hide This -->
                                                                            <input type="hidden" name="date_id" value="<?php echo $dates->date_id; ?>">
                                                                            <button type="button" class="text-center btn btn-success" data-dismiss="modal">No</button>
                                                                            <input type="submit" name="delete" value="Delete" class="text-center btn btn-danger">
                                                                        </div>
                                                                    </form>
                                                                </div>
                                                            </div>
                                                        </div>
                                                        <!-- End Delete Modal -->
                                                    </tr>
                                                <?php
                                                }
                                                ?>
                                            </tbody>
                                        </table>
                                    </fieldset>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div><!-- container -->
            <!-- Footer -->
            <?php require_once('../partials/footer.php'); ?>
            <!--end footer-->
        </div>
        <!-- end page content -->
    </div>
    <!-- end page-wrapper -->
    <!-- Scripts -->
    <?php require_once('../partials/scripts.php'); ?>

</body>


</html>