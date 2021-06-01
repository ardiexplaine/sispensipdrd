<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Dashboard extends CI_Controller {

	function __construct()
	{
		parent::__construct();
	}

	public function index() {	
		$data['content'] = 'dashboard/index';
		$this->load->view('layout2',$data);
	}
	
	public function loadDashboard() {
		$conds = '';
		$usrcd = $this->session->userdata('usrcd');
		$usrty = $this->session->userdata('user_type');
		$group = $this->session->userdata('group_user');
		

		if($usrty == 'KAB'){ // 
			$conds .= "AND b.group_user='$group' ";
		}
		if($usrty == 'PRO'){
			$dataOtorisasi = $this->Global_model->otorisasiUserPRO($group);
			$conds .= "AND b.group_user IN ('".implode("','",$dataOtorisasi)."') ";
		}

		if($usrty == 'KEM'){
			$dataOtorisasi = $this->Global_model->otorisasiUserKEM($usrcd);
			$conds .= "AND b.group_user IN ('".implode("','",$dataOtorisasi)."') ";
		}

		$SQL = "SELECT a.*, COUNT(b.curst) as jml FROM wf_status a LEFT JOIN ranperda b ON a.stscd=b.curst WHERE 1=1 $conds GROUP BY b.curst ORDER BY a.stscd";
		$query = $this->db->query($SQL);

		$data = array();
		$no = 1;
		foreach($query->result() as $row){
			$data[] = array(
				"no" => $no++,
				"stsnm" => $row->stsnm,
				"jml" => $row->jml
			);
		}

		$resultObj = $data;

		header("Content-type:application/json");
		echo json_encode($resultObj);
	}
}