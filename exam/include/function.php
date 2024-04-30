<?php

function getTypeName($type){
    $types['violating']='مخالفة نظام لجنة';
    $types['absence']='مخالفة غياب طالب';
    $types['forbidden']='مخالفة دخول طالب محروم';
    $types['late']='مخالفة تأخر طالب';
    $types['cheating']='مخالفة حالة غش';
    $types['proofing']='مخالفة اثبات هوية';
    if(isset($types[$type])){
        return $types[$type];
    }
    return '';
}

function get_user_faculties($id){
    global $conn;
    $item = array();
    $sql = "select * from faculties where faculty_no=$id ";
    $result = $conn->query($sql);
    if($result->num_rows > 0) {
        while($row = $result->fetch_assoc()) {
            $item = $row['faculty_name'];
        }
    }
    return $item;
}

function get_user_department($id){
    global $conn;
    $item = array();
    $sql = "select * from departments where department_no=$id ";
    $result = $conn->query($sql);
    if($result->num_rows > 0) {
        while($row = $result->fetch_assoc()) {
            $item = $row['department_name'];
        }
    }
    return $item;
}

function getTotalByType($year,$type){
    global $conn;
    $total = 0;
    $tables = ['absence','cheating','forbidden','late','proofing','violating'];
    foreach ($tables as $table){
        $sql = "select count(*) as `total` from `$table` where `semester`='$type' and `year`='$year' ";
        $result = $conn->query($sql);
        if($result->num_rows > 0) {
            while($row = $result->fetch_assoc()) {
                $total += $row['total'];
            }
        }
    }
    return $total;
}


function getTotal(){
    global $conn;
    $total = 0;
    $tables = ['absence','cheating','forbidden','late','proofing','violating'];
    foreach ($tables as $table){
        $sql = "select count(*) as `total` from `$table`";
        $result = $conn->query($sql);
        if($result->num_rows > 0) {
            while($row = $result->fetch_assoc()) {
                $total += $row['total'];
            }
        }
    }
    return $total;
}
function getCourseName($id){
    global $conn;
    $item = array();
    $sql = "select * from courses where course_no=$id ";
    $result = $conn->query($sql);
    if($result->num_rows > 0) {
        while($row = $result->fetch_assoc()) {
            $item = $row['course_name'];
        }
    }
    return $item;
}
function getTotalByCourse($year,$type){
    global $conn;
    $tables = ['absence','cheating','forbidden','late','proofing','violating'];
    $course = [];
    foreach ($tables as $table){
        $sql = "SELECT count(*) as `total` FROM `$table` where semester='$type' and `year`='$year'";
        $result = $conn->query($sql);
        if($result->num_rows > 0) {
            while($row = $result->fetch_assoc()) {
                $course[$table]['total'] = $row['total'];
            }
        }
    }
    return $course;
}

function getTotalByCourseAll($year,$type){
    global $conn;
    $tables = ['absence','cheating','forbidden','late','proofing','violating'];
    $course = [];
    foreach ($tables as $table){
        $sql = "SELECT count(*) as `total`,course_no FROM `$table` where semester='$type' and `year`='$year' group by course_no;";
        $result = $conn->query($sql);
        if($result->num_rows > 0) {
            while($row = $result->fetch_assoc()) {
                if(isset($course[$row['course_no']])){
                    $course[$row['course_no']]['total'] += $row['total'];
                }else{
                    $course[$row['course_no']] = ['name'=>getCourseName($row['course_no']),'total'=>$row['total']];
                }
            }
        }
    }
    return $course;
}