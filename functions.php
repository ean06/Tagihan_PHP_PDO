<?php

    // error_reporting(0);
        // ================ KONEKSI DATABASE ================ //

       // buat koneksi dengan database //
        try{
                $dbh = new PDO("mysql:host=localhost;dbname=tagihan","root","");
                $dbh->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

        }catch (Exception $e){
                die("Error: " . $e->getMessage());

        }


        // ================== FILTER TAGIHAN ==================== //

        // -------------- FILTER TAGIHAN -------------- //


        function filter($bulan, $tahun, $sumdan, $kategori, $status) {
            global $dbh;
            
            $query = "SELECT * FROM tagihan WHERE 1=1";
            
            if (!empty($sumdan)) {
                $query .= " AND kode_sumdan LIKE :sumdan";
            }
            if (!empty($kategori)) {
                $query .= " AND kode_kategori LIKE :kategori";
            }
            if (!empty($status)) {
                $query .= " AND status_tagihan LIKE :status";
            }
            if (!empty($bulan) && !empty($tahun)) {
                $query .= " AND (
                    (MONTH(tanggal_jatuh_tempo) = :bulan AND YEAR(tanggal_jatuh_tempo) = :tahun) OR 
                    (MONTH(tanggal_tagihan_next) = :bulan AND YEAR(tanggal_tagihan_next) = :tahun)
                )";
            } else if (!empty($bulan) && empty($tahun)) {
                $query .= " AND (
                    MONTH(tanggal_jatuh_tempo) = :bulan OR 
                    MONTH(tanggal_tagihan_next) = :bulan
                )";
            } else if (empty($bulan) && !empty($tahun)) {
                $query .= " AND (
                    YEAR(tanggal_jatuh_tempo) = :tahun OR 
                    YEAR(tanggal_tagihan_next) = :tahun
                )";
            }
            
            $statement = $dbh->prepare($query);
            
            if (!empty($sumdan)) {
                $statement->bindParam(':sumdan', $sumdan, PDO::PARAM_STR);
            }
            if (!empty($kategori)) {
                $statement->bindParam(':kategori', $kategori, PDO::PARAM_STR);
            }
            if (!empty($status)) {
                $statement->bindParam(':status', $status, PDO::PARAM_STR);
            }
            if (!empty($bulan)) {
                $statement->bindParam(':bulan', $bulan, PDO::PARAM_INT);
            }
            if (!empty($tahun)) {
                $statement->bindParam(':tahun', $tahun, PDO::PARAM_INT);
            }
            
            $statement->execute();
            $rows = [];
            while ($row = $statement->fetch(PDO::FETCH_ASSOC)) {
                $rows[] = $row;
            }
            return $rows;
        }


        
        // ================== SUMBER PENDANAAN ==================== //

        // ------- ADD SUMBER PENDANAAN ------- //
        function add_subdan($subdan)  {
            global $dbh;
                    $query = "INSERT INTO sumber_dana (kode_sumdan, nama_pendanaan, nama_bank, nama_rekening, nomor_rekening, status_subdan) VALUES (?, ?, ?, ?, ?, ?)";
                    $stmt = $dbh->prepare($query);
                    $stmt->bindParam(1, $subdan['kode_sumdan']);
                    $stmt->bindParam(2, $subdan['nama_pendanaan']);
                    $stmt->bindParam(3, $subdan['nama_bank']);
                    $stmt->bindParam(4, $subdan['nama_rekening']);
                    $stmt->bindParam(5, $subdan['nomor_rekening']);
                    $stmt->bindParam(6, $subdan['status_subdan']);
                    $stmt->execute();
            return $stmt->rowCount();  
        }

        // ------- UPDATE SUMBER PENDANAAN ------- //
        function update_subdan($var_id, $var_kode, $var_namap, $var_namab, $var_namar, $var_nomorr, $var_status) {
            global $dbh;
            $query = ("UPDATE sumber_dana SET   id_sumdan=:var_id, 
                                                kode_sumdan=:var_kode, 
                                                nama_pendanaan=:var_namap, 
                                                nama_bank=:var_namab, 
                                                nama_rekening=:var_namar, 
                                                nomor_rekening=:var_nomorr, 
                                                status_subdan=:var_status
                                            WHERE id_sumdan=:var_id");
                $stmt = $dbh->prepare($query);
                $stmt->bindParam(":var_id", $var_id);
                $stmt->bindParam(":var_kode", $var_kode);
                $stmt->bindParam(":var_namap", $var_namap);
                $stmt->bindParam(":var_namab", $var_namab);
                $stmt->bindParam(":var_namar", $var_namar);
                $stmt->bindParam(":var_nomorr", $var_nomorr);
                $stmt->bindParam(":var_status", $var_status);
                $stmt->execute();        
            return $stmt->rowCount(); 
        }
        
        // ------- DELETE SUMBER PENDANAAN ------- //
        function delete_subdan($id) {
            global $dbh;
                $query = "DELETE FROM sumber_dana WHERE id_sumdan = :id";
                $data = $dbh->prepare($query);
                $data->bindParam(':id', $id, PDO::PARAM_INT);
                $data->execute();
            return $data->rowCount();
        }




        // ===================== TAGIHAN ======================= //}

        // -------------- ADD TAGIHAN -------------- //
        function add_tagihan($tagihan)  {
            global $dbh;
                    $query = "INSERT INTO tagihan (id_pengguna, kode_sumdan, kode_kategori, tagihan_termin, nama_tagihan, rupiah_tagihan, rekening_tujuan_bank, rekening_tujuan_norek, rekening_tujuan_nama, rekening_tujuan_va, tanggal_jatuh_tempo,tanggal_pembayaran, tanggal_tagihan_next, status_tagihan) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)";
                    $stmt = $dbh->prepare($query);
                    $stmt->bindParam(1, $tagihan['id_pengguna']);
                    $stmt->bindParam(2, $tagihan['kode_sumdan']);
                    $stmt->bindParam(3, $tagihan['kode_kategori']);
                    $stmt->bindParam(4, $tagihan['tagihan_termin']);
                    $stmt->bindParam(5, $tagihan['nama_tagihan']);
                    $stmt->bindParam(6, $tagihan['rupiah_tagihan']);
                    $stmt->bindParam(7, $tagihan['rekening_tujuan_bank']);
                    $stmt->bindParam(8, $tagihan['rekening_tujuan_norek']);
                    $stmt->bindParam(9, $tagihan['rekening_tujuan_nama']);
                    $stmt->bindParam(10, $tagihan['rekening_tujuan_va']);
                    $stmt->bindParam(11, $tagihan['tanggal_jatuh_tempo']);
                    $stmt->bindParam(12, $tagihan['tanggal_pembayaran']);
                    $stmt->bindParam(13, $tagihan['tanggal_tagihan_next']);
                    $stmt->bindParam(14, $tagihan['status_tagihan']);
                    $stmt->execute();
            return $stmt->rowCount();  
        }

        // -------------- UPDATE TAGIHAN -------------- //
        function update_tagihan($var_id_t, $var_id_p, $var_kode, $var_kategori, $var_nama_t, $var_tagihan, $var_rupiah_t, $var_rtb, $var_rtr, $var_rtn, $var_rtv, $var_tjp, $var_ttn, $var_tp) {
            global $dbh;
                                $query = "UPDATE tagihan SET 
                                        id_pengguna=:var_id_p,
                                        kode_sumdan=:var_kode,
                                        kode_kategori=:var_kategori,
                                        tagihan_termin=:var_nama_t,
                                        nama_tagihan=:var_tagihan,
                                        rupiah_tagihan=:var_rupiah_t,
                                        rekening_tujuan_bank=:var_rtb,
                                        rekening_tujuan_norek=:var_rtr,
                                        rekening_tujuan_nama=:var_rtn,
                                        rekening_tujuan_va=:var_rtv,
                                        tanggal_jatuh_tempo=:var_tjp,   
                                        tanggal_tagihan_next=:var_ttn,
                                        tanggal_pembayaran=:var_tp
                                                    WHERE id_tagihan=:var_id_t";
                $stmt = $dbh->prepare($query);
                $stmt->bindParam(":var_id_t", $var_id_t);
                $stmt->bindParam(":var_id_p", $var_id_p);
                $stmt->bindParam(":var_kode", $var_kode);
                $stmt->bindParam(":var_kategori", $var_kategori);
                $stmt->bindParam(":var_nama_t", $var_nama_t);
                $stmt->bindParam(":var_tagihan", $var_tagihan);
                $stmt->bindParam(":var_rupiah_t", $var_rupiah_t);
                $stmt->bindParam(":var_rtb", $var_rtb);
                $stmt->bindParam(":var_rtr", $var_rtr);
                $stmt->bindParam(":var_rtn", $var_rtn);
                $stmt->bindParam(":var_rtv", $var_rtv);
                $stmt->bindParam(":var_tjp", $var_tjp);
                $stmt->bindParam(":var_ttn", $var_ttn);
                $stmt->bindParam(":var_tp", $var_tp);
                $stmt->execute();
            return $stmt->rowCount();
        }


        // -------------- UPLOAD TAGIHAN -------------- //
        function upload_tagihan ($var_id, $var_tp, $var_bp, $var_keterangan, $var_status) {
            global $dbh;
                $query = "UPDATE tagihan SET    tanggal_pembayaran = :var_tp,
                                                bukti_pembayaran = :var_bp,
                                                tagihan_keterangan = :var_keterangan,
                                                status_tagihan = :var_status
                                        WHERE id_tagihan = :var_id";
                    $stmt = $dbh->prepare($query);
                    $stmt->bindParam(":var_id", $var_id);
                    $stmt->bindParam(":var_tp", $var_tp);
                    $stmt->bindParam(":var_bp", $var_bp, PDO::PARAM_LOB);
                    $stmt->bindParam(":var_keterangan", $var_keterangan);
                    $stmt->bindParam(":var_status", $var_status);
                $stmt->execute();
            return $stmt->rowCount();
        }

        // -------------- DELETE TAGIHAN -------------- //
        function delete_tagihan($id) {
            global $dbh;
                $query = "DELETE FROM tagihan WHERE id_tagihan = :id";
                $data = $dbh->prepare($query);
                $data->bindParam(':id', $id, PDO::PARAM_INT);
                $data->execute();
            return $data->rowCount();
        }




        // ================ KATEGORI ================ // by Putra

        // Add Kategori
        function add_kategori($kategori) {
            global $dbh;
            $query = "INSERT INTO kategori (id_pengguna, kode_kategori, kategori, keterangan) VALUES (?, ?, ?, ?)";
            $stmt = $dbh->prepare($query);
            $stmt->bindParam(1, $kategori['id_pengguna']);
            $stmt->bindParam(2, $kategori['kode_kategori']);
            $stmt->bindParam(3, $kategori['kategori']);
            $stmt->bindParam(4, $kategori['keterangan']);

            $stmt->execute();
            return $stmt->rowCount();
    }

    //Get Kategori
    function get_kategori($dbh, $id) {
            $query = "SELECT * FROM kategori WHERE id_kategori = ?";
            $stmt = $dbh->prepare($query);
            $stmt->bindParam(1, $id, PDO::PARAM_INT);
        
            try {
                $stmt->execute();
                $result = $stmt->fetch(PDO::FETCH_ASSOC);
                return $result;
            } catch (PDOException $e) {
                return false; // Mengembalikan false jika terjadi error
            }
        }

    //Delete Kategori
    function delete_kategori($id) {
            global $dbh;
                $query = "DELETE FROM kategori WHERE id_kategori = :id";
                $data = $dbh->prepare($query);
                $data->bindParam(':id', $id, PDO::PARAM_INT);
                $data->execute();
            return $data->rowCount();
        }

    //Edit Kategori
    function edit_kategori($dbh, $id, $id_pengguna, $kode_kategori, $kategori, $keterangan) {
        try {
            $query = "UPDATE kategori 
                        SET id_pengguna = ?, kode_kategori = ?, kategori = ?, keterangan = ? 
                        WHERE id_kategori = ?";
            $stmt = $dbh->prepare($query);
            $stmt->bindParam(1, $id_pengguna, PDO::PARAM_INT);
            $stmt->bindParam(2, $kode_kategori, PDO::PARAM_STR);
            $stmt->bindParam(3, $kategori, PDO::PARAM_STR);
            $stmt->bindParam(4, $keterangan, PDO::PARAM_STR);
            $stmt->bindParam(5, $id, PDO::PARAM_INT);
            $stmt->execute();
    
            return "Kategori berhasil diperbarui";
        } catch (PDOException $e) {
            return "Error: " . $e->getMessage();
        }
    }
    
    // ================ PENGGUNA ================ // by Putra

    //Add Pengguna
    function add_pengguna($pengguna) {
            global $dbh;
            $query = "INSERT INTO pengguna (nama_lengkap, email, handphone, username, password, hak_akses) VALUES (?, ?, ?, ?, ?, ?)";
            $stmt = $dbh->prepare($query);
            $stmt->bindParam(1, $pengguna['nama_lengkap']);
            $stmt->bindParam(2, $pengguna['email']);
            $stmt->bindParam(3, $pengguna['handphone']);
            $stmt->bindParam(4, $pengguna['username']);
            $stmt->bindParam(5, $pengguna['password']);
            $stmt->bindParam(6, $pengguna['hak_akses']);
        
            $stmt->execute();
            return $stmt->rowCount();  
        }

    //Get Pengguna
    function get_pengguna($dbh, $id) {
            $query = "SELECT * FROM pengguna WHERE id_pengguna = ?";
            $stmt = $dbh->prepare($query);
            $stmt->bindParam(1, $id, PDO::PARAM_INT);
        
            try {
                $stmt->execute();
                $result = $stmt->fetch(PDO::FETCH_ASSOC);
                return $result;
            } catch (PDOException $e) {
                return false; // Mengembalikan false jika terjadi error
            }
        }
        

    //Delete Pengguna
    function delete_pengguna($id) {
            global $dbh;
                $query = "DELETE FROM pengguna WHERE id_pengguna = :id";
                $data = $dbh->prepare($query);
                $data->bindParam(':id', $id, PDO::PARAM_INT);
                $data->execute();
            return $data->rowCount();
        }
        

    //Edit Pengguna
    function edit_pengguna($dbh, $id, $nama_lengkap, $email, $handphone, $username, $password, $hak_akses) {
            $query = "UPDATE pengguna 
                        SET nama_lengkap = ?, email = ?, handphone = ?, username = ?, password = ?, hak_akses = ? 
                        WHERE id_pengguna = ?";
            $stmt = $dbh->prepare($query);
            $stmt->bindParam(1, $nama_lengkap, PDO::PARAM_STR);
            $stmt->bindParam(2, $email, PDO::PARAM_STR);
            $stmt->bindParam(3, $handphone, PDO::PARAM_STR);
            $stmt->bindParam(4, $username, PDO::PARAM_STR);
            $stmt->bindParam(5, $password, PDO::PARAM_STR);
            $stmt->bindParam(6, $hak_akses, PDO::PARAM_STR);
            $stmt->bindParam(7, $id, PDO::PARAM_INT);
        
            try {
                $stmt->execute();
                return "Data Pengguna berhasil diperbarui.";
            } catch (PDOException $e) {
                return "Error: " . $e->getMessage();
            }
        }
?>