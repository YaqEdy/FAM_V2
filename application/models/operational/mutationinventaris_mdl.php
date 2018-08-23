<?php

Class Mutationinventaris_mdl extends CI_Model {

    public function __construct() {
        parent::__construct();
    }

    function seldata($num, $offset, $src_category = null, $src = null) {
        //Koneksi keSQL SERVER
        $this->db2 = $this->load->database('config1', true);
        $lokasi = $this->getLokasi($this->session->userdata('user_id'));
        $data = '';
//		if($this->session->userdata('groupid') != 1){
//			if((int)$lokasi->BranchCode == 00000)
//				$data = 'and req.BranchID='.$lokasi->BranchID.' and req.DivisionID='.$lokasi->DivisionID;
//			else
//				$data = 'and req.BranchID='.$lokasi->BranchID.' and req.BisUnitID='.$lokasi->BisUnitID;
//		}
        //math 14 08 17
        $div = $this->session->userdata('DivisionID');
        $branch = $this->session->userdata('BranchID');
        $usergroup = $this->session->userdata('groupid');
        if ($branch == 1) { //JIKA PUSAT : semua ppi bisa lihat data kecuali ppi dengan usergroup support
            if (($div == '8' && $usergroup <> '3') || $div == '20' || $usergroup == '1') {
                $data = '';
            } else {
                $data = 'AND req.DivisionID=' . "$div";
            }
        } else { //JIKA CABANG : cabang hanya bisa melihat cabang dan divisinya saja
            $data = ' AND req.BranchID=' . "$branch";
        }

        if ($src != null) {
            $date = " and dep.Date like '%" . date('Y-m') . "%'";
            if ($src_category == 'BranchName') {
                $src_category = 'br.BranchName';
                $src = "like '%" . $src . "%'";
            } elseif ($src_category == 'ItemName') {
                $src_category = 'item.ItemName';
                $src = "like '%" . $src . "%'";
            }


            $querydata = $this->db2->query("SELECT item.ItemName, zone.ZoneName, br.BranchName, br.BranchCode, unit.BisUnitName,  div.DivisionName, trx.QTY, trx.Raw_ID, trx.FAID, trx.Period,trx.PriceVendor, trx.SetDatePayment, trx.Condition
												FROM Trx_DetItemReq trx
												INNER JOIN Mst_ItemList item ON trx.ItemID = item.ItemID
												INNER JOIN Mst_Request req ON trx.RequestID = req.RequestID
												INNER JOIN Mst_Branch br ON req.BranchID = br.BranchID
												LEFT JOIN Mst_BisUnit unit ON req.BisUnitID = unit.BisUnitID
												LEFT JOIN Mst_Division div ON req.DivisionID = div.DivisionID
												INNER JOIN Mst_Zonasi zone ON req.ZoneID = zone.ZoneID											
												where trx.Is_trash=0 and trx.Status=4 and trx.StatusLelang=0 and item.AssetType='OPEXINVENTARIS'" . $data . "
												and " . $src_category . " " . $src . " ORDER BY zone.ZoneID ");
        } else {
            if ($offset != null) {
                $of = $offset;
            } else {
                $of = 0;
            }


            $querydata = $this->db2->query("SELECT item.ItemName, zone.ZoneName, br.BranchName,br.BranchCode, unit.BisUnitName,  div.DivisionName, trx.QTY, trx.Raw_ID, trx.FAID, trx.Period,  trx.PriceVendor, trx.SetDatePayment, trx.Condition
												FROM Trx_DetItemReq trx
												INNER JOIN Mst_ItemList item ON trx.ItemID = item.ItemID
												INNER JOIN Mst_Request req ON trx.RequestID = req.RequestID
												INNER JOIN Mst_Branch br ON req.BranchID = br.BranchID									
												LEFT JOIN Mst_BisUnit unit ON req.BisUnitID = unit.BisUnitID
												LEFT JOIN Mst_Division div ON req.DivisionID = div.DivisionID
												INNER JOIN Mst_Zonasi zone ON req.ZoneID = zone.ZoneID												
												where trx.Is_trash=0 and trx.Status=4 and  trx.StatusLelang=0 and item.AssetType='OPEXINVENTARIS'" . $data . " 
				                                ORDER BY zone.ZoneID OFFSET $of ROWS FETCH NEXT $num ROWS ONLY ");
        }
        return $querydata->result();
        $querydata->close();
    }

    function seldetil($id) {
        //echo $id;die;
        $db2 = $this->load->database('config1', true);
        $querydata = $db2->query("SELECT * FROM Appv_List where Is_trash=0 and appvID='" . $id . "'");
        if (count($querydata) > 0) {
            return $querydata->result();
        } else {
            return false;
        }
        $querydata->close();
    }

    function sel_vendortype() {
        $db2 = $this->load->database('config1', true);
        $querydata = $db2->query("SELECT * FROM Mst_VendorType where Is_trash=0");
        return $querydata->result();
    }

    function savedata($category, $position, $level, $alternate) {
        $data = array(
            'AppvCategoryID' => $category,
            'PositionID' => $position,
            'ApprovalLevel' => $level,
            'Alternate' => $alternate,
            'Status' => 0,
            'Is_trash' => 0
        );

        $this->db2 = $this->load->database('config1', true);
        $this->db2->insert('Appv_List', $data);
        $this->db2->close();
    }

    function updatedata($id) {
        $data = array(
            'AppvCategoryID' => $this->input->post('category'),
            'PositionID' => $this->input->post('position'),
            'ApprovalLevel' => $this->input->post('level'),
            'Alternate' => $this->input->post('alternate')
        );
        $this->db2 = $this->load->database('config1', true);
        $this->db2->where('AppvID', $id);
        $this->db2->update('Appv_List', $data);
        $this->db2->close();
    }

    function deletedata($id) {
        $data = array(
            'Is_trash' => 1
        );
        $this->db2 = $this->load->database('config1', true);
        $this->db2->where('AppvID', $id);
        $this->db2->update('Appv_List', $data);
        $this->db2->close();
    }

    function jumlah() {
        $this->db2 = $this->load->database('config1', true);
//        $lokasi = $this->getLokasi($this->session->userdata('user_id'));
//        $dat = '';
//        if ($this->session->userdata('groupid') != 1) {
//            if ((int) $lokasi->BranchCode == 00000)
//                $dat = 'and req.BranchID=' . $lokasi->BranchID . ' and req.DivisionID=' . $lokasi->DivisionID;
//            else
//                $dat = 'and req.BranchID=' . $lokasi->BranchID . ' and req.BisUnitID=' . $lokasi->BisUnitID;
//        }
        $dat = '';
        $div = $this->session->userdata('DivisionID');
        $branch = $this->session->userdata('BranchID');
        $usergroup = $this->session->userdata('groupid');
        if ($branch == 1) { //JIKA PUSAT : semua ppi bisa lihat data kecuali ppi dengan usergroup support
            if (($div == '8' && $usergroup <> '3') || $div == '20' || $usergroup == '1') {
                $dat = '';
            } else {
                $dat = 'AND req.DivisionID=' . "$div";
            }
        } else { //JIKA CABANG : cabang hanya bisa melihat cabang dan divisinya saja
            $data = ' AND req.BranchID=' . "$branch";
        }
        $data = $this->db2->query("SELECT COUNT(trx.Raw_ID) AS jml 
									FROM Trx_DetItemReq trx
									INNER JOIN Mst_ItemList item ON trx.ItemID = item.ItemID
									INNER JOIN Mst_Request req ON trx.RequestID = req.RequestID
									where trx.Is_trash=0 and trx.Status=4 and item.AssetType='OPEXINVENTARIS' and trx.StatusLelang=0 " . $dat . "");
        return $data->result();
    }

    function getcategory() {
        $this->db2 = $this->load->database('config1', true);
        $data = $this->db2->query('SELECT AppvCategoryID, AppvCategoryMax, AppvCategoryMin  FROM Appv_ListCategory where Is_trash=0');
        return $data->result();
    }

    function getposition() {
        $this->db2 = $this->load->database('config1', true);
        $data = $this->db2->query('SELECT PositionID, PositionName FROM Mst_Position where Is_trash=0');
        return $data->result();
    }

    function setPeriod($id, $period) {
        $this->db2 = $this->load->database('config1', true);
        $data = $this->db2->query('UPDATE Trx_DetItemReq set Period=' . $period . ', Depreciation=PriceVendor/' . $period . ' where RAW_ID=' . $id);

        $depreciation = $this->db2->query('SELECT Depreciation,PriceVendor,SetDatePayment FROM Trx_DetItemReq where RAW_ID=' . $id);

        return $depreciation->row();
        $this->db2->close();
    }

    function setDepreciation($trxid, $date, $value) {
        $data = array(
            'TrxDetItemID' => $trxid,
            'Date' => $date,
            'Value' => $value
        );

        $this->db2 = $this->load->database('config1', true);
        $this->db2->insert('Depreciation', $data);
        $this->db2->close();
    }

    function getDetil($id) {
        $this->db2 = $this->load->database('config1', true);

        $data = $this->db2->query('SELECT item.ItemName, de.Date, de.Value
									FROM Depreciation de 
									INNER JOIN Trx_DetItemReq trx ON de.TrxDetItemID = trx.Raw_ID
									INNER JOIN Mst_ItemList item ON trx.ItemID = item.ItemID
									WHERE de.TrxDetItemID=' . $id);
        return $data->result();
    }

    function getLokasi($id) {
        $this->db2 = $this->load->database('config1', true);

        $data = $this->db2->query('SELECT emp.BranchID, emp.BisUnitID, emp.DivisionID , br.BranchCode
									FROM Mst_Employee emp
									LEFT JOIN Mst_Branch br ON br.BranchID = emp.BranchID
									WHERE EmployeeID=' . $id);
        return $data->row();
    }

    function setlelang($id) {
        $data = array(
            'StatusLelang' => 1,
            'DateLelang' => date('Y-m-d H:i:s')
        );
        $this->db2 = $this->load->database('config1', true);
        $this->db2->where('Raw_ID', $id);
        $this->db2->update('Trx_DetItemReq', $data);
        $this->db2->close();
    }

    function getbranch($id) {
        $this->db2 = $this->load->database('config1', true);
        $data = $this->db2->query('SELECT BranchName FROM Mst_Branch where Is_trash=0 AND BranchID=' . $id);
        return $data->row()->BranchName;
    }

    function getCodeBranch($idbranch) {
        $this->db2 = $this->load->database('config1', true);
        $division = $this->db2->query("SELECT BranchCode FROM Mst_Branch WHERE BranchID=" . $idbranch);

        return $division->row()->BranchCode;
    }

    function getBranchFromCode($id) {
        $this->db2 = $this->load->database('config1', true);
        $data = $this->db2->query("SELECT br.BranchName , div.DivisionName, br.BranchCode
									FROM Mst_Branch br
									LEFT JOIN Mst_Division div ON div.BranchID = br.BranchID									
									where br.Is_trash=0 AND (br.BranchCode=" . $id . " OR div.DivisionCode=" . $id . ")");
        return $data->row();
    }

}

?>