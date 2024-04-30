<!DOCTYPE html>
<html lang="en">

<?php include 'header.php';
if (!isset($_SESSION['admin_id'])) {
    header('location:index.php');
    exit();
}

if(!isset($_GET['id']) || empty($_GET['id'])){
    header('location:index.php');
    exit();
}
$id = $_GET['id'];

if (isset($_POST['add'])) {
    $errors = array();
    $fields = array(
        'المقر' => 'campus_no', 'القاعة' => 'room_no', 'التاريخ' => 'date',   'وقت' => 'time', 'الفترة' => 'period',
        'الفصل الدراسي' => 'semester', 'العام الدراسي' => 'year', 'المقرر' => 'course_no', 'الشعبة' => 'section_seq', 'سبب التأخير' => 'reason',
        'رئيس اللجنة' => 'com_member_id1', 'لجنة الاختبارات' => 'confirm','الطالب' => 'student_id'
    );
    foreach ($fields as $key => $field) {
        if (!isset($_POST[$field]) || empty(trim($_POST[$field]))) {
            $errors[$field] = " حقل $key الزامي";
        }
    }

    $campus_no = mysqli_real_escape_string($conn, trim($_POST['campus_no']));
    $room_no = mysqli_real_escape_string($conn, trim($_POST['room_no']));
    $date = mysqli_real_escape_string($conn, trim($_POST['date']));
    $time = mysqli_real_escape_string($conn, trim($_POST['time']));
    $period = mysqli_real_escape_string($conn, trim($_POST['period']));
    $semester = mysqli_real_escape_string($conn, trim($_POST['semester']));
    $year = mysqli_real_escape_string($conn, trim($_POST['year']));
    $course_no = mysqli_real_escape_string($conn, trim($_POST['course_no']));
    $confirm = mysqli_real_escape_string($conn, trim($_POST['confirm']));
    $section_seq = mysqli_real_escape_string($conn, trim($_POST['section_seq']));
    if (isset($section_seq) && !empty($section_seq)) {
        if (!is_numeric($section_seq)) {
            $errors['section_seq'] = 'الشعبة يجب ان تحتوي على ارقام فقط';
        }
    }
    $com_member_id1 = mysqli_real_escape_string($conn, trim($_POST['com_member_id1']));

    $reason = mysqli_real_escape_string($conn, trim($_POST['reason']));
    $student_id = mysqli_real_escape_string($conn, trim($_POST['student_id']));
    if (isset($student_id) && !empty($student_id)) {
        $query = "SELECT * FROM students where student_id='$student_id' limit 1";
        $result = $conn->query($query);
        if (!($result->num_rows > 0)) {
            $errors['student_id'] = "رقم الطالب المدخل غير موجود";
        }
    }
    if (empty($errors)) {
        $sql = "Update late  SET `campus_no`='$campus_no',`room_no`='$room_no',`date`='$date',`time`='$time',`period`='$period',`year`='$year',`semester`='$semester'
,`course_no`='$course_no',`section_seq`='$section_seq',`reason`='$reason',`com_member_id1`='$com_member_id1',`confirm`='$confirm',`student_id`='$student_id' WHERE late_id=$id";

        if ($conn->query($sql) == TRUE) {
            $success = 'تم تعديل الاستمارة بنجاح';
        } else {
            echo $conn->error;
            echo $sql;
        }
    }
}
?>

<body>
<?php include 'menu.php'; ?>

<!-- ##### Right Side Cart Area ##### -->
<div class="cart-bg-overlay"></div>

<!-- ##### Right Side Cart End ##### -->

<!-- ##### Welcome Area Start ##### -->
<div class="row" style="margin-top: 150px;text-align: center;margin-bottom: 20px">
    <div class="col-lg-12">
        <h3> استمارة دخول طالب محروم</h3>
        <p>يرجى ملىء جميع الحقول </p>
    </div>
</div>


<div class="row">
    <div class="col-lg-3"></div>
    <div class="col-lg-6" style="text-align: right" dir="rtl">
        <form action="" method="post">
            <?php
            if (isset($errors)) {
                foreach ($errors as $error) { ?>
                    <div class="col-md-12 form-group">
                        <div class="alert alert-danger" style="text-align: right">
                            <strong>خطأ!</strong> <?php echo $error; ?>
                        </div>
                    </div>
                <?php    }
            }
            ?>
            <?php
            if(isset($success)){
                ?>
                <div class="alert alert-success" style="text-align: right">
                    <a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>
                    <strong>صحيح!</strong> <?php echo $success; ?>
                </div>
                <?php
            }
            ?>
            <?php
                $sqlMain = "select * from `late` WHERE late_id='$id' limit 1 ";
                $result5 = $conn->query($sqlMain);
                if ($result5->num_rows > 0) {
                while ($row5 = $result5->fetch_assoc()) {
                    $campus_no_update = $row5['campus_no'];
                    $room_no_update = $row5['room_no'];
            ?>
            <div class="form-group">
                <label>المقر</label>
                <select type="text" id="campus_no" name="campus_no" class="form-control">
                    <option value=""> -- اختيار المقر --</option>
                    <?php
                    $sql = "select * from `campuses` ";
                    $result = $conn->query($sql);
                    if ($result->num_rows > 0) {
                        while ($row = $result->fetch_assoc()) {
                            ?>
                            <option value="<?php echo $row['campus_no'] ?>" <?php
                            if (isset($_POST['campus_no'])) {
                                if ($_POST['campus_no'] == $row['campus_no']) {
                                    echo 'selected';
                                }
                            }else{
                                if($row5['campus_no'] == $row['campus_no']){
                                    echo 'selected';
                                }
                            }
                            ?>><?php echo $row['campus_name'] ?></option>
                        <?php }
                    } ?>
                </select>
            </div>
            <div class="form-group">
                <label>القاعة</label>
                <select name="room_no" id="room" type="text" class="form-control">
                    <option value=""> -- اختيار القاعة --</option>
                </select>
            </div>

            <div class="form-group">
                <label>التاريخ</label>
                <input type="date" name="date" style="text-align: right;" class="form-control" value="<?php if (isset($_POST['date'])) {
                    echo $_POST['date'];
                }else{ echo $row5['date']; } ?>">
            </div>
            <div class="form-group">
                <label>الوقت</label>
                <input type="time" name="time" style="text-align: right;" value="<?php if (isset($_POST['time'])) {
                    echo $_POST['time'];
                }else{
                    echo $row5['time'];
                } ?>" class="form-control">
            </div>

            <div class="form-group">
                <label>الفترة</label>
                <select type="text" name="period" class="form-control">
                    <option value=""> -- اختيار الفترة --</option>
                    <?php
                    $sql = "select * from `periods` ";
                    $result = $conn->query($sql);
                    if ($result->num_rows > 0) {
                        while ($row = $result->fetch_assoc()) {
                            ?>
                            <option value="<?php echo $row['period_no'] ?>" <?php
                            if (isset($_POST['period'])) {
                                if ($_POST['period'] == $row['period_no']) {
                                    echo 'selected';
                                }
                            }else{
                                if($row5['period'] == $row['period_no']){
                                    echo ' selected';
                                }
                            }
                            ?>><?php echo $row['period_name'] ?></option>
                        <?php }
                    } ?>
                </select>
            </div>

            <div class="form-group">
                <label>الفصل الدراسي</label>
                <select type="text" name="semester" class="form-control">
                    <option value=""> -- اختيار الفصل الدراسي --</option>
                    <option value="الفصل الاول" <?php
                    if (isset($_POST['semester'])) {
                        if ($_POST['semester'] == "الفصل الاول") {
                            echo 'selected';
                        }
                    }else{
                        if($row5['semester'] == 'الفصل الاول'){
                            echo 'selected';
                        }
                    }
                    ?>>الفصل الاول</option>
                    <option value="الفصل الثاني" <?php
                    if (isset($_POST['semester'])) {
                        if ($_POST['semester'] == "الفصل الثاني") {
                            echo 'selected';
                        }
                    }else{
                        if($row5['semester'] == 'الفصل الثاني'){
                            echo 'selected';
                        }
                    }
                    ?>>الفصل الثاني</option>
                    <option value="الفصل الصيفي" <?php
                    if (isset($_POST['semester'])) {
                        if ($_POST['semester'] == "الفصل الصيفي") {
                            echo 'selected';
                        }
                    }else{
                        if($row5['semester'] == 'الفصل الصيفي'){
                            echo 'selected';
                        }
                    }
                    ?>>الفصل الصيفي</option>
                </select>
            </div>



            <div class="form-group">
                <label>العام الدراسي</label>
                <select type="text" name="year" class="form-control">
                    <option value=""> -- اختيار العام الدراسي --</option>
                    <?php
                    $sql = "select * from `years` ";
                    $result = $conn->query($sql);
                    if ($result->num_rows > 0) {
                        while ($row = $result->fetch_assoc()) {
                            ?>
                            <option value="<?php echo $row['year_no'] ?>" <?php
                            if (isset($_POST['year'])) {
                                if ($_POST['year'] == $row['year_no']) {
                                    echo 'selected';
                                }
                            }else{
                                if ($row5['year'] == $row['year_no']){
                                    echo 'selected';
                                }
                            }
                            ?>><?php echo $row['year_name'] ?></option>
                        <?php }
                    } ?>
                </select>
            </div>


            <div class="form-group">
                <label>المقرر</label>
                <select type="text" name="course_no" class="form-control">
                    <option value=""> -- اختيار المقرر --</option>
                    <?php
                    $sql = "select * from `courses` ";
                    $result = $conn->query($sql);
                    if ($result->num_rows > 0) {
                        while ($row = $result->fetch_assoc()) {
                            ?>
                            <option value="<?php echo $row['course_no'] ?>" <?php
                            if (isset($_POST['course_no'])) {
                                if ($_POST['course_no'] == $row['course_no']) {
                                    echo 'selected';
                                }
                            }else{
                                if($row5['course_no'] == $row['course_no']){
                                    echo 'selected';
                                }
                            }
                            ?>><?php echo $row['course_name'] ?></option>
                        <?php }
                    } ?>
                </select>
            </div>

            <div class="form-group">
                <label>الشعبة</label>
                <input name="section_seq" type="number" class="form-control" value="<?php if (isset($_POST['section_seq'])) {
                    echo $_POST['section_seq'];
                }else{
                    echo $row5['section_seq'];
                } ?>">
            </div>

            <div class="form-group">
                <label>سبب التأخير</label>
                <textarea name="reason" rows="3" type="text" class="form-control"><?php if (isset($_POST['reason'])) {
                        echo $_POST['reason'];
                    }else{
                    echo $row5['reason'];
                    } ?></textarea>
            </div>




            <div class="form-group">
                <label>رئيس اللجنة</label>
                <select type="text" name="com_member_id1" class="form-control">
                    <option value=""> -- اختيار رئيس اللجنة --</option>
                    <?php
                    $sql = "select * from `instructors` ";
                    $result = $conn->query($sql);
                    if ($result->num_rows > 0) {
                        while ($row = $result->fetch_assoc()) {
                            ?>
                            <option value="<?php echo $row['instructor_id'] ?>" <?php
                            if (isset($_POST['com_member_id1'])) {
                                if ($_POST['com_member_id1'] == $row['instructor_id']) {
                                    echo 'selected';
                                }
                            }else{
                                if($row5['com_member_id1'] == $row['instructor_id']){
                                    echo  'selected';
                                }
                            }
                            ?>><?php echo $row['instructor_name'] ?></option>
                        <?php }
                    } ?>
                </select>
            </div>

            <div class="form-group">
                <label>لجنة الاختبارات</label>
                <textarea name="confirm" rows="3" type="text" class="form-control"><?php if(isset($_POST['confirm'])){ echo $_POST['confirm']; }else{ echo $row5['confirm']; } ?></textarea>
            </div>


            <div class="form-group">
                <label>رقم الطالب</label>
                <input name="student_id" id="student_id" type="text" class="form-control" value="<?php if (isset($_POST['student_id'])) {
                    echo $_POST['student_id'];
                }else{ echo $row5['student_id'];} ?>"><a id="search" class="btn btn-info">بحث</a>
                <span id="student_data">ادخل رقم الطالب</span>
            </div>


            <?php }} ?>





            <button type="submit" name="add" class="btn btn-primary">تعديل</button>
        </form>
    </div>
</div>







<hr>




<!-- ##### New Arrivals Area Start ##### -->

<!-- ##### New Arrivals Area End ##### -->



<?php include 'footer.php'; ?>
<script>
    $(document).ready(function() {
        $('#campus_no').on('change', function() {
            var campus_no = $(this).val();
            if (campus_no) {
                $.ajax({
                    type: 'POST',
                    url: 'ajaxData.php',
                    data: 'campus_no=' + campus_no,
                    success: function(html) {
                        $('#room').html(html);
                    }
                });
            } else {
                $('#room').html('<option value=""> -- اختيار القاعة --</option>');
            }
        });

        <?php
        if (isset($_POST['campus_no']) && !empty($_POST['campus_no'])) {
        ?>
        var campus_no = <?php echo $_POST['campus_no']; ?>;
        var room = <?php echo (isset($_POST['room_no']) && !empty($_POST['room_no'])) ? $_POST['room_no'] : 0; ?>;
        if (campus_no) {
            $.ajax({
                type: 'POST',
                url: 'ajaxData.php',
                data: {
                    campus_no: campus_no,
                    room: room
                },
                success: function(html) {
                    $('#room').html(html);
                }
            });
        }
        <?php }else{ ?>
        var campus_no = <?php echo $campus_no_update; ?>;
        var room = <?php echo (isset($_POST['room_no']) && !empty($_POST['room_no'])) ? $_POST['room_no'] : $room_no_update; ?>;
        if (campus_no) {
            $.ajax({
                type: 'POST',
                url: 'ajaxData.php',
                data: {
                    campus_no: campus_no,
                    room: room
                },
                success: function(html) {
                    $('#room').html(html);
                }
            });
        }
        <?php  } ?>


        $('#search').on('click', function() {
            var campus_no = $("#student_id").val();
            if (campus_no) {
                $.ajax({
                    type: 'POST',
                    url: 'ajaxData.php',
                    data: 'student_id=' + campus_no,
                    success: function(html) {
                        $('#student_data').html(html);
                    }
                });
            } else {
                $('#student_data').html('<span> ادخل رقم الطالب</span>');
            }
        });
    });
</script>
</body>

</html>