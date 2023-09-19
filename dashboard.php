<?php
session_start();
    if( !isset($_SESSION["nama_lengkap"])){
        header("location: login.php");
        exit;
    }
    include_once 'functions.php'; 

try {
    // Query pertama: Total Tagihan
    $stmt1 = $dbh->prepare('SELECT COUNT(*) as jumlah_tagihan FROM tagihan WHERE 1');
    $stmt1->execute();
    $result1 = $stmt1->fetch(PDO::FETCH_ASSOC);
    $jumlah_tagihan = $result1['jumlah_tagihan'];

    // Query kedua: Total Tagihan yang Sudah Dibayar
    $stmt2 = $dbh->prepare('SELECT COUNT(*) as jumlah_tagihan_paid FROM tagihan WHERE status_tagihan = "PAID"');
    $stmt2->execute();
    $result2 = $stmt2->fetch(PDO::FETCH_ASSOC);
    $jumlah_tagihan_paid = $result2['jumlah_tagihan_paid'];

    // Query ketiga: Total Tagihan yang Belum Dibayar
    $stmt3 = $dbh->prepare('SELECT COUNT(*) as jumlah_tagihan_unpaid FROM tagihan WHERE status_tagihan = "UNPAID"');
    $stmt3->execute();
    $result3 = $stmt3->fetch(PDO::FETCH_ASSOC);
    $jumlah_tagihan_unpaid = $result3['jumlah_tagihan_unpaid'];

   // Query keempat: Total Rupiah Tagihan
    $stmt4 = $dbh->prepare('SELECT SUM(rupiah_tagihan) as total_rupiah_tagihan FROM tagihan');
    $stmt4->execute();
    $result4 = $stmt4->fetch(PDO::FETCH_ASSOC);
    $total_rupiah_tagihan = $result4['total_rupiah_tagihan'];

    // Query kelima: Total Rupiah Tagihan yang Sudah Dibayar
    $stmt5 = $dbh->prepare('SELECT FORMAT(SUM(rupiah_tagihan), 0) as total_rupiah_tagihan_paid FROM tagihan WHERE status_tagihan = "PAID"');
    $stmt5->execute();
    $result5 = $stmt5->fetch(PDO::FETCH_ASSOC);
    $total_rupiah_tagihan_paid = $result5['total_rupiah_tagihan_paid'];

    // Query keenam: Total Rupiah Tagihan yang Belum Dibayar
    $stmt6 = $dbh->prepare('SELECT SUM(rupiah_tagihan) as total_rupiah_tagihan_unpaid FROM tagihan WHERE status_tagihan = "UNPAID"');
    $stmt6->execute();
    $result6 = $stmt6->fetch(PDO::FETCH_ASSOC);
    $total_rupiah_tagihan_unpaid = $result6['total_rupiah_tagihan_unpaid'];
} catch (PDOException $e) {
    echo 'Koneksi gagal: ' . $e->getMessage();
}
?>


<!doctype html>
<html lang="en">
    <head>
        <meta charset="utf-8" />
        <title>Starter Page | Skote - Admin & Dashboard Template</title>
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <meta content="Premium Multipurpose Admin & Dashboard Template" name="description" />
        <meta content="Themesbrand" name="author" />
        <!-- App favicon -->
        <link rel="shortcut icon" href="assets/images/favicon.ico">
        <!-- Bootstrap Css -->
        <link href="assets/css/bootstrap.min.css" id="bootstrap-style" rel="stylesheet" type="text/css" />
        <!-- Icons Css -->
        <link href="assets/css/icons.min.css" rel="stylesheet" type="text/css" />
        <!-- App Css-->
        <link href="assets/css/app.min.css" id="app-style" rel="stylesheet" type="text/css" />
    </head>
    <body data-sidebar="dark">
    <!-- <body data-layout="horizontal" data-topbar="dark"> -->
        <!-- Begin page -->
        <div id="layout-wrapper">
            <header id="page-topbar">
                <div class="navbar-header">
                    <div class="d-flex">
                        <!-- LOGO -->
                        <div class="navbar-brand-box">
                            <a href="index.html" class="logo logo-dark">
                                <span class="logo-sm">
                                    <img src="assets/images/logo.svg" alt="" height="22">
                                </span>
                                <span class="logo-lg">
                                    <img src="assets/images/logo-dark.png" alt="" height="17">
                                </span>
                            </a>

                            <a href="index.html" class="logo logo-light">
                                <span class="logo-sm">
                                    <img src="assets/images/logo-light.svg" alt="" height="22">
                                </span>
                                <span class="logo-lg">
                                    <img src="assets/images/logo-light.png" alt="" height="19">
                                </span>
                            </a>
                        </div>

                        <button type="button" class="btn btn-sm px-3 font-size-16 header-item waves-effect" id="vertical-menu-btn">
                            <i class="fa fa-fw fa-bars"></i>
                        </button> 

                    </div>

                    <div class="d-flex"> 
                        <?php include_once("menu_profile.php"); ?> 
                    </div> 
                </div>
            </header>

            <?php include_once("menu_sidebar.php"); ?>

            

            <!-- ============================================================== -->
            <!-- Start right Content here -->
            <!-- ============================================================== -->
            <div class="main-content">

                <div class="page-content">
                    <div class="container-fluid">

                        <!-- start page title -->
                        <div class="row">
                            <div class="col-12">
                                <div class="page-title-box d-sm-flex align-items-center justify-content-between">
                                    <h4 class="mb-sm-0 font-size-18">Dashboard - SEPTEMBER 2023</h4>

                                    
                                </div>
                            </div>
                        </div>
                        <!-- end page title -->



                        <div class="row">

                            <div class="col-xl-12">
                                <div class="row">
                                    <div class="col-lg-4">
                                        <div class="card mini-stats-wid">
                                            <div class="card-body">
                                                
                                                <div class="d-flex flex-wrap">
                                                    <div class="me-3">
                                                        <p class="text-muted mb-2">Total Tagihan</p>
                                                        <h5 class="mb-0"><?php echo number_format($jumlah_tagihan); ?></h5>
                                                    </div>
    
                                                    <div class="avatar-sm ms-auto">
                                                        <div class="avatar-title bg-light rounded-circle text-primary font-size-20">
                                                            <i class="bx bx-money"></i>
                                                        </div>
                                                    </div>
                                                </div>

                                            </div>
                                        </div>
                                    </div>
                                    
                                    <div class="col-lg-4">
                                        <div class="card blog-stats-wid">
                                            <div class="card-body">

                                                <div class="d-flex flex-wrap">
                                                    <div class="me-3">
                                                        <p class="text-muted mb-2">PAID</p>
                                                        <h5 class="mb-0"><?php echo number_format($jumlah_tagihan_paid); ?></h5>
                                                    </div>
    
                                                    <div class="avatar-sm ms-auto">
                                                        <div class="avatar-title bg-light rounded-circle text-primary font-size-20">
                                                            <i class="bx bx-money"></i>
                                                        </div>
                                                    </div>
                                                </div>
                                                
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-lg-4">
                                        <div class="card blog-stats-wid">
                                            <div class="card-body">
                                                <div class="d-flex flex-wrap">
                                                    <div class="me-3">
                                                        <p class="text-muted mb-2">PAID</p>
                                                        <h5 class="mb-0"><?php echo number_format($jumlah_tagihan_unpaid); ?></h5>
                                                    </div>
    
                                                    <div class="avatar-sm ms-auto">
                                                        <div class="avatar-title bg-light rounded-circle text-primary font-size-20">
                                                            <i class="bx bx-money"></i>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <!-- end row -->

                                 
                            </div>
                            <!-- end col -->

                             

                        </div>
                        <!-- end row -->






                        <div class="row">

                            <div class="col-xl-12">
                                <div class="row">
                                    <div class="col-lg-4">
                                        <div class="card mini-stats-wid">
                                            <div class="card-body">
                                                
                                                <div class="d-flex flex-wrap">
                                                    <div class="me-3">
                                                        <p class="text-muted mb-2">Total Rupiah Tagihan</p>
                                                        <h5 class="mb-0"><?php echo number_format($total_rupiah_tagihan); ?></h5>
                                                    </div>
    
                                                    <div class="avatar-sm ms-auto">
                                                        <div class="avatar-title bg-light rounded-circle text-primary font-size-20">
                                                            <i class="bx bx-money"></i>
                                                        </div>
                                                    </div>
                                                </div>

                                            </div>
                                        </div>
                                    </div>
                                    
                                    <div class="col-lg-4">
                                        <div class="card blog-stats-wid">
                                            <div class="card-body">

                                                <div class="d-flex flex-wrap">
                                                    <div class="me-3">
                                                        <p class="text-muted mb-2">RUPIAH PAID</p>
                                                        <h5 class="mb-0"><?php echo $total_rupiah_tagihan_paid; ?></h5>
                                                    </div>
    
                                                    <div class="avatar-sm ms-auto">
                                                        <div class="avatar-title bg-light rounded-circle text-primary font-size-20">
                                                            <i class="bx bx-money"></i>
                                                        </div>
                                                    </div>
                                                </div>
                                                
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-lg-4">
                                        <div class="card blog-stats-wid">
                                            <div class="card-body">
                                                <div class="d-flex flex-wrap">
                                                    <div class="me-3">
                                                        <p class="text-muted mb-2">RUPIAH UNPAID</p>
                                                        <h5 class="mb-0"><?php echo number_format($total_rupiah_tagihan_unpaid); ?></h5>
                                                    </div>
    
                                                    <div class="avatar-sm ms-auto">
                                                        <div class="avatar-title bg-light rounded-circle text-primary font-size-20">
                                                            <i class="bx bx-money"></i>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <!-- end row -->

                                 
                            </div>
                            <!-- end col -->

                             

                        </div>
                        <!-- end row -->



                         

                    </div> <!-- container-fluid -->
                </div>
                <!-- End Page-content -->

                
                <footer class="footer">
                    <div class="container-fluid">
                        <div class="row">
                            <div class="col-sm-6">
                                <script>document.write(new Date().getFullYear())</script> © Skote.
                            </div>
                            <div class="col-sm-6">
                                <div class="text-sm-end d-none d-sm-block">
                                    Design & Develop by Themesbrand
                                </div>
                            </div>
                        </div>
                    </div>
                </footer>
            </div>
            <!-- end main content-->

        </div>
        <!-- END layout-wrapper -->

         

        <!-- Right bar overlay-->
        <div class="rightbar-overlay"></div>

        <!-- JAVASCRIPT -->
        <script src="assets/libs/jquery/jquery.min.js"></script>
        <script src="assets/libs/bootstrap/js/bootstrap.bundle.min.js"></script>
        <script src="assets/libs/metismenu/metisMenu.min.js"></script>
        <script src="assets/libs/simplebar/simplebar.min.js"></script>
        <script src="assets/libs/node-waves/waves.min.js"></script>

        <!-- Chart JS -->
        <script src="assets/libs/chart.js/Chart.bundle.min.js"></script>
        <script src="assets/js/pages/chartjs.init.js"></script> 

        <script src="assets/js/app.js"></script>

    </body>
</html>