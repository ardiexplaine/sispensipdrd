<?php if (!defined('BASEPATH')) exit('No direct script access allowed');


class Ranperda_model extends CI_Model
{	
	function __construct()
	{
		parent::__construct();
	}

	function getHistory($wfnum){

		$SQL = "SELECT * FROM wf_history where wfnum='$wfnum' ORDER BY zdate,ztime";
		$query = $this->db->query($SQL);
		$data = array();
		foreach($query->result() as $row){
			$data[] = array(
				"zdate" => date('d F Y', strtotime($row->zdate)), 
				"ztime" => $row->ztime, 
				"zuser"=> $this->getdesc('users','username',array("usrcd"=>$row->zuser)), 
				"from_status"=> $this->getdesc('wf_status','stsnm',array("stscd"=>$row->from_status)),
				"to_status" => $this->getdesc('wf_status','stsnm',array("stscd"=>$row->to_status)),
				"reason" => $row->reason
			);
		}
		return $data;
	}

	function getdesc($table,$cols,$where){
		if(is_array($where)){
			$data = $this->db->get_where($table, $where);
			$row = $data->row();
			return $row->$cols;
		}
		return '';
	}

	function slcJenisStatus() {
		$html = '<option value="">- Semua Data</option>';
		$query = $this->db->get('wf_status');	
		foreach ($query->result() as $row) {
			$html .= '<option value="'.$row->stscd.'">'.$row->stscd.' - '.$row->stsnm.'</option>';
		}
		return $html;
	}

}