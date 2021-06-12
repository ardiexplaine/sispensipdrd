<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
date_default_timezone_set('Asia/Jakarta');

class Ranperda extends CI_Controller {

	function __construct() {
		parent::__construct();
		$this->auth->checkLogin();
		$this->load->model('Global_model');
		$this->load->model('Ranperda_model');
	}

	public function index() {
		$data['content'] = 'ranperda/selection';
		$this->load->view('layout2',$data);
	}

	public function kabkot() {
		$data['wfnum'] = $this->uri->segment(3);
		$data['content'] = 'ranperda/kabkot';
		$this->load->view('layout2',$data);
	}

	public function provin() {
		$data['wfnum'] = $this->uri->segment(3);
		$data['content'] = 'ranperda/provin';
		$this->load->view('layout2',$data);
	}

	public function workflow() {
		$wfnum = $this->input->post("wfnum");
		$cek = $this->db->get_where('ranperda', array('wfnum' => $wfnum));
		if($cek->num_rows()>0){
			$data = $cek->row();
			$curst = $data->curst;
			$wfcat = $data->wfcat;
		}else{
			$type = $this->session->userdata('user_type');
			if($type == 'KAB'){
				$curst = 'RNA1';
				$wfcat = 'WF01';
			}else{
				$curst = 'PVA1';
				$wfcat = 'WF02';
			}
			
		}
		$btnwf = $this->Global_model->ButtonWorkflow($wfcat,$curst);
		$data = array("status"=>1,"button"=>$btnwf);
		echo json_encode($data);
	}

	public function loadDropdown() {
		$mode = $this->input->post("mode");

		if($mode=='JENISSTATUS'){
			$option = $this->Ranperda_model->slcJenisStatus();
		}
		
		$data = array("status"=>0,"option"=>$option);
		echo json_encode($data);
	}

	function _wfcategory(){
		$type = $this->session->userdata('user_type');
		if($type == 'KAB'){
			$wfcat = 'WF01';
		}else{
			$wfcat = 'WF02';
		}
		return $wfcat;
	}

	function validationData($wfnum, $nexst){
		$res = true;

		if($nexst == 'RNB1' || $nexst == 'PVB1'){
			
		}

		if($nexst == 'RNC1' || $nexst == 'PVC1'){

			$fcode = array('FL01', 'FL02');
			$this->db->where_in('fcode', $fcode);
			$this->db->where('wfnum', $wfnum);
			$cek = $this->db->get('item_files');
			if($cek->num_rows() == 2){
				$res = true;
			}else{
				$res = false;
			}

			$fcode = array('KP01');
			$this->db->where_in('filetype', $fcode);
			$this->db->where('wfnum', $wfnum);
			$cek = $this->db->get('ranperda_files');
			if($cek->num_rows() > 0){
				$res = true;
			}else{
				$res = false;
			}
		}

		if($nexst == 'RNF1'){

			$fcode = array('FL03');
			$this->db->where_in('fcode', $fcode);
			$this->db->where('wfnum', $wfnum);
			$cek = $this->db->get('item_files');
			if($cek->num_rows() == 1){
				$res = true;
			}else{
				$res = false;
			}

			$fcode = array('PR01');
			$this->db->where_in('filetype', $fcode);
			$this->db->where('wfnum', $wfnum);
			$cek = $this->db->get('ranperda_files');
			if($cek->num_rows() > 0){
				$res = true;
			}else{
				$res = false;
			}
		}

		if($nexst == 'RNH1' || $nexst == 'PVE1'){

			$fcode = array('FL04');
			$this->db->where_in('fcode', $fcode);
			$this->db->where('wfnum', $wfnum);
			$cek = $this->db->get('item_files');
			if($cek->num_rows() == 1){
				$res = true;
			}else{
				$res = false;
			}

			$fcode = array('KM01');
			$this->db->where_in('filetype', $fcode);
			$this->db->where('wfnum', $wfnum);
			$cek = $this->db->get('ranperda_files');
			if($cek->num_rows() > 0){
				$res = true;
			}else{
				$res = false;
			}
		}

		if($nexst == 'RNI1'){

			$fcode = array('FL05');
			$this->db->where_in('fcode', $fcode);
			$this->db->where('wfnum', $wfnum);
			$cek = $this->db->get('item_files');
			if($cek->num_rows() == 1){
				$res = true;
			}else{
				$res = false;
			}

			$fcode = array('PR02');
			$this->db->where_in('filetype', $fcode);
			$this->db->where('wfnum', $wfnum);
			$cek = $this->db->get('ranperda_files');
			if($cek->num_rows() > 0){
				$res = true;
			}else{
				$res = false;
			}
		}

		if($nexst == 'RNJ1' || $nexst == 'PVF1'){

			$fcode = array('KP02');
			$this->db->where_in('filetype', $fcode);
			$this->db->where('wfnum', $wfnum);
			$cek = $this->db->get('ranperda_files');
			if($cek->num_rows() == 1){
				$res = true;
			}else{
				$res = false;
			}

			$fcode = array('KP02');
			$this->db->where_in('filetype', $fcode);
			$this->db->where('wfnum', $wfnum);
			$cek = $this->db->get('ranperda_files');
			if($cek->num_rows() > 0){
				$res = true;
			}else{
				$res = false;
			}
		}
		

		return $res;
	}

	public function saveData() {
		// echo '<pre>'; print_r($_POST);
		// exit();

		$wfnum = $this->input->post('wfnum');
		$nexst = $this->input->post('nexst');

		//if($this->validationData($wfnum, $nexst)) { // Blok Role Vlidasi Form

			$cek = $this->db->get_where('ranperda', array('wfnum' => $wfnum));
			if($cek->num_rows() == 0){

				$ranperda = array(
					"wfnum"=> $wfnum,
					"wfcat"=> $this->_wfcategory(),
					"zdate" => date('Y-m-d'),
					"ztime" => date('H:i:s'),
					"zuser" => $this->session->userdata('usrcd'),
					"curst"=> $this->input->post("curst"),
					"iscls"=> '',
					"group_user" => $this->session->userdata('group_user'),
					"kategori"=> $this->input->post('kategori'),
					"jns_pad"=> $this->input->post('jns_pad'),
					"jns_pajak"=> $this->input->post('jns_pajak')	
				);
				$this->db->insert('ranperda',$ranperda);
			}else{

				$ranperda = array(
					"wfnum"=> $wfnum,
					"zdate" => date('Y-m-d'),
					"ztime" => date('H:i:s'),
					"curst"=> $this->input->post("curst"),
					"iscls"=> '',
					"group_user" => $this->session->userdata('group_user'),
					"no_surat_ke_gubernur"=> $this->input->post('no_surat_ke_gubernur'),
					"tgl_surat_ke_gubernur"=> $this->input->post('tgl_surat_ke_gubernur'),
					"no_surat_ke_mendagri"=> $this->input->post('no_surat_ke_mendagri'),
					"tgl_surat_ke_mendagri"=> $this->input->post('tgl_surat_ke_mendagri'),
					"no_surat_ke_menkeu"=> $this->input->post('no_surat_ke_menkeu'),
					"tgl_surat_ke_menkeu"=> $this->input->post('tgl_surat_ke_menkeu'),
					"no_surat_menkeu_ke_mendagri"=> $this->input->post('no_surat_menkeu_ke_mendagri'),
					"tgl_surat_menkeu_ke_mendagri"=> $this->input->post('tgl_surat_menkeu_ke_mendagri'),
					"no_kepmenkeu"=> $this->input->post('no_kepmenkeu'),
					"tgl_kepmenkeu"=> $this->input->post('tgl_kepmenkeu'),
					"no_surat_gub_ke_kabkota"=> $this->input->post('no_surat_gub_ke_kabkota'),
					"tgl_surat_gub_ke_kabkota"=> $this->input->post('tgl_surat_gub_ke_kabkota'),
					"hasil_evaluasi"=> $this->input->post('hasil_evaluasi'),
					"no_kepgub"=> $this->input->post('no_kepgub'),
					"tgl_kepgub"=> $this->input->post('tgl_kepgub'),
					"no_surat_mendagri_kegub"=> $this->input->post('no_surat_mendagri_kegub'),
					"tgl_surat_mendagri_kegub"=> $this->input->post('tgl_surat_mendagri_kegub'),
					"no_kepmendagri"=> $this->input->post('no_kepmendagri'),
					"tgl_kepmendagri"=> $this->input->post('tgl_kepmendagri'),	
				);
				$this->db->update('ranperda',$ranperda, array("wfnum"=>$wfnum));
			}
			
			// $file1 = $this->do_upload(array('pdf','jpg','png'),'fileSuratPengantar');
			// if($file1["status"]==0) {
			// 	$item1 = array(
			// 		"wfnum"=> $wfnum,
			// 		"fcode"=> 'FL01',
			// 		"zdate" => date('Y-m-d'),
			// 		"ztime" => date('H:i:s'),
			// 		"zuser" => $this->session->userdata('usrcd'),
			// 		"original_name"=> $file1["upload_data"]["orig_name"],
			// 		"encrypt_name" => $file1["upload_data"]["file_name"]
			// 	);

			// 	$cek = $this->db->get_where('item_files', array('wfnum' => $wfnum, "fcode"=> 'FL01'));
			// 	if($cek->num_rows() == 0){
			// 		$this->db->insert('item_files', $item1);
			// 	}else{
			// 		$this->db->update('item_files',$item1, array('wfnum' => $wfnum, "fcode"=> 'FL01'));
			// 	}
			// }

			// $file1 = $this->do_upload(array('pdf','jpg','png'),'fileFL01');
			// if($file1["status"]==0) {
			// 	$item1 = array(
			// 		"wfnum"=> $wfnum,
			// 		"fcode"=> 'FL01',
			// 		"zdate" => date('Y-m-d'),
			// 		"ztime" => date('H:i:s'),
			// 		"zuser" => $this->session->userdata('usrcd'),
			// 		"original_name"=> $file1["upload_data"]["orig_name"],
			// 		"encrypt_name" => $file1["upload_data"]["file_name"]
			// 	);

			// 	$cek = $this->db->get_where('item_files', array('wfnum' => $wfnum, "fcode"=> 'FL01'));
			// 	if($cek->num_rows() == 0){
			// 		$this->db->insert('item_files', $item1);
			// 	}else{
			// 		$this->db->update('item_files',$item1, array('wfnum' => $wfnum, "fcode"=> 'FL01'));
			// 	}
			// }



			// $file2 = $this->do_upload(array('pdf','jpg','png'),'fileFL02');
			// if($file2["status"]==0) {
			// 	$item2 = array(
			// 		"wfnum"=> $wfnum,
			// 		"fcode"=> 'FL02',
			// 		"zdate" => date('Y-m-d'),
			// 		"ztime" => date('H:i:s'),
			// 		"zuser" => $this->session->userdata('usrcd'),
			// 		"original_name"=> $file2["upload_data"]["orig_name"],
			// 		"encrypt_name" => $file2["upload_data"]["file_name"]
			// 	);

			// 	$cek = $this->db->get_where('item_files', array('wfnum' => $wfnum, "fcode"=> 'FL02'));
			// 	if($cek->num_rows() == 0){
			// 		$this->db->insert('item_files', $item2);
			// 	}else{
			// 		$this->db->update('item_files',$item2, array('wfnum' => $wfnum, "fcode"=> 'FL02'));
			// 	}
			// }

			// $file3 = $this->do_upload(array('pdf'),'fileFL03');
			// if($file3["status"]==0) {
			// 	$item3 = array(
			// 		"wfnum"=> $wfnum,
			// 		"fcode"=> 'FL03',
			// 		"zdate" => date('Y-m-d'),
			// 		"ztime" => date('H:i:s'),
			// 		"zuser" => $this->session->userdata('usrcd'),
			// 		"original_name"=> $file3["upload_data"]["orig_name"],
			// 		"encrypt_name" => $file3["upload_data"]["file_name"]
			// 	);

			// 	$cek = $this->db->get_where('item_files', array('wfnum' => $wfnum, "fcode"=> 'FL03'));
			// 	if($cek->num_rows() == 0){
			// 		$this->db->insert('item_files', $item3);
			// 	}else{
			// 		$this->db->update('item_files',$item3, array('wfnum' => $wfnum, "fcode"=> 'FL03'));
			// 	}
			// }

			// $file4 = $this->do_upload(array('pdf'),'fileFL04');
			// if($file4["status"]==0) {
			// 	$item4 = array(
			// 		"wfnum"=> $wfnum,
			// 		"fcode"=> 'FL04',
			// 		"zdate" => date('Y-m-d'),
			// 		"ztime" => date('H:i:s'),
			// 		"zuser" => $this->session->userdata('usrcd'),
			// 		"original_name"=> $file4["upload_data"]["orig_name"],
			// 		"encrypt_name" => $file4["upload_data"]["file_name"]
			// 	);

			// 	$cek = $this->db->get_where('item_files', array('wfnum' => $wfnum, "fcode"=> 'FL04'));
			// 	if($cek->num_rows() == 0){
			// 		$this->db->insert('item_files', $item4);
			// 	}else{
			// 		$this->db->update('item_files',$item4, array('wfnum' => $wfnum, "fcode"=> 'FL04'));
			// 	}
			// }

			// $file5 = $this->do_upload(array('pdf','jpg','png'),'fileFL05');
			// if($file5["status"]==0) {
			// 	$item5 = array(
			// 		"wfnum"=> $wfnum,
			// 		"fcode"=> 'FL05',
			// 		"zdate" => date('Y-m-d'),
			// 		"ztime" => date('H:i:s'),
			// 		"zuser" => $this->session->userdata('usrcd'),
			// 		"original_name"=> $file5["upload_data"]["orig_name"],
			// 		"encrypt_name" => $file5["upload_data"]["file_name"]
			// 	);

			// 	$cek = $this->db->get_where('item_files', array('wfnum' => $wfnum, "fcode"=> 'FL05'));
			// 	if($cek->num_rows() == 0){
			// 		$this->db->insert('item_files', $item5);
			// 	}else{
			// 		$this->db->update('item_files',$item5, array('wfnum' => $wfnum, "fcode"=> 'FL05'));
			// 	}
			// }

			// input History
			$history = array(
				"wfnum"=> $wfnum,
				"zdate" => date('Y-m-d'),
				"ztime" => date('H:i:s'),
				"zuser" => $this->session->userdata('usrcd'),
				"from_status"=> $this->input->post("curst"),
				"to_status" => $this->input->post("nexst"),
				"reason" => ''
			);
			$cekHis = $this->db->get_where('wf_history', array('wfnum' => $wfnum, "from_status"=> $this->input->post("curst"), "to_status" => $this->input->post("nexst")));
			if($cekHis->num_rows() == 0){
				$this->db->insert('wf_history', $history);
			}else{
				$this->db->update('wf_history', $history, array('wfnum' => $wfnum, "from_status"=> $this->input->post("curst"), "to_status" => $this->input->post("nexst")));
			}
			

			if($this->input->post('nexst') != ''){
				$this->db->update('ranperda',array("curst"=>$this->input->post('nexst')), array("wfnum"=>$wfnum));
			}

			$ranperdaObj = array(
				"status" => 0,
				"message" => 'Ok',
				"wfnum"=> $wfnum,
				"zdate" => date('Y-m-d'),
				"ztime" => date('H:i:s'),
				"zuser" => $this->session->userdata('usrcd'),
				"curst"=> $this->input->post("curst"),
				//"desc"=> $this->input->post("txtTentang"),
				"group_user" => $this->session->userdata('group_user'),
				"iscls"=> ''
			);
		// }else{
		// 	$ranperdaObj = array(
		// 		"status" => 1,
		// 		"message" => "Data masih belum lengkap, harap periksa kembali.",
		// 		"wfnum"=> $wfnum,
		// 		"zdate" => date('Y-m-d'),
		// 		"ztime" => date('H:i:s'),
		// 		"zuser" => $this->session->userdata('usrcd'),
		// 		"curst"=> $this->input->post("curst"),
		// 		//"desc"=> $this->input->post("txtTentang"),
		// 		"group_user" => $this->session->userdata('group_user'),
		// 		"iscls"=> '',
		// 		"notif" => $this->Global_model->getNotif(1,"Data masih belum lengkap, harap periksa kembali.")
		// 	);
		// }
		echo json_encode($ranperdaObj);
	}

	public function rejectData(){
		$wfnum = $this->input->post('wfnum');
		$curre = $this->input->post("curre");
		$nexst = $this->input->post("nexst");
		$reasn = $this->input->post("reasn");

		$this->db->update('ranperda',array("curst"=>$nexst), array("wfnum"=>$wfnum));

		// input History
		$history = array(
			"wfnum"=> $wfnum,
			"zdate" => date('Y-m-d'),
			"ztime" => date('H:i:s'),
			"zuser" => $this->session->userdata('usrcd'),
			"from_status"=> $curre,
			"to_status" => $nexst,
			"reason" => $reasn
		);
		$this->db->insert('wf_history', $history);

		echo json_encode(array("wfnum"=>$wfnum));
	}

	public function do_upload($ext_allow,$objName) {
		$config['upload_path']   = './assets/uploads/'; 
		$config['allowed_types'] = implode("|",$ext_allow);
		$config['encrypt_name'] = true;
		$this->load->library('upload', $config);
		$this->upload->initialize($config);
		if ( ! $this->upload->do_upload($objName)) {
			if(isset($_FILES[$objName]['name'])){
				$status = 1;
				$message = strip_tags($this->upload->display_errors());
				$resultObj = array('status'=> $status, 'message' => $message, 'notif' =>  $this->Global_model->getNotif($status,$message) ); 
				echo json_encode($resultObj);
				exit();
			}else{
				$status = array('status'=>1, 'message' => 'ok');
			}
			
		}else { 
		   $status = array('status'=>0, 'message' => 'ok', 'upload_data' => $this->upload->data()); 
		}
		return $status;
	}

	public function single_upload($ext_allow,$objName) {
		$fdate = './assets/uploads/'.date('Ym').'/';

		$config['upload_path']   = $fdate.$this->input->post('wfnum').'/'; 
		$config['allowed_types'] = implode("|",$ext_allow);
		$config['encrypt_name'] = true;

		if(!is_dir($fdate)) mkdir($fdate, 0777, TRUE);
		if(!is_dir($config['upload_path'])) mkdir($config['upload_path'], 0777, TRUE);

		$this->load->library('upload', $config);
		$this->upload->initialize($config);
		if ( ! $this->upload->do_upload($objName)) {
			if(isset($_FILES[$objName]['name'])){
				$status = 1;
				$message = strip_tags($this->upload->display_errors());
				$resultObj = array('status'=> $status, 'message' => $message, 'notif' =>  $this->Global_model->getNotif($status,$message) ); 
				echo json_encode($resultObj);
				exit();
			}else{
				$status = array('status'=>1, 'message' => 'ok');
			}
			
		}else { 
		   $status = array('status'=>0, 'message' => 'ok', 'upload_data' => $this->upload->data()); 
		}
		return $status;
	}

	public function loaddata(){
		$wfnum = $this->input->post("wfnum");
		$header = $this->db->get_where('ranperda', array('wfnum' => $wfnum));
		$detail = $this->db->get_where('item_files', array('wfnum' => $wfnum));

		$fls = $header->row();
		$fileDownload = array(
			array(
				"fcode" => "file_surat_ke_gubernur",
				"oriname" => $fls->file_surat_ke_gubernur,
				"path" => $fls->file_surat_ke_gubernur_path
			),
			array(
				"fcode" => "file_surat_ke_mendagri",
				"oriname" => $fls->file_surat_ke_mendagri,
				"path" => $fls->file_surat_ke_mendagri_path
			),
			array(
				"fcode" => "file_surat_ke_menkeu",
				"oriname" => $fls->file_surat_ke_menkeu,
				"path" => $fls->file_surat_ke_menkeu_path
			),
			array(
				"fcode" => "file_ltr_blkng",
				"oriname" => $fls->file_ltr_blkng,
				"path" => $fls->file_ltr_blkng_path
			),
			array(
				"fcode" => "file_berita_acara",
				"oriname" => $fls->file_berita_acara,
				"path" => $fls->file_berita_acara_path
			),
			array(
				"fcode" => "file_ranperda",
				"oriname" => $fls->file_ranperda,
				"path" => $fls->file_ranperda_path
			),	
			array(
				"fcode" => "file_lampiran_ranperda",
				"oriname" => $fls->file_lampiran_ranperda,
				"path" => $fls->file_lampiran_ranperda_path
			),	
			array(
				"fcode" => "file_surat_menkeu_ke_mendagri",
				"oriname" => $fls->file_surat_menkeu_ke_mendagri,
				"path" => $fls->file_surat_menkeu_ke_mendagri_path
			),	
			array(
				"fcode" => "file_kepmenkeu",
				"oriname" => $fls->file_kepmenkeu,
				"path" => $fls->file_kepmenkeu_path
			),	
			array(
				"fcode" => "file_ttd_matrik_ev_menkeu",
				"oriname" => $fls->file_ttd_matrik_ev_menkeu,
				"path" => $fls->file_ttd_matrik_ev_menkeu_path
			),	
			array(
				"fcode" => "file_edited_matrik_ev_menkeu",
				"oriname" => $fls->file_edited_matrik_ev_menkeu,
				"path" => $fls->file_edited_matrik_ev_menkeu_path
			),	
			array(
				"fcode" => "file_surat_gub_ke_kabkota",
				"oriname" => $fls->file_surat_gub_ke_kabkota,
				"path" => $fls->file_surat_gub_ke_kabkota_path
			),	
			array(
				"fcode" => "file_kepgub",
				"oriname" => $fls->file_kepgub,
				"path" => $fls->file_kepgub_path
			),	
			array(
				"fcode" => "file_ttd_matrik_ev_provinsi",
				"oriname" => $fls->file_ttd_matrik_ev_provinsi,
				"path" => $fls->file_ttd_matrik_ev_provinsi_path
			),	
			array(
				"fcode" => "file_edited_matrik_ev_provinsi",
				"oriname" => $fls->file_edited_matrik_ev_provinsi,
				"path" => $fls->file_edited_matrik_ev_provinsi_path
			),	
			array(
				"fcode" => "file_surat_mendagri_kegub",
				"oriname" => $fls->file_surat_mendagri_kegub,
				"path" => $fls->file_surat_mendagri_kegub_path
			),	
			array(
				"fcode" => "file_kepmendagri",
				"oriname" => $fls->file_kepmendagri,
				"path" => $fls->file_kepmendagri_path
			),	
			array(
				"fcode" => "file_ttd_matrik_ev_mendagri",
				"oriname" => $fls->file_ttd_matrik_ev_mendagri,
				"path" => $fls->file_ttd_matrik_ev_mendagri_path
			),	
			array(
				"fcode" => "file_edited_matrik_ev_mendagri",
				"oriname" => $fls->file_edited_matrik_ev_mendagri,
				"path" => $fls->file_edited_matrik_ev_mendagri_path
			),	
			array(
				"fcode" => "file_revisi_ranperda",
				"oriname" => $fls->file_revisi_ranperda,
				"path" => $fls->file_revisi_ranperda_path
			),	
			array(
				"fcode" => "file_revisi_lampiran_ranperda",
				"oriname" => $fls->file_revisi_lampiran_ranperda,
				"path" => $fls->file_revisi_lampiran_ranperda_path
			)						
		);


		$resultObj = array("status" => 0, "message" =>'', "user_type" => $this->session->userdata('user_type'), "header"=> $fls, "item" => $detail->result_array(), "btnFiles" => $fileDownload);
		echo json_encode($resultObj);
	}

	public function loadstatus() {
		$stscd = $this->input->post("stscd");
		$cek = $this->db->get_where('wf_status', array('stscd' => $stscd));
		$row = $cek->row();

		$data = array("stscd"=>$row->stscd,"stsnm"=>$row->stsnm);
		echo json_encode($data);
	}

	function singlelink()
    {
		$path = '.'.$_GET['path']; 
		$name = $_GET['fname']; 
     	if(is_file($path))
      	{
			// required for IE
			if(ini_get('zlib.output_compression')) { ini_set('zlib.output_compression', 'Off'); }

			// get the file mime type using the file extension
			$this->load->helper('file');

			$mime = get_mime_by_extension($path);

			// Build the headers to push out the file properly.
			header('Pragma: public');     // required
			header('Expires: 0');         // no cache
			header('Cache-Control: must-revalidate, post-check=0, pre-check=0');
			header('Last-Modified: '.gmdate ('D, d M Y H:i:s', filemtime ($path)).' GMT');
			header('Cache-Control: private',false);
			header('Content-Type: '.$mime);  // Add the mime type from Code igniter.
			header('Content-Disposition: attachment; filename="'.basename($name).'"');  // Add the file name
			header('Content-Transfer-Encoding: binary');
			header('Content-Length: '.filesize($path)); // provide file size
			header('Connection: close');
			readfile($path); // push it out
			exit();
		}
	}

	function push_file($path, $name)
    {
		  // make sure it's a file before doing anything!
		$path = './assets/uploads/'.$path;  
     	if(is_file($path))
      	{
			// required for IE
			if(ini_get('zlib.output_compression')) { ini_set('zlib.output_compression', 'Off'); }

			// get the file mime type using the file extension
			$this->load->helper('file');

			$mime = get_mime_by_extension($path);

			// Build the headers to push out the file properly.
			header('Pragma: public');     // required
			header('Expires: 0');         // no cache
			header('Cache-Control: must-revalidate, post-check=0, pre-check=0');
			header('Last-Modified: '.gmdate ('D, d M Y H:i:s', filemtime ($path)).' GMT');
			header('Cache-Control: private',false);
			header('Content-Type: '.$mime);  // Add the mime type from Code igniter.
			header('Content-Disposition: attachment; filename="'.basename($name).'"');  // Add the file name
			header('Content-Transfer-Encoding: binary');
			header('Content-Length: '.filesize($path)); // provide file size
			header('Connection: close');
			readfile($path); // push it out
			exit();
		}
	}

	public function loadHistory() {
		$wfnum = $this->input->post('wfnum');
		$resultObj = $this->Ranperda_model->getHistory($wfnum);
		echo json_encode($resultObj);
	}

	public function searchData() {
		$conds = '';
		$usrcd = $this->session->userdata('usrcd');
		$usrty = $this->session->userdata('user_type');
		$group = $this->session->userdata('group_user');
		$wfnum = $this->input->post('wfnum');
		$curst = $this->input->post('slcJenisStatus');
		$kabkt = $this->input->post('slcDaerahKab');

		$srpng = $this->input->post('slcSuPeng');
		

		if($usrty == 'KAB'){ // 
			$conds .= "AND zuser='$usrcd' ";
		}
		if($usrty == 'PRO'){
			if($kabkt != ''){
				$conds .= "AND group_user=$kabkt ";
			} else{
				$dataOtorisasi = $this->Global_model->otorisasiUserPRO($group);
				$conds .= "AND group_user IN ('".implode("','",$dataOtorisasi)."') ";
			}	
		}

		if($usrty == 'KEM'){
			if($kabkt != ''){
				$conds .= "AND group_user=$kabkt ";
			} else{ 
				$dataOtorisasi = $this->Global_model->otorisasiUserKEM($usrcd);
				$conds .= "AND group_user IN ('".implode("','",$dataOtorisasi)."') ";
			}
		}

		if($wfnum !=''){
			$conds .= "AND wfnum='$wfnum' ";
		}
		if($curst !=''){
			$conds .= "AND curst='$curst' ";
		}

		if($srpng != ''){
			$conds .= "AND (sp_walikota LIKE '%$srpng%' OR sp_gubernur LIKE '%$srpng%' OR  sp_mdn LIKE '%$srpng%') ";
		}


		$SQL = "SELECT * FROM ranperda WHERE 1=1 $conds ORDER BY zdate,ztime DESC";
		// echo $SQL;
		// 	exit();
		$query = $this->db->query($SQL);

		if($query->num_rows()>0){
			
			foreach($query->result() as $row){
				if($row->wfcat == 'WF01'){
					$data[] = array(
						"wfnum" => $row->wfnum,
						"wfcat" => $row->wfcat,
						"zuser" => $this->Ranperda_model->getdesc('hirarki','namakab',array("id"=>$row->group_user)) ,
						"stsnm" => $this->Ranperda_model->getdesc('wf_status','stsnm',array("stscd"=>$row->curst)),
					);
				}else{
					$data[] = array(
						"wfnum" => $row->wfnum,
						"wfcat" => $row->wfcat,
						"zuser" => $this->Ranperda_model->getdesc('hirarki','namakab',array("id"=>$row->group_user)) ,
						"stsnm" => $this->Ranperda_model->getdesc('wf_status','stsnm',array("stscd"=>$row->curst)),
					);
				}
				
			}
			$resultObj = array("status"=>0,"message"=>"Ok", "result"=>$data);
		}else{
			$resultObj = array("status"=>1,"message"=>"Data Notfound", "notif" => $this->Global_model->getNotif(1,"Data Not found"));
		}

		header("Content-type:application/json");
		echo json_encode($resultObj);
	}

	function cekKosong($data){
		$res = '-';
		if($data == 'undefined'){
			$res = '-';
		}else{
			$res = $data;
		}
		return $res;
	}


	function slckabkot(){
		$kodeprov = $this->input->post('kodeprov');
		$html = '<option value="">- Semua Data</option>';
		$query = $this->db->get_where('hirarki', array("kodeprov" => $kodeprov));
		foreach ($query->result() as $row) {
			$html .= '<option value="'.$row->id.'">'.$row->namakab.'</option>';
		}

		echo json_encode(array('option'=>$html));
	}
	
	function additem() {
		$filetype = array();
		$wfnum = $this->input->post('wfnum');
		$filety = $this->input->post("filety");
		$filecd = $this->input->post("filecd");
		$title = $this->input->post("title");
		$filenm = $this->input->post("filenm");
		$fileid = $this->input->post("fileid");

		$kepgubno = $this->input->post("kepgubno");
		$kepgubtgl = $this->input->post("kepgubtgl");

		$perdareg = $this->input->post("perdareg");
		$perdano  = $this->input->post("perdano");
		$perdatgl = $this->input->post("perdatgl");

		if($filety == 'KM01' || $filety == 'PR02' || $filety == 'KP02'){
			$filetype = array('pdf');
		}else{
			$filetype = array('doc','docx');
		}

		$file1 = $this->single_upload($filetype,'fileid');
		if($file1["status"]==0) {
			
			$data = array(
				"wfnum"=> $wfnum,
				"zdate" => date('Y-m-d'),
				"ztime" => date('H:i:s'),
				"filecd" => $filecd,
				"filetype" => $filety,
				"title" => $title,
				"kepgubno" => $kepgubno,
				"kepgubtgl" => $kepgubtgl,
				"perdareg" => $perdareg,
				"perdano" => $perdano,
				"perdatgl" => $perdatgl,
				"original_name"=> $file1["upload_data"]["orig_name"],
				"encrypt_name" => strstr($file1["upload_data"]["full_path"], '/assets')
			);
			$this->db->insert('ranperda_files', $data);
			
			$status = 0;
			$message = 'ok';

			$resultObj = array('status'=>$status, "message"=>$message);
		}else{
			$status = 1;
			$message = 'Data Not Found!';
			$notif = $this->Global_model->getNotif(1,"Data Not found");
			$resultObj = array('status'=>$status, "message"=>$message, "notif"=>$notif);
		}
		echo json_encode($resultObj);
	}

	function loaditem(){
		$wfnum = $this->input->post('wfnum');
		$filety = $this->input->post('filety');

		$html = '';
		$this->db->order_by('zdate', 'ASC');
		$this->db->order_by('ztime', 'ASC');
		$query = $this->db->get_where('ranperda_files', array('wfnum' => $wfnum, "filetype" => $filety));

		
		if($query->num_rows() > 0){
			$ctg = $this->Ranperda_model->getdesc('ranperda','wfcat',array("wfnum"=>$wfnum));
			if($ctg == 'WF01') {
				$html .= '<div class="form-group">
							<div class="col-lg-2"></div>
								<div class="col-lg-9">';

				if($filety == 'KP01')	{
					
					$btn = $this->Ranperda_model->getdesc('ranperda','curst',array("wfnum"=>$wfnum));
					if(($btn == "RNA1" || $btn == "RNB1" || $btn == "RNBX") && $this->session->userdata('user_type') == 'KAB'){
						$disabled = '';
					}else{
						$disabled = 'disabled="disabled"';
					}

					$html .= '<table id="divtblKP01" class="table table-striped" data-provides="rowlink">
						<thead>
							<tr>
								<th>No</th>
								<th>File Uploads</th>
								<th>#</th>
							</tr>
						</thead>
						<tbody>';
					$no = 1;
					foreach($query->result() as $row){
					$html .='<tr class="rowlink">
								<td>'.$no.'</td>
								<td><a onclick="singlelink('."'".$row->encrypt_name."'".','."'".$row->original_name."'".');">'.$row->original_name.'</a></td>
								<td><button '.$disabled.' onclick="delItem('."'".$row->filetype."'".','."'".$row->wfnum."'".','."'".$row->filecd."'".');"></i> Hapus</button></td>
							</tr>';
						$no++;
					}
					
					$html .='</tbody></table>';
				}

				if($filety == 'KP02')	{	
					
					$btn = $this->Ranperda_model->getdesc('ranperda','curst',array("wfnum"=>$wfnum));
					if(($btn == "RNF1" || $btn == "RNIX") && $this->session->userdata('user_type') == 'KAB'){
						$disabled = '';
					}else{
						$disabled = 'disabled="disabled"';
					}

					$html .= '<table id="divtblKP01" class="table table-striped" data-provides="rowlink">
						<thead>
							<tr>
								<th>No</th>
								<th>No Reg Perda</th>
								<th>No Perda</th>
								<th>Tanggal</th>
								<th>Deskripsi File</th>
								<th>File</th>
								<th>#</th>
							</tr>
						</thead>
						<tbody>';
					$no = 1;
					foreach($query->result() as $row){
					$html .='<tr class="rowlink">
								<td>'.$no.'</td>
								<td>'.$row->perdareg.'</td>
								<td>'.$row->perdano.'</td>
								<td>'.$row->perdatgl.'</td>
								<td>'.$row->title.'</td>
								<td><a onclick="singlelink('."'".$row->encrypt_name."'".','."'".$row->original_name."'".');">'.$row->original_name.'</a></td>
								<td><button '.$disabled.' class="zbtnItem'.$no.'" onclick="delItem('."'".$row->filetype."'".','."'".$row->wfnum."'".','."'".$row->filecd."'".');"></i> Hapus</button></td>
							</tr>';
							$no++;
					}
					$html .='</tbody>
						</table>';
				}

				if($filety == 'PR01')	{
					
					$btn = $this->Ranperda_model->getdesc('ranperda','curst',array("wfnum"=>$wfnum));
					if(($btn == "RND1" || $btn == "RNE1" || $btn == "RNEX" || $btn == "PVB1") && $this->session->userdata('user_type') == 'PRO'){
						$disabled = '';
					}else{
						$disabled = 'disabled="disabled"';
					}

					$html .= '<table id="divtblKP01" class="table table-striped" data-provides="rowlink">
						<thead>
							<tr>
								<th>No</th>
								<th>Name</th>
								<th>File Uploads</th>
								<th>#</th>
							</tr>
						</thead>
						<tbody>';
					$no = 1;
					foreach($query->result() as $row){
					$html .='<tr class="rowlink">
								<td>'.$no.'</td>
								<td>'.$row->title.'</td>
								<td><a onclick="fdownload('."'".$row->encrypt_name."'".','."'".$row->original_name."'".');">'.$row->original_name.'</a></td>
								<td><button '.$disabled.' onclick="delItem('."'".$row->filetype."'".','."'".$row->wfnum."'".','."'".$row->filecd."'".');"></i> Hapus</button></td>
							</tr>';
							$no++;
					}
					$html .='</tbody></table>';
				}

				if($filety == 'KM01'){
					$btn = $this->Ranperda_model->getdesc('ranperda','curst',array("wfnum"=>$wfnum));
					if($btn == "RNG1" && $this->session->userdata('user_type') == 'KEM'){
						$disabled = '';
					}else{
						$disabled = 'disabled="disabled"';
					}

					$html .= '<table id="divtblKP01" class="table table-striped" data-provides="rowlink">
						<thead>
							<tr>
								<th>No</th>
								<th>Name</th>
								<th>File Uploads</th>
								<th>#</th>
							</tr>
						</thead>
						<tbody>';
					$no = 1;
					foreach($query->result() as $row){
					$html .='<tr class="rowlink">
								<td>'.$no.'</td>
								<td>'.$row->title.'</td>
								<td><a onclick="fdownload('."'".$row->encrypt_name."'".','."'".$row->original_name."'".');">'.$row->original_name.'</a></td>
								<td><button '.$disabled.' onclick="delItem('."'".$row->filetype."'".','."'".$row->wfnum."'".','."'".$row->filecd."'".');"></i> Hapus</button></td>
							</tr>';
							$no++;
					}
					$html .='</tbody></table>';
				}

				if($filety == 'PR02')	{
					
					$btn = $this->Ranperda_model->getdesc('ranperda','curst',array("wfnum"=>$wfnum));
					if($btn == "RNH1" && $this->session->userdata('user_type') == 'PRO'){
						$disabled = '';
					}else{
						$disabled = 'disabled="disabled"';
					}

					$html .= '<table id="divtblKP01" class="table table-striped" data-provides="rowlink">
						<thead>
							<tr>
								<th>No</th>
								<th>No KepGub</th>
								<th>Tgl KepGub</th>
								<th>Deskripsi File</th>
								<th>File</th>
								<th>#</th>
							</tr>
						</thead>
						<tbody>';
					$no = 1;
					foreach($query->result() as $row){
					$html .='<tr class="rowlink">
								<td>'.$no.'</td>
								<td>'.$row->kepgubno.'</td>
								<td>'.$row->kepgubtgl.'</td>
								<td>'.$row->title.'</td>
								<td><a onclick="fdownload('."'".$row->encrypt_name."'".','."'".$row->original_name."'".');">'.$row->original_name.'</a></td>
								<td><button '.$disabled.' onclick="delItem('."'".$row->filetype."'".','."'".$row->wfnum."'".','."'".$row->filecd."'".');"></i> Hapus</button></td>
							</tr>';
							$no++;
					}
					$html .='</tbody>
						</table>';
				}

				$html .= '</div>
						</div>';
			}

			if($ctg == 'WF02') {
				$html .= '<div class="form-group">
							<div class="col-lg-2"></div>
								<div class="col-lg-9">';

				if($filety == 'KP01')	{
					
					$btn = $this->Ranperda_model->getdesc('ranperda','curst',array("wfnum"=>$wfnum));
					if(($btn == "PVA1" || $btn == "PVB1" || $btn == "PVBX") && $this->session->userdata('user_type') == 'PRO'){
						$disabled = '';
					}else{
						$disabled = 'disabled="disabled"';
					}

					$html .= '<table id="divtblKP01" class="table table-striped" data-provides="rowlink">
						<thead>
							<tr>
								<th>No</th>
								<th>Name</th>
								<th>File Uploads</th>
								<th>#</th>
							</tr>
						</thead>
						<tbody>';
					$no = 1;
					foreach($query->result() as $row){
					$html .='<tr class="rowlink">
								<td>'.$no.'</td>
								<td>'.$row->title.'</td>
								<td><a onclick="fdownload('."'".$row->encrypt_name."'".','."'".$row->original_name."'".');">'.$row->original_name.'</a></td>
								<td><button '.$disabled.' onclick="delItem('."'".$row->filetype."'".','."'".$row->wfnum."'".','."'".$row->filecd."'".');"></i> Hapus</button></td>
							</tr>';
						$no++;
					}
					$html .='</tbody></table>';
				}

				if($filety == 'KM01'){
					$btn = $this->Ranperda_model->getdesc('ranperda','curst',array("wfnum"=>$wfnum));
					if($btn == "PVD1" && $this->session->userdata('user_type') == 'KEM'){
						$disabled = '';
					}else{
						$disabled = 'disabled="disabled"';
					}

					$html .= '<table id="divtblKP01" class="table table-striped" data-provides="rowlink">
						<thead>
							<tr>
								<th>No</th>
								<th>Name</th>
								<th>File Uploads</th>
								<th>#</th>
							</tr>
						</thead>
						<tbody>';
					$no = 1;
					foreach($query->result() as $row){
					$html .='<tr class="rowlink">
								<td>'.$no.'</td>
								<td>'.$row->title.'</td>
								<td><a onclick="fdownload('."'".$row->encrypt_name."'".','."'".$row->original_name."'".');">'.$row->original_name.'</a></td>
								<td><button '.$disabled.' onclick="delItem('."'".$row->filetype."'".','."'".$row->wfnum."'".','."'".$row->filecd."'".');"></i> Hapus</button></td>
							</tr>';
						$no++;
					}
					$html .='</tbody></table>';
				}

				if($filety == 'KP02')	{	
					
					$btn = $this->Ranperda_model->getdesc('ranperda','curst',array("wfnum"=>$wfnum));
					if(($btn == "PVE1" || $btn == "PVEX") && $this->session->userdata('user_type') == 'PRO'){
						$disabled = '';
					}else{
						$disabled = 'disabled="disabled"';
					}

					$html .= '<table id="divtblKP01" class="table table-striped" data-provides="rowlink">
						<thead>
							<tr>
								<th>No</th>
								<th>No Reg Perda</th>
								<th>No Perda</th>
								<th>Tanggal</th>
								<th>Deskripsi File</th>
								<th>File</th>
								<th>#</th>
							</tr>
						</thead>
						<tbody>';
					$no = 1;
					foreach($query->result() as $row){
					$html .='<tr class="rowlink">
								<td>'.$no.'</td>
								<td>'.$row->perdareg.'</td>
								<td>'.$row->perdano.'</td>
								<td>'.$row->perdatgl.'</td>
								<td>'.$row->title.'</td>
								<td><a onclick="fdownload('."'".$row->encrypt_name."'".','."'".$row->original_name."'".');">'.$row->original_name.'</a></td>
								<td><button '.$disabled.' onclick="delItem('."'".$row->filetype."'".','."'".$row->wfnum."'".','."'".$row->filecd."'".');"></i> Hapus</button></td>
							</tr>';
							$no++;
					}
					$html .='</tbody>
						</table>';
				}

				$html .= '</div>
						</div>';
			}
		}

		echo json_encode(array('status'=>1, "message"=>'ok', "html"=>$html));
		
	}

	function delitem() {

		$wfnum = $this->input->post('wfnum');
		$filety = $this->input->post("filety");
		$filecd = $this->input->post("filecd");

		$where = array("wfnum"=>$wfnum, "filecd"=>$filecd, "filetype"=>$filety);
		$row = $this->db->get_where('ranperda_files', $where)->row();
		unlink('.'.$row->encrypt_name);

		$this->db->delete('ranperda_files', $where);
			
		$status = 0;
		$message = '';

		$resultObj = array('status'=>$status, "message"=>$message);
		echo json_encode($resultObj);
	}

	function getNDI(){

		$usr = $this->session->userdata('group_user');
		$data = $this->db->get_where('hirarki', array('id' => $this->session->userdata('group_user')));

		if($data->num_rows()>0){
			$row = $data->row();
			$tID = $row->kdprov.$row->kdkabkota.date("ymdHis");

			$status = 0;
			$message = 'ok';

			$resultObj = array('status'=>$status, "message"=>$message, "ndi" => $tID);
		}else{
			$tID = '';

			$status = 1;
			$message = 'Gagal Membuat NDI';

			$resultObj = array('status'=>$status, "message"=>$message, "ndi" => $tID);
		}
		header("Content-type:application/json");
		echo json_encode($resultObj);
	}

	function douploads(){
		// echo '<pre>'; print_r($_POST);
		// echo '<pre>'; print_r($_FILES);
		// exit();
		$attr_name = $this->input->post('attr_name');
		$fileext = $this->input->post('fileext');
		$file1 = $this->single_upload(explode(",",$fileext),$attr_name);
		if($file1["status"]==0) {
			$data = array(
				$attr_name => $file1["upload_data"]["orig_name"],
				$attr_name."_path" => strstr($file1["upload_data"]["full_path"], '/assets')
			);
			$this->db->update('ranperda',$data, array('wfnum' => $this->input->post('wfnum')));

			echo json_encode(array(
				'status' => 0,
				'orig_name' => $file1["upload_data"]["orig_name"],
				'full_path' => strstr($file1["upload_data"]["full_path"], '/assets')
			));
		}
		
	}
}

/* End of file welcome.php */
/* Location: ./application/controllers/welcome.php */