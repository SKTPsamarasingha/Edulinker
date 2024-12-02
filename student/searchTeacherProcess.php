<?php
session_start();

require "../connection.php";

if (isset($_SESSION['student'])) {

    $sname = $_POST['sname'];
    $sgrade = $_POST['sgrade'];
    $ssubject = $_POST['ssubject'];

    $sNameLike = "%" . $sname . "%";

    $sParams = array();
    $sParams[] = $sNameLike;
    $sParams[] = $sNameLike;
    $sParams[] = "1";
    $sParamTypes = "sss";

    $query = "SELECT DISTINCT(`teacher`.`id`) FROM `teacher` INNER JOIN `teacher_has_grade_has_subject` ON `teacher`.`id`=`teacher_has_grade_has_subject`.`teacher_id` WHERE (`teacher`.`fname` LIKE ? OR `teacher`.`lname` LIKE ?) AND `teacher`.`status`=? ";

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

    $searchTeacher_rs = Database::search($query, $sParams, $sParamTypes);
    $searchTeacher_num = $searchTeacher_rs->num_rows;

    for ($k = 0; $k < $searchTeacher_num; $k++) {
        $searchTeacher_data = $searchTeacher_rs->fetch_assoc();
        $teacher_id = $searchTeacher_data['id'];

        $teacher_rs = Database::search("SELECT * FROM `teacher` WHERE `id`=?", [$teacher_id], "s");
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
                                            <textarea class="form-control" disabled><?php echo $teacher_data['qulification']; ?></textarea>
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
                                                for ($n = 0; $n < $sessionType_num; $n++) {
                                                    $sessionType_data = $sessionType_rs->fetch_assoc();
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
    }
} else {
    echo 'login';
}
