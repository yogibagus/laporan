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
			echo $date[0] . "-" . $date[1];

			$result = $this->M_laporan->get_first_total($date[0],$gudang, $item);

			$jumlah = $result->jumlah_masuk - $result->jumlah_keluar;	
			$saldo = $result->hpp* $jumlah;
				$data = [
					'jumlah' => $jumlah,
					'harga' => $result->hpp,
					'saldo' => $saldo
				];
			// if($result != false) {
			// 	$jumlah = 0;
			// 	foreach ($result as $key => $value) {
			// 		if ($value->jumlah_masuk != null) {
			// 			$jumlah = $jumlah + $value->jumlah_masuk;
			// 			$saldo = $jumlah * $value->hpp;
			// 		}

			// 		if ($value->jumlah_keluar != null) {
			// 			$jumlah = $jumlah - $value->jumlah_keluar;
			// 			$saldo = $jumlah * $value->hpp;
			// 		}
			// 	}

			// 	$harga = $result[0]->hpp;

			// 	$data = [
			// 		'jumlah' => $jumlah,
			// 		'harga' => $harga,
			// 		'saldo' => $saldo
			// 	];
			// }else{
			// 	$data = [
			// 		'jumlah' => 0,
			// 		'harga' => 0,
			// 		'saldo' => 0
			// 	];
			// }

			
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
