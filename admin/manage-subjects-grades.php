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
        <title>Dashboard | Admin</title>

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

                                <h1 class="text-decoration-underline">Manage Subjects & Grades</h1>

                                <div>
                                    <p class="bg-body">dashboard / <span>manage subjects & grades</span></p>
                                </div>

                                <div class="col-12 col-md-6 p-3">
                                    <div class="row">

                                        <div class="col-12 border p-3 rounded shadow">
                                            <div class="row">
                                                <h3>Add New Subject</h3>
                                                <div>
                                                    <input class="form-control mb-3" placeholder="Subject Name" type="text" id="subject" />
                                                    <button class="btn btn-primary" onclick="saveSubject();">Save Subject</button>

                                                </div>
                                            </div>
                                        </div>

                                    </div>
                                </div>

                                <div class="col-12 col-md-6 p-3">
                                    <div class="row">

                                        <div class="col-12 border p-3 rounded shadow">
                                            <div class="row">
                                                <h3>Add New Grade</h3>
                                                <div>
                                                    <input class="form-control mb-3" placeholder="Grade  eg:(Grade 07)" type="text" id="grade" />
                                                    <button class="btn btn-primary" onclick="saveGrade();">Save Grade</button>

                                                </div>
                                            </div>
                                        </div>

                                    </div>
                                </div>

                                <div class="col-12 col-md-6 p-3">
                                    <div class="row">

                                        <div class="col-12 border p-3 rounded shadow">
                                            <div class="row">
                                                <h3>Subjects</h3>
                                                <div class="table-responsive">
                                                    <table class="table table-striped table-hover">
                                                        <thead>
                                                            <tr>
                                                                <th>ID</th>
                                                                <th>Name</th>
                                                                <!-- <th>Action</th> -->
                                                            </tr>
                                                        </thead>
                                                        <tbody>
                                                            <?php
                                                            $subject_rs = Database::search("SELECT * FROM `subject`");
                                                            $subject_num = $subject_rs->num_rows;
                                                            for ($i = 0; $i < $subject_num; $i++) {
                                                                $subject_data = $subject_rs->fetch_assoc();
                                                            ?>
                                                                <tr>
                                                                    <td><?php echo $subject_data['id']; ?></td>
                                                                    <td><?php echo $subject_data['name']; ?></td>
                                                                    <!-- <td><button class="btn btn-danger">Remove</button></td> -->
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

                                <div class="col-12 col-md-6 p-3">
                                    <div class="row">

                                        <div class="col-12 border p-3 rounded shadow">
                                            <div class="row">
                                                <h3>Grades</h3>
                                                <div class="table-responsive">
                                                    <table class="table table-striped table-hover">
                                                        <thead>
                                                            <tr>
                                                                <th>ID</th>
                                                                <th>Name</th>
                                                                <!-- <th>Action</th> -->
                                                            </tr>
                                                        </thead>
                                                        <tbody>
                                                            <?php
                                                            $grade_rs = Database::search("SELECT * FROM `grade`");
                                                            $grade_num = $grade_rs->num_rows;
                                                            for ($i = 0; $i < $grade_num; $i++) {
                                                                $grade_data = $grade_rs->fetch_assoc();
                                                            ?>
                                                                <tr>
                                                                    <td><?php echo $grade_data['id']; ?></td>
                                                                    <td><?php echo $grade_data['name']; ?></td>
                                                                    <!-- <td><button class="btn btn-danger">Remove</button></td> -->
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