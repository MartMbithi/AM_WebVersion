<?php

session_start();
require_once('../config/config.php');
require_once('../config/checklogin.php');
check_login();
require_once('../config/codeGen.php');
/* Add Past Paper */
if (isset($_POST['add_paper'])) {
    $paper_module_id = $_POST['paper_module_id'];
    $paper_topic  = $_POST['paper_topic'];
    $paper_attachments = $_FILES['paper_attachments']['name'];
    $paper_user_id  = $_SESSION['user_id'];
    if (!empty($paper_attachments)) {
        $new_file_name = $paper_topic . ' ' . $paper_attachments;
        /* Upload Papers */
        $upload_directory = "../public/uploads/sys_data/pastpapers/" . $new_file_name;
        $temp_name = $_FILES["paper_attachments"]["tmp_name"];
        move_uploaded_file($temp_name, $upload_directory);

        /* Persist */
        $sql = "INSERT INTO module_past_papers (paper_module_id, paper_user_id, paper_topic, paper_attachments) VALUES(?,?,?,?)";
        $prepare = $mysqli->prepare($sql);
        $bind = $prepare->bind_param(
            'ssss',
            $paper_module_id,
            $paper_user_id,
            $paper_topic,
            $new_file_name
        );
        $prepare->execute();
        if ($prepare) {
            $success = "$paper_topic, Uploaded";
        } else {
            $err = "Failed!, Please Try Again";
        }
    }
}

/* Update Past Papers */
if (isset($_POST['update_paper'])) {
    $paper_id = $_POST['paper_id'];
    $paper_topic = $_POST['paper_topic'];
    $paper_attachments = $_FILES['paper_attachments']['name'];
    if (!empty($paper_attachments)) {
        $new_file_name = $paper_topic . ' ' . $paper_attachments;
        /* Upload Papers */
        $upload_directory = "../public/uploads/sys_data/pastpapers/" . $new_file_name;
        $temp_name = $_FILES["paper_attachments"]["tmp_name"];
        move_uploaded_file($temp_name, $upload_directory);

        /* Persist */
        $sql = "UPDATE module_past_papers SET paper_topic =?, paper_attachments =? WHERE paper_id = ?";
        $prepare = $mysqli->prepare($sql);
        $bind = $prepare->bind_param(
            'sss',
            $paper_topic,
            $new_file_name,
            $paper_id
        );
        $prepare->execute();
        if ($prepare) {
            $success = "$paper_topic Updated";
        } else {
            $err = "Failed!, Please Try Again";
        }
    } else {
        $sql = "UPDATE module_past_papers SET paper_topic =? WHERE paper_id = ?";
        $prepare = $mysqli->prepare($sql);
        $bind = $prepare->bind_param(
            'ss',
            $paper_topic,
            $paper_id
        );
        $prepare->execute();
        if ($prepare) {
            $success = "$paper_topic Updated";
        } else {
            $err = "Failed!, Please Try Again";
        }
    }
}

/* Delete Past Paper */
if (isset($_POST['delete'])) {
    $paper_id = $_POST['paper_id'];
    $paper_attachments = $_POST['paper_attachments'];
    if (!empty($paper_attachments)) {
        /* Purge From Main Directory */
        $purge = unlink("../public/uploads/sys_data/pastpapers/" . $paper_attachments);
        /* Load Delete */
        $sql = "DELETE FROM module_past_papers WHERE paper_id =?";
        $prepare = $mysqli->prepare($sql);
        $bind = $prepare->bind_param('s', $paper_id);
        $prepare->execute();
        if ($prepare && $purge) {
            $success = "Past Paper Deleted";
        } else {
            $err = "Failed!, Please Try Again Later";
        }
    }
}

/* Update Visibility */
if (isset($_POST['update_visibility'])) {
    $paper_id = $_POST['paper_id'];
    $paper_status = $_POST['paper_status'];
    /* Pesist */
    $sql = "UPDATE module_past_papers SET paper_status =? WHERE paper_id =?";
    $prepare = $mysqli->prepare($sql);
    $bind = $prepare->bind_param('ss', $paper_status, $paper_id);
    $prepare->execute();
    if ($prepare) {
        $success = "Paper Visibility Updated";
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
                                    <li class="breadcrumb-item"><a href="lec_dashboard">Home</a></li>
                                    <li class="breadcrumb-item"><a href="">Modules</a></li>
                                    <li class="breadcrumb-item active">Module Past Paper</li>
                                </ol>
                            </div>
                            <h4 class="page-title">Module Past Papers</h4>
                        </div>
                        <!--end page-title-box-->
                        <div class="text-right">
                            <button type="button" data-toggle="modal" data-target="#add_modal" class="btn btn-primary">Upload Past Papers</button>
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
                                            <label>Module Name</label>
                                            <select name="paper_module_id" style="width: 100%;" required class="basic form-control">
                                                <?php
                                                /* Pop All Courses In Asc Order */
                                                $user_id = $_SESSION['user_id'];
                                                $ret = "SELECT * FROM module_allocations ma
                                                INNER JOIN modules m ON m.module_id = ma.allocation_module_id
                                                INNER JOIN academic_calendar ac ON ac.calendar_id = ma.allocation_calendar_id
                                                WHERE ma.allocation_user_id = '$user_id' AND ac.calendar_status = 'Current'
                                                ORDER BY m.module_code ASC ";
                                                $stmt = $mysqli->prepare($ret);
                                                $stmt->execute(); //ok
                                                $res = $stmt->get_result();
                                                while ($modules = $res->fetch_object()) {
                                                ?>
                                                    <option value="<?php echo $modules->module_id; ?>"><?php echo $modules->module_code . ' - ' . $modules->module_name; ?></option>
                                                <?php } ?>
                                            </select>
                                        </div>
                                        <div class="form-group col-md-6">
                                            <label for="exampleInputFile">Past Papers Attachments</label>
                                            <div class="input-group">
                                                <div class="custom-file">
                                                    <input name="paper_attachments" accept=".pdf, .docx, .doc" type="file" class="custom-file-input">
                                                    <label class="custom-file-label" for="exampleInputFile">Choose file</label>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="form-group col-md-12">
                                            <label>Past Paper Topic / Title</label>
                                            <input type="text" name="paper_topic" required class="form-control">
                                        </div>
                                    </div>
                                    <div class="text-right">
                                        <button name="add_paper" class="btn btn-primary" type="submit">
                                            Upload
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
                                <legend class="w-auto text-primary font-weight-light">Select Module Code & Name To View Posted Past Papers</legend>
                                <form method="post" enctype="multipart/form-data">
                                    <div class="form-row">
                                        <div class="form-group col-md-12">
                                            <select name="module_id" style="width: 100%;" required class="basic form-control">
                                                <option>Select Module</option>
                                                <?php
                                                /* Pop All Modules */
                                                $user_id = $_SESSION['user_id'];
                                                $ret = "SELECT * FROM module_allocations ma
                                                INNER JOIN modules m ON m.module_id = ma.allocation_module_id
                                                INNER JOIN academic_calendar ac ON ac.calendar_id = ma.allocation_calendar_id
                                                WHERE ma.allocation_user_id = '$user_id' AND ac.calendar_status = 'Current'
                                                ORDER BY m.module_code ASC ";
                                                $stmt = $mysqli->prepare($ret);
                                                $stmt->execute(); //ok
                                                $res = $stmt->get_result();
                                                while ($module = $res->fetch_object()) {
                                                ?>
                                                    <option value="<?php echo $module->module_id; ?>"><?php echo $module->module_code . ' - ' . $module->module_name; ?></option>
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
                                <fieldset class="border border-primary p-2">
                                    <legend class="w-auto text-primary font-weight-light">Uploaded Past Papers</legend>
                                    <?php
                                    $module_id = $_POST['module_id'];
                                    $user_id = $_SESSION['user_id'];
                                    $ret = "SELECT * FROM module_past_papers mpp
                                    INNER JOIN users u ON u.user_id = mpp.paper_user_id
                                    INNER JOIN module_allocations ma ON ma.allocation_module_id = mpp.paper_module_id
                                    INNER JOIN academic_calendar ac ON ac.calendar_id = ma.allocation_calendar_id
                                    WHERE paper_module_id = '$module_id' AND ma.allocation_user_id = '$user_id'
                                    AND ac.calendar_status = 'Current'";
                                    $stmt = $mysqli->prepare($ret);
                                    $stmt->execute(); //ok
                                    $res = $stmt->get_result();
                                    while ($paper = $res->fetch_object()) {
                                    ?>
                                        <div class="card mb-3" style="max-width: 100%;">
                                            <div class="row g-0">
                                                <div class="col-md-4">
                                                    <img src="../public/images/icons/exam.png" class="img-fluid rounded-start" alt="...">
                                                </div>
                                                <div class="col-md-8">
                                                    <div class="card-body">
                                                        <h5 class="card-title"><?php echo $paper->paper_topic ?></h5>
                                                        <p class="card-text">
                                                        <figcaption class="blockquote-footer">
                                                            Uploaded By :
                                                            <cite class="text-success" title="Source Title">
                                                                <?php echo $paper->user_number . ' ' . $paper->user_name; ?>
                                                            </cite>
                                                        </figcaption>
                                                        <figcaption class="blockquote-footer">
                                                            Uploaded On :
                                                            <cite class="text-success" title="Source Title">
                                                                <?php echo date('d M Y g:ia', strtotime($paper->paper_uploaded_at)); ?>
                                                            </cite>
                                                        </figcaption>
                                                        <figcaption class="blockquote-footer">
                                                            Visibility Status :
                                                            <?php if ($paper->paper_status == 'hidden') { ?>
                                                                <cite class="text-danger" title="Source Title">
                                                                    Not Available
                                                                </cite>
                                                            <?php } else { ?>
                                                                <cite class="text-success" title="Source Title">
                                                                    Available
                                                                </cite>
                                                            <?php } ?>
                                                        </figcaption>
                                                        <br><br><br><br>
                                                        <div class="text-right">
                                                            <a data-toggle="modal" href="#status_<?php echo $paper->paper_id; ?>" class="badge badge-warning"><i class="fas fa-eye"></i> Update Visibility</a>
                                                            <a data-toggle="modal" href="#update_<?php echo $paper->paper_id; ?>" class="badge badge-primary"><i class="fas fa-edit"></i> Edit</a>
                                                            <a data-toggle="modal" href="#delete_<?php echo $paper->paper_id; ?>" class="badge badge-danger"><i class="fas fa-trash"></i> Delete</a>
                                                        </div>
                                                        <hr>
                                                        <?php
                                                        if (!empty($paper->paper_attachments) && $paper->paper_status == 'available') {
                                                        ?>
                                                            <div class="text-center">
                                                                <a href="../public/uploads/sys_data/pastpapers/<?php echo $paper->paper_attachments; ?>" class="btn btn-outline-success"><i class="fas fa-download"></i> Download</a>
                                                            </div>
                                                        <?php } else { ?>
                                                            <div class="text-center">
                                                                <button class="btn btn-outline-danger"><i class="fas fa-exclamation-circle"></i> Paper Not Available</button>
                                                            </div>
                                                        <?php } ?>
                                                        </p>
                                                        <!-- Load Modals -->
                                                        <?php include('../helpers/modals/manage_past_papers.php'); ?>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    <?php } ?>
                                </fieldset>
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