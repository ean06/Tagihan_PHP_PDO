<?php
session_start();
if( !isset($_SESSION["nama_lengkap"])){
    header("location: login.php");
    exit;
}
    
$sql = "SELECT * FROM pengguna";
$stmt = $dbh->query($sql);
$penggunas = $stmt->fetchAll(PDO::FETCH_ASSOC);

$sql1 = "SELECT * FROM sumber_dana";
$stmt1 = $dbh->query($sql1);
$subdans = $stmt1->fetchAll(PDO::FETCH_ASSOC);

$sql2 = "SELECT * FROM kategori";
$stmt2 = $dbh->query($sql2);
$kategoris = $stmt2->fetchAll(PDO::FETCH_ASSOC);

if( isset($_POST["add"]) ) {
        if( add_tagihan($_POST) > 0 ) {
        echo"<script>
                alert('Tagihan berhasil ditambahkan!');
                document.location.href = 'tagihan.php';
            </script>";
            exit();
        } else {
            echo"<script>
                    alert('Tagihan gagal ditambahkan!');
                    document.location.href = 'tagihan_add.php';
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
                                    <h4 class="mb-sm-0 font-size-18">Tagihan</h4>
                                    <div class="page-title-right">
                                        <ol class="breadcrumb m-0">
                                            <li class="breadcrumb-item"><a href="javascript: void(0);">Tagihan</a></li>
                                            <li class="breadcrumb-item active">Tambah Tagihan</li>
                                        </ol>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <!-- end page title -->
                        <div class="row">
                            <div class="col-xl-10">
                                <div class="card">
                                    <div class="card-body">
                                        <h4 class="card-title mb-4">Tambah Tagihan</h4>
                                        <form action="" method="post">
                                        <input type="hidden" name="tanggal_pembayaran" value="Belum Bayar">
                                        <input type="hidden" name="status_tagihan" value="UNPAID">
                                            <div class="col-lg-8">
                                                <div class="mb-3">
                                                    <label for="formrow-inputState" class="form-label">Pengguna</label>
                                                    <select id="formrow-inputState" name="id_pengguna" class="form-select">
                                                        <option disabled selected>--- Silahkan Pilih Pengguna ---</option>
                                                        <?php foreach ($penggunas as $pengguna) : ?>
                                                            <option value="<?=$pengguna['id_pengguna']?>"> <?=$pengguna['nama_lengkap']?></option> 
                                                        <?php endforeach; ?> 
                                                    </select>
                                                </div>
                                            </div>
                                            <div class="col-lg-8">
                                                <div class="mb-3">
                                                        <label for="formrow-inputState" class="form-label">Sumber Pendanaan</label>
                                                        <select id="formrow-inputState" name="kode_sumdan" class="form-select">
                                                            <option disabled selected>--- Silahkan Pilih Sumber Pendanaan ---</option>
                                                            <?php foreach ($subdans as $subdan) : ?>
                                                                <option value="<?=$subdan['status_subdan']?>"><?=$subdan['nama_pendanaan']?></option> 
                                                            <?php endforeach; ?>
                                                        </select>
                                                    </div>
                                                </div>
                                                <div class="col-lg-8">
                                                    <div class="mb-3">
                                                        <label for="formrow-inputState" class="form-label">Kategori</label>
                                                        <select id="formrow-inputState" name="kode_kategori" class="form-select">
                                                            <option disabled selected>--- Silahkan Pilih kategori ---</option>
                                                            <?php foreach ($kategoris as $kategori) : ?>
                                                                <option value="<?=$kategori['kategori']?>"><?=$kategori['kategori']?></option> 
                                                            <?php endforeach; ?>
                                                        </select>
                                                    </div>
                                                </div>
                                                <div class="col-lg-8">
                                                    <div class="mb-3">
                                                        <label for="formrow-inputState" class="form-label">Termin</label>
                                                        <select id="formrow-inputState" name="tagihan_termin" class="form-select">
                                                            <option disabled selected>--- Silahkan Piliih Termin ---</option>
                                                            <option value="0">Sekali </option>
                                                            <option value="1">1 Bulanan</option>
                                                            <option value="2">2 Bulanan</option>
                                                            <option value="3">3 Bulanan</option>
                                                        </select>
                                                    </div>
                                                </div>
                                            <div class="mb-3">
                                                <label for="formrow-firstname-input" class="form-label">Tagihan</label>
                                                <input type="text" class="form-control" name="nama_tagihan" id="formrow-firstname-input" autocomplete="off" placeholder="Nama Tagihan" required>
                                            </div>
                                            <div class="row">
                                                <div class="col-md-6">
                                                    <div class="mb-3">
                                                        <label for="formrow-email-input" class="form-label">Rupiah Tagihan</label>
                                                        <input type="number" class="form-control" min="0" name="rupiah_tagihan" id="formrow-email-input" placeholder="Rupiah Tagihan" required>
                                                    </div>
                                                </div>                      
                                            </div>
                                            <div class="row">
                                                <div class="col-lg-4">
                                                    <div class="mb-3">
                                                        <label for="formrow-inputCity" class="form-label">Bank</label>
                                                        <input type="text" class="form-control" name="rekening_tujuan_bank" autocomplete="off" id="formrow-inputCity" placeholder="Masukkan Bank" required>
                                                    </div>
                                                </div>
                                                <div class="col-lg-4">
                                                    <div class="mb-3">
                                                        <label for="formrow-inputZip" class="form-label">Nomor Rekening</label>
                                                        <input type="text" class="form-control" name="rekening_tujuan_norek" autocomplete="off" id="formrow-inputZip" placeholder="Masukkan Rekening" required>
                                                    </div>
                                                </div>
                                                <div class="col-lg-4">
                                                    <div class="mb-3">
                                                        <label for="formrow-inputZip" class="form-label">Nama Tujuan</label>
                                                        <input type="text" class="form-control" name="rekening_tujuan_nama" autocomplete="off" id="formrow-inputZip" placeholder="Masukkan Tujuan" required>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="row">
                                                
                                                <div class="col-md-6">
                                                    <div class="mb-3">
                                                        <label for="formrow-email-input" class="form-label">Virtual Akun</label>
                                                        <input type="number" class="form-control" name="rekening_tujuan_va" id="formrow-email-input" placeholder="Masukan Virtual Akun" required>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="row">
                                                <div class="col-lg-4">
                                                    <div class="mb-3">
                                                        <label for="formrow-inputCity" class="form-label">Tanggal Jatuh Tempo</label>
                                                        <input type="date" class="form-control" name="tanggal_jatuh_tempo" id="formrow-inputCity" placeholder="Masukkan Bank" required>
                                                    </div>
                                                </div>
                                                <div class="col-lg-4">
                                                    <div class="mb-3">
                                                        <label for="formrow-inputZip" class="form-label">Next Pembayaran</label>
                                                        <input type="date" class="form-control" name="tanggal_tagihan_next" id="formrow-inputZip" placeholder="Masukkan Rekening" required>
                                                    </div>
                                                </div>
                                            </div>
                                            <div>
                                                <button type="submit" name="add" class="btn btn-primary w-md">Submit</button>
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
