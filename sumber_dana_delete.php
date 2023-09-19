<?php
session_start();
if( !isset($_SESSION["nama_lengkap"])){
    header("location: login.php");
    exit;
}
require 'functions.php';
    
        if (isset($_GET['id'])) {
            if (delete_subdan($_GET['id']) > 0) {
                echo "<script>
                        alert('Subdan Berhasil dihapus!');
                        document.location.href = 'sumber_dana.php';
                    </script>";
                exit();
            } else {
                echo "<script>
                        alert('Subdan Gagal dihapus!');
                        document.location.href = 'sumber_dana.php';
                    </script>";
                exit();
            }
        } else {
            echo "Invalid ID Sumber Dana.";
            exit();
        }
?>