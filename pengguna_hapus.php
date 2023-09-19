<?php
session_start();
if( !isset($_SESSION["nama_lengkap"])){
    header("location: login.php");
    exit;
}
require 'functions.php';
    
    if (isset($_GET['id'])) {
        $id = $_GET['id'];
        try {
            $result = delete_pengguna($id);
            if ($result === -1) {
                echo "<script>
                        alert('Data tidak bisa dihapus karena memiliki ketergantungan');
                        document.location.href = 'pengguna.php';
                        </script>";
                exit();
            } elseif ($result === 0) {
                echo "<script>
                        alert('Pengguna Gagal dihapus!');
                        document.location.href = 'pengguna.php';
                    </script>";
                exit();
            } else {
                echo "<script>
                        alert('Pengguna Berhasil dihapus!');
                        document.location.href = 'pengguna.php';
                    </script>";
                exit();
            }
        } catch (PDOException $e) {
            echo "<script>
                    alert('Terjadi kesalahan dalam penghapusan data. Silakan coba lagi.');
                    document.location.href = 'pengguna.php';
                </script>";
            exit();
        }
    } else {
        echo "Invalid ID Pengguna.";
        exit();
    } 
?>