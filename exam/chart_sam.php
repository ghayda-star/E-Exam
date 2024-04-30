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

<!-- ##### Right Side Cart Area ##### -->
<div class="cart-bg-overlay"></div>

<!-- ##### Right Side Cart End ##### -->

<!-- ##### Welcome Area Start ##### -->
<div class="row" style="margin-top: 150px;text-align: center;margin-bottom: 20px">
    <div class="col-lg-12">
        <h3>احصائيات على مستوى الفصل</h3>
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
    <div class="col-lg-3"></div>
    <div class="col-lg-6 text-center" style="text-align: center" dir="rtl">
        <form class="form-inline" style="margin-right: 160px" action="" method="get">
            <div class="form-group">
                <select type="text" name="year" class="form-control">
                    <option value=""> -- اختيار العام الدراسي --</option>
                    <?php
                    $sql = "select * from `years` ";
                    $result = $conn->query($sql);
                    if ($result->num_rows > 0) {
                        while ($row = $result->fetch_assoc()) {
                            ?>
                            <option value="<?php echo $row['year_no'] ?>" <?php
                            if (isset($_GET['year'])) {
                                if ($_GET['year'] == $row['year_no']) {
                                    echo 'selected';
                                }
                            }
                            ?>><?php echo $row['year_name'] ?></option>
                        <?php }
                    } ?>
                </select>
                <select type="text" name="semester" class="form-control">
                    <option value=""> -- اختيار الفصل الدراسي --</option>
                    <option value="الفصل الاول" <?php
                    if (isset($_GET['semester'])) {
                        if ($_GET['semester'] == "الفصل الاول") {
                            echo 'selected';
                        }
                    }
                    ?>>الفصل الاول</option>
                    <option value="الفصل الثاني" <?php
                    if (isset($_GET['semester'])) {
                        if ($_GET['semester'] == "الفصل الثاني") {
                            echo 'selected';
                        }
                    }
                    ?>>الفصل الثاني</option>
                    <option value="الفصل الصيفي" <?php
                    if (isset($_GET['semester'])) {
                        if ($_GET['semester'] == "الفصل الصيفي") {
                            echo 'selected';
                        }
                    }
                    ?>>الفصل الصيفي</option>
                </select>
            </div>

            <button style="margin-top: 8px;" type="submit" class="btn btn-primary mb-2">بحث</button>
        </form>
    </div>
</div>

<hr>

<div class="row" dir="rtl" style="text-align: right">
    <div class="col-lg-2"></div>
    <div class="col-lg-8">
        <?php if(isset($_GET['semester']) && !empty($_GET['semester']) && isset($_GET['year']) && !empty($_GET['year'])){ ?>
        <button class="btn btn-primary" id="printPageButton" style="padding: 8px;margin-bottom: 5px" onClick="window.print();"> <i class="fa fa-print"></i> طباعه</button>
        <table class="table">
            <tr>
                <td>
                    <?php echo $_GET['semester']; ?>
                </td>
                <td> <?php echo getTotalByType($_GET['year'],$_GET['semester']); ?> </td>
            </tr>
            <?php foreach (getTotalByCourse($_GET['year'],$_GET['semester']) as $key => $value){ ?>
            <tr>
                <td>
                    <?php echo getTypeName($key); ?>
                </td>
                <td>
                    <?php echo $value['total']; ?>
                </td>
            </tr>
            <?php } ?>
        </table>
        <?php } ?>
    </div>
</div>




<!-- ##### New Arrivals Area Start ##### -->

<!-- ##### New Arrivals Area End ##### -->



<?php include 'footer.php'; ?>
</body>

</html>