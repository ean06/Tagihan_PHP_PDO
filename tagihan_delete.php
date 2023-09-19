<?php
    session_start();
    if( !isset($_SESSION["nama_lengkap"])){
        header("location: login.php");
        exit;
    }
    require 'functions.php';
        
        if (isset($_GET['id'])) {
            if (delete_tagihan($_GET['id']) > 0) {
                echo "<script>
                        alert('Tagihan Berhasil dihapus!');
                        document.location.href = 'tagihan.php';
                    </script>";
                exit();
            } else {
                echo "<script>
                        alert('Tagihan Gagal dihapus!');
                        document.location.href = 'tagihan.php';
                    </script>";
                exit();
            }
        } else {
            echo "Invalid ID Tagihan.";
            exit();
        }
?>