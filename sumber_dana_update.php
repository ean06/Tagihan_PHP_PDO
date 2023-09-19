<?php
require 'functions.php';
session_start();
    if( !isset($_SESSION["login"])){
        header("location: login.php");
        exit;
    }
    
    $query = "SELECT * FROM sumber_dana WHERE id_sumdan='$_GET[id]'";
    $data  = $dbh->prepare($query);
    $data->execute();
    $subdan = $data->fetch(PDO::FETCH_LAZY);

    if( isset($_GET['id'])){
        $query = "SELECT * FROM sumber_dana WHERE id_sumdan = :id";
        $data = $dbh->prepare($query);
        $data->bindParam(':id', $_GET['id'], PDO::PARAM_INT);
        $data->execute();
        $subdan = $data->fetch(PDO::FETCH_OBJ);
        if ($subdan) {
            if (isset($_POST["update"])) {
                $updatedSubdan = [
                    'id_sumdan'         => $_POST['id_sumdan'],
                    'kode_sumdan'       => $_POST['kode_sumdan'],
                    'nama_pendanaan'    => $_POST['nama_pendanaan'],
                    'nama_bank'         => $_POST['nama_bank'],
                    'nama_rekening'     => $_POST['nama_rekening'],
                    'nomor_rekening'    => $_POST['nomor_rekening'],
                    'status_subdan'     => $_POST['status_subdan']
                ];

                //var_dump($subdan);
    
                if (update_subdan($updatedSubdan['id_sumdan'], 
                                        $updatedSubdan['kode_sumdan'], 
                                        $updatedSubdan['nama_pendanaan'], 
                                        $updatedSubdan['nama_bank'], 
                                        $updatedSubdan['nama_rekening'], 
                                        $updatedSubdan['nomor_rekening'], 
                                        $updatedSubdan['status_subdan']) > 0) {
                    echo "<script>
                        alert('Subdan berhasil diupdate!');
                        document.location.href = 'sumber_dana.php';
                    </script>";
                    exit();
                } else {
                    echo "<script>
                        alert('Tidak Ada Data Yang diupdate!');
                        document.location.href = 'sumber_dana.php';
                    </script>";
                    exit();
                }
            }
        } else {
            echo "Sumber Dana  tidak ada.";
            exit();
        }
    }else{
        echo "Invalid ID Sumber Dana";
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
                                    <h4 class="mb-sm-0 font-size-18">Sumber Pendanaan</h4>
                                    <div class="page-title-right">
                                        <ol class="breadcrumb m-0">
                                            <li class="breadcrumb-item"><a href="javascript: void(0);">Sumber Pendanaan</a></li>
                                            <li class="breadcrumb-item active">Update Sumber Pendanaan</li>
                                        </ol>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <!-- end page title -->
                        <div class="row">
                            <div class="col-xl-8">
                                <div class="card">
                                    <div class="card-body">
                                        <h4 class="card-title mb-4">Update Sumber Pendanaan</h4>
                                        <form action="" method="post">
                                            <input type="hidden" name="id_sumdan" value="<?= $subdan->id_sumdan ?>">
                                            <div class="mb-3">
                                                <label for="formrow-firstname-input" class="form-label">Kode</label>
                                                <input type="text" name="kode_sumdan" class="form-control" autocomplete="off" id="formrow-firstname-input" value="<?= $subdan->kode_sumdan ?>">
                                            </div>
                                            <div class="mb-3">
                                                <label for="formrow-firstname-input" class="form-label">Nama Pendanaan</label>
                                                <input type="text" name="nama_pendanaan" class="form-control" autocomplete="off" id="formrow-firstname-input" value="<?= $subdan->nama_pendanaan ?>">
                                            </div>
                                            <div class="mb-3">
                                                <label for="formrow-firstname-input" class="form-label">Bank</label>
                                                <input type="text" name="nama_bank" class="form-control" autocomplete="off" id="formrow-firstname-input" value="<?= $subdan->nama_bank ?>">
                                            </div>
                                            <div class="mb-3">
                                                <label for="formrow-firstname-input" class="form-label">Nama Rekening</label>
                                                <input type="text" name="nama_rekening" class="form-control" autocomplete="off" id="formrow-firstname-input" value="<?= $subdan->nama_rekening ?>">
                                            </div>
                                            <div class="mb-3">
                                                <label for="formrow-firstname-input" class="form-label">Nomor Rekening</label>
                                                <input type="number" min="0" name="nomor_rekening" class="form-control" autocomplete="off" id="formrow-firstname-input" value="<?= $subdan->nomor_rekening ?>">
                                            </div>
                                            <div class="col-lg-8">
                                                    <div class="mb-3">
                                                        <label for="formrow-inputState" class="form-label">Status</label>
                                                        <select id="formrow-inputState" name="status_subdan" class="form-select">
                                                            <option selected value="<?= $subdan->status_subdan ?>" ><?= $subdan->status_subdan ?></option>
                                                            <option value="Pribadi" >Pribadi</option>
                                                            <option value="Perusahaan" >Perusahaan</option>
                                                        </select>
                                                    </div>
                                                </div>
                                            <div>
                                                <button type="submit" name="update" class="btn btn-primary w-md">Submit</button>
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
