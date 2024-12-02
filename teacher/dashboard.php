<?php
session_start();
if (isset($_SESSION["teacher"])) {

    require "../connection.php";
?>
    <!DOCTYPE html>
    <html lang="en">

    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title>Dashboard | Teacher</title>

        <link rel="stylesheet" href="../css/bootstrap.css" />
    </head>

    <body>

        <div class="container-fluid">
            <div class="row">
                <div class="col-12 col-md-3 bg-light">
                    <div class="row">
                        <h1 class="mt-3">Education</h1>
                        <hr>
                        <ul>
                            <li class="border border-1 border-primary shadow rounded-3 p-3 mb-1 fs-4" style="cursor: pointer;" onclick="window.location = 'dashboard.php';"><a class="text-decoration-none text-black" href="dashboard.php">Dashboard</a></li>
                            <li class="border border-1 border-primary shadow rounded-3 p-3 mb-1 fs-4" style="cursor: pointer;" onclick="window.location = 'my-profile.php';"><a class="text-decoration-none text-black" href="my-profile.php">My Profile</a></li>
                            <li class="border border-1 border-primary shadow rounded-3 p-3 mb-1 fs-4" style="cursor: pointer;" onclick="window.location = 'my-session.php';"><a class="text-decoration-none text-black" href="my-session.php">Sessions</a></li>
                            <li class="border border-1 border-primary shadow rounded-3 p-3 mb-1 fs-4" style="cursor: pointer;" onclick="logOut();"><a class="text-decoration-none text-black" href="#">Log Out</a></li>
                        </ul>
                    </div>
                </div>

                <div class="col-12 col-md-9">
                    <div class="row p-2">
                        <div class="col-12 border border-1 rounded bg-light">
                            <div class="row">

                                <h1 class="text-decoration-underline">Teacher Dashboard</h1>

                                <div>
                                    <p class="bg-body">Dashboard / <span>Home</span></p>
                                </div>

                                <div class="col-12">
                                    <div class="row">

                                        <?php
                                        $totalSession_rs = Database::search("SELECT COUNT(`session`.`id`) AS `total_session` FROM `session` INNER JOIN `teacher_has_grade_has_subject` ON `session`.`teacher_grade_subject_id`=`teacher_has_grade_has_subject`.`id` WHERE `teacher_has_grade_has_subject`.`teacher_id`=?", [$_SESSION['teacher']['id']], "s");

                                        $totalSession_data = $totalSession_rs->fetch_assoc();

                                        ?>

                                        <div class="col-6 col-md-4 p-3">
                                            <div class="row bg-primary rounded rounded-3 py-3">
                                                <h3 class="text-center">Total Sessions</h3>
                                                <h4 class="m-0 text-center"><?php echo $totalSession_data['total_session']; ?></h4>
                                            </div>
                                        </div>
                                        <?php
                                        $completeSession_rs = Database::search("SELECT COUNT(`session`.`id`) AS `complete_session` FROM `session` INNER JOIN `teacher_has_grade_has_subject` ON `session`.`teacher_grade_subject_id`=`teacher_has_grade_has_subject`.`id` WHERE `teacher_has_grade_has_subject`.`teacher_id`=?  AND `session`.`status`=?", [$_SESSION['teacher']['id'], '3'], "ss");

                                        $completeSession_data = $completeSession_rs->fetch_assoc();
                                        ?>

                                        <div class="col-6 col-md-4 p-3">
                                            <div class="row bg-success rounded rounded-3 py-3">
                                                <h3 class="text-center">Completed Sessions</h3>
                                                <h4 class="m-0 text-center"><?php echo $completeSession_data['complete_session']; ?></h4>
                                            </div>
                                        </div>

                                        <?php
                                        $pendingSession_rs = Database::search("SELECT COUNT(`session`.`id`) AS `pending_session` FROM `session` INNER JOIN `teacher_has_grade_has_subject` ON `session`.`teacher_grade_subject_id`=`teacher_has_grade_has_subject`.`id` WHERE `teacher_has_grade_has_subject`.`teacher_id`=?  AND `session`.`status`=?", [$_SESSION['teacher']['id'], '0'], "ss");

                                        $pendingSession_data = $pendingSession_rs->fetch_assoc();
                                        ?>
                                        <div class="col-6 col-md-4 p-3">
                                            <div class="row bg-info rounded rounded-3 py-3">
                                                <h3 class="text-center">Pending Sessions</h3>
                                                <h4 class="m-0 text-center"><?php echo $pendingSession_data['pending_session']; ?></h4>
                                            </div>
                                        </div>

                                        <?php
                                        $approveSession_rs = Database::search("SELECT COUNT(`session`.`id`) AS `approve_session` FROM `session` INNER JOIN `teacher_has_grade_has_subject` ON `session`.`teacher_grade_subject_id`=`teacher_has_grade_has_subject`.`id` WHERE `teacher_has_grade_has_subject`.`teacher_id`=?  AND `session`.`status`=?", [$_SESSION['teacher']['id'], '1'], "ss");

                                        $approveSession_data = $approveSession_rs->fetch_assoc();
                                        ?>
                                        <div class="col-6 col-md-4 p-3">
                                            <div class="row bg-warning rounded rounded-3 py-3">
                                                <h3 class="text-center">Approved Sessions</h3>
                                                <h4 class="m-0 text-center"><?php echo $approveSession_data['approve_session']; ?></h4>
                                            </div>
                                        </div>

                                        <?php
                                        $totalIncome_rs = Database::search("SELECT SUM(`session`.`hours`) AS `totalHours` FROM `session_payment` INNER JOIN `session` ON `session_payment`.`session_id` = `session`.`id` INNER JOIN `teacher_has_grade_has_subject` ON `session`.`teacher_grade_subject_id`=`teacher_has_grade_has_subject`.`id` WHERE `teacher_has_grade_has_subject`.`teacher_id`=?", [$_SESSION['teacher']['id']], "s");

                                        $totalIncome_data = $totalIncome_rs->fetch_assoc();

                                        $totalIncome = $totalIncome_data["totalHours"] * 1500 * (60 /100);
                                        ?>
                                        <div class="col-6 col-md-4 p-3">
                                            <div class="row bg-danger rounded rounded-3 py-3">
                                                <h3 class="text-center">Total Income</h3>
                                                <h4 class="m-0 text-center">Rs.<?php echo $totalIncome; ?></h4>
                                            </div>
                                        </div>

                                    </div>
                                </div>
                                <hr class="mt-4">
                                <div class="col-12 mt-4">
                                    <div class="row">

                                        <h3>Pending Sessions</h3>

                                        <div class="table-responsive">

                                            <table class="table table-striped table-hover mt-4">
                                                <thead>
                                                    <tr>
                                                        <th>ID</th>
                                                        <th>Student Name</th>
                                                        <th>Grade/Subject</th>
                                                        <th>Date</th>
                                                        <th>Start Time</th>
                                                        <th>Hours</th>
                                                        <th>Status</th>
                                                        <th>Action</th>
                                                    </tr>
                                                </thead>

                                                <tbody id="sSessionBody">
                                                    <?php
                                                    $session_rs = Database::search("SELECT `session`.`id` AS `id`,`student`.`fname` AS `fname`,`student`.`lname` AS `lname`, `grade`.`name` AS `grade`, `subject`.`name` AS `subject`, `session`.`session_date` AS `session_date`, `session`.`start_time` AS `start_time`, `session`.`hours` AS `hours`, `session`.`status` AS `status`,`session_type`.`name` AS `session_type`,`session`.`path` AS `path`,`session`.`note` AS `note` FROM `session` INNER JOIN `teacher_has_grade_has_subject` ON `session`.`teacher_grade_subject_id`=`teacher_has_grade_has_subject`.`id` INNER JOIN `student` ON `session`.`student_id`=`student`.`id` INNER JOIN `subject` ON `teacher_has_grade_has_subject`.`subject_id`=`subject`.`id` INNER JOIN `grade` ON `teacher_has_grade_has_subject`.`grade_id`=`grade`.`id` INNER JOIN `session_type` ON `session`.`session_type_id`=`session_type`.`id` WHERE `teacher_has_grade_has_subject`.`teacher_id`=? AND `session`.`status`=?", [$_SESSION['teacher']['id'], '0'], "ss");

                                                    $session_num = $session_rs->num_rows;

                                                    if($session_num>0){
                                                      

                                                    for ($i = 0; $i < $session_num; $i++) {
                                                        $session_data = $session_rs->fetch_assoc();
                                                    ?>
                                                        <tr>
                                                            <td><?php echo $session_data['id']; ?></td>
                                                            <td><?php echo $session_data['fname'] . " " . $session_data['lname']; ?></td>
                                                            <td><?php echo $session_data['grade'] . " - " . $session_data['subject']; ?></td>
                                                            <td><?php echo $session_data['session_date']; ?></td>
                                                            <td><?php echo $session_data['start_time']; ?></td>
                                                            <td><?php echo $session_data['hours']; ?></td>
                                                            <td><?php

                                                                if ($session_data["status"] == "0") {
                                                                    echo "Pending...";
                                                                } else if ($session_data["status"] == "1") {
                                                                    echo "Approved";
                                                                } else if ($session_data["status"] == "2") {
                                                                    echo "Rejected";
                                                                } else if ($session_data["status"] == "3") {
                                                                    echo "Completed";
                                                                }
                                                                ?></td>
                                                            <td><button class="btn btn-info" data-bs-toggle="modal" data-bs-target="#createSessionModel<?php echo $session_data['id']; ?>">More</button></td>

                                                            <!-- MODEL -->
                                                            <div class="modal fade" id="createSessionModel<?php echo $session_data['id']; ?>" tabindex="-1" aria-labelledby="createSessionModelLabel" aria-hidden="true">
                                                                <div class="modal-dialog modal-dialog-centered modal-dialog-scrollable modal-lg">
                                                                    <div class="modal-content">
                                                                        <div class="modal-header">
                                                                            <h1 class="modal-title fs-5" id="createSessionModelLabel">Schedule Class Details</h1>
                                                                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                                                        </div>
                                                                        <div class="modal-body">
                                                                            <div class="col-12">
                                                                                <div class="row">
                                                                                    <label class="d-none" id="teacherId"><?php echo $session_data['id']; ?></label>
                                                                                    <h2><?php echo $session_data['fname'] . " " . $session_data['lname']; ?></h2>
                                                                                    <?php
                                                                                    if ($session_data["status"] == "0") {
                                                                                    ?>
                                                                                        <div class="offset-md-3 my-3 col-md-6 bg-warning">
                                                                                            <h2 class="text-center">Pending..</h2>
                                                                                        </div>
                                                                                    <?php
                                                                                    } else if ($session_data["status"] == "1") {
                                                                                    ?>
                                                                                        <div class="offset-md-3 my-3 col-md-6 bg-success">
                                                                                            <h2 class="text-center">Approved</h2>
                                                                                        </div>
                                                                                    <?php
                                                                                    } else if ($session_data["status"] == "2") {
                                                                                    ?>
                                                                                        <div class="offset-md-3 my-3 col-md-6 bg-danger">
                                                                                            <h2 class="text-center">Rejected</h2>
                                                                                        </div>
                                                                                    <?php
                                                                                    } else if ($session_data["status"] == "3") {
                                                                                    ?>
                                                                                        <div class="offset-md-3 my-3 col-md-6 bg-secondary">
                                                                                            <h2 class="text-center">Completed</h2>
                                                                                        </div>
                                                                                    <?php
                                                                                    }
                                                                                    ?>
                                                                                    <div class="col-md-6">
                                                                                        <label for="">Class</label>
                                                                                        <input class="form-control" type="text" value="<?php echo $session_data['grade'] . " - " . $session_data['subject']; ?>" disabled />
                                                                                    </div>
                                                                                    <div class="col-md-6">
                                                                                        <label for="">Date</label>
                                                                                        <input class="form-control" type="date" value="<?php echo $session_data['session_date']; ?>" disabled />
                                                                                    </div>
                                                                                    <div class="col-md-6">
                                                                                        <label for="">Start Time</label>
                                                                                        <input class="form-control" type="time" value="<?php echo $session_data['start_time']; ?>" disabled />
                                                                                    </div>
                                                                                    <div class="col-md-6">
                                                                                        <label for="">Hours</label>
                                                                                        <input class="form-control" type="number" value="<?php echo $session_data['hours']; ?>" disabled />
                                                                                    </div>
                                                                                    <div class="col-md-6">
                                                                                        <label for="">Session Type</label>
                                                                                        <input class="form-control" type="text" value="<?php echo $session_data['session_type']; ?>" disabled />
                                                                                    </div>
                                                                                    <div class="col-md-6 mt-4">
                                                                                        <h3>Total:Rs. <?php echo $session_data['hours'] * 1500 * (60/100); ?></h3>
                                                                                    </div>

                                                                                    <?php
                                                                                    if ($session_data["status"] == "0") {
                                                                                    ?>
                                                                                        <div class="col-12">
                                                                                            <label for="">Location / Link</label>
                                                                                            <input class="form-control" type="text" id="sPath<?php echo $session_data['id']; ?>" />
                                                                                        </div>
                                                                                        <div class="col-12">
                                                                                            <label for="">Note (optional)</label>
                                                                                            <textarea class="form-control" id="sNote<?php echo $session_data['id']; ?>"></textarea>
                                                                                        </div>
                                                                                    <?php
                                                                                    } else {
                                                                                    ?>
                                                                                        <div class="col-12">
                                                                                            <label for="">Location / Link</label>
                                                                                            <input class="form-control" type="text" value="<?php echo isset($session_data['path']) ? $session_data['path'] : 'not updated'; ?>" disabled />
                                                                                        </div>
                                                                                        <div class="col-12 mb-3">
                                                                                            <label for="">Note (optional)</label>
                                                                                            <textarea class="form-control" disabled><?php echo isset($session_data['note']) ? $session_data['note'] : 'not updated'; ?></textarea>
                                                                                        </div>
                                                                                        <hr>
                                                                                        <h4>Session Payment</h4>
                                                                                        <?php
                                                                                        $sessionPayment_rs = Database::search("SELECT * FROM `session_payment` WHERE `session_id`=?", [$session_data['id']], "s");
                                                                                        $sessionPayment_num = $sessionPayment_rs->num_rows;
                                                                                        if ($sessionPayment_num > 0) {
                                                                                        ?>
                                                                                            <div class="offset-md-3 my-3 col-md-6 bg-success">
                                                                                                <h2 class="text-center">Paid</h2>
                                                                                            </div>
                                                                                        <?php
                                                                                        } else {
                                                                                        ?>
                                                                                            <div class="offset-md-3 my-3 col-md-6 bg-warning">
                                                                                                <h2 class="text-center">Didn't pay yet</h2>
                                                                                            </div>
                                                                                        <?php
                                                                                        }
                                                                                        ?>
                                                                                    <?php
                                                                                    }

                                                                                    ?>
                                                                                </div>
                                                                            </div>
                                                                        </div>
                                                                        <div class="modal-footer">
                                                                            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                                                                            <?php
                                                                            if ($session_data["status"] == "0") {
                                                                            ?>
                                                                                <button type="button" class="btn btn-primary" onclick="appeoveSession(<?php echo $session_data['id']; ?>);">Approve Session</button>
                                                                                <button type="button" class="btn btn-danger" onclick="rejectSession(<?php echo $session_data['id']; ?>);">Reject Session</button>

                                                                            <?php
                                                                            } else {
                                                                            ?>
                                                                                <button type="button" class="btn btn-primary" onclick="CompleteSession(<?php echo $session_data['id']; ?>);">Completed Session</button>

                                                                            <?php
                                                                            }
                                                                            ?>
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                            <!-- MODEL -->

                                                        </tr>
                                                    <?php
                                                    }
                                                      
                                                }else{
                                                    ?>
                                                    <tr>
                                                        <td class="text-center text-danger" colspan="8">
                                                            No Pending Sessions
                                                        </td>
                                                    </tr>
                                                    <?php
                                                }
                                                    ?>
                                                </tbody>

                                            </table>

                                        </div>

                                    </div>
                                </div>


                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <script src="../js/bootstrap.bundle.js"></script>
        <script src="../js/bootstrap.js"></script>
        <script src="js/script.js"></script>
    </body>

    </html>

<?php
} else {
    header("Location: login.php");
}
?>