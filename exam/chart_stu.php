<!DOCTYPE html>
<html lang="en">

<?php include 'header.php'; ?>

<body>
<style>
    @media print {
        #printPageButton {
            display: none;
        }
        #search-form{
            display: none;
        }
        .ssd{
            display: none;
        }
        #tt{
            display: none;
        }
    }
</style>
<?php include 'menu.php'; ?>

<br><br>
<br>
<br>

<!-- ##### Right Side Cart Area ##### -->
<div class="cart-bg-overlay"></div>

<!-- ##### Right Side Cart End ##### -->

<!-- ##### Welcome Area Start ##### -->
<div class="row" style="margin-top: 150px;text-align: center;margin-bottom: 20px">
    <div class="col-lg-12">
        <h3> تقرير بمخالفات طالب</h3>
        <p id="tt">يرجى البحث عن رقم الطالب </p>
    </div>
</div>

<?php
$login = false;
$url = 'login.php';
if(isset($_SESSION['admin_id'])){
    $login = true;
}
?>
<div class="row" id="search-form">
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
                    <h3 class="text-center" style="margin-bottom: 50px"> تقرير مخالفات الطالب :  <?php echo $row['student_name']; ?></h3>
                    <button class="btn btn-primary" id="printPageButton" style="padding: 8px;margin-bottom: 5px" onClick="window.print();"> <i class="fa fa-print"></i> طباعه</button>
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
                            $result2 = $conn->query($sql);
                            if ($result2->num_rows > 0) {
                                while ($row5 = $result2->fetch_assoc()) {
                                    $url = $type['url'];
                                    $table_id = $type['table_id'];
                                    $type_id = $row5[$table_id];
                                    ?>
                                        <h3><?php echo $type['type_name']; ?></h3>
                                    <table class="table">
                                    <tr>

                                        <td>
                                            <label>المقر</label>
                                        </td>
                                        <td>
                                            <?php
                                            $cam=$row5['campus_no'];
                                            $sql = "select * from `campuses` where `campus_no`='$cam' ";
                                            $result = $conn->query($sql);
                                            if ($result->num_rows > 0) {
                                                while ($row = $result->fetch_assoc()) {
                                                    ?>
                                                    <?php echo $row['campus_name'] ?>
                                                <?php }
                                            } ?>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td>
                                            القاعة
                                        </td>
                                        <td> <?php echo $row5['room_no']; ?> </td>
                                    </tr>
                                        <tr>
                                            <td>
                                                التاريخ
                                            </td>
                                            <td> <?php echo $row5['date']; ?> </td>
                                        </tr>
                                        <tr>
                                            <td>
                                                الوقت
                                            </td>
                                            <td> <?php echo $row5['time']; ?> </td>
                                        </tr>

                                        <tr>
                                            <td>
                                                الفترة
                                            </td>
                                            <td> <?php
                                                $per=$row5['period'];
                                                $sql = "select * from `periods` WHERE `period_no` = '$per' ";
                                                $result = $conn->query($sql);
                                                if ($result->num_rows > 0) {
                                                    while ($row = $result->fetch_assoc()) {
                                                        echo $row['period_name'];
                                                        ?>
                                                    <?php }
                                                } ?> </td>
                                        </tr>

                                        <tr>
                                            <td>
                                                الفصل الدراسي
                                            </td>
                                            <td> <?php echo $row5['semester']; ?> </td>
                                        </tr>

                                        <tr>
                                            <td>
                                                العام الدراسي
                                            </td>
                                            <td> <?php
                                                $years=$row5['year'];
                                                $sql = "select * from `years` WHERE `year_no` = '$years' ";
                                                $result = $conn->query($sql);
                                                if ($result->num_rows > 0) {
                                                    while ($row = $result->fetch_assoc()) {
                                                        echo $row['year_name'];
                                                        ?>
                                                    <?php }
                                                } ?> </td>
                                        </tr>

                                        <tr>
                                            <td>
                                                المقرر
                                            </td>
                                            <td> <?php
                                                $course_no=$row5['course_no'];
                                                $sql = "select * from `courses` WHERE `course_no` = '$course_no' ";
                                                $result = $conn->query($sql);
                                                if ($result->num_rows > 0) {
                                                    while ($row = $result->fetch_assoc()) {
                                                        echo $row['course_name'];
                                                        ?>
                                                    <?php }
                                                } ?> </td>
                                        </tr>

                                        <tr>
                                            <td>
                                                الشعبة
                                            </td>
                                            <td> <?php echo $row5['section_seq']; ?> </td>
                                        </tr>
                                    <?php if($table == 'violating'){ ?>
                                        <tr>
                                            <td>
                                                المخالفة
                                            </td>
                                            <td> <?php echo $row5['violate_case']; ?> </td>
                                        </tr>


                                        <tr>
                                            <td>
                                                المشرف
                                            </td>
                                            <td> <?php
                                                $instructor_id=$row5['monetor_member_id1'];
                                                $sql = "select * from `instructors` WHERE `instructor_id` = '$instructor_id' ";
                                                $result = $conn->query($sql);
                                                if ($result->num_rows > 0) {
                                                    while ($row = $result->fetch_assoc()) {
                                                        echo $row['instructor_name'];
                                                        ?>
                                                    <?php }
                                                } ?> </td>
                                        </tr>

                                        <tr>
                                            <td>
                                                المراقب
                                            </td>
                                            <td> <?php
                                                $instructor_id=$row5['monetor_member_id2'];
                                                $sql = "select * from `instructors` WHERE `instructor_id` = '$instructor_id' ";
                                                $result = $conn->query($sql);
                                                if ($result->num_rows > 0) {
                                                    while ($row = $result->fetch_assoc()) {
                                                        echo $row['instructor_name'];
                                                        ?>
                                                    <?php }
                                                } ?> </td>
                                        </tr>

                                        <tr>
                                            <td>
                                                رئيس اللجنة
                                            </td>
                                            <td> <?php
                                                $instructor_id=$row5['com_member_id1'];
                                                $sql = "select * from `instructors` WHERE `instructor_id` = '$instructor_id' ";
                                                $result = $conn->query($sql);
                                                if ($result->num_rows > 0) {
                                                    while ($row = $result->fetch_assoc()) {
                                                        echo $row['instructor_name'];
                                                        ?>
                                                    <?php }
                                                } ?> </td>
                                        </tr>

                                        <tr style="border-bottom: 6px solid">
                                            <td>
                                                لجنة الاختبارات
                                            </td>
                                            <td> <?php echo $row5['confirm']; ?> </td>
                                        </tr>
                                        <?php } ?>
                                        <?php if($table == 'absence'){ ?>
                                            <tr>
                                                <td>
                                                    ملاحظات
                                                </td>
                                                <td> <?php echo $row5['remarks']; ?> </td>
                                            </tr>


                                            <tr>
                                                <td>
                                                    المشرف
                                                </td>
                                                <td> <?php
                                                    $instructor_id=$row5['monetor_member_id1'];
                                                    $sql = "select * from `instructors` WHERE `instructor_id` = '$instructor_id' ";
                                                    $result = $conn->query($sql);
                                                    if ($result->num_rows > 0) {
                                                        while ($row = $result->fetch_assoc()) {
                                                            echo $row['instructor_name'];
                                                            ?>
                                                        <?php }
                                                    } ?> </td>
                                            </tr>

                                            <tr>
                                                <td>
                                                    المراقب
                                                </td>
                                                <td> <?php
                                                    $instructor_id=$row5['monetor_member_id2'];
                                                    $sql = "select * from `instructors` WHERE `instructor_id` = '$instructor_id' ";
                                                    $result = $conn->query($sql);
                                                    if ($result->num_rows > 0) {
                                                        while ($row = $result->fetch_assoc()) {
                                                            echo $row['instructor_name'];
                                                            ?>
                                                        <?php }
                                                    } ?> </td>
                                            </tr>

                                            <tr>
                                                <td>
                                                    رئيس اللجنة
                                                </td>
                                                <td> <?php
                                                    $instructor_id=$row5['com_member_id1'];
                                                    $sql = "select * from `instructors` WHERE `instructor_id` = '$instructor_id' ";
                                                    $result = $conn->query($sql);
                                                    if ($result->num_rows > 0) {
                                                        while ($row = $result->fetch_assoc()) {
                                                            echo $row['instructor_name'];
                                                            ?>
                                                        <?php }
                                                    } ?> </td>
                                            </tr>
                                            <tr style="border-bottom: 6px solid">
                                                <td>
                                                    عضو اللجنة
                                                </td>
                                                <td> <?php
                                                    $instructor_id=$row5['com_member_id2'];
                                                    $sql = "select * from `instructors` WHERE `instructor_id` = '$instructor_id' ";
                                                    $result = $conn->query($sql);
                                                    if ($result->num_rows > 0) {
                                                        while ($row = $result->fetch_assoc()) {
                                                            echo $row['instructor_name'];
                                                            ?>
                                                        <?php }
                                                    } ?> </td>
                                            </tr>
                                        <?php } ?>

                                        <?php if($table == 'forbidden'){ ?>
                                            <tr>
                                                <td>
                                                    سبب السماح بالدخول
                                                </td>
                                                <td> <?php echo $row5['reason']; ?> </td>
                                            </tr>
                                            <tr style="border-bottom: 6px solid">
                                                <td>
                                                    رئيس اللجنة
                                                </td>
                                                <td> <?php
                                                    $instructor_id=$row5['com_member_id1'];
                                                    $sql = "select * from `instructors` WHERE `instructor_id` = '$instructor_id' ";
                                                    $result = $conn->query($sql);
                                                    if ($result->num_rows > 0) {
                                                        while ($row = $result->fetch_assoc()) {
                                                            echo $row['instructor_name'];
                                                            ?>
                                                        <?php }
                                                    } ?> </td>
                                            </tr>
                                        <?php } ?>
                                        <?php if($table == 'late'){ ?>
                                            <tr>
                                                <td>
                                                    سبب التاخير
                                                </td>
                                                <td> <?php echo $row5['reason']; ?> </td>
                                            </tr>
                                            <tr>
                                                <td>
                                                    رئيس اللجنة
                                                </td>
                                                <td> <?php
                                                    $instructor_id=$row5['com_member_id1'];
                                                    $sql = "select * from `instructors` WHERE `instructor_id` = '$instructor_id' ";
                                                    $result = $conn->query($sql);
                                                    if ($result->num_rows > 0) {
                                                        while ($row = $result->fetch_assoc()) {
                                                            echo $row['instructor_name'];
                                                            ?>
                                                        <?php }
                                                    } ?> </td>
                                            </tr>

                                            <tr style="border-bottom: 6px solid">
                                                <td>
                                                    لجنة الاختبارات
                                                </td>
                                                <td> <?php echo $row5['confirm']; ?> </td>
                                            </tr>
                                        <?php } ?>
                                        <?php if($table == 'cheating'){ ?>
                                            <tr>
                                                <td>
                                                    واقعة الغش والأدوات المستخدمة
                                                </td>
                                                <td> <?php echo $row5['cheat_case']; ?> </td>
                                            </tr>


                                            <tr>
                                                <td>
                                                    المشرف
                                                </td>
                                                <td> <?php
                                                    $instructor_id=$row5['monetor_member_id1'];
                                                    $sql = "select * from `instructors` WHERE `instructor_id` = '$instructor_id' ";
                                                    $result = $conn->query($sql);
                                                    if ($result->num_rows > 0) {
                                                        while ($row = $result->fetch_assoc()) {
                                                            echo $row['instructor_name'];
                                                            ?>
                                                        <?php }
                                                    } ?> </td>
                                            </tr>

                                            <tr>
                                                <td>
                                                    المراقب
                                                </td>
                                                <td> <?php
                                                    $instructor_id=$row5['monetor_member_id2'];
                                                    $sql = "select * from `instructors` WHERE `instructor_id` = '$instructor_id' ";
                                                    $result = $conn->query($sql);
                                                    if ($result->num_rows > 0) {
                                                        while ($row = $result->fetch_assoc()) {
                                                            echo $row['instructor_name'];
                                                            ?>
                                                        <?php }
                                                    } ?> </td>
                                            </tr>

                                            <tr>
                                                <td>
                                                    رئيس اللجنة
                                                </td>
                                                <td> <?php
                                                    $instructor_id=$row5['com_member_id1'];
                                                    $sql = "select * from `instructors` WHERE `instructor_id` = '$instructor_id' ";
                                                    $result = $conn->query($sql);
                                                    if ($result->num_rows > 0) {
                                                        while ($row = $result->fetch_assoc()) {
                                                            echo $row['instructor_name'];
                                                            ?>
                                                        <?php }
                                                    } ?> </td>
                                            </tr>

                                            <tr style="border-bottom: 6px solid">
                                                <td>
                                                    المرفقات
                                                </td>
                                                <td> <a href="img/<?php echo $row5['doc']; ?>" download="">تنزيل</a> </td>
                                            </tr>
                                        <?php } ?>
                                        <?php if($table == 'proofing'){ ?>
                                            <tr>
                                                <td>
                                                    سبب عدم إحضار الهوية
                                                </td>
                                                <td> <?php echo $row5['reason']; ?> </td>
                                            </tr>



                                            <tr>
                                                <td>
                                                    رئيس اللجنة
                                                </td>
                                                <td> <?php
                                                    $instructor_id=$row5['com_member_id1'];
                                                    $sql = "select * from `instructors` WHERE `instructor_id` = '$instructor_id' ";
                                                    $result = $conn->query($sql);
                                                    if ($result->num_rows > 0) {
                                                        while ($row = $result->fetch_assoc()) {
                                                            echo $row['instructor_name'];
                                                            ?>
                                                        <?php }
                                                    } ?> </td>
                                            </tr>

                                            <tr style="border-bottom: 6px solid">
                                                <td>
                                                    لجنة الاختبارات
                                                </td>
                                                <td> <?php echo $row5['confirm']; ?> </td>
                                            </tr>
                                        <?php } ?>
                                    </table>
                                <?php
                                    }
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


<br>
<br>
<br>
<br>
<br>
<br>


<br>
<br>
<br>
<br>



<!-- ##### New Arrivals Area Start ##### -->

<!-- ##### New Arrivals Area End ##### -->



<?php include 'footer.php'; ?>
</body>

</html>