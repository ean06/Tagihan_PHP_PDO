<?php
session_start();
if( !isset($_SESSION["nama_lengkap"])){
    header("location: login.php");
    exit;
}
require 'functions.php';

$sql = "SELECT * FROM sumber_dana";
$stmt = $dbh->query($sql);
$subdans = $stmt->fetchAll(PDO::FETCH_ASSOC);

$sql1 = "SELECT * FROM kategori";
$stmt1 = $dbh->query($sql1);
$kategoris = $stmt1->fetchAll(PDO::FETCH_ASSOC);

if (isset($_POST["filter"])) {
    $sumdan   = $_POST['sumdan'];
    $kategori = $_POST['kategori'];
    $status   = $_POST['status'];
    $bulan    = $_POST['bulan'];
    $tahun    = $_POST['tahun'];

    $keyword = [
        'sumdan'   => $sumdan,
        'kategori' => $kategori,
        'status'   => $status,
        'bulan'    => $bulan,
        'tahun'    => $tahun
    ];

    $tagihans = filter($bulan, $tahun, $sumdan, $kategori, $status);
} else {
    $sql2 = "SELECT * FROM tagihan";
    $stmt2 = $dbh->query($sql2);
    $tagihans = $stmt2->fetchAll(PDO::FETCH_ASSOC);
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
                                    <h4 class="mb-sm-0 font-size-18">Tagihan</h4>
                                    <div class="page-title-right">
                                        <ol class="breadcrumb m-0">
                                            <li class="breadcrumb-item"><a href="javascript: void(0);">Tagihan</a></li>
                                            <li class="breadcrumb-item active">Lihat Tagihan</li>
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
                                        <form action="" method="post">
                                            <div class="row">
                                                <div class="col-lg-3">
                                                    <div class="mb-3">
                                                        <label for="formrow-inputState" class="form-label">Sumber Pendanaan</label>
                                                        <select id="formrow-inputState" name="sumdan" class="form-select">
                                                            <option value="" selected>ALL</option>
                                                                <option value="Pribadi">Pribadi</option> 
                                                                <option value="Perusahaan">Perusahaan</option> 
                                                        </select>
                                                    </div>
                                                </div>
                                                <div class="col-lg-3">
                                                    <div class="mb-3">
                                                        <label for="formrow-inputState" class="form-label">Kategori</label>
                                                        <select id="formrow-inputState" name="kategori" class="form-select">
                                                            <option selected value="">ALL</option>
                                                            <?php foreach ($kategoris as $kategori) : ?>
                                                            <option value="<?= $kategori['kategori'] ?>"><?= $kategori['kategori'] ?></option>
                                                            <?php endforeach; ?>
                                                        </select>
                                                    </div>
                                                </div>
                                                <div class="col-lg-2">
                                                    <div class="mb-3">
                                                        <label for="formrow-inputState" class="form-label">Status</label>
                                                        <select id="formrow-inputState" name="status" class="form-select">
                                                            <option value="" selected>ALL</option>
                                                            <option value="PAID">PAID</option>
                                                            <option value="UNPAID">UNPAID</option>
                                                        </select>
                                                    </div>
                                                </div>
                                                <div class="col-lg-2">
                                                    <div class="mb-3">
                                                        <label for="formrow-inputState" class="form-label">Bulan</label>
                                                        <select id="formrow-inputState" name="bulan" class="form-select">
                                                            <option value="" selected>ALL</option>
                                                                <option value="01">Januari</option>
                                                                <option value="02">Februari</option>
                                                                <option value="03">Maret</option>
                                                                <option value="04">April</option>
                                                                <option value="05">Mei</option>
                                                                <option value="06">Juni</option>
                                                                <option value="07">Juli</option>
                                                                <option value="08">Agustus</option>
                                                                <option value="09">September</option>
                                                                <option value="10">Oktober</option>
                                                                <option value="11">November</option>
                                                                <option value="12">Desember</option>
                                                        </select>
                                                    </div>
                                                </div>
                                                <div class="col-lg-2">
                                                    <div class="mb-3">
                                                        <label for="formrow-inputState" class="form-label">Tahun</label>
                                                        <select id="formrow-inputState" name="tahun" class="form-select">
                                                            <option value="" selected>ALL</option>
                                                                <option value="2020">2020</option>
                                                                <option value="2021">2021</option>
                                                                <option value="2022">2022</option>
                                                                <option value="2023">2023</option>
                                                                <option value="2024">2024</option>
                                                                <option value="2025">2025</option>
                                                        </select>
                                                    </div>
                                                </div>
                                            </div>
                                            <div>
                                                <button type="submit" name="filter" class="btn btn-primary w-md">Filter</button>
                                            </div>
                                        </form>
                                        <!-- <div class="col-lg-2">
                                                <div class="mb-3">
                                                <select id="year" name="year" required>
                                                        <?php
                                                        // Generate a list of years from a start year to an end year
                                                        $startYear = 2020;
                                                        $endYear = date("Y"); // Get the current year
                                                        for ($year = $startYear; $year <= $endYear; $year++) {
                                                        echo "<option value=\"$year\">$year</option>";
                                                        }
                                                        ?>
                                                    </select>
                                                </div>
                                            </div> -->
                                    </div>
                                    <!-- end card body -->
                                </div>
                                <!-- end card -->
                            </div>
                            <!-- end col -->
                        </div>
                        <!-- end row -->
                        <div class="col-xl-12">
                                <div class="card">
                                    <div class="card-body">
                                        <div class="table-responsive">
                                            <table class="table table-striped  mb-0">
                                                <thead class="table-light">
                                                    <tr>
                                                        <th>#</th>
                                                        <th>Sumber Pendanaan</th>
                                                        <th>Kategori</th>
                                                        <th>Termin</th>
                                                        <th>Tagihan</th>
                                                        <th>Rupiah Tagihan</th>
                                                        <th>Bank</th>
                                                        <th>Nama Tujuan</th>
                                                        <th>Nomor Rekening</th>
                                                        <th>Virtual Akun</th>
                                                        <th>Tanggal Jatuh Tempo</th>
                                                        <th>Tanggal Pembayaran</th>
                                                        <th>Next Pembayaran</th>
                                                        <th>Status</th>
                                                        <th>Bukti Bayar</th>
                                                        <th>Action</th>
                                                    </tr>
                                                </thead>
                                                <tbody>
                                                    <?php $i=1; ?>
                                                    <?php foreach ($tagihans as $tagihan) : ?>
                                                    <tr>
                                                        <th><?= $i; ?></th>
                                                        <td><?= $tagihan['kode_sumdan'] ?></td>
                                                        <td><?= $tagihan['kode_kategori'] ?></td>
                                                        <td><?= $tagihan['tagihan_termin'] ?></td>
                                                        <td><?= $tagihan['nama_tagihan'] ?></td>
                                                        <td><?= $tagihan['rupiah_tagihan'] ?></td>
                                                        <td><?= $tagihan['rekening_tujuan_bank'] ?></td>
                                                        <td><?= $tagihan['rekening_tujuan_nama'] ?></td>
                                                        <td><?= $tagihan['rekening_tujuan_norek'] ?></td>
                                                        <td><?= $tagihan['rekening_tujuan_va'] ?></td>
                                                        <td><?= $tagihan['tanggal_jatuh_tempo'] ?></td>
                                                        <td><?= $tagihan['tanggal_pembayaran'] ?></td>  
                                                        <td><?= $tagihan['tanggal_tagihan_next'] ?></td>
                                                        
                                                        <!-- bikin pake if else -->
                                                        <?php if( $tagihan['tanggal_pembayaran'] == 'Belum Bayar') :?>
                                                            <td> 
                                                                <button type="button" class="btn btn-sm btn-danger waves-effect waves-light">UNPAID</button>                                                            
                                                            </td>
                                                            <td>
                                                                <a href="tagihan_upload.php?id=<?= $tagihan['id_tagihan'] ?>"  class="btn btn-sm btn-outline-dark waves-effect waves-light">Upload Bukti Bayar</a>
                                                            </td>
                                                        <?php else :?>
                                                            <td>
                                                                <button type="button" class="btn btn-sm btn-success waves-effect waves-light">PAID</button>
                                                            </td> 
                                                            <td> 
                                                                <button type="button" class="btn btn-sm btn-primary waves-effect waves-light w-sm">
                                                                    <a href="bukti_pembayaran.php?id=<?php echo $tagihan['id_tagihan']; ?>" class="btn btn-sm btn-primary waves-effect waves-light w-sm" target="_blank" >
                                                                        <i class="mdi mdi-download d-block font-size-16"></i> Download
                                                                    </a>
                                                                </button>  
                                                            </td>
                                                        <?php endif; ?>
                                                        <td>
                                                            <a href="tagihan_edit.php?id=<?= $tagihan['id_tagihan'] ?>"  class="btn btn-sm btn-outline-dark waves-effect waves-light">Edit</a>
                                                            <a href="tagihan_delete.php?id=<?= $tagihan['id_tagihan'] ?>" onclick="return confirm('Apakah Anda Yakin Menghapus Data Ini ?')" class="btn btn-sm btn-outline-danger waves-effect waves-light">Delete</a>
                                                        </td>
                                                        <!-- end -->
                                                    </tr>
                                                        <?php $i++ ?>
                                                    <?php endforeach; ?>
                                                </tbody>   
                                            </table>
                                        </div>
                                    </div>
                                </div>
                            </div>
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
