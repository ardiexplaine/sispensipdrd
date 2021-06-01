<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Attr extends CI_Controller {

	function __construct()
	{
		parent::__construct();
	}

    public function dropdown() {	
        $kpad = $this->input->post('pad');
        $html = '';
		$query = $this->db->get_where('perda',array('jenis'=>$kpad));
        foreach($query->result() as $row) {
            $html .= "<option value='".$row->docno."'>".$row->docnm."</option>";
        }
        echo json_encode(array('html'=>$html));
	}

}