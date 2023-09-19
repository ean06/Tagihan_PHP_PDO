<?php
session_start();
if( !isset($_SESSION["nama_lengkap"])){
    header("location: login.php");
    exit;
}
require 'functions.php';



if( isset($_POST["tambah"]) ) {
   
        if( add_pengguna($_POST) > 0 ) {
        echo"<script>
                alert('Pengguna berhasil ditambahkan!');
                document.location.href = 'pengguna.php';
            </script>";
            exit();
        } else {
            echo"<script>
                    alert('Pengguna gagal ditambahkan!');
                    document.location.href = 'pengguna_add.php';
                </script>";
        }
    }

?>

<!doctype html>
<html lang="en">

    <head>
        
        <meta charset="utf-8" />
        <title>Tagihan</title>
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
                                    <h4 class="mb-sm-0 font-size-18">Pengguna</h4>

                                    <div class="page-title-right">
                                        <ol class="breadcrumb m-0">
                                            <li class="breadcrumb-item"><a href="javascript: void(0);">Pengguna</a></li>
                                            <li class="breadcrumb-item active">Tambah Pengguna</li>
                                        </ol>
                                    </div>

                                </div>
                            </div>
                        </div>
                        <!-- end page title -->


                        <div class="row">
                            <div class="col-xl-6">
                                <div class="card">
                                    <div class="card-body">
                                        <h4 class="card-title mb-4">Tambah Pengguna</h4>

                                        <form action="" method="post">
                                            <div class="mb-3">
                                                <label for="formrow-firstname-input" class="form-label">Nama Lengkap</label>
                                                <input type="text" class="form-control" id="formrow-firstname-input" placeholder="Masukkan Nama Lengkap" name="nama_lengkap">
                                            </div>

                                            <div class="mb-3">
                                                <label for="formrow-firstname-input" class="form-label">Email</label>
                                                <input type="text" class="form-control" id="formrow-firstname-input" placeholder="Masukkan Email" name="email">
                                            </div>

                                            <div class="mb-3">
                                                <label for="formrow-firstname-input" class="form-label">Handphone</label>
                                                <input type="text" class="form-control" id="formrow-firstname-input" placeholder="Masukkan Handphone" name="handphone">
                                            </div>

                                            <div class="mb-3">
                                                <label for="formrow-firstname-input" class="form-label">Username</label>
                                                <input type="text" class="form-control" id="formrow-firstname-input" placeholder="Masukkan Username" name="username">
                                            </div>

                                            <div class="mb-3">
                                                <label for="formrow-firstname-input" class="form-label">Password</label>
                                                <input type="text" class="form-control" id="formrow-firstname-input" placeholder="Masukkan Password" name="password">
                                            </div>

                                            <div class="col-lg-8">
                                                    <div class="mb-3">
                                                        <label for="formrow-inputState" class="form-label">Hak Akses</label>
                                                        <select id="formrow-inputState" class="form-select" name="hak_akses">
                                                            <option selected value="ADMIN">ADMIN</option>
                                                            <option value="MEMBER">MEMBER</option>
                                                        </select>
                                                    </div>
                                            </div>

                                             
                                            <div>
                                                <button type="submit" class="btn btn-primary w-md" name="tambah">Submit</button>
                                            </div>
                                        </form>
                                    </div>
                                    <!-- end card body -->
                                </div>
                                <!-- end card -->
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

        <script src="assets/js/app.js"></script>

    </body>
</html>
