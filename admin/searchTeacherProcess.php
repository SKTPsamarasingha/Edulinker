<?php
session_start();

require "../connection.php";

if (isset($_SESSION['admin'])) {

    $sname = $_POST['sname'];
    $sstatus = $_POST['sstatus'];
    $sgrade = $_POST['sgrade'];
    $ssubject = $_POST['ssubject'];

    $sNameLike = "%" . $sname . "%";

    $sParams = array();
    $sParams[] = $sNameLike;
    $sParams[] = $sNameLike;
    $sParamTypes = "ss";

    $query = "SELECT DISTINCT(`teacher`.`id`) FROM `teacher` INNER JOIN `teacher_has_grade_has_subject` ON `teacher`.`id`=`teacher_has_grade_has_subject`.`teacher_id` WHERE (`teacher`.`fname` LIKE ? OR `teacher`.`lname` LIKE ?) ";

    if (!empty($sstatus)) {
        if ($sstatus == '1') {
            $query .= " AND `teacher`.`status`=? ";
            $sParams[] = "1";
            $sParamTypes .= "s";
        } else if ($sstatus == '2') {
            $query .= " AND `teacher`.`status`=? ";
            $sParams[] = "2";
            $sParamTypes .= "s";
        } else if ($sstatus == '3') {
            $query .= " AND `teacher`.`status`=? ";
            $sParams[] = "0";
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

                <td><?php
                    if ($teacher_data['status'] == "0") {
                        echo "Pending";
                    } else if ($teacher_data['status'] == "1") {
                        echo "Active";
                    } else {
                        echo "Blocked";
                    }
                    ?></td>
                <td><?php
                    if ($teacher_data['status'] == "0") {
                    ?>
                        <button class="btn btn-primary" onclick="changeTeacherStatus(<?php echo $teacher_data['id']; ?>);">Aprove</button>
                    <?php
                    } else if ($teacher_data['status'] == "1") {
                    ?>
                        <button class="btn btn-danger" onclick="changeTeacherStatus(<?php echo $teacher_data['id']; ?>);">Block</button>
                    <?php
                    } else {
                    ?>
                        <button class="btn btn-success" onclick="changeTeacherStatus(<?php echo $teacher_data['id']; ?>);">Active</button>
                    <?php
                    }
                    ?>
                </td>
            </tr>
<?php
        }
    }
} else {
    echo 'login';
}
