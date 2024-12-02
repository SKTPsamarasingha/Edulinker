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

                                <h1 class="text-decoration-underline">Dashboard</h1>

                                <div>
                                    <p class="bg-body">Dashboard / <span>Home</span></p>
                                </div>

                                <div class="col-12">
                                    <div class="row">

                                        <?php
                                        $totalSession_rs = Database::search("SELECT COUNT(`id`) AS `totalSessions` FROM `session`");
                                        $totalSession_data = $totalSession_rs->fetch_assoc();
                                        ?>

                                        <div class="col-6 col-md-4 p-3">
                                            <div class="row bg-primary rounded rounded-3 py-3">
                                                <h3 class="text-center">Total Sessions</h3>
                                                <h4 class="m-0 text-center"><?php echo $totalSession_data['totalSessions']; ?></h4>
                                            </div>
                                        </div>

                                        <?php
                                        $completeSession_rs = Database::search("SELECT COUNT(`id`) AS `complete_session` FROM `session` WHERE `status`=?", ['3'], "s");
                                        $completeSession_data = $completeSession_rs->fetch_assoc();
                                        ?>
                                        <div class="col-6 col-md-4 p-3">
                                            <div class="row bg-success rounded rounded-3 py-3">
                                                <h3 class="text-center">Completed Sessions</h3>
                                                <h4 class="m-0 text-center"><?php echo $completeSession_data['complete_session']; ?></h4>
                                            </div>
                                        </div>
                                        <?php
                                        $pendingSession_rs = Database::search("SELECT COUNT(`id`) AS `pending_session` FROM `session` WHERE `status`=?", ['0'], "s");
                                        $pendingSession_data = $pendingSession_rs->fetch_assoc();
                                        ?>
                                        <div class="col-6 col-md-4 p-3">
                                            <div class="row bg-info rounded rounded-3 py-3">
                                                <h3 class="text-center">Pending Sessions</h3>
                                                <h4 class="m-0 text-center"><?php echo $pendingSession_data['pending_session']; ?></h4>
                                            </div>
                                        </div>
                                        <?php
                                        $approveSession_rs = Database::search("SELECT COUNT(`id`) AS `approve_session` FROM `session` WHERE `status`=?", ['1'], "s");
                                        $approveSession_data = $approveSession_rs->fetch_assoc();
                                        ?>
                                        <div class="col-6 col-md-4 p-3">
                                            <div class="row bg-warning rounded rounded-3 py-3">
                                                <h3 class="text-center">Approved Sessions</h3>
                                                <h4 class="m-0 text-center"><?php echo $approveSession_data['approve_session']; ?></h4>
                                            </div>
                                        </div>
                                        <?php
                                        $rejected_rs = Database::search("SELECT COUNT(`id`) AS `rejected_session` FROM `session` WHERE `status`=?", ['2'], "s");
                                        $rejected_data = $rejected_rs->fetch_assoc();
                                        ?>
                                        <div class="col-6 col-md-4 p-3">
                                            <div class="row bg-danger rounded rounded-3 py-3">
                                                <h3 class="text-center">Rejected Sessions</h3>
                                                <h4 class="m-0 text-center"><?php echo $rejected_data['rejected_session']; ?></h4>
                                            </div>
                                        </div>

                                        <?php
                                        $totalIncome_rs = Database::search("SELECT SUM(`session`.`hours`) AS `totalHours` FROM `session_payment` INNER JOIN `session` ON `session_payment`.`session_id` = `session`.`id`");

                                        $totalIncome_data = $totalIncome_rs->fetch_assoc();

                                        $totalIncome = $totalIncome_data["totalHours"] * 1500 * (30 /100);
                                        ?>
                                        <div class="col-6 col-md-4 p-3">
                                            <div class="row bg-secondary rounded rounded-3 py-3">
                                                <h3 class="text-center">Total Income</h3>
                                                <h4 class="m-0 text-center">Rs.<?php echo $totalIncome; ?></h4>
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