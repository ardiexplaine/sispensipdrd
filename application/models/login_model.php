<?php if (!defined('BASEPATH')) exit('No direct script access allowed'); 

class Login_model extends CI_Model
{	
	function __construct()
	{
		parent::__construct();
	}
	
	function cek_login($data)
	{
		$cek['username'] = $data['username'];
		$cek['password'] = md5($data['password'].$this->config->item("key_login"));
		$cek['aktif']    = 'Y';
		$cek_login       = $this->db->get_where('users', $cek);
		
		if(count($cek_login->result())>0)
		{

			$row = $cek_login->row();

			if($row->nama_lengkap == '' || $row->jabatan == '' || $row->email == '' || $row->telepon ==''){
				$this->session->set_userdata(array('regis'=>TRUE, 'usrcd'=>$row->usrcd));
				$status = 2;
				$message = '';
				$resultObj = array("status" => $status, "message" =>$message);
				//exit();
			}else{
				$sess_data['usrcd'] 	   = $row->usrcd;
				$sess_data['nama_lengkap'] = $row->nama_lengkap;
				$sess_data['username'] 	   = $row->username;
				$sess_data['group_user']   = $row->group_user;
				$sess_data['user_type']    = $row->user_type;
				$sess_data['level']    	   = $row->superadmin;
				$sess_data['login']        = TRUE;
				if($row->group_user == '0'){
					$sess_data['whoami'] = 'Kemendagri';
				}else{
					$where = array("id"=>$row->group_user);
					$row = $this->db->get_where('hirarki', $where)->row();
					$sess_data['whoami'] = $row->namakab;
				}
				$this->session->set_userdata($sess_data);
				
				$status = 0;
				$message = 'login berhasil, halaman akan berpindah dalam 3 detik';
				$notif = $this->Global_model->getNotif($status,$message);
				$resultObj = array("status" => $status, "message" =>$message, "notif"=> $notif);
			}
			
		}
		else
		{
			$status = 1;
			$message = 'Username dan password tidak benar!';
			$notif = $this->Global_model->getNotif($status,$message);
            $resultObj = array("status" => $status, "message" =>$message, "notif"=> $notif);
        }
        return $resultObj;
	}

}