<?php
session_start();
if (isset($_SESSION["teacher"])) {

    require "../connection.php";

    $teacher_rs = Database::search("SELECT * FROM `teacher` WHERE `id` = ?", [$_SESSION['teacher']['id']], "s");
    $teacher_data = $teacher_rs->fetch_assoc();
?>
    <!DOCTYPE html>
    <html lang="en">

    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title>Profile | Teacher</title>

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
                                    <p class="bg-body">Dashboard / <span class="text-secondary">profile</span></p>
                                </div>


                                <div class="col-12 p-3">
                                    <div class="row">
                                        <div class="d-flex flex-column align-items-center text-center p-3">

                                            <img id="viewimg" src="..//<?php echo $teacher_data['profile']; ?>" class="rounded " style="width: 150px;" />

                                            <input class="d-none" type="file" accept="img/*" id="profileimg" />
                                            <label class="btn btn-warning mt-5" for="profileimg" onclick="changeImage();">Select Profile Image</label>

                                        </div>
                                        <div class="col-md-6">
                                            <label for="">First name</label>
                                            <input class="form-control" id="fname" type="text" value="<?php echo $teacher_data['fname']; ?>" />
                                        </div>
                                        <div class="col-md-6">
                                            <label for="">First name</label>
                                            <input class="form-control" id="lname" type="text" value="<?php echo $teacher_data['lname']; ?>" />
                                        </div>
                                        <div class="col-md-6">
                                            <label for="">Mobile</label>
                                            <input class="form-control" id="mobile" type="text" value="<?php echo $teacher_data['mobile']; ?>" />
                                        </div>
                                        <div class="col-md-6">
                                            <label for="">Qulifications</label>
                                            <textarea class="form-control" rows="5" id="qulification"><?php echo $teacher_data['qulification']; ?></textarea>
                                        </div>
                                        <div class="col-12 my-4 text-end">
                                            <button class="btn btn-primary " onclick="updateProfile();">Update Profile</button>
                                        </div>

                                        <div class="col-12">
                                            <div class="row">

                                                <?php
                                                $review_rs = Database::search("SELECT COUNT(`review`.`id`) AS `revireCount`,SUM(`review`.`rate`) AS `reviewRate`  FROM `review` INNER JOIN `session` ON `review`.`session_id`=`session`.`id` INNER JOIN `teacher_has_grade_has_subject` ON `session`.`teacher_grade_subject_id` = `teacher_has_grade_has_subject`.`id` WHERE `teacher_has_grade_has_subject`.`teacher_id`=?", [$_SESSION['teacher']['id']], "s");
                                                
                                                $reviewRate=0;
                                                $review_data = $review_rs->fetch_assoc();
                                                $revireCount=$review_data["revireCount"];
                                                $reviewRate=$review_data["reviewRate"];

                                                if($revireCount>0){
                                                    $rate = $reviewRate / $revireCount;
                                                  }
                                                ?>

                                                <hr class="mt-4">
                                                <div class="col-12 mt-3">
                                                    <div class="row">
                                                        <h4>Review</h4>
                                                        <div id="star-rating" class="d-flex">
                                                            <span class="star <?php echo $rate>=1?'selected':''; ?>" data-value="1">&#9733;</span>
                                                            <span class="star <?php echo $rate>=2?'selected':''; ?>" data-value="2">&#9733;</span>
                                                            <span class="star <?php echo $rate>=3?'selected':''; ?>" data-value="3">&#9733;</span>
                                                            <span class="star <?php echo $rate>=4?'selected':''; ?>" data-value="4">&#9733;</span>
                                                            <span class="star <?php echo $rate>=5?'selected':''; ?>" data-value="5">&#9733;</span>
                                                        </div>
                                                        <span><?php echo $reviewRate; ?> stars</span>
                                                    </div>
                                                </div>

                                                <?php
                                                ?>

                                            </div>
                                        </div>

                                        <hr class="mt-4">

                                        <div class="col-md-4 ">
                                            <label for="">Grade</label>
                                            <select class="form-select" id="grade">
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
                                            <select class="form-select" id="subject">
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
                                            <button class="btn btn-primary w-100 mt-4" onclick="addCladdForTeacher();">Add Class</button>
                                        </div>
                                    </div>
                                </div>
                                <hr class="mt-3">
                                <div class="col-12 mt-4">
                                    <div class="row">
                                        <h3>My Classess</h3>
                                        <table class="table table-striped table-hover">
                                            <thead>
                                                <tr>
                                                    <th>ID</th>
                                                    <th>Grade</th>
                                                    <th>Subject</th>
                                                    <th>Action</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                <?php
                                                $tgs_rs = Database::search("SELECT `teacher_has_grade_has_subject`.`id` AS `id`,`grade`.`name` AS `grade`,`subject`.`name` AS `subject` FROM `teacher_has_grade_has_subject` INNER JOIN `grade` ON `teacher_has_grade_has_subject`.`grade_id`=`grade`.`id` INNER JOIN `subject` ON `teacher_has_grade_has_subject`.`subject_id`=`subject`.`id` WHERE `teacher_id`=?", [$_SESSION['teacher']['id']], "s");
                                                $tgs_num = $tgs_rs->num_rows;
                                                for ($i = 0; $i < $tgs_num; $i++) {
                                                    $tgs_data = $tgs_rs->fetch_assoc();
                                                ?>
                                                    <tr>
                                                        <td><?php echo $tgs_data['id']; ?></td>
                                                        <td><?php echo $tgs_data['grade']; ?></td>
                                                        <td><?php echo $tgs_data['subject']; ?></td>
                                                        <td><button class="btn btn-danger" onclick="removeTeacherClass(<?php echo $tgs_data['id']; ?>);">Remove</button></td>
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