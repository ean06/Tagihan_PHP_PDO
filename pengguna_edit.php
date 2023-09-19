<?php
session_start();
if( !isset($_SESSION["nama_lengkap"])){
    header("location: login.php");
    exit;
}
require 'functions.php';

if(isset($_GET['id']) && !empty($_GET['id'])) {
    $id = $_GET['id'];

    // Ambil data pengguna dari database
    $pengguna = get_pengguna($dbh, $id);

    if($pengguna) {
        // Cek apakah formulir telah disubmit
        if($_SERVER['REQUEST_METHOD'] === 'POST') {
            $nama_lengkap = $_POST['nama_lengkap'];
            $email = $_POST['email'];
            $handphone = $_POST['handphone'];
            $username = $_POST['username'];
            $password = $_POST['password'];
            $hak_akses = $_POST['hak_akses'];

            // Lakukan validasi data jika diperlukan

            // Proses update pengguna
            $result = edit_pengguna($dbh, $id, $nama_lengkap, $email, $handphone, $username, $password, $hak_akses);

            if (strpos($result, "Error") !== false) {
                echo "Terjadi kesalahan: " . $result;
            } else {
                echo $result;
                header("Location: pengguna.php");
                exit();
            }
        }

    } else {
        echo "Pengguna dengan ID tersebut tidak ditemukan";
    }
} else {
    echo "ID pengguna tidak valid";
}
?>


<!doctype html>
<html lang="en">

<head>

    <meta charset="utf-8" />
    <title>Edit Pengguna</title>
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

                    <button type="button" class="btn btn-sm px-3 font-size-16 header-item waves-effect"
                        id="vertical-menu-btn">
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
                            <div
                                class="page-title-box d-sm-flex align-items-center justify-content-between">
                                <h4 class="mb-sm-0 font-size-18">Edit Pengguna</h4>

                                <div class="page-title-right">
                                    <ol class="breadcrumb m-0">
                                        <li class="breadcrumb-item"><a href="javascript: void(0);">Pengguna</a>
                                        </li>
                                        <li class="breadcrumb-item active">Edit Pengguna</li>
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
                                    <h4 class="card-title mb-4">Edit Pengguna</h4>


                                    <form action="pengguna_edit.php?id=<?php echo $id; ?>" method="post">

                                        <div class="mb-3">
                                            <label for="formrow-firstname-input" class="form-label">Nama Lengkap</label>
                                            <input type="text" class="form-control" id="formrow-firstname-input" placeholder="Masukkan Nama Lengkap" name="nama_lengkap" value="<?php echo isset($pengguna['nama_lengkap']) ? $pengguna['nama_lengkap'] : ''; ?>">
                                        </div>

                                        <div class="mb-3">
                                            <label for="formrow-email-input" class="form-label">Email</label>
                                            <input type="text" class="form-control" id="formrow-email-input" placeholder="Masukkan Email" name="email" value="<?php echo isset($pengguna['email']) ? $pengguna['email'] : ''; ?>">
                                        </div>

                                        <div class="mb-3">
                                            <label for="formrow-handphone-input" class="form-label">Handphone</label>
                                            <input type="text" class="form-control" id="formrow-handphone-input" placeholder="Masukkan Handphone" name="handphone" value="<?php echo isset($pengguna['handphone']) ? $pengguna['handphone'] : ''; ?>">
                                        </div>

                                        <div class="mb-3">
                                            <label for="formrow-username-input" class="form-label">Username</label>
                                            <input type="text" class="form-control" id="formrow-username-input" placeholder="Masukkan Username" name="username" value="<?php echo isset($pengguna['username']) ? $pengguna['username'] : ''; ?>">
                                        </div>

                                        <div class="mb-3">
                                            <label for="formrow-password-input" class="form-label">Password</label>
                                            <input type="password" class="form-control" id="formrow-password-input" placeholder="Masukkan Password" name="password" value="<?php echo isset($pengguna['password']) ? $pengguna['password'] : ''; ?>">
                                        </div>

                                        <div class="col-lg-8">
                                            <div class="mb-3">
                                                <label for="formrow-inputState" class="form-label">Hak Akses</label>
                                                <select id="formrow-inputState" class="form-select" name="hak_akses">
                                                    <option value="ADMIN" <?php echo (isset($pengguna['hak_akses']) && $pengguna['hak_akses'] === 'ADMIN') ? 'selected' : ''; ?>>ADMIN</option>
                                                    <option value="MEMBER" <?php echo (isset($pengguna['hak_akses']) && $pengguna['hak_akses'] === 'MEMBER') ? 'selected' : ''; ?>>MEMBER</option>
                                                </select>
                                            </div>
                                        </div>

                                        <div>
                                            <button type="submit" class="btn btn-primary w-md" name="update">Submit</button>
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
