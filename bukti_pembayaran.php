<?php
session_start();
if( !isset($_SESSION["nama_lengkap"])){
    header("location: login.php");
    exit;
}

if (isset($_GET['id'])) {
    $id = $_GET['id'];

        $query = "SELECT * FROM tagihan WHERE id_tagihan = :id";
        $stmt = $dbh->prepare($query);
        $stmt->bindParam(':id', $id, PDO::PARAM_INT);
        $stmt->execute();
        $row = $stmt->fetch(PDO::FETCH_ASSOC);
        
        // UNUTK MENAMPILKAN GAMBAR DI TAB BARU DAN BUKAN DI DOWNLOAD
        // if ($row) {
        //     echo '<img src="data:image/jpeg;base64,' . base64_encode($row['bukti_pembayaran']) . '" />';
        // } else {
        //     echo 'Bukti Pembayaran tidak ditemukan.';
        // }

        if ($row) {
            header("Content-type: image/jpeg"); 
            header("Content-Disposition: attachment; filename= Bukti Pembayaran.jpg");
            echo $row['bukti_pembayaran'];
            exit;
        } else {
            echo 'Bukti Pembayaran tidak ditemukan.';
        }
}
?>

