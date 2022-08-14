<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Dashboard extends CI_Controller {

	function __construct()
	{
		parent::__construct();
		$this->auth->checkLogin();
	}

	public function index() {	
		$data['content'] = 'dashboard/index';
		$this->load->view('layout2',$data);
	}
	
	public function loadDashboardKab() {
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

		$SQL = "SELECT * FROM wf_status a LEFT JOIN ranperda b ON a.stscd=b.curst WHERE 1=1 AND b.curst NOT IN ('RNXX') AND b.wfcat='WF01' $conds ORDER BY a.stscd";
		//echo $SQL; exit;
		$query = $this->db->query($SQL);

		$data = array();
		$no = 1;
		foreach($query->result() as $row){

			$redlabel = $this->db->get_where('users', array('usrcd' => $row->zuser))->row();

			$sisahari=$this->Global_model->number_of_working_days(date('Y-m-d'),$row->jatuh_tempo);
			if($sisahari == 0 || $row->curst =='RNG1'){
				$sisahari = '';
			}

			$data[] = array(
				"no" => $no++,
				"wfnum" => $row->wfnum,
				"wfcat" => $row->wfcat,
				"daerah" => $redlabel->nama_lengkap,
				"sp_kab_kota" => $row->no_surat_ke_gubernur.'</br>'.$row->no_surat_ke_mendagri.'</br>'.$row->no_surat_ke_menkeu,
				"tglterima" => $this->tglvalid($row->tgl_diterima).'</br>'.$this->tglvalid($row->jatuh_tempo),
				"sp_provinsi" => $row->no_surat_gub_ke_kabkota.'</br>'.$this->tglvalid($row->tgl_surat_gub_ke_kabkota),
				"sp_kemendagri" => $row->no_surat_mendagri_kegub.'</br>'.$this->tglvalid($row->tgl_surat_mendagri_kegub),
				"sp_kemenkeu" => $row->no_surat_menkeu_ke_mendagri.'</br>'.$this->tglvalid($row->tgl_surat_menkeu_ke_mendagri),
				"stsnm" => $row->stsnm,
				"jml" => '<h1>'.$sisahari.'</h1>'
			);
		}

		$resultObj = $data;

		header("Content-type:application/json");
		echo json_encode($resultObj);
	}

	public function loadDashboardPro() {
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

		$SQL = "SELECT * FROM wf_status a LEFT JOIN ranperda b ON a.stscd=b.curst WHERE 1=1 AND b.curst NOT IN ('PVXX') AND b.wfcat='WF02' $conds ORDER BY a.stscd";
		$query = $this->db->query($SQL);

		$data = array();
		$no = 1;
		foreach($query->result() as $row){

			$redlabel = $this->db->get_where('users', array('usrcd' => $row->zuser))->row();

			$sisahari=$this->Global_model->number_of_working_days(date('Y-m-d'),$row->jatuh_tempo);
			if($sisahari == 0 || $row->curst =='PVF1'){
				$sisahari = '';
			}

			$data[] = array(
				"no" => $no++,
				"wfnum" => $row->wfnum,
				"wfcat" => $row->wfcat,
				"daerah" => $redlabel->nama_lengkap,
				"sp_provinsi" => $row->no_surat_ke_mendagri.'</br>'.$row->no_surat_ke_menkeu, 
				"tglterima" => $this->tglvalid($row->tgl_diterima).'</br>'.$this->tglvalid($row->jatuh_tempo),
				"sp_kemendagri" => $row->no_surat_gub_ke_kabkota.'</br>'.$this->tglvalid($row->tgl_surat_gub_ke_kabkota),
				"sp_kemenkeu" => $row->no_surat_menkeu_ke_mendagri.'</br>'.$this->tglvalid($row->tgl_surat_menkeu_ke_mendagri),
				"stsnm" => $row->stsnm,
				"jml" => '<h1>'.$sisahari.'</h1>'
			);
		}

		$resultObj = $data;

		header("Content-type:application/json");
		echo json_encode($resultObj);
	}

	function tglvalid($date){
		if($date == "0000-00-00" || $date == ""){
			return '';
		}else{
			return date('d F Y', strtotime($date));
		}
	}
}