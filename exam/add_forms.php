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
        <h3> ادخال استمارة</h3>
        <p>يرجى اختيار نوع الاستماره </p>
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
    <div class="col-lg-4" style="text-align: center">
       <a href="add_violation.php" style="width: 100%;margin-top: 10px" class="btn btn-primary">استمارة مخالفة نظام لجنة</a>
       <a href="add_absence.php" style="width: 100%;margin-top: 10px"  class="btn btn-info">استمارة غياب طالب</a>
       <a href="add_forbidden.php" style="width: 100%;margin-top: 10px" class="btn btn-warning">استمارة دخول طالب محروم</a>
       <a href="add_late.php" style="width: 100%;margin-top: 10px" class="btn btn-danger">استمارة تأخر طالب</a>
       <a href="add_cheat.php" style="width: 100%;margin-top: 10px" class="btn btn-dark">استمارة حالة غش</a>
       <a href="add_proofing.php" style="width: 100%;margin-top: 10px" class="btn btn-success">استمارة إثبات هوية طالب</a>
    </div>
</div>

<hr>




<!-- ##### New Arrivals Area Start ##### -->

<!-- ##### New Arrivals Area End ##### -->



<?php include 'footer.php'; ?>
</body>

</html>