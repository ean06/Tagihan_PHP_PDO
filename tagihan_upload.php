<?php
session_start();
if( !isset($_SESSION["nama_lengkap"])){
    header("location: login.php");
    exit;
}
require 'functions.php';

$query = "SELECT * FROM tagihan WHERE id_tagihan='$_GET[id]'";
$data  = $dbh->prepare($query);
$data->execute();
$tagihan = $data->fetch(PDO::FETCH_LAZY);
if(isset($_GET['id'])) {
    $query = "SELECT * FROM tagihan WHERE id_tagihan=:id";
    $data = $dbh->prepare($query);
    $data->bindParam(':id', $_GET['id'], PDO::PARAM_INT);
    $data->execute();
    $tagihan = $data->fetch(PDO::FETCH_OBJ);

    if($tagihan) {
        if(isset($_POST["upload"])) {
            $updatedTagihan = [
                'id_tagihan'            => $_POST['id_tagihan'],
                'id_pengguna'           => $_POST['id_pengguna'],
                'kode_sumdan'           => $_POST['kode_sumdan'],
                'kode_kategori'         => $_POST['kode_kategori'],
                'tagihan_termin'        => $_POST['tagihan_termin'],
                'nama_tagihan'          => $_POST['nama_tagihan'],
                'rupiah_tagihan'        => $_POST['rupiah_tagihan'],
                'rekening_tujuan_bank'  => $_POST['rekening_tujuan_bank'],
                'rekening_tujuan_norek' => $_POST['rekening_tujuan_norek'],
                'rekening_tujuan_nama'  => $_POST['rekening_tujuan_nama'],
                'rekening_tujuan_va'    => $_POST['rekening_tujuan_va'],
                'tanggal_jatuh_tempo'   => $_POST['tanggal_jatuh_tempo'],
                'tanggal_tagihan_next'  => $_POST['tanggal_tagihan_next'],
                'tanggal_pembayaran'    => date('Y-m-d'),
                'tagihan_keterangan'    => $_POST['tagihan_keterangan'],
                'status_tagihan'        => $_POST['status_tagihan']
            ];
            $imageData = file_get_contents($_FILES['bukti_pembayaran']['tmp_name']);


            if(upload_tagihan(
                $updatedTagihan['id_tagihan'],
                $updatedTagihan['tanggal_pembayaran'],
                $imageData,
                $updatedTagihan['tagihan_keterangan'],
                $updatedTagihan['status_tagihan']
            ) > 0) {
                echo "<script>
                    alert('Tagihan berhasil dibayar!');
                    document.location.href = 'tagihan.php';
                </script>";
                exit();
            } else {
                echo "<script>
                    alert('Tagihan gagal dibayar!');
                    document.location.href = 'tagihan_upload.php?id={$tagihan->id_tagihan}';
                </script>";
                exit();
            }
        }
    } else {
        echo "Tagihan tidak ada.";
        exit();
    }
} else {
    echo "Invalid ID Tagihan";
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
                                    <h4 class="mb-sm-0 font-size-18">Upload Tagihan</h4>
                                    <div class="page-title-right">
                                        <ol class="breadcrumb m-0">
                                            <li class="breadcrumb-item"><a href="javascript: void(0);">Tagihan</a></li>
                                            <li class="breadcrumb-item active">Upload Tagihan</li>
                                        </ol>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <!-- end page title -->
                        <div class="row">
                            <div class="col-xl-12">
                                <div class="card">
                                    <div class="card-body">
                                        <h4 class="card-title mb-4">Upload Tagihan</h4>
                                        <form action="" method="post" enctype="multipart/form-data">
                                            <input type="hidden" name="id_tagihan" value="<?= $tagihan->id_tagihan ?>">
                                            <input type="hidden" name="id_pengguna" value="<?= $tagihan->id_pengguna ?>">
                                            <input type="hidden" name="status_tagihan" value="PAID">
                                            <div class="row">
                                                <div class="col-lg-4">
                                                    <div class="mb-3">
                                                        <label for="formrow-inputCity" class="form-label">Kategori</label>
                                                        <input type="text" class="form-control" name="kode_kategori" id="formrow-inputCity" value="<?= $tagihan->kode_kategori ?>" disabled>
                                                    </div>
                                                </div>
                                                
                                                <div class="col-lg-4">
                                                    <div class="mb-3">
                                                        <label for="formrow-inputZip" class="form-label">Sumber Pendanaan</label>
                                                        <input type="text" class="form-control" name="kode_sumdan" id="formrow-inputZip" value="<?= $tagihan->kode_sumdan ?>" disabled>
                                                    </div>
                                                </div>
                                                <div class="col-lg-4">
                                                    <div class="mb-3">
                                                        <label for="formrow-inputZip" class="form-label">Termin</label>
                                                        <input type="text" class="form-control" name="tagihan_termin" id="formrow-inputZip" value="<?= $tagihan->tagihan_termin ?>" disabled>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="mb-3">
                                                <label for="formrow-firstname-input" class="form-label">Tagihan</label>
                                                <input type="text" class="form-control" name="nama_tagihan" id="formrow-firstname-input" value="<?= $tagihan->nama_tagihan ?>"disabled>
                                            </div>
                                            <div class="row">
                                                <div class="col-md-4">
                                                    <div class="mb-3">
                                                        <label for="formrow-email-input" class="form-label">Rupiah Tagihan</label>
                                                        <input type="number" class="form-control" name="rupiah_tagihan" id="formrow-email-input" value="<?= $tagihan->rupiah_tagihan ?>" disabled>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="row">
                                                <div class="col-lg-4">
                                                    <div class="mb-3">
                                                        <label for="formrow-inputCity" class="form-label">Bank</label>
                                                        <input type="text" class="form-control" name="rekening_tujuan_bank" id="formrow-inputCity" value="<?= $tagihan->rekening_tujuan_bank ?>" disabled>
                                                    </div>
                                                </div>
                                                <div class="col-lg-4">
                                                    <div class="mb-3">
                                                        <label for="formrow-inputZip" class="form-label">Nomor Rekening</label>
                                                        <input type="text" class="form-control" name="rekening_tujuan_norek" id="formrow-inputZip" value="<?= $tagihan->rekening_tujuan_norek ?>" disabled>
                                                    </div>
                                                </div>
                                                <div class="col-lg-4">
                                                    <div class="mb-3">
                                                        <label for="formrow-inputZip" class="form-label">Nama Tujuan</label>
                                                        <input type="text" class="form-control" name="rekening_tujuan_nama" id="formrow-inputZip" value="<?= $tagihan->rekening_tujuan_nama ?>" disabled>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="row">
                                                <div class="col-md-6">
                                                    <div class="mb-3">
                                                        <label for="formrow-email-input" class="form-label">Virtual Akun</label>
                                                        <input type="number" class="form-control" name="rekening_tujuan_va" id="formrow-email-input" value="<?= $tagihan->rekening_tujuan_va ?>" disabled>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="row">
                                                <div class="col-lg-4">
                                                    <div class="mb-3">
                                                        <label for="formrow-inputCity" class="form-label">Tanggal Jatuh Tempo</label>
                                                        <input type="date" class="form-control" name="tanggal_jatuh_tempo" id="formrow-inputCity" value="<?= $tagihan->tanggal_jatuh_tempo ?>" disabled>
                                                    </div>
                                                </div>
                                                <div class="col-lg-4">
                                                    <div class="mb-3">
                                                        <label for="formrow-inputZip" class="form-label">Next Pembayaran</label>
                                                        <input type="date" class="form-control" name="tanggal_tagihan_next" id="formrow-inputZip" value="<?= $tagihan->tanggal_tagihan_next ?>" disabled>
                                                    </div>
                                                </div> 
                                            </div>
                                                <div class="col-lg-8">
                                                    <div class="mb-3">
                                                        <label for="formrow-inputZip" class="form-label">Upload Bukti Pembayaran</label>
                                                        <input class="form-control" name="bukti_pembayaran" type="file" id="formFile" value="<?= $tagihan->bukti_pembayaran ?>" required>
                                                    </div>
                                                </div> 
                                            </div>
                                                <div class="mt-3">
                                                    <label class="mb-1">Keterangan</label>
                                                    <textarea id="textarea" class="form-control" name="tagihan_keterangan" maxlength="225" rows="3"
                                                        placeholder="This textarea has a limit of 225 chars." value="<?= $tagihan->keterangan ?>" required></textarea>
                                                </div>
                                                    <BR>
                                            <div>
                                                <button type="submit" name="upload" class="btn btn-primary w-md">Submit</button>
                                            </div>
                                        </form>
                                    </div>
                                    <!-- end card body -->
                                </div>
                                <!-- end card -->
                            </div>
                            <!-- end col -->
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
