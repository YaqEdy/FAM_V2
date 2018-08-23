<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');
date_default_timezone_set('Asia/Jakarta');

class Mutationinventaris extends CI_Controller {

    function __construct() {
        parent::__construct();
        session_start();
        $this->load->model('home_m');
        $this->load->model('admin/konfigurasi_menu_status_user_m');
//        $this->load->model('zsessions_m');
        $this->load->model('global_m');
        $this->load->model('operational/mutationinventaris_mdl', 'mutation');
        $this->load->model('datatables_custom');

//        $sess = $this->zsessions_m->get_sess_data();
//        echo '<pre>';print_r($sess);  
//        if (sizeof($sess) > 0) {
//            $this->userid = $sess->id_user;
//            $this->username = $sess->username;
//            $this->role = $sess->usergroup_desc;
//        } else {
//            redirect('main/logout');
//        }
    }

    public function index() {
        if ($this->auth->is_logged_in() == false) {
            $this->login();
        } else {
            $data['multilevel'] = $this->user_m->get_data(0, $this->session->userdata('usergroup'));

            $this->template->set('title', 'Home');
            $this->template->load('template/template1', 'global/index', $data);
        }
    }

    function home() {
        $menuId = $this->home_m->get_menu_id('operational/mutationinventaris/home');
        $data['menu_id'] = $menuId[0]->menu_id;
        $data['menu_parent'] = $menuId[0]->parent;
        $data['menu_nama'] = $menuId[0]->menu_nama;
        $data['menu_header'] = $menuId[0]->menu_header;
        $this->auth->restrict($data['menu_id']);
        $this->auth->cek_menu($data['menu_id']);
        $data['group_user'] = $this->konfigurasi_menu_status_user_m->get_status_user();
        //$data['level_user'] = $this->sec_user_m->get_level_user();
        if (isset($_POST["idTmpAksiBtn"])) {
            $act = $_POST["idTmpAksiBtn"];
            if ($act == 1) {
                $this->simpan();
            } elseif ($act == 2) {
                $this->ubah();
            } elseif ($act == '3') {
                $this->hapus();
            } else {
                $data['multilevel'] = $this->user_m->get_data(0, $this->session->userdata('usergroup'));
                $data['menu_all'] = $this->user_m->get_menu_all(0);
                $data['karyawan'] = $this->global_m->tampil_id_desk('master_karyawan', 'id_kyw', 'nama_kyw', 'id_kyw');
                $data['goluser'] = $this->global_m->tampil_id_desk('sec_gol_user', 'goluser_id', 'goluser_desc', 'goluser_id');

                $data['statususer'] = $this->global_m->tampil_id_desk('sec_status_user', 'statususer_id', 'statususer_desc', 'statususer_id');
                $this->template->set('title', 'Term Of Payment');
                $this->template->load('template/template_dataTable', 'operational/mutationinventaris/mutationinventaris_v', $data);
            }
        } else {
            $data['multilevel'] = $this->user_m->get_data(0, $this->session->userdata('usergroup'));
            $data['menu_all'] = $this->user_m->get_menu_all(0);
            $data['karyawan'] = $this->global_m->tampil_id_desk('master_karyawan', 'id_kyw', 'nama_kyw', 'id_kyw');
            $data['goluser'] = $this->global_m->tampil_id_desk('sec_gol_user', 'goluser_id', 'goluser_desc', 'goluser_id');
            $data['statususer'] = $this->global_m->tampil_id_desk('sec_status_user', 'statususer_id', 'statususer_desc', 'statususer_id');

            $this->template->set('title', 'Term Of Payment');
            $this->template->load('template/template_dataTable', 'operational/mutationinventaris/mutationinventaris_v', $data);
        }
    }

    public function ajax_GridOpex() {
//        dari login
//        $sessid = $this->session->userdata('usergroup');
//        $method = $this->uri->segment('2');
//        $accesdata = $this->Menu_mdl->get_menusetting2($sessid, $method);
        $div = $this->session->userdata('DivisionID');
        $branch = $this->session->userdata('BranchID');
        $usergroup = $this->session->userdata('groupid');
        $iwhere1 = array($this->input->post('sSearch') => $_POST['search']['value']);
        $iwhere2 = array();
        $iwhere3 = array();
        if ($branch == 1) { //JIKA PUSAT : semua ppi bisa lihat data kecuali ppi dengan usergroup support
            if (($div == '8' && $usergroup <> '3') || $div == '20' || $usergroup == '1') {
//                $iwhere1 = array($this->input->post('sSearch') => $_POST['search']['value']);
            } else {
//                $iwhere2 = array('DivisionID' => $div);
            }
        } else { //JIKA CABANG : cabang hanya bisa melihat cabang dan divisinya saja
            $iwhere3 = array('BranchID' => $branch);
        }

        $iwhere = array_merge($iwhere1, $iwhere2, $iwhere3);
        $icolumn = array('ItemName', 'ZoneName', 'BranchName', 'BranchCode', 'BisUnitName', 'DivisionName', 'QTY', 'Raw_ID', 'FAID', 'Period', 'PriceVendor', 'SetDatePayment', 'Condition');
        $iorder = array('Raw_ID' => 'asc');
        $list = $this->datatables_custom->get_datatables('vw_opr_mutationinventaris', $icolumn, $iorder, $iwhere);

        $data = array();
        $no = $_POST['start'];
        foreach ($list as $idatatables) {
//            $tujuan = $this->mutation->getBranchFromCode(substr($idatatables->FAID, 11, 5));
            $tujuan = $this->mutation->getBranchFromCode('00167');
            $irow = '';
            if (!empty($idatatables->FAID)) {
                $irow = '<a href=" base_url()assets/temp/ trim($idatatables->FAID)" download=" trim($idatatables->FAID)"><img src="base_url(); ?>assets/temp/ trim($idatatables->FAID)" style="width: 30px; height:30px"></a>';
            }

            $no++;
            $row = array();
            $row[] = $no;

            $row[] = $idatatables->ZoneName;
            $row[] = ((int) $idatatables->BranchCode == 00000) ? $idatatables->BranchName . ' - ' . $idatatables->DivisionName : $idatatables->BranchName . ' => <strong>'
                    . ((int) $tujuan->BranchCode == 00000) ? $tujuan->DivisionName : $tujuan->BranchName . '</strong>';
            $row[] = $idatatables->FAID;
            $row[] = $idatatables->ItemName;
            $row[] = $idatatables->QTY;
            $row[] = $irow;

            $data[] = $row;
        }
//        print_r($data);
//        die();
        $output = array(
            "draw" => $_POST['draw'],
            "recordsTotal" => $this->datatables_custom->count_all(),
            "recordsFiltered" => $this->datatables_custom->count_filtered(),
            "data" => $data,
        );
        //output to json format
        echo json_encode($output);
    }

}

/* End of file sec_user.php */
/* Location: ./application/controllers/sec_user.php */