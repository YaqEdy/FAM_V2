<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');
date_default_timezone_set('Asia/Jakarta');

class Listasset extends CI_Controller {

    function __construct() {
        parent::__construct();
        session_start();
        $this->load->model('home_m');
        $this->load->model('admin/konfigurasi_menu_status_user_m');
//        $this->load->model('zsessions_m');
        $this->load->model('global_m');
        $this->load->model('procurement/menu_mdl', 'Menu_mdl');
        $this->load->model('asset_management/payment_mdl', 'Payment_mdl');
        $this->load->model('asset_management/listasset_mdl', 'assetlist');
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
        $menuId = $this->home_m->get_menu_id('asset_management/listasset/home');
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
                $this->template->load('template/template_dataTable', 'asset_management/listasset/listasset_v', $data);
            }
        } else {
            $data['multilevel'] = $this->user_m->get_data(0, $this->session->userdata('usergroup'));
            $data['menu_all'] = $this->user_m->get_menu_all(0);
            $data['karyawan'] = $this->global_m->tampil_id_desk('master_karyawan', 'id_kyw', 'nama_kyw', 'id_kyw');
            $data['goluser'] = $this->global_m->tampil_id_desk('sec_gol_user', 'goluser_id', 'goluser_desc', 'goluser_id');
            $data['statususer'] = $this->global_m->tampil_id_desk('sec_status_user', 'statususer_id', 'statususer_desc', 'statususer_id');

            $this->template->set('title', 'Term Of Payment');
            $this->template->load('template/template_dataTable', 'asset_management/listasset/listasset_v', $data);
        }
    }

    public function ajax_GridMutation() {
        $div = $this->session->userdata('DivisionID');
        $branch = $this->session->userdata('BranchID');
        $usergroup = $this->session->userdata('groupid');

        if ($this->input->post('sZoneName') != "") {
            $iwhere1 = array('ZoneName' => $this->input->post('sZoneName'));
        } else {
            $iwhere1 = array();
        }
        if ($this->input->post('sDivisionName') != "") {
            $iwhere2 = array('DivisionName' => $this->input->post('sDivisionName'));
        } else {
            $iwhere2 = array();
        }
        if ($this->input->post('sBisUnitName') != "") {
            $iwhere3 = array('BisUnitName' => $this->input->post('sBisUnitName'));
        } else {
            $iwhere3 = array();
        }
        if ($this->input->post('sFAID') != "") {
            $iwhere4 = array('FAID' => $this->input->post('sFAID'));
        } else {
            $iwhere4 = array();
        }
        if ($this->input->post('sItemName') != "") {
            $iwhere5 = array('ItemName' => $this->input->post('sItemName'));
        } else {
            $iwhere5 = array();
        }

        $iwhere = array_merge($iwhere1, $iwhere2, $iwhere3, $iwhere4, $iwhere5);
        $icolumn = array('coa', 'Status', 'QTY', 'Raw_ID', 'FAID', 'FAID_lama', 'Period', 'PriceVendor', 'SetDatePayment', 'Condition', 'Is_trash', 'Image', 'DateCondition', 'ItemName', 'ZoneName', 'BranchName', 'BranchCode', 'DivisionName', 'BisUnitName');
        $iorder = array('Raw_ID' => 'desc');

        $list = $this->datatables_custom->get_datatables('vw_asset_list', $icolumn, $iorder, $iwhere);
//        print_r($list);die();
        $data = array();
        $no = $_POST['start'];
        foreach ($list as $idatatables) {
            if ($idatatables->Status == 3) {
                $tujuan = $this->assetlist->getBranchFromCode(substr($idatatables->FAID, 11, 5));
            }
            $statuspembayaran = (empty($idatatables->SetDatePayment)) ? 'disabled' : '';
            $tujuan = $this->assetlist->getBranchFromCode(substr($idatatables->FAID, 11, 5));
            $irow = '';
            $no++;
            $row = array();
            $row[] = $no;
            $row[] = $idatatables->ZoneName;
            $row[] = ((int) $idatatables->BranchCode == 00000) ? $idatatables->BranchName . ' - ' . $idatatables->DivisionName : $idatatables->BranchName
                    . ($idatatables->Status == 3) ? ' => <strong>'
                            . (((int) $tujuan->BranchCode == 00000) ? $tujuan->DivisionName : $tujuan->BranchName) . '</strong>' : '';
            $row[] = ($idatatables->BisUnitName == '') ? '-' : $idatatables->BisUnitName;
            $row[] = $idatatables->FAID;
            $row[] = $idatatables->FAID_lama;
            $row[] = $idatatables->ItemName;
            $row[] = $idatatables->QTY;
            if (!empty($idatatables->Image)) {
                $irow_img = '<a href="' . base_url() . 'uploads/item_images/' . trim($idatatables->Image) . '" download="' . trim($idatatables->Image) . '.png">'
                        . '<img src="' . base_url() . 'uploads/item_images/' . trim($idatatables->Image) . '" style="width: 30px; height:30px"></a>.';
            }
            $row[] = $irow_img;
            if (!empty($idatatables->FAID)) {
                $irow_qr = '<a href="' . base_url() . 'uploads/qr_code/' . trim($idatatables->FAID) . '.png" download="' . trim($idatatables->FAID) . '.png">'
                        . '<img src="' . base_url() . 'uploads/qr_code/' . trim($idatatables->FAID) . '.png" style="width: 30px; height:30px"></a>.';
            }
            $row[] = $irow_qr;
            $date = date('d-m-Y H:i:s', strtotime($idatatables->DateCondition));
            if ($idatatables->Condition == 1) {
                $cond = '<b>Bagus</b> <br>' . $date;
            } elseif ($idatatables->Condition == 2) {
                $cond = '<b>Rusak</b> <br>' . $date;
            } elseif ($idatatables->Condition == 3) {
                $cond = '<b>Hilang</b> <br>' . $date;
            } elseif ($idatatables->Condition == 4) {
                $cond = '<b>Musnah</b> <br>' . $date;
            }
            $row[] = $cond;
            $btn = '';
            if ($idatatables->Is_trash == 0) {
                $iclass = 'btn-primary';
            } else {
                $iclass = 'btn-danger';
            }
            if ($idatatables->Is_trash == 1 || $idatatables->Status == 1) {
                $idisabled = 'disabled';
            } else {
                $idisabled = '';
            }
            if ($idatatables->Is_trash == 0) {
                $hd = 'Disposal';
            } else {
                $hd = 'Has Disposal';
            }
            if ($div == 8 && $branch == 1 && $usergroup <> 3) {
                $btn.='<a onclick="mutationasset(this)" data-toggle="modal" data-target="#myModal" id="' . $idatatables->Raw_ID . '" name="' . $idatatables->FAID . '" class="mutationasset"  ><button class="btn btn-primary btn-xs" type="button" ' . $idisabled . '>Mutation</button></a>'
                        . '<a><button onclick="disposal(this)" class="btn btn-xs disposal ' . $iclass . '" type="button" name="' . $idatatables->FAID . '" id="' . $idatatables->Raw_ID . '" ' . $idisabled . '>' . $hd . '</button></a>';
            } elseif ($branch <> 1) {
                $btn.='<a onclick="mutationasset(this)" data-toggle="modal" data-target="#myModal" id="' . $idatatables->Raw_ID . '" name="' . $idatatables->FAID . '" class="mutationasset"  ><button class="btn btn-primary btn-xs" type="button" ' . $idisabled . '>Mutation</button></a>';
            } else {
                $btn.='<a onclick="mutationasset(this)" data-toggle="modal" data-target="#myModal" id="' . $idatatables->Raw_ID . '" name="' . $idatatables->FAID . '" class="mutationasset"  ><button class="btn btn-primary btn-xs" type="button" ' . $idisabled . '>Mutation</button></a>'
                        . '<a><button onclick="disposal(this)" class="btn btn-xs disposal ' . $iclass . '" type="button" name="' . $idatatables->FAID . '" id="' . $idatatables->Raw_ID . '" ' . $idisabled . '>' . $hd . '</button></a>';
            }
            $row[] = '<a data-toggle="modal" data-target="#myModal" id="' . $idatatables->FAID . '" onclick="detilasset(this)"><button class="btn btn-primary btn-xs" type="button" >Depreciation</button></a>' . $btn;
            $data[] = $row;
        }

        $output = array(
            "draw" => $_POST['draw'],
            "recordsTotal" => $this->datatables_custom->count_all(),
            "recordsFiltered" => $this->datatables_custom->count_filtered(),
            "data" => $data,
        );
        //output to json format
        echo json_encode($output);
    }

    public function detilasset($id) {
        $data = $this->assetlist->getDetil($id);
        $icount = count($data);
        $datas = array(
            'listdata' => $data,
            'icount' => $icount
        );
        $this->load->view('asset_management/listasset/detil_asset', $datas);
    }

    public function mutationasset($id, $faid) {
        $branch = $this->session->userdata('BranchID');
//        $branch = 8;
        $data = $this->assetlist->getzone();
        $type = $this->assetlist->gettype($id);
        $dataUnit = $this->assetlist->getunit($branch);
//            print_r($dataUnit);die();
        $datas = array(
            'zona' => $data,
            'id' => $id,
            'faid' => $faid,
            'type' => $type,
            'dataUnit' => $dataUnit
        );
        $this->load->view('asset_management/listasset/mutation', $datas);
    }

    public function disposal($id, $faid) {
        $return=$this->assetlist->disposal($id, $faid);
        echo json_encode($return);
    }

    public function mutasi($iid) {
        $faid = $this->assetlist->setMutasi();
        $data=$this->generateQR(1, $faid, $iid);
//        print_r($data);die();
        $this->load->view('asset_management/listasset/generateqr', $data);
    }

    function generateQR($status, $faid, $id) {
        $dataitem = $this->Payment_mdl->gendata_qrmutasi($id);
        foreach ($dataitem as $row) {
            //$BranchCode=substr($faid, 12,5);
            //echo $BranchCode;
            $array = explode(".", $faid);
            $kode = substr($array[2], 0, 5);

            $db2 = $this->load->database('config1', true);
            $sqlBranchCode = $db2->query("SELECT BranchCode FROM Mst_Branch WHERE BranchCode='" . $kode . "'");
            $BranchCode = '';
            if (!empty($sqlBranchCode->result())) {
                $BranchCode = $sqlBranchCode->result()[0]->BranchCode;
            }
//                        echo "1. ".$BranchCode."<br>";
            if ($BranchCode == '') {
                $sqlDivisionCode = $db2->query("SELECT DivisionCode FROM Mst_Division WHERE DivisionCode='" . $kode . "'");
                $DivisionCode = '';
                if (!empty($sqlDivisionCode->result())) {
                    $DivisionCode = $sqlDivisionCode->result()[0]->DivisionCode;
                }
                //                            echo "2. ".$DivisionCode."<br>";
                if ($DivisionCode == '') {
                    $field = 'br.BranchName,div.DivisionName,unit.BisUnitName';
                    $codefix = "LEFT JOIN Mst_BisUnit unit on br.BranchID = unit.BisUnitBranchID
                                LEFT JOIN Mst_Division div on br.BranchID = div.BranchID
                                where unit.BisUnitCode = '$kode'";
                } else {
                    $field = 'br.BranchName,div.DivisionName,unit.BisUnitName';
                    $codefix = "LEFT JOIN Mst_Division div on br.BranchID = div.BranchID
                                LEFT JOIN Mst_BisUnit unit on br.BranchID = unit.BisUnitBranchID
                                where div.DivisionCode = '$kode'";
                }
            } else {
                $field = 'br.BranchName,div.DivisionName,unit.BisUnitName';
                $codefix = "LEFT JOIN Mst_Division div on div.DivisionCode = '$kode'"
                        . "LEFT JOIN Mst_BisUnit unit on unit.BisUnitCode = '$kode'"
                        . "where br.BranchCode = '$kode'";
            }
//                        echo $codefix."<br>";
//                        die();
            $qdata = $db2->query("SELECT $field FROM Mst_Branch br $codefix");
            $qdata = $qdata->result_array();
            foreach ($qdata as $key) {
                $BranchName = $key['BranchName'];
                $DivisionName = $key['DivisionName'];
                $BisUnitName = $key['BisUnitName'];
            }
            if ($DivisionName == '') {
                $location = "(" . $BisUnitName . ")";
            } elseif ($BisUnitName == '') {
                $location = "(" . $DivisionName . ")";
            } else {
                $location = $BranchName;
            }
            $data = array(
                'faid' => $faid,
                'ItemName' => $row->ItemName,
                'IClassName' => $row->IClassName,
                'BranchName' => $BranchName,
                'location' => $location,
            );
        }
        // $this->load->view('payment/generateqr',$data);
        if ($status == 1)
            $this->session->set_flashdata('msg', 'Success! Mutation Assets Success');
        else
            $this->session->set_flashdata('msg', 'Success! Mutation Item Inventory Success');
        return $data;
//        $this->load->view('payment/generateqr', $data);
    }

    public function getBranch($zone) {
        $item = $this->assetlist->getbranch($zone);
        $data = "<option value=''>--Select--</option> ";
        foreach ($item as $row) {
            $data .=' <option kode="' . $row->BranchCode . '"  value="' . $row->BranchID . '">' . $row->BranchName . '</option>';
        }
        echo $data;
    }

    public function getdivisi($unit) {
        $data = $this->assetlist->getdivisi($unit);
        $list = "<option value=''>--Select--</option>";
        foreach ($data as $row) {
            $list .= '<option value="' . $row->DivisionID . '">' . $row->DivisionName . '</option>';
        }

        echo $list;
    }

    public function getunit($branch) {
        $data = $this->assetlist->getunit($branch);
        $list = "<option value=''>--Select--</option>";
        foreach ($data as $row) {
            $list .= '<option value="' . $row->BisUnitID . '">' . $row->BisUnitName . '</option>';
        }

        echo $list;
    }

    
    
    
}

/* End of file sec_user.php */
    /* Location: ./application/controllers/sec_user.php */    