<?php
session_start();

require "../connection.php";

if (isset($_SESSION['admin'])) {

    $sname = $_POST['sname'];
    $sstatus = $_POST['sstatus'];

    $sNameLike = "%" . $sname . "%";

    $sParams = array();
    $sParams[] = $sNameLike;
    $sParams[] = $sNameLike;
    $sParamTypes = "ss";

    $query = "SELECT * FROM `student` WHERE (`fname` LIKE ? OR `lname` LIKE ?) ";

    if (!empty($sstatus)) {
        if ($sstatus == "1") {
            $query .= " AND `status`=? ";
            $sParams[] = "1";
            $sParamTypes .= "s";
        } else if ($sstatus == "2") {
            $query .= " AND `status`=? ";
            $sParams[] = "2";
            $sParamTypes .= "s";
        }
    }

    $student_rs = Database::search($query, $sParams, $sParamTypes);
    $student_num = $student_rs->num_rows;
    for ($i = 0; $i < $student_num; $i++) {
        $student_data = $student_rs->fetch_assoc();

?>
        <tr>
            <td><?php echo $student_data['id']; ?></td>
            <td><?php echo $student_data['fname'] . " " . $student_data['lname']; ?></td>
            <td><?php echo $student_data['email']; ?></td>
            <td><?php
                if ($student_data['status'] == "1") {
                    echo "Active";
                } else {
                    echo "Blocked";
                }
                ?></td>
            <td><?php
                if ($student_data['status'] == "1") {
                ?>
                    <button class="btn btn-danger" onclick="changeStudentStatus(<?php echo $student_data['id']; ?>);">Block</button>
                <?php
                } else {
                ?>
                    <button class="btn btn-success" onclick="changeStudentStatus(<?php echo $student_data['id']; ?>);">Active</button>
                <?php
                }
                ?>
            </td>
        </tr>
<?php
    }
} else {
    echo 'login';
}
