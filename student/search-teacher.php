<?php
session_start();
if (isset($_SESSION["student"])) {

    require "../connection.php";
?>
    <!DOCTYPE html>
    <html lang="en">

    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title>Teachers | Student</title>

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
                        <li class="border border-1 border-primary shadow rounded-3 p-3 mb-1 fs-4" style="cursor: pointer;" onclick="window.location = 'search-teacher.php';"><a class="text-decoration-none text-black" href="search-teacher.php">Create Sessions</a></li>
                        <li class="border border-1 border-primary shadow rounded-3 p-3 mb-1 fs-4" style="cursor: pointer;" onclick="window.location = 'my-sessions.php';"><a class="text-decoration-none text-black" href="my-sessions.php">My Sessions</a></li>
                        <li class="border border-1 border-primary shadow rounded-3 p-3 mb-1 fs-4" style="cursor: pointer;" onclick="logOut();"><a class="text-decoration-none text-black" href="#">Log Out</a></li>
                    </ul>
                    </div>
                </div>

                <div class="col-12 col-md-9">
                    <div class="row p-2">
                        <div class="col-12 border border-1 rounded bg-light">
                            <div class="row">

                                <h1 class="text-decoration-underline">Create Session</h1>

                                <div>
                                    <p class="bg-body">Dashboard / <span>create session</span></p>
                                </div>

                                <div class="col-12 p-3">
                                    <div class="row">
                                        <h3>Search teachers</h3>

                                        <div class="col-md-4">
                                            <label for="">Teacher name</label>
                                            <input class="form-control" id="sname" type="text" onkeyup="searchTeacher();" />
                                        </div>

                                        <div class="col-md-4">
                                            <label for="">Grade</label>
                                            <select class="form-select" id="sgrade" onchange="searchTeacher();">
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
                                            <select class="form-select" id="ssubject" onchange="searchTeacher();">
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

                                        <table class="table table-striped table-hover mt-4">
                                            <thead>
                                                <tr>
                                                    <th>ID</th>
                                                    <th>Name</th>
                                                    <th>Email</th>
                                                    <th>Mobile</th>
                                                    <th>Grade/Subject</th>
                                                    <th>Action</th>
                                                </tr>
                                            </thead>
                                            <tbody id="sTeacherBody">
                                                <?php
                                                $teacher_rs = Database::search("SELECT * FROM `teacher` WHERE `status`='1'");
                                                $teacher_num = $teacher_rs->num_rows;
                                                for ($i = 0; $i < $teacher_num; $i++) {
                                                    $teacher_data = $teacher_rs->fetch_assoc();

                                                ?>
                                                    <tr>
                                                        <td><?php echo $teacher_data['id']; ?></td>
                                                        <td><?php echo $teacher_data['fname'] . " " . $teacher_data['lname']; ?></td>
                                                        <td><?php echo $teacher_data['email']; ?></td>
                                                        <td><?php echo $teacher_data['mobile']; ?></td>
                                                        <td>
                                                            <ul>
                                                                <?php
                                                                $tgs_rs = Database::search("SELECT `teacher_has_grade_has_subject`.`id` AS `id`,`grade`.`name` AS `grade`,`subject`.`name` AS `subject` FROM `teacher_has_grade_has_subject` INNER JOIN `grade` ON `teacher_has_grade_has_subject`.`grade_id`=`grade`.`id` INNER JOIN `subject` ON `teacher_has_grade_has_subject`.`subject_id`=`subject`.`id` WHERE `teacher_id`=?", [$teacher_data['id']], "s");
                                                                $tgs_num = $tgs_rs->num_rows;
                                                                for ($j = 0; $j < $tgs_num; $j++) {
                                                                    $tgs_data = $tgs_rs->fetch_assoc();
                                                                ?>
                                                                    <li><?php echo $tgs_data['grade'] . " - " . $tgs_data['subject'] ?></li>
                                                                <?php
                                                                }
                                                                ?>
                                                            </ul>
                                                        </td>

                                                        <td>

                                                            <button class="btn btn-info" data-bs-toggle="modal" data-bs-target="#createSessionModel<?php echo $teacher_data['id']; ?>">Schedule A Class</button>

                                                        </td>
                                                        <!-- MODEL -->
                                                        <div class="modal fade" id="createSessionModel<?php echo $teacher_data['id']; ?>" tabindex="-1" aria-labelledby="createSessionModelLabel" aria-hidden="true">
                                                            <div class="modal-dialog modal-dialog-centered modal-dialog-scrollable modal-lg">
                                                                <div class="modal-content">
                                                                    <div class="modal-header">
                                                                        <h1 class="modal-title fs-5" id="createSessionModelLabel">Schedule Class</h1>
                                                                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                                                    </div>
                                                                    <div class="modal-body">
                                                                        <div class="col-12">
                                                                            <div class="row">
                                                                                <label class="d-none" id="teacherId"><?php echo $teacher_data['id']; ?></label>
                                                                                <h2><?php echo $teacher_data['fname'] . " " . $teacher_data['lname']; ?></h2>

                                                                                <div class="col-12 mb-3">
                                                                                <label for="">Qulifications</label>
                                                                                    <textarea  class="form-control" disabled><?php echo $teacher_data['qulification']; ?></textarea>
                                                                                </div>
                                                                                

                                                                                <div class="col-12">
                                                                                    <label for="">Select Class</label>
                                                                                    <select class="form-select mb-3" id="classId<?php echo $teacher_data['id']; ?>">
                                                                                        <option value="0">Select</option>
                                                                                        <?php
                                                                                        $tgs_rs = Database::search("SELECT `teacher_has_grade_has_subject`.`id` AS `id`,`grade`.`name` AS `grade`,`subject`.`name` AS `subject` FROM `teacher_has_grade_has_subject` INNER JOIN `grade` ON `teacher_has_grade_has_subject`.`grade_id`=`grade`.`id` INNER JOIN `subject` ON `teacher_has_grade_has_subject`.`subject_id`=`subject`.`id` WHERE `teacher_id`=?", [$teacher_data['id']], "s");
                                                                                        $tgs_num = $tgs_rs->num_rows;
                                                                                        for ($m = 0; $m < $tgs_num; $m++) {
                                                                                            $tgs_data = $tgs_rs->fetch_assoc();
                                                                                        ?>
                                                                                            <option value="<?php echo $tgs_data['id']; ?>"><?php echo $tgs_data['grade'] . " - " . $tgs_data['subject'] ?></option>
                                                                                        <?php
                                                                                        }
                                                                                        ?>
                                                                                    </select>
                                                                                </div>

                                                                                <div class="col-md-6">
                                                                                    <label for="">Date</label>
                                                                                    <input class="form-control" type="date" id="date<?php echo $teacher_data['id']; ?>" />
                                                                                </div>
                                                                                <div class="col-md-6">
                                                                                    <label for="">Start Time</label>
                                                                                    <input class="form-control" type="time" id="startTime<?php echo $teacher_data['id']; ?>" />
                                                                                </div>
                                                                                <div class="col-md-6">
                                                                                    <label for="">Hours</label>
                                                                                    <input class="form-control" type="number" id="hours<?php echo $teacher_data['id']; ?>" min="1" onkeyup="calToalFee(<?php echo $teacher_data['id']; ?>);" />
                                                                                </div>
                                                                                <div class="col-md-6 mt-4">
                                                                                    <h3>Total:Rs. <span id="total<?php echo $teacher_data['id']; ?>"></span></h3>
                                                                                </div>

                                                                                <p>Rs. 1500 will be charged for one hour of class. Payment can be made after the teacher does the approve</p>
                                                                                <div class="col-md-6">
                                                                                    <label for="">Session Type</label>
                                                                                    <select class="form-select" id="sessionType<?php echo $teacher_data['id']; ?>">
                                                                                        <option value="0">Select</option>
                                                                                        <?php 
                                                                                        $sessionType_rs = Database::search('SELECT * FROM `session_type`');
                                                                                        $sessionType_num = $sessionType_rs->num_rows;
                                                                                        for ($n=0; $n < $sessionType_num; $n++) { 
                                                                                            $sessionType_data=$sessionType_rs->fetch_assoc();
                                                                                            ?>
                                                                                            <option value="<?php echo $sessionType_data['id']; ?>"><?php echo $sessionType_data['name']; ?></option>
                                                                                            <?php
                                                                                        }
                                                                                        ?>
                                                                                    </select>
                                                                                </div>
                                                                                
                                                                            </div>
                                                                        </div>
                                                                    </div>
                                                                    <div class="modal-footer">
                                                                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                                                                        <button type="button" class="btn btn-primary" onclick="scheduleSession(<?php echo $teacher_data['id']; ?>);">Schedule Session</button>
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