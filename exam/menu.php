<!-- ##### Header Area Start ##### -->
<header class="header_area" dir="rtl">
    <div class="classy-nav-container breakpoint-off d-flex align-items-center justify-content-between">
        <!-- Classy Menu -->
        <nav class="classy-navbar" id="essenceNav">
            <!-- Logo -->
            <a class="nav-brand" href="index.php"><img src="logo.png" style="height: 50px;" alt=""></a>
            <!-- Navbar Toggler -->
            <div class="classy-navbar-toggler">
                <span class="navbarToggler"><span></span><span></span><span></span></span>
            </div>
            <!-- Menu -->
            <div class="classy-menu">
                <!-- close btn -->
                <div class="classycloseIcon">
                    <div class="cross-wrap"><span class="top"></span><span class="bottom"></span></div>
                </div>
                <!-- Nav Start -->
                <div class="classynav">
                    <ul>
                        <li><a style="" href="index.php">الرئيسية</a></li>
                        <li><a style="" href="about.php">حول الموقع</a></li>
                        <li><a style="" href="contact.php">اتصل بنا</a></li>
                        <?php if(isset($_SESSION['admin_id'])){ ?>
                            <li><a style="" href="logout.php">تسجيل الخروج</a></li>
                        <?php }else{ ?>
                            <li><a style="" href="login.php">الدخول</a></li>
                        <?php } ?>
                    </ul>
                 
                </div>
                <!-- Nav End -->
            </div>
        </nav>

        <!-- Header Meta Data -->

    </div>
</header>
<!-- ##### Header Area End ##### -->