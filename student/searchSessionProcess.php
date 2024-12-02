<?php 
session_start();
require "../connection.php";

if (isset($_SESSION['student'])) {

    $sname = $_POST['sname'];
    $sstatus = $_POST['sstatus'];
    $sgrade = $_POST['sgrade'];
    $ssubject = $_POST['ssubject'];

    $sNameLike = "%" . $sname . "%";
    $student_id = $_SESSION['student']['id'];

    $sParams = array();
    $sParams[] = $student_id;
    $sParams[] = $sNameLike;
    $sParams[] = $sNameLike;
    $sParamTypes = "sss";

    $query="SELECT `session`.`id` AS `id` FROM `session` INNER JOIN `teacher_has_grade_has_subject` ON `session`.`teacher_grade_subject_id`=`teacher_has_grade_has_subject`.`id` INNER JOIN `teacher` ON `teacher_has_grade_has_subject`.`teacher_id`=`teacher`.`id` INNER JOIN `subject` ON `teacher_has_grade_has_subject`.`subject_id`=`subject`.`id` INNER JOIN `grade` ON `teacher_has_grade_has_subject`.`grade_id`=`grade`.`id` WHERE `session`.student_id=? AND (`teacher`.`fname` LIKE ? OR `teacher`.`lname` LIKE ?) ";

    if (!empty($sstatus)) {
        if ($sstatus == '1') {
            $query .= " AND `session`.`status`=? ";
            $sParams[] = "3";
            $sParamTypes .= "s";
        } else if ($sstatus == '2') {
            $query .= " AND `session`.`status`=? ";
            $sParams[] = "1";
            $sParamTypes .= "s";
        } else if ($sstatus == '3') {
            $query .= " AND `session`.`status`=? ";
            $sParams[] = "0";
            $sParamTypes .= "s";
        }else if ($sstatus == '4') {
            $query .= " AND `session`.`status`=? ";
            $sParams[] = "2";
            $sParamTypes .= "s";
        }
    }

    if (!empty($sgrade)) {
        $query .= " AND `teacher_has_grade_has_subject`.`grade_id`=? ";
        $sParams[] = $sgrade;
        $sParamTypes .= "s";
    }
    if (!empty($ssubject)) {
        $query .= " AND `teacher_has_grade_has_subject`.`subject_id`=? ";
        $sParams[] = $ssubject;
        $sParamTypes .= "s";
    }

    $searchSession_rs = Database::search($query, $sParams, $sParamTypes);
    $searchSession_num = $searchSession_rs->num_rows;

    for ($k = 0; $k < $searchSession_num; $k++) {
        $searchSession_data = $searchSession_rs->fetch_assoc();
        $sessionId = $searchSession_data['id'];

        $session_rs = Database::search("SELECT `session`.`id` AS `id`,`teacher`.`fname` AS `fname`,`teacher`.`lname` AS `lname`, `grade`.`name` AS `grade`, `subject`.`name` AS `subject`, `session`.`session_date` AS `session_date`, `session`.`start_time` AS `start_time`, `session`.`hours` AS `hours`, `session`.`status` AS `status`,`session_type`.`name` AS `session_type`,`session`.`path` AS `path`,`session`.`note` AS `note` FROM `session` INNER JOIN `teacher_has_grade_has_subject` ON `session`.`teacher_grade_subject_id`=`teacher_has_grade_has_subject`.`id` INNER JOIN `teacher` ON `teacher_has_grade_has_subject`.`teacher_id`=`teacher`.`id` INNER JOIN `subject` ON `teacher_has_grade_has_subject`.`subject_id`=`subject`.`id` INNER JOIN `grade` ON `teacher_has_grade_has_subject`.`grade_id`=`grade`.`id` INNER JOIN `session_type` ON `session`.`session_type_id`=`session_type`.`id` WHERE `session`.id=? ORDER BY `session`.`session_date` DESC", [$sessionId], "s");

        $session_num = $session_rs->num_rows;

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
                    } else if ($session_data["status"] == "2"){
                        echo "Rejected";
                    }else if ($session_data["status"] == "3"){
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
                                        } else if ($session_data["status"] == "2"){
                                        ?>
                                            <div class="offset-md-3 my-3 col-md-6 bg-danger">
                                                <h2 class="text-center">Rejected</h2>
                                            </div>
                                        <?php
                                        }else if ($session_data["status"] == "3"){
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
                                            <h3>Total:Rs. <?php echo $session_data['hours'] * 1500; ?></h3>
                                        </div>

                                        <p>Rs. 1500 will be charged for one hour of class. Payment can be made after the teacher does the approve</p>
                                        <?php
                                        if ($session_data["status"] == "1") {
                                        ?>
                                            <div class="col-12">
                                                <label for="">Location / Link</label>
                                                <input class="form-control" type="text" value="<?php echo isset($session_data['path']) ? $session_data['path'] : 'not updated'; ?>" disabled />
                                            </div>
                                            <div class="col-12">
                                                <label for="">Note</label>
                                                <textarea class="form-control" disabled><?php echo isset($session_data['note']) ? $session_data['note'] : 'not updated'; ?></textarea>
                                            </div>
                                            <hr>
                                            <h4>Session Payment</h4>
                                            <div class="col-md-6">
                                                <label for="">Card Number</label>
                                                <input class="form-control" type="text" id="cardNo" />
                                            </div>
                                            <div class="col-md-6">
                                                <label for="">CVV</label>
                                                <input class="form-control" type="text" id="cardCvv" />
                                            </div>
                                            <div class="col-md-6">
                                                <label for="">Expire Date</label>
                                                <input class="form-control" type="text" id="cardExDate" />
                                            </div>
                                        <?php
                                        }

                                        ?>
                                    </div>
                                </div>
                            </div>
                            <div class="modal-footer">
                                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                                <?php 
                                if ($session_data["status"] == "1") {
                                    ?>
                                    <button type="button" class="btn btn-primary">Schedule Session</button>
                                
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

    }

} else {
    echo 'login';
}
?>