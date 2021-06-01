<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
date_default_timezone_set('Asia/Jakarta');

class Api extends CI_Controller {

	function __construct()
	{
		parent::__construct();
		$this->auth->checkLogin();
		$this->load->model('Global_model');
		$this->load->model('Ranperda_model');
    }

    public function dataNotifkasi() {
		$conds = '';
		$usrcd = $this->session->userdata('usrcd');
		$usrty = $this->session->userdata('user_type');
		$group = $this->session->userdata('group_user');

		if($usrty == 'KAB'){ // 
			$conds .= "AND zuser='$usrcd' AND curst IN ('RND1','RNBX','RNJ1','RNK1','RNKX') ";
		}
		if($usrty == 'PRO'){             
            $dataOtorisasi = $this->Global_model->otorisasiUserPRO($group);
			$conds .= "AND group_user IN ('".implode("','",$dataOtorisasi)."') AND curst IN ('RNC1','RNG1','RNEX','RNH1','PVE1','PVG1','PVEX') ";
        }

		if($usrty == 'KEM'){ 
			$dataOtorisasi = $this->Global_model->otorisasiUserKEM($usrcd);
			$conds .= "AND group_user IN ('".implode("','",$dataOtorisasi)."') AND curst IN ('PVC1','RNF1') ";
		}

        $html = '';
		$SQL = "SELECT * FROM ranperda WHERE 1=1 $conds ORDER BY zdate,ztime DESC LIMIT 10";
		$query = $this->db->query($SQL);
		if($query->num_rows()>0){
			
			foreach($query->result() as $row){
				$html .= "<tr data-dismiss='modal' onclick='setDetailData(".'"'.$row->wfcat.'","'.$row->wfnum.'"'.")' class='rowlink'>
                                <td>".$row->wfnum."</td>
                                <td>".$this->Ranperda_model->getdesc('hirarki','namakab',array("id"=>$row->group_user))."</td>
                                <td>".$this->Ranperda_model->getdesc('wf_status','stsnm',array("stscd"=>$row->curst))."</td>
                                <td>".$this->Global_model->getDateHistoryAction($row->wfnum,$row->curst)."</td>    
                          </tr>";
			}
		}else{
			$html .= "<tr data-dismiss='modal'>
                        <td colspan='4'>Tidak ada Notifikasi</td>
                      </tr>";
		}
		return $html;
	}

    public function getmodal(){
        $html = '';
        $mode = $this->input->post('mode');

        if($mode=='NOTIF'){
            $html .= "<div class='modal-header'>
                    <button type='button' class='close' data-dismiss='modal' aria-hidden='true'>&times;</button>
                    <h3 class='modal-title'>Pemberitahuan Baru</h3>
                </div>
                <div class='modal-body'>
                    <table id='dataModalTable' data-provides='rowlink'>
                        <thead>
                            <tr>
                                <th>WF No.</th>
                                <th>From</th>
                                <th>Status</th>
                                <th>Tanggal</th>
                            </tr>
                        </thead>
                        <tbody>";
                            
                        $html .= $this->dataNotifkasi();
             $html .= "</tbody>
                    </table>
                </div>";
        }
        
        $resultObj = array("status"=>0, "message"=> 'load modal, OK', "htmlmodal"=> $html);
        $this->withJson($resultObj);
    }

    function changepassword(){
        $data['content'] = 'cpassword';
		$this->load->view('layout2',$data);
    }

    function proseschangepassword() {
		$this->form_validation->set_rules('oldpass','Password Lama','required|xss_clean');
        $this->form_validation->set_rules('newpass','Password Baru','required|xss_clean');
        $this->form_validation->set_rules('ulapass', 'Password Confirmation', 'trim|required|matches[newpass]');
		
		if($this->form_validation->run() == TRUE)
		{
            $cek['usrcd']    = $this->session->userdata('usrcd');
            $cek['password'] = md5($this->input->post('oldpass').$this->config->item("key_login"));
            $cek_login       = $this->db->get_where('users', $cek);
            
            if(count($cek_login->result())>0) {   
                $this->db->update('users',array("password"=>md5($this->input->post('newpass').$this->config->item("key_login"))), array("usrcd"=>$cek['usrcd']));
                
                $status = 0;
                $message = 'Password berhasil dirubah';
                $notif = $this->Global_model->getNotif($status,$message);
                $resultObj = array("status" => $status, "message" =>$message, "notif"=> $notif);
            }else{
                $status = 1;
                $message = 'Password lama salah';
                $notif = $this->Global_model->getNotif($status,$message);
                $resultObj = array("status" => $status, "message" =>$message, "notif"=> $notif);
            }
			
		}else{
			$status = 1;
			$message = strip_tags(validation_errors());
			$notif = $this->Global_model->getNotif($status,$message);
            $resultObj = array("status" => $status, "message" =>$message, "notif"=> $notif);
		}
		echo $this->withJson($resultObj);
		
	}

    function withJson($resultObj){
        header("Content-type:application/json");
		echo json_encode($resultObj);
    }
}