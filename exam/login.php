<!DOCTYPE html>
<html lang="en">

<?php include 'header.php'; ?>

<body>
    <?php include 'menu.php'; ?>

    <?php

    if (isset($_POST['submit'])) {
        $form = 1;

        if (isset($_POST['username']) && !empty(trim($_POST['username']))) {
            $username = trim($_POST['username']);
        } else {
            $form = 0;
            $errors['username'] = 'حقل اسم المستخدم إلزامي';
        }

        if (isset($_POST['password']) && !empty(trim($_POST['password']))) {
            $password = trim($_POST['password']);
        } else {
            $form = 0;
            $errors['password'] = 'حقل كلمة المرور إلزامي';
        }


        if ($form == 1) {

            $sql = "SELECT * FROM `instructors` where instructor_password='$password' and instructor_username='$username' LIMIT 1";
            $result = $conn->query($sql);
            if ($result->num_rows > 0) {
                while ($row = $result->fetch_assoc()) {
                    $id = $row['instructor_id'];
                    $_SESSION['admin_id'] = $id;
                    $_SESSION['admin_name'] = $row['instructor_name'];
                    header('location:home.php');
                    exit();
                }
            } else {
                $form = 0;
                $errors['login'] = 'خطأ في بيانات الدخول';
            }
        }
    }
    ?>

    <div class="cart-bg-overlay"></div>

    <!-- ##### Right Side Cart End ##### -->

    <!-- ##### Breadcumb Area Start ##### -->
    <div class="breadcumb_area bg-img" style="background-image: url(img/bg-img/breadcumb.jpg); margin-top: 86px;">
        <div class="container h-100">
            <div class="row h-100 align-items-center">
                <div class="col-12">
                    <div class="page-title text-center">
                        <h2>تسجيل الدخول</h2>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- ##### Breadcumb Area End ##### -->

    <!-- ##### Checkout Area Start ##### -->
    <div class="checkout_area section-padding-80" dir="rtl">
        <div class="container">
            <div class="row">

                <div class="col-md-12 col-lg-12 ml-lg-auto">
                    <div class="order-details-confirmation">

                        <form action="#" method="post" dir="rtl" style="text-align: right">
                            <?php
                            if (isset($errors)) {
                                foreach ($errors as $error) { ?>
                                    <div class="alert alert-danger">
                                        <strong>خطأ!</strong> <?php echo $error; ?>
                                    </div>
                            <?php    }
                            }
                            ?>

                            <div class="form-group">
                                <label for="exampleInputEmail1">اسم المستخدم</label>
                                <input type="text" name="username" class="form-control" maxlength="20" value="<?php if (isset($_POST['username'])) {
                                                                                                                    echo $_POST['username'];
                                                                                                                } ?>" />
                            </div>

                            <div class="form-group">
                                <label for="exampleInputEmail1">كلمة المرور</label>
                                <input type="password" name="password" class="form-control" maxlength="20" /></p>
                            </div>
                            <div class="form-group">
                                <input type="submit" name="submit" value="تسجيل الدخول " class="btn btn-primary" />
                            </div>
                            هل نسيت كلمة المرور؟
                            <a href="new_pass.php">اضغط هنا</a>


                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- ##### Checkout Area End ##### -->


    <?php include 'footer.php'; ?>

</body>

</html>