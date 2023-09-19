<?php
session_start();
if( !isset($_SESSION["nama_lengkap"])){
    header("location: login.php");
    exit;
}
?>
<!-- ========== Left Sidebar Start ========== -->
            <div class="vertical-menu">
                <div data-simplebar class="h-100">
                    <!--- Sidemenu -->
                    <div id="sidebar-menu">
                        <!-- Left Menu Start -->
                        <ul class="metismenu list-unstyled" id="side-menu">
                            <li class="menu-title" key="t-menu">Dashboard</li>
                            <li>
                                <a href="dashboard.php" class="waves-effect">
                                    <i class="bx bx-calendar"></i>
                                    <span key="t-calendar">Dashboard</span>
                                </a>
                            </li>
                            <li class="menu-title" key="t-apps">Data</li>
                                <?php 
                                    if ($_SESSION["hak_akses"]=="ADMIN") :
                                ?>
                            <li>
                                <a href="javascript: void(0);" class="has-arrow waves-effect">
                                    <i class="bx bx-task"></i>
                                    <span key="t-tasks">Pengguna</span>
                                </a>
                                <ul class="sub-menu" aria-expanded="false">
                                    <li><a href="pengguna.php" key="t-kanban-board">Lihat Pengguna</a></li> 
                                    <li><a href="pengguna_add.php" key="t-task-list">Tambah Penggguna</a></li>
                                </ul>
                            </li>
                            <li>
                                <a href="javascript: void(0);" class="has-arrow waves-effect">
                                    <i class="bx bx-task"></i>
                                    <span key="t-tasks">Kategori</span>
                                </a>
                                <ul class="sub-menu" aria-expanded="false">
                                    <li><a href="kategori.php" key="t-kanban-board">Lihat Kategori </a></li>
                                    <li><a href="kategori_add.php" key="t-task-list">Tambah Kategori </a></li>
                                </ul>
                            </li>
                            <li>
                                <a href="javascript: void(0);" class="has-arrow waves-effect">
                                    <i class="bx bx-task"></i>
                                    <span key="t-tasks">Sumber Pendanaan</span>
                                </a>
                                <ul class="sub-menu" aria-expanded="false">
                                    <li><a href="sumber_dana.php" key="t-kanban-board">Lihat Sumber Pendanaan </a></li>
                                    <li><a href="sumber_pendanaan_add.php" key="t-task-list">Tambah Sumber Pendanaan </a></li>
                                </ul>
                            </li>
                            <?php endif; ?>
                            <li>
                                <a href="javascript: void(0);" class="has-arrow waves-effect">
                                    <i class="bx bx-task"></i>
                                    <span key="t-tasks">Tagihan</span>
                                </a>
                                <ul class="sub-menu" aria-expanded="false">
                                    <li><a href="tagihan.php" key="t-kanban-board">Lihat Tagihan</a></li> 
                                    <li><a href="tagihan_add.php" key="t-task-list">Tambah Tagihan</a></li>
                                </ul>
                            </li>
                            <li>
                                <a href="logout.php" class="waves-effect">
                                    <i class="bx bx-calendar"></i>
                                    <span key="t-calendar">Logout</span>
                                </a>
                            </li>
                        </ul>
                    </div>
                    <!-- Sidebar -->
                </div>
            </div>
            <!-- Left Sidebar End -->