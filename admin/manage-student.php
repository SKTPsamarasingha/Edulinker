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
        <title>Manage student | Admin</title>

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

                                <h1 class="text-decoration-underline">Manage Students</h1>

                                <div>
                                    <p class="bg-body">Dashboard / <span class="text-secondary">student</span></p>
                                </div>

                                <div class="col-12 p-3">
                                    <div class="row">
                                        <h3>Search student</h3>

                                        <div class="col-md-6">
                                            <label for="">Student name</label>
                                            <input class="form-control" id="sname" type="text" onkeyup="searchStudent();" />
                                        </div>
                                        <div class="col-md-6">
                                            <label for="">Stauts</label>
                                            <select class="form-select" id="sstatus" onchange="searchStudent();">
                                                <option value="0">SELECT</option>
                                                <option value="1">Active</option>
                                                <option value="2">Block</option>
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
                                                    <th>Status</th>
                                                    <th>Action</th>
                                                </tr>
                                            </thead>
                                            <tbody id="sStudentBody">
                                                <?php
                                                $student_rs = Database::search("SELECT * FROM `student`");
                                                $student_num = $student_rs->num_rows;
                                                for ($i = 0; $i < $student_num; $i++) {
                                                    $student_data = $student_rs->fetch_assoc();

                                                ?>
                                                    <tr>
                                                        <td><?php echo $student_data['id']; ?></td>
                                                        <td><?php echo $student_data['fname'] . " " . $student_data['lname']; ?></td>
                                                        <td><?php echo $student_data['email']; ?></td>
                                                        <td><?php 
                                                        if($student_data['status']=="1"){
                                                            echo "Active";
                                                        }else{
                                                            echo "Blocked";
                                                        }
                                                        ?></td>
                                                        <td><?php 
                                                        if($student_data['status']=="1"){
                                                            ?>
                                                            <button class="btn btn-danger" onclick="changeStudentStatus(<?php echo $student_data['id']; ?>);">Block</button>
                                                            <?php
                                                        }else{
                                                            ?>
                                                            <button class="btn btn-success" onclick="changeStudentStatus(<?php echo $student_data['id']; ?>);">Active</button>
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