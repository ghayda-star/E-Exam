<?php
include "include/connections.php";
if(isset($_POST['campus_no']) && !empty($_POST['campus_no'])){
    $c_num = trim($_POST['campus_no']);
    if(isset($_POST['room'])) {
        $room = trim($_POST['room']);
    }else{
        $room = 0;
    }
    $query = "SELECT * FROM rooms where campus_no='$c_num'";
    $result = $conn->query($query);
    // Generate HTML of state options list
    if($result->num_rows > 0){
        echo '<option value=""> -- اختيار القاعة --</option>';
        while($row = $result->fetch_assoc()){
            $selected = '';
            if($room == $row['room_no']){
                $selected = 'selected';
            }
            echo '<option value="'.$row['room_no'].'" '."$selected".'>'.$row['room_name'].'</option>';
        }
    }else{
        echo '<option value="">القاعة غير موجودة</option>';
    }
}

if(isset($_POST['student_id']) && !empty($_POST['student_id'])){
    $c_num = trim($_POST['student_id']);
    $query = "SELECT * FROM students where student_id='$c_num' limit 1";
    $result = $conn->query($query);
    // Generate HTML of state options list
    if($result->num_rows > 0){
        while($row = $result->fetch_assoc()){
            echo '<span>'.$row['student_name'].'</span>';
        }
    }else{
        echo '<span style="color: red">الرقم المدخل غير موجود</span>';
    }
}