<?php
session_start();
if (isset($_SESSION["admin"])) {

    require "../connection.php";
?>
    <!DOCTYPE html>
    <html lang="en">

    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title>Sessions | Admin</title>

        <link rel="stylesheet" href="../css/bootstrap.css" />

        <style>
            .star {
                font-size: 2rem;
                color: gray;
                cursor: pointer;
            }

            .star.selected {
                color: gold;
            }
        </style>
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
                            <li class="border border-1 border-primary shadow rounded-3 p-3 mb-1 fs-4" style="cursor: pointer;" onclick="window.location = 'manage-teacher.php';"><a class="text-decoration-none text-black" href="manage-teacher.php">Manage Teachers</a></li>
                            <li class="border border-1 border-primary shadow rounded-3 p-3 mb-1 fs-4" style="cursor: pointer;" onclick="window.location = 'manage-student.php';"><a class="text-decoration-none text-black" href="manage-student.php">Manage Students</a></li>
                            <li class="border border-1 border-primary shadow rounded-3 p-3 mb-1 fs-4" style="cursor: pointer;" onclick="window.location = 'manage-sessions.php';"><a class="text-decoration-none text-black" href="manage-sessions.php">Manage Sessions</a></li>
                            <li class="border border-1 border-primary shadow rounded-3 p-3 mb-1 fs-4" style="cursor: pointer;" onclick="window.location = 'manage-subjects-grades.php';"><a class="text-decoration-none text-black" href="manage-subjects-grades.php">Subjects & Grades</a></li>
                            <li class="border border-1 border-primary shadow rounded-3 p-3 mb-1 fs-4" style="cursor: pointer;" onclick="logOut();"><a class="text-decoration-none text-black" href="#">Log Out</a></li>
                        </ul>
                    </div>
                </div>

                <div class="col-12 col-md-9">
                    <div class="row p-2">
                        <div class="col-12 border border-1 rounded bg-light">
                            <div class="row">

                                <h1 class="text-decoration-underline">Sessions</h1>

                                <div>
                                    <p class="bg-body">Dashboard / <span>sessions</span></p>
                                </div>

                                <div class="col-12 p-3">
                                    <div class="row">
                                        <h3>Search Session</h3>

                                        <div class="col-md-4">
                                            <label for="">Stauts</label>
                                            <select class="form-select" id="sstatus" onchange="searchSession();">
                                                <option value="0">SELECT</option>
                                                <option value="1">Completed</option>
                                                <option value="2">Approved</option>
                                                <option value="3">Pending</option>
                                                <option value="4">Rejected</option>
                                            </select>
                                        </div>

                                        <div class="col-md-4">
                                            <label for="">Grade</label>
                                            <select class="form-select" id="sgrade" onchange="searchSession();">
                                                <option value="0">SELECT</option>
                                                <?php
                                                $grade_rs = Database::search("SELECT * FROM `grade`");
                                                $grade_num = $grade_rs->num_rows;
                                                for ($i = 0; $i < $grade_num; $i++) {
                                                    $grade_data = $grade_rs->fetch_assoc();
                                                ?>
                                                    <option value="<?php echo $grade_data['id']; ?>"><?php echo $grade_data['name']; ?></option>
                                                <?php
                                                }
                                                ?>
                                            </select>
                                        </div>
                                        <div class="col-md-4">
                                            <label for="">Subject</label>
                                            <select class="form-select" id="ssubject" onchange="searchSession();">
                                                <option value="0">SELECT</option>
                                                <?php
                                                $subject_rs = Database::search("SELECT * FROM `subject`");
                                                $subject_num = $subject_rs->num_rows;
                                                for ($i = 0; $i < $subject_num; $i++) {
                                                    $subject_data = $subject_rs->fetch_assoc();
                                                ?>
                                                    <option value="<?php echo $subject_data['id']; ?>"><?php echo $subject_data['name']; ?></option>
                                                <?php
                                                }
                                                ?>
                                            </select>
                                        </div>
                                        <div class="col-md-4">
                                            <button class="btn btn-secondary w-100 mt-4" onclick="window.location.reload();">Clear</button>
                                        </div>

                                        <div class="table-responsive">

                                        
                                        <table class="table table-striped table-hover mt-4">
                                            <thead>
                                                <tr>
                                                    <th>ID</th>
                                                    <th>Teacher Name</th>
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
                                                $session_rs = Database::search("SELECT `session`.`id` AS `id`,`student`.`fname` AS `stufname`,`student`.`lname` AS `stulname`,`teacher`.`fname` AS `techfname`,`teacher`.`lname` AS `teachlname`, `grade`.`name` AS `grade`, `subject`.`name` AS `subject`, `session`.`session_date` AS `session_date`, `session`.`start_time` AS `start_time`, `session`.`hours` AS `hours`, `session`.`status` AS `status`,`session_type`.`name` AS `session_type`,`session`.`path` AS `path`,`session`.`note` AS `note` FROM `session` INNER JOIN `teacher_has_grade_has_subject` ON `session`.`teacher_grade_subject_id`=`teacher_has_grade_has_subject`.`id` INNER JOIN `student` ON `session`.`student_id`=`student`.`id` INNER JOIN `teacher` ON `teacher_has_grade_has_subject`.`teacher_id`=`teacher`.`id` INNER JOIN `subject` ON `teacher_has_grade_has_subject`.`subject_id`=`subject`.`id` INNER JOIN `grade` ON `teacher_has_grade_has_subject`.`grade_id`=`grade`.`id` INNER JOIN `session_type` ON `session`.`session_type_id`=`session_type`.`id`");

                                                $session_num = $session_rs->num_rows;

                                                for ($i = 0; $i < $session_num; $i++) {
                                                    $session_data = $session_rs->fetch_assoc();
                                                ?>
                                                    <tr>
                                                        <td><?php echo $session_data['id']; ?></td>
                                                        <td><?php echo $session_data['techfname'] . " " . $session_data['teachlname']; ?></td>
                                                        <td><?php echo $session_data['stufname'] . " " . $session_data['stulname']; ?></td>
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
                                                                                    <label for="">Student Name</label>
                                                                                    <input class="form-control" type="text" value="<?php echo $session_data['stufname'] . " " . $session_data['stulname']; ?>" disabled />
                                                                                </div>
                                                                                <div class="col-md-6">
                                                                                    <label for="">Teacher Name</label>
                                                                                    <input class="form-control" type="text" value="<?php echo $session_data['techfname'] . " " . $session_data['teachlname']; ?>" disabled />
                                                                                </div>
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
                                                                                    <h3>Total:Rs. <?php echo $session_data['hours'] * 1500; ?></h3>
                                                                                </div>

                                                                                
                                                                                    <div class="col-12">
                                                                                        <label for="">Location / Link</label>
                                                                                        <br>
                                                                                        <a href="<?php echo isset($session_data['path']) ? $session_data['path'] : '#'; ?>"><?php echo isset($session_data['path']) ? $session_data['path'] : 'not updated'; ?></a>
                                                                                        
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
                                                                                        $sessionPayment_data = $sessionPayment_rs->fetch_assoc();
                                                                                    ?>
                                                                                        <div class="offset-md-3 my-3 col-md-6 bg-success">
                                                                                            <h2 class="text-center">Paid</h2>
                                                                                        </div>
                                                                                        <div class="col-md-6">
                                                                                            <label for="">Card Number</label>
                                                                                            <input class="form-control" type="text" value="<?php echo $sessionPayment_data['card_no']; ?>" disabled />
                                                                                        </div>
                                                                                        <div class="col-md-6">
                                                                                            <label for="">CVV</label>
                                                                                            <input class="form-control" type="text" value="<?php echo $sessionPayment_data['cvv']; ?>" disabled />
                                                                                        </div>
                                                                                        <div class="col-md-6">
                                                                                            <label for="">Expire Date</label>
                                                                                            <input class="form-control" type="text" value="<?php echo $sessionPayment_data['exp_date']; ?>" disabled />
                                                                                        </div>
                                                                                    <?php
                                                                                    } else {
                                                                                    ?>
                                                                                        <div class="offset-md-3 my-3 col-md-6 bg-warning">
                                                                                            <h2 class="text-center">Didn't pay yet</h2>
                                                                                        </div>
                                                                                    <?php
                                                                                    }

                                                                                    if ($session_data["status"] == "3") {
                                                                                        $review_rs = Database::search("SELECT * FROM `review` WHERE `session_id`=?", [$session_data['id']], "s");
                                                                                        $review_data = $review_rs->fetch_assoc();
                                                                                        ?>
    
                                                                                        <hr class="mt-4">
                                                                                        <div class="col-12 mt-3">
                                                                                            <div class="row">
                                                                                                <h4>Review</h4>
                                                                                                <div id="star-rating-<?php echo $session_data['id']; ?>" class="d-flex">
                                                                                                    <span class="star <?php echo isset($review_data['rate']) ? ($review_data['rate'] >= 1 ? 'selected' : '') : ''; ?>" data-value="1">&#9733;</span>
                                                                                                    <span class="star <?php echo isset($review_data['rate']) ? ($review_data['rate'] >= 2 ? 'selected' : '') : ''; ?>" data-value="2">&#9733;</span>
                                                                                                    <span class="star <?php echo isset($review_data['rate']) ? ($review_data['rate'] >= 3 ? 'selected' : '') : ''; ?>" data-value="3">&#9733;</span>
                                                                                                    <span class="star <?php echo isset($review_data['rate']) ? ($review_data['rate'] >= 4 ? 'selected' : '') : ''; ?>" data-value="4">&#9733;</span>
                                                                                                    <span class="star <?php echo isset($review_data['rate']) ? ($review_data['rate'] >= 5 ? 'selected' : '') : ''; ?>" data-value="5">&#9733;</span>
                                                                                                </div>
                                                                                            </div>
                                                                                        </div>
    
                                                                                        <div class="col-12 px-4">
                                                                                            <div class="row">
                                                                                                <label>Feedback (Optional)</label>
                                                                                                <textarea class="form-control" rows="5" disabled id="feetbackTxt<?php echo $session_data['id']; ?>"><?php echo isset($review_data['feedback']) ? $review_data['feedback'] : ''; ?></textarea>
                                                                                            </div>
                                                                                        </div>
    
                                                                                    <?php
                                                                                    }
                                                                                    ?>
                                                                                
                                                                            </div>
                                                                        </div>
                                                                    </div>
                                                                    <div class="modal-footer">
                                                                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                                                                        
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </div>
                                                        <!-- MODEL -->

                                                    </tr>
                                                <?php
                                                }
                                                ?>
                                            </tbody>
                                            </div>
                                        </table>

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