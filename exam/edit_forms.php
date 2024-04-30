<!DOCTYPE html>
<html lang="en">

<?php include 'header.php'; ?>

<body>
<?php include 'menu.php'; ?>

<!-- ##### Right Side Cart Area ##### -->
<div class="cart-bg-overlay"></div>

<!-- ##### Right Side Cart End ##### -->

<!-- ##### Welcome Area Start ##### -->
<div class="row" style="margin-top: 150px;text-align: center;margin-bottom: 20px">
    <div class="col-lg-12">
        <h3> تعديل استمارة</h3>
        <p>يرجى البحث عن رقم الطالب </p>
    </div>
</div>

<?php
$login = false;
$url = 'login.php';
if(isset($_SESSION['admin_id'])){
    $login = true;
}
?>
<div class="row">
    <div class="col-lg-4"></div>
    <div class="col-lg-4 text-center" style="text-align: center" dir="rtl">
        <form class="form-inline" style="margin-right: 160px" action="" method="get">
            <input type="text" class="form-control mb-2 mr-sm-2" id="inlineFormInputName2" name="student_id" placeholder="رقم الطالب ...">

            <button type="submit" class="btn btn-primary mb-2">بحث</button>
        </form>
    </div>
</div>

<hr>

<div class="row" dir="rtl" style="text-align: right">
    <div class="col-lg-2"></div>
    <?php
    if(isset($_GET['student_id']) && !empty($_GET['student_id'])) {
        $student_id = trim($_GET['student_id']);
        $sql = "select * from `students` WHERE student_id='$student_id' limit 1 ";
        $result = $conn->query($sql);
        if ($result->num_rows > 0) {
            while ($row = $result->fetch_assoc()) {
                ?>
                <div class="col-lg-8">
                    <table class="table table-striped">
                        <thead>
                        <tr>
                            <th scope="col">الطالب</th>
                            <th scope="col">الاستمارة</th>
                            <th scope="col">الكلية</th>
                            <th scope="col">القسم</th>
                            <th scope="col">المقرر</th>
                            <th scope="col">المقر</th>

                            <th scope="col">العمليات</th>
                        </tr>
                        </thead>
                        <tbody>
                        <?php
                        $student_name = $row['student_name'];
                        $getDepartment = get_user_department($row['dept_no']);
                        $getFaculties = get_user_faculties($row['faculty_no']);//الكلية
                        $types = [[
                          'table'=>'violating',
                          'table_id' =>'violation_id',
                          'type_name' =>'مخالفة نظام لجنة',
                            'url'=>'edit_violating.php'
                        ],[
                            'table'=>'absence',
                            'table_id' =>'absence_id',
                            'type_name' =>'غياب طالب',
                            'url'=>'edit_absence.php'
                        ],[
                            'table'=>'forbidden',
                            'table_id' =>'forbidden_id',
                            'type_name' =>'دخول طالب محروم',
                            'url'=>'edit_forbidden.php'
                        ],[
                            'table'=>'late',
                            'table_id' =>'late_id',
                            'type_name' =>'تأخر طالب',
                            'url'=>'edit_late.php'
                        ],[
                            'table'=>'cheating',
                            'table_id' =>'cheat_id',
                            'type_name' =>'حالة غش',
                            'url'=>'edit_cheating.php'
                        ],[
                            'table'=>'proofing',
                            'table_id' =>'proofing_id',
                            'type_name' =>'اثبات هوية',
                            'url'=>'edit_proofing.php'
                        ]

                        ];
                        foreach ($types as $type) {
                            $table = $type['table'];
                            $sql = "select `$table`.*,`campuses`.campus_name,`courses`.course_name from `$table` inner join `campuses` on `$table`.campus_no = `campuses`.campus_no inner join `courses` on `$table`.course_no = `courses`.course_no WHERE student_id='$student_id' ";
                            $result = $conn->query($sql);
                            if ($result->num_rows > 0) {
                                while ($row = $result->fetch_assoc()) {
                                    $url = $type['url'];
                                    $table_id = $type['table_id'];
                                    $type_id = $row[$table_id];
                                    ?>
                                    <tr>
                                        <td><?php echo $student_name; ?></td>
                                        <td><?php echo $type['type_name']; ?></td>
                                        <td><?php echo $getFaculties; ?></td>
                                        <td><?php echo $getDepartment; ?></td>
                                        <td><?php echo $row['course_name']; ?></td>
                                        <td><?php echo $row['campus_name']; ?></td>
                                        <td>
                                            <a href="<?php echo $url ?>?id=<?php echo $type_id; ?>"> تعديل </a>
                                        </td>
                                    </tr>
                                <?php }
                            }
                        }
                            ?>
                        </tbody>
                    </table>
                </div>
            <?php }
        }else{ ?>
            <div class="col-lg-8 text-center" >
            <b style='color: red;text-align: center'> رقم الطالب <?php echo $student_id ?> غير موجود </b>
            </div>
        <?php }
    }
    ?>
</div>




<!-- ##### New Arrivals Area Start ##### -->

<!-- ##### New Arrivals Area End ##### -->



<?php include 'footer.php'; ?>
</body>

</html>