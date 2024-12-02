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
        <title>Manage teachers | Admin</title>

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

                                <h1 class="text-decoration-underline">Manage Teachers</h1>

                                <div>
                                    <p class="bg-body">Dashboard / <span class="text-secondary">teachers</span></p>
                                </div>

                                <div class="col-12 p-3">
                                    <div class="row">
                                        <h3>Search teachers</h3>

                                        <div class="col-md-6">
                                            <label for="">Teacher name</label>
                                            <input class="form-control" id="sname" type="text" onkeyup="searchTeacher();" />
                                        </div>
                                        <div class="col-md-6">
                                            <label for="">Stauts</label>
                                            <select class="form-select" id="sstatus" onchange="searchTeacher();">
                                                <option value="0">SELECT</option>
                                                <option value="1">Active</option>
                                                <option value="2">Block</option>
                                                <option value="3">Pending</option>
                                            </select>
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
                                        <div class="table-responsive">
                                        <table class="table table-striped table-hover mt-4">
                                            <thead>
                                                <tr>
                                                    <th>ID</th>
                                                    <th>Name</th>
                                                    <th>Email</th>
                                                    <th>Mobile</th>
                                                    <th>Grade/Subject</th>
                                                    <th>Status</th>
                                                    <th>Action</th>
                                                </tr>
                                            </thead>
                                            <tbody id="sTeacherBody">
                                                <?php
                                                $teacher_rs = Database::search("SELECT * FROM `teacher`");
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

                                                        <td><?php 
                                                        if($teacher_data['status']=="0"){
                                                            echo "Pending";
                                                        }else if($teacher_data['status']=="1"){
                                                            echo "Active";
                                                        }else{
                                                            echo "Blocked";
                                                        }
                                                        ?></td>
                                                        <td><?php 
                                                         if($teacher_data['status']=="0"){
                                                            ?>
                                                            <button class="btn btn-primary" onclick="changeTeacherStatus(<?php echo $teacher_data['id']; ?>);">Aprove</button>
                                                            <?php
                                                        }else if($teacher_data['status']=="1"){
                                                            ?>
                                                            <button class="btn btn-danger" onclick="changeTeacherStatus(<?php echo $teacher_data['id']; ?>);">Block</button>
                                                            <?php
                                                        }else{
                                                            ?>
                                                            <button class="btn btn-success" onclick="changeTeacherStatus(<?php echo $teacher_data['id']; ?>);">Active</button>
                                                            <?php
                                                        }
                                                        ?></td>
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