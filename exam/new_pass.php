<!DOCTYPE html>
<html lang="en">

<?php include 'header.php'; ?>

<body>
<?php include 'menu.php'; ?>

<?php
if(isset($_POST['submit'])){
    $errors = array();
    $fields = array('البريد الالكتروني'=>'email');
    foreach ($fields as $key=>$field){
        if(!isset($_POST[$field]) || empty(trim($_POST[$field]))){
            $errors[$field] = " حقل $key الزامي";
        }
    }

    if(empty($errors)){
        $success = 'لقد تم ارسال كلمة مرور جديدة الى بريدك الالكتروني';
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
                    <h2>ارسال كلمة مرور جديدة</h2>
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
                        if(isset($errors)){
                            foreach ($errors as $error){ ?>
                                <div class="alert alert-danger">
                                    <strong>خطأ!</strong> <?php echo $error; ?>
                                </div>
                            <?php    }
                        }
                        if(isset($success)){
                            ?>
                            <div class="alert alert-success">
                                <strong>صحيح!</strong> <?php echo $success; ?>
                            </div>
                            <?php
                        }
                        ?>

                        <div class="form-group">
                            <label for="exampleInputEmail1">البريد الالكتروني</label>
                            <input type="email" name="email" class="form-control" maxlength="50"  value="<?php if(isset($_POST['email'])){echo $_POST['email'];} ?>"/></p>
                        </div>
                            <div class="form-group">
                                <input type="submit" name="submit" value="ارسال "  class="btn btn-primary" />
                            </div>

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