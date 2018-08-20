<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Konfigurasi_menu_status_user_m extends CI_Model {

    public function get_status_user() {
        $rows = array(); //will hold all results
        $sql = "select * from sec_usergroup order by usergroup_id asc ";
        $query = $this->db->query($sql);
        foreach ($query->result_array() as $row) {
            $rows[] = $row; //add the fetched result to the result array;
        }
        return $rows; // returning rows, not row
    }

    public function update_menu_status_user_m($data_menu, $status_user) {

        $allowed = '+' . $status_user;
        $sqlgetmenu = "select menu_id,menu_allowed from sec_menu where menu_allowed like '%" . $allowed . "%'";
        $querygetmenu = $this->db->query($sqlgetmenu);
        $resltgetmenu = $querygetmenu->result();
        foreach ($resltgetmenu as $keywordgetmenu) {
            $allowed_new = '';
            $menu_alowedgetmenu = $keywordgetmenu->menu_allowed;
            $menu_idgetmenu = $keywordgetmenu->menu_id;
            $menu_alowed2 = explode('+', $menu_alowedgetmenu);
            foreach ($menu_alowed2 as $keyword) {
                if ((strlen(trim($keyword)) != 0) && ($keyword != $status_user)) {
                    $allowed_new = $allowed_new . '+' . $keyword;
                }
            }
            $sql = "update sec_menu set menu_allowed = '" . $allowed_new . "' where menu_id = '" . $menu_idgetmenu . "'";
            $this->db->query($sql);
        }
//        die();


        foreach ($data_menu as $menu_id) {
            $sql0 = "select menu_allowed,parent,lvl from sec_menu where menu_id = '" . $menu_id . "'";
            $query0 = $this->db->query($sql0);
            $reslt = $query0->result();
            $menu_alowed = $reslt[0]->menu_allowed;
            $menuid = $reslt[0]->parent;
            $sql1 = "update sec_menu set menu_allowed = concat(menu_allowed,'" . $allowed . "') where menu_id = '" . $menu_id . "'";
            $query1 = $this->db->query($sql1);
            
            $lvl = $reslt[0]->lvl;
            if ($lvl > 0) {
                for ($i = 1; $i <= $lvl; $i++) {
                    $allowed4 = '';
                    $count = 0;
                    $sql0 = "select menu_allowed,parent from sec_menu where menu_id = '" . $menuid . "'";
                    $query0 = $this->db->query($sql0);
                    $reslt = $query0->result();
                    $menu_alowed = $reslt[0]->menu_allowed;
                    $menu_alowed3 = explode('+', $menu_alowed);
                    foreach ($menu_alowed3 as $keyword3) {
                        if ($keyword3 == $status_user) {
                            $count = $count + 1;
                        }
                    }
                    if ($count == '0') {
                        $sql2 = "update sec_menu set menu_allowed = concat(menu_allowed,'" . $allowed . "') where menu_id = '" . $menuid . "'";
                        $query1 = $this->db->query($sql2);
                    }
                    $menuid = $reslt[0]->parent;
                } 
            }
        } 
        /*
          foreach ($data_menu as $x => $x_value) {

          $data_menu2 = array();
          $data_menu2 = explode('_', $x_value);
          foreach ($data_menu2 as $y => $y_value) {
          $sql0 = "select menu_allowed from sec_menu where menu_id = '" . $y_value . "'";
          $query0 = $this->db->query($sql0);
          $menu_alowed = $query0->result();
          $menu_alowed = $menu_alowed[0]->menu_allowed;
          if (!strpos($menu_alowed, $status_user)) {
          $sql = "update sec_menu set menu_allowed = concat(menu_allowed,'" . $allowed_new . "') where menu_id = '" . $y_value . "'";
          $query = $this->db->query($sql);
          }
          }
          }// end foreach($data_menu as $x=>$x_value){
         * */
    }

    public function get_menu_group_user_m($kd_group_user) {
        /* $this->db->select ( 'menu_id,parent' );
          $this->db->from('sec_menu');
          $this->db->where ( 'menu_uri', '#' );
          $this->db->like ( 'menu_allowed', $kd_group_user ); */
        $sql = "select menu_id,parent,menu_allowed from sec_menu where menu_allowed like '%$kd_group_user%' and menu_uri not in ('#','-')";
        $query = $this->db->query($sql);
        //$query = $this->db->get (); data_menu

        $rows = $query->result();
        return $rows; // returning rows, not row
    }

    public function update_level() {
        //$sqlalter = "ALTER TABLE sec_menu ADD lvl tinyint(4) NOT NULL DEFAULT '0';";
        //$query_alter = $this->db->query($sqlalter);
        $sqlx = "update sec_menu set lvl= 2 where menu_uri <> '#'";
        $queryx = $this->db->query($sqlx);
        $sql = "select menu_id,parent from sec_menu where menu_uri ='#' ";
        $query = $this->db->query($sql);
        $rows = $query->result();
        foreach ($rows as $row) {
            $sql2 = "select menu_id,parent from sec_menu where parent ='$row->menu_id' ";
            $query2 = $this->db->query($sql2);
            $rows2 = $query2->result();
            foreach ($rows2 as $row2) {
                $sql3 = "update sec_menu set lvl = 1 where menu_id = '$row2->menu_id'";
                $query3 = $this->db->query($sql3);
            }
        }
    }

}

/* End of file Konfigurasi_menu_status_user_m.php */
/* Location: ./application/models/master_nasabahmodel.php */