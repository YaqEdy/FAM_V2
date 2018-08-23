<?php

Class Opex_mdl extends CI_Model {

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
//				$data = 'and req.BranchID='.$lokasi->BranchID;
//		}
//		
        //dewi 23 08 17
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
                $src_category = ' and br.BranchName';
                $src = "like '%" . $src . "%'";
            } elseif ($src_category == 'ItemName') {
                $src_category = 'and item.ItemName';
                $src = "like '%" . $src . "%'";
            }

            $querydata = $this->db2->query("SELECT item.ItemName, zone.ZoneName, br.BranchName, br.BranchCode,  
												div.DivisionName, trx.QTY, trx.Raw_ID, trx.Period,  trx.PriceVendor, trx.SetDatePayment
												FROM Trx_DetItemReq trx
												INNER JOIN Mst_ItemList item ON trx.ItemID = item.ItemID
												INNER JOIN Mst_Request req ON trx.RequestID = req.RequestID
												INNER JOIN Mst_Branch br ON req.BranchID = br.BranchID												
												LEFT JOIN Mst_Division div ON req.DivisionID = div.DivisionID
												INNER JOIN Mst_Zonasi zone ON req.ZoneID = zone.ZoneID
												where trx.Is_trash=0 and trx.Status in (1,2) and  item.AssetType 
												NOT IN ('CAPEX','OPEXINVENTARIS') " . $data . "
												" . $src_category . " " . $src . " ORDER BY zone.ZoneID ");
        } else {
            if ($offset != null) {
                $of = $offset;
            } else {
                $of = 0;
            }
            $querydata = $this->db2->query("SELECT trx.Status,type.ReqTypeName,req.RequestID,item.ItemName, zone.ZoneName, br.BranchName, br.BranchCode, 
 												div.DivisionName, trx.QTY, trx.Raw_ID, trx.Period,  trx.PriceVendor, trx.SetDatePayment
												FROM Trx_DetItemReq trx
												INNER JOIN Mst_ItemList item ON trx.ItemID = item.ItemID
												INNER JOIN Mst_Request req ON trx.RequestID = req.RequestID
												INNER JOIN Mst_Branch br ON req.BranchID = br.BranchID												
												LEFT JOIN Mst_Division div ON req.DivisionID = div.DivisionID
												INNER JOIN Mst_Zonasi zone ON req.ZoneID = zone.ZoneID
												LEFT JOIN Mst_RequestType type ON req.ReqTypeID = type.ReqTypeID
                                                                                                where 
                                                                            			trx.Is_trash=0  and trx.Status in (1,2)  
												and  item.AssetType  
												NOT IN ('CAPEX','OPEXINVENTARIS') " . $data . "
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

    function jumlah() {
        $this->db2 = $this->load->database('config1', true);
        $lokasi = $this->getLokasi($this->session->userdata('user_id'));
        $dat = '';
        if ($this->session->userdata('groupid') != 1) {
            if ((int) $lokasi->BranchCode == 00000)
                $dat = 'and req.BranchID=' . $lokasi->BranchID . ' and req.DivisionID=' . $lokasi->DivisionID;
            else
                $dat = 'and req.BranchID=' . $lokasi->BranchID;
        }

        $data = $this->db2->query("SELECT COUNT(trx.Raw_ID) AS jml
									FROM Trx_DetItemReq trx
									INNER JOIN Mst_ItemList item ON trx.ItemID = item.ItemID
									INNER JOIN Mst_Request req ON trx.RequestID = req.RequestID
									INNER JOIN Mst_Branch br ON req.BranchID = br.BranchID									
									LEFT JOIN Mst_Division div ON req.DivisionID = div.DivisionID
									WHERE item.AssetType NOT IN ('CAPEX','OPEXINVENTARIS') AND trx.Status=2 AND trx.Is_trash=0 " . $dat . "");
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

}

?>