<?php
session_start();
if( !isset($_SESSION["nama_lengkap"])){
    header("location: login.php");
    exit;
}
        
        if (isset($_GET['id'])) {
            if (delete_kategori($_GET['id']) > 0) {
                echo "<script>
                        alert('Kategori Berhasil dihapus!');
                        document.location.href = 'kategori.php';
                    </script>";
                exit();
            } else {
                echo "<script>
                        alert('Kategori Gagal dihapus!');
                        document.location.href = 'kategori.php';
                    </script>";
                exit();
            }
        } else {
            echo "Invalid ID Kategori.";
            exit();
        }
?>