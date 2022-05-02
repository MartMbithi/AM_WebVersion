<?php
/*
 * Created on Sun Feb 27 2022
 *
 *  Devlan Agency - devlan.co.ke 
 *
 * hello@devlan.co.ke
 *
 *
 * The Devlan End User License Agreement
 *
 * Copyright (c) 2022 Devlan Agency
 *
 * 1. GRANT OF LICENSE
 * Devlan Agency hereby grants to you (an individual) the revocable, personal, non-exclusive, and nontransferable right to
 * install and activate this system on two separated computers solely for your personal and non-commercial use,
 * unless you have purchased a commercial license from Devlan Agency. Sharing this Software with other individuals, 
 * or allowing other individuals to view the contents of this Software, is in violation of this license.
 * You may not make the Software available on a network, or in any way provide the Software to multiple users
 * unless you have first purchased at least a multi-user license from Devlan Agency.
 *
 * 2. COPYRIGHT 
 * The Software is owned by Devlan Agency and protected by copyright law and international copyright treaties. 
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
 * DEVLAN AGENCY  DOES NOT WARRANT THAT THE SOFTWARE IS ERROR FREE. 
 * DEVLAN AGENCY SOFTWARE DISCLAIMS ALL OTHER WARRANTIES WITH RESPECT TO THE SOFTWARE, 
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
 * 7. NO LIABILITY FOR CONSEQUENTIAL DAMAGES IN NO EVENT SHALL DEVLAN AGENCY  OR ITS SUPPLIERS BE LIABLE TO YOU FOR ANY
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
/* Add Unit To Time Table */
if (isset($_POST['add_unit'])) {
    $timetable_allocation_id = $_POST['timetable_allocation_id'];
    $timetable_class_start_time = $_POST['timetable_class_start_time'];
    $timetable_class_end_time  = $_POST['timetable_class_end_time'];
    $timetable_class_day = $_POST['timetable_class_day'];
    $timetable_class_room = $_POST['timetable_class_room'];

    /* Prevent Double Entries */
    $sql = "SELECT * FROM timetable  WHERE timetable_allocation_id ='$timetable_allocation_id' 
    AND timetable_class_start_time = '$timetable_class_start_time'";
    $res = mysqli_query($mysqli, $sql);
    if (mysqli_num_rows($res) > 0) {
        $row = mysqli_fetch_assoc($res);
        if (
            $timetable_allocation_id == $row['timetable_allocation_id'] &&
            $timetable_class_start_time == $row['timetable_class_start_time'] &&
            $timetable_class_room == $row['timetable_class_room']
        ) {
            $err = "This Module Is Already In The Time Table";
        }
    } else {
        /* Persist */
        $sql = "INSERT INTO timetable (timetable_allocation_id, timetable_class_start_time, timetable_class_end_time, timetable_class_day, timetable_class_room)
        VALUES(?,?,?,?,?)";
        $prepare = $mysqli->prepare($sql);
        $bind = $prepare->bind_param(
            'sssss',
            $timetable_allocation_id,
            $timetable_class_start_time,
            $timetable_class_end_time,
            $timetable_class_day,
            $timetable_class_room
        );
        $prepare->execute();
        if ($prepare) {
            $success = "Module Added To Timetable";
        } else {
            $err = "Failed!, Please Try Again Later";
        }
    }
}

/* Update Unit To Time Table */
if (isset($_POST['update_unit'])) {
    $timetable_class_start_time = $_POST['timetable_class_start_time'];
    $timetable_class_end_time  = $_POST['timetable_class_end_time'];
    $timetable_class_day = $_POST['timetable_class_day'];
    $timetable_id = $_POST['timetable_id'];
    $timetable_class_room = $_POST['timetable_class_room'];

    /* Persist */
    $sql = "UPDATE timetable SET timetable_class_start_time =?, timetable_class_end_time =?,
    timetable_class_day =?, timetable_class_room = ?  WHERE timetable_id =?";
    $prepare = $mysqli->prepare($sql);
    $bind = $prepare->bind_param(
        'sssss',
        $timetable_class_start_time,
        $timetable_class_end_time,
        $timetable_class_day,
        $timetable_class_room,
        $timetable_id
    );
    $prepare->execute();
    if ($prepare) {
        $success = "Module In Timetable Updated";
    } else {
        $err = "Failed!, Please Try Again Later";
    }
}

/* Delete Unit To TimeTable */
if (isset($_POST['delete'])) {
    $timetable_id = $_POST['timetable_id'];

    /* Persist Delete */
    $sql = "DELETE FROM timetable WHERE timetable_id =?";
    $prepare = $mysqli->prepare($sql);
    $bind = $prepare->bind_param('s', $timetable_id);
    $prepare->execute();
    if ($prepare) {
        $success = "Module Deleted From Timetable";
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
                                    <li class="breadcrumb-item"><a href="edu_dashboard">Home</a></li>
                                    <li class="breadcrumb-item"><a href="">Courses</a></li>
                                    <li class="breadcrumb-item active">Timetable</li>
                                </ol>
                            </div>
                            <h4 class="page-title">Time Table</h4>
                        </div>
                        <!--end page-title-box-->
                        <div class="text-right">
                            <button type="button" data-toggle="modal" data-target="#add_modal" class="btn btn-primary">Add Module To TimeTable</button>
                        </div>
                        <hr>
                    </div>
                    <!--end col-->
                </div>
                <!-- end page title end breadcrumb -->
                <!-- Add Departmental Memo Modal -->
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
                                        <div class="form-group col-md-6">
                                            <label>Module Code & Name </label>
                                            <select name="timetable_allocation_id" style="width: 100%;" required class="basic form-control">
                                                <?php
                                                /* Pop Module Details */
                                                $ret = "SELECT * FROM module_allocations ma 
                                                INNER JOIN modules m ON m.module_id = ma.allocation_module_id";
                                                $stmt = $mysqli->prepare($ret);
                                                $stmt->execute(); //ok
                                                $res = $stmt->get_result();
                                                while ($allocation = $res->fetch_object()) {
                                                ?>
                                                    <option value="<?php echo $allocation->allocation_id; ?>"><?php echo $allocation->module_code . ' ' . $allocation->module_name; ?></option>
                                                <?php } ?>
                                            </select>
                                        </div>
                                        <div class="form-group col-md-6">
                                            <label>Class Room Number</label>
                                            <input type="text" name="timetable_class_room" required class="form-control">
                                        </div>
                                        <div class="form-group col-md-4">
                                            <label>Class Start Time</label>
                                            <input type="time" name="timetable_class_start_time" required class="form-control">
                                        </div>
                                        <div class="form-group col-md-4">
                                            <label>Class End Time</label>
                                            <input type="time" name="timetable_class_end_time" required class="form-control">
                                        </div>
                                        <div class="form-group col-md-4">
                                            <label>Class Day Offered</label>
                                            <select name="timetable_class_day" style="width: 100%;" required class="basic form-control">
                                                <option>Monday</option>
                                                <option>Tuesday</option>
                                                <option>Wednesday</option>
                                                <option>Thursday</option>
                                                <option>Friday</option>
                                                <option>Saturday</option>
                                                <option>Sunday</option>
                                            </select>
                                        </div>
                                    </div>
                                    <div class="text-right">
                                        <button name="add_unit" class="btn btn-primary" type="submit">
                                            Add Module To Time Table
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
                        <div class="">
                            <fieldset class="border border-primary p-2">
                                <legend class="w-auto text-primary font-weight-light">Select Course Name & Code To Manage Modules In Timetable</legend>
                                <form method="post" enctype="multipart/form-data">
                                    <div class="form-row">
                                        <div class="form-group col-md-12">
                                            <select name="course_id" style="width: 100%;" required class="basic form-control">
                                                <option>Select Course</option>
                                                <?php
                                                /* Pop All Courses In Asc Order */
                                                $ret = "SELECT * FROM courses                                 
                                                ORDER BY course_code ASC  ";
                                                $stmt = $mysqli->prepare($ret);
                                                $stmt->execute(); //ok
                                                $res = $stmt->get_result();
                                                while ($courses = $res->fetch_object()) {
                                                ?>
                                                    <option value="<?php echo $courses->course_id; ?>"><?php echo $courses->course_code . ' - ' . $courses->course_name; ?></option>
                                                <?php } ?>
                                            </select>
                                        </div>
                                    </div>
                                    <div class="text-right">
                                        <button name="search" class="btn btn-primary" type="submit">
                                            Search
                                        </button>
                                    </div>
                                </form>
                            </fieldset>
                            <!-- Get All Departmental Memos Posted On Selected Department -->
                            <hr>
                            <?php
                            if (isset($_POST['search'])) {
                            ?>

                                <div class="col-lg-12">
                                    <div class="card">
                                        <div class="card-body">
                                            <table class="table table-bordered dt-responsive nowrap" style="border-collapse: collapse; border-spacing: 0; width: 100%;">
                                                <thead>
                                                    <tr>
                                                        <th>Module Details</th>
                                                        <th>Instructor</th>
                                                        <th>Room</th>
                                                        <th>Time</th>
                                                        <th>Day</th>
                                                        <th>Manage</th>
                                                    </tr>
                                                </thead>
                                                <tbody>
                                                    <?php
                                                    $course_id = $_POST['course_id'];
                                                    $ret = "SELECT * FROM timetable t
                                                    INNER JOIN module_allocations ma ON ma.allocation_id = t.timetable_allocation_id
                                                    INNER JOIN modules m ON m.module_id = ma.allocation_module_id
                                                    INNER JOIN users s ON s.user_id = ma.allocation_user_id
                                                    WHERE m.module_course_id = '$course_id'";
                                                    $stmt = $mysqli->prepare($ret);
                                                    $stmt->execute(); //ok
                                                    $res = $stmt->get_result();
                                                    while ($tt = $res->fetch_object()) {
                                                    ?>
                                                        <tr>
                                                            <td><?php echo $tt->module_code . ' ' . $tt->module_name; ?></td>
                                                            <td><?php echo $tt->user_number . ' ' . $tt->user_name; ?></td>
                                                            <td><?php echo $tt->timetable_class_room; ?></td>
                                                            <td>
                                                                <?php echo $tt->timetable_class_start_time . ' To ' . $tt->timetable_class_end_time; ?>
                                                            </td>
                                                            <td><?php echo $tt->timetable_class_day; ?></td>
                                                            <td>
                                                                <a data-toggle="modal" href="#update_<?php echo $tt->timetable_id; ?>" class="badge badge-primary"><i class="fas fa-edit"></i> Edit</a>
                                                                <a data-toggle="modal" href="#delete_<?php echo $tt->timetable_id; ?>" class="badge badge-danger"><i class="fas fa-trash"></i> Delete</a>
                                                            </td>

                                                            <!-- Udpate Modal -->
                                                            <div class="modal fade" id="update_<?php echo $tt->timetable_id; ?>">
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
                                                                                        <label>Class Room Number</label>
                                                                                        <input type="text" value="<?php echo $tt->timetable_class_room; ?>" name="timetable_class_room" required class="form-control">
                                                                                        <input type="hidden" value="<?php echo $tt->timetable_id; ?>" name="timetable_id" required class="form-control">
                                                                                    </div>
                                                                                    <div class="form-group col-md-6">
                                                                                        <label>Class Start Time</label>
                                                                                        <input type="time" value="<?php echo $tt->timetable_class_start_time; ?>" name="timetable_class_start_time" required class="form-control">
                                                                                    </div>
                                                                                    <div class="form-group col-md-6">
                                                                                        <label>Class End Time</label>
                                                                                        <input type="time" value="<?php echo $tt->timetable_class_start_time; ?>" name="timetable_class_end_time" required class="form-control">
                                                                                    </div>
                                                                                    <div class="form-group col-md-6">
                                                                                        <label>Class Day Offered</label>
                                                                                        <select name="timetable_class_day" style="width: 100%;" required class="basic form-control">
                                                                                            <option><?php echo $tt->timetable_class_day; ?></option>
                                                                                            <option>Monday</option>
                                                                                            <option>Tuesday</option>
                                                                                            <option>Wednesday</option>
                                                                                            <option>Thursday</option>
                                                                                            <option>Friday</option>
                                                                                            <option>Saturday</option>
                                                                                            <option>Sunday</option>
                                                                                        </select>
                                                                                    </div>
                                                                                </div>
                                                                                <div class="text-right">
                                                                                    <button name="update_unit" class="btn btn-primary" type="submit">
                                                                                        Update Module To Time Table
                                                                                    </button>
                                                                                </div>
                                                                            </form>
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                            <!-- End Modal -->

                                                            <!-- Delete Modal -->
                                                            <div class="modal fade" id="delete_<?php echo $tt->timetable_id; ?>" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
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
                                                                                <h4>Delete This Module From Timetable </h4>
                                                                                <br>
                                                                                <!-- Hide This -->
                                                                                <input type="hidden" name="timetable_id" value="<?php echo $tt->timetable_id; ?>">
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
                                        </div>
                                    </div>
                                </div>
                            <?php } ?>
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