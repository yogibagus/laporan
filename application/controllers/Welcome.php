<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Welcome extends CI_Controller {

	public function __construct()
	{
		parent::__construct();
		$this->load->model(['M_laporan']);
	}
	public function index()
	{	

		if($this->input->get("daterange") == null){
			$data['laporan'] = null;
			$data['first'] = null;
		}else{
			$daterange = $this->input->get('daterange');
			$gudang = $this->input->get('gudang');
			$item = $this->input->get('item');
			$date = (explode(" - ", $daterange));
			echo $date[0] . "-" . $date[1] . " | ";

			$result = $this->M_laporan->get_first_total($date[0],$gudang, $item);

			$jumlah = $result->total_jumlah_masuk - $result->total_jumlah_keluar;	
			$saldo = $result->hpp * $jumlah;
				$data = [
					'jumlah' => $jumlah,
					'harga' => $result->hpp,
					'saldo' => $saldo
				];

			

			
			$stock = $this->M_laporan->get_kartu_stok($date[0], $date[1], $gudang, $item);
			if($stock != false){
				$data['laporan'] = $stock;
			}else{
				$data['laporan'] = null;
			}

		 echo $gudang . "-" . $item;
		}

		$data['gudang'] = $this->M_laporan->get_gudang();
		$data['cabang'] = $this->M_laporan->get_cabang();
		$data['item'] = $this->M_laporan->get_item();
		$this->load->view('welcome_message', $data);
		
	}

	public function get_gudang($id)
	{
		$data = $this->M_laporan->get_gudang_by_id_cabang($id);
		echo json_encode($data);
	}

}
