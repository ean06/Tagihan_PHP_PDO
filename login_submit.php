<?php 
session_start();
require 'functions.php';

$query = "SELECT * FROM pengguna WHERE username = ? AND password = ?";
$stmt = $dbh->prepare($query);

    $username = $_POST["username"];
    $password = $_POST["password"];

    $stmt->execute([$username, $password]);
    $result = $stmt->fetchAll();

if($result > 0){
    $username           = $result[0]['username'];
    $nama_lengkap       = $result[0]['nama_lengkap'];
    $password           = $result[0]['password'];
    $status_hak_akses   = $result[0]['hak_akses'];

    $_SESSION["hak_akses"] = $status_hak_akses;
    $_SESSION["nama_lengkap"] = $nama_lengkap;

        if($username != ""){   
            header("Location: dashboard.php");
        }else{ echo "<script>
                    alert('Username/Password Salah!');
                    document.location.href = 'login.php';
                </script>";
        }
    }
?>