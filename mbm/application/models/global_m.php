<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Global_m extends CI_Model {

    public function simpan($tabel, $data) {
        $this->db->trans_begin();
        $model = $this->db->insert($tabel, $data);
        if ($this->db->trans_status() === FALSE) {
            $this->db->trans_rollback();
            return false;
        } else {
            $this->db->trans_commit();
            return true;
        }
    }

    function ubah($tabel,$data,$id_kolom ,$id_data) {
        $this->db->trans_begin();
        $query1 = $this->db->where($id_kolom, $id_data);
        $query2 = $this->db->update($tabel, $data);
        if ($this->db->trans_status() === FALSE) {
            $this->db->trans_rollback();
            return false;
        } else {
            $this->db->trans_commit();
            return true;
        }
    }

    function hapus($tabel,$id_kolom ,$id_data) {
        $this->db->trans_begin();
        $query1 = $this->db->where($id_kolom, $id_data);
        $query2 = $this->db->delete($tabel);
        if ($this->db->trans_status() === FALSE) {
            $this->db->trans_rollback();
            return false;
        } else {
            $this->db->trans_commit();
            return true;
        }
    }

    public function tampil_semua($tabel,$orderby_1) {
        $sql = "select * from $tabel order by $orderby_1 asc ";
        $query = $this->db->query($sql);
        $result = $query->result();
        return $result;
    }
    public function tampil_id_desk($tabel,$kolom_id_data,$kolom_desk_data,$orderby_1) {
        $sql = "select $kolom_id_data,$kolom_desk_data from $tabel order by $orderby_1 asc ";
        $query = $this->db->query($sql);
        $result = $query->result();
        return $result;
    }

    public function truncateAllData() {
        $this->db->query("truncate table master_in");
                $this->db->query("update master_produk set masuk= 0.00, masuk_campur = 0.00, masuk_lain = 0.00, keluar = 0.00, keluar_req = 0.00, keluar_campur = 0.00, keluar_lain = 0.00, stok_avl =0.00, stok_akhir = 0.00");

        //$result = $query->result();
        //return $result;
    }

}

/* End of file sec_menu_user_m.php */
/* Location: ./application/models/sec_menu_user.php */