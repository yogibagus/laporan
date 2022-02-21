<?php
defined('BASEPATH') or exit('No direct script access allowed');

class M_laporan extends CI_Model
{
	function __construct()
	{
		parent::__construct();
	}


	public function get_kartu_stok($first , $end, $gudang = "", $item = "")
	{
		$query = $this->db->query("
        	SELECT a.tanggal, a.catatan, a.harga_keluar, a.harga_masuk, a.jumlah_keluar, a.jumlah_masuk, a.kode, a.hpp, a.created_by,
            b.nama ,c.nama , d.nama as petugas, e.nama as item_satuan
            FROM inv_kartu_stok as a
            LEFT JOIN m_item as b ON a.m_item_id = b.id
            LEFT JOIN m_gudang as c ON a.m_gudang_id = c.id
            LEFT JOIN m_user as d ON a.created_by = d.id
            LEFT JOIN m_item_satuan as e ON b.m_item_satuan_id = e.id
            WHERE
            a.tanggal between '$first' and '$end'

            AND b.nama LIKE '%$item%' AND c.nama LIKE '%$gudang%';
        ");
            if ($query->num_rows() > 0) {
                return $query->result();
            } else {
                return false;
            }
	}

    public function get_first_total($date = "",$gudang = "", $item = "")
    {
        if($date == ""){
            $date = date("Y-m-d");
        }
        $query = $this->db->query("
        	SELECT 
           	a.tanggal, a.catatan, a.harga_keluar, a.harga_masuk, a.jumlah_keluar, a.jumlah_masuk, a.kode, a.hpp, SUM(a.jumlah_masuk) as total_jumlah_masuk, SUM(a.jumlah_keluar) as total_jumlah_keluar, b.nama, c.nama 
            FROM inv_kartu_stok as a
            LEFT JOIN m_item as b
            ON a.m_item_id = b.id
            LEFT JOIN m_gudang as c
            ON a.m_gudang_id = c.id
            WHERE a.tanggal < '$date'
            AND b.nama LIKE '%$item%' AND c.nama LIKE '%$gudang%';
        ");
        if ($query->num_rows() > 0) {
            return $query->row();
        } else {
            return false;
        }
    }
    

    public function get_gudang($id = "")
    {
        

        if ($id != "") {
            $query = $this->db->query("
                SELECT * FROM m_gudang WHERE id = $id
            ");
        } else {
            $query = $this->db->query("
        	SELECT * FROM m_gudang ");
        }

        if ($query->num_rows() > 0) {
            return $query->result();
        } else {
            return false;
        }
    }

    public function get_cabang($id = "")
    {   
        if($id != ""){

            $query = $this->db->query("
                SELECT * FROM m_cabang WHERE id = $id
            ");
        }else{
            $query = $this->db->query("
                SELECT * FROM m_cabang
            ");
        }
        if ($query->num_rows() > 0) {
            return $query->result();
        } else {
            return false;
        }
    }

    public function get_gudang_by_id_cabang($id = "")
    {
        if ($id != "") {

            $query = $this->db->query("
               select a.id, a.cabang_id, a.nama as nama_cabang, b.nama as nama_gudang FROM m_gudang as a
            LEFT JOIN m_cabang as b
                ON a.cabang_id = b.id
                WHERE a.cabang_id = $id
            ");
        } else {
            $query = $this->db->query("
                 select a.id, a.cabang_id, a.nama as nama_cabang, b.nama as nama_gudang FROM m_gudang as a
            LEFT JOIN m_cabang as b
                ON a.cabang_id = b.id
            ");
        }
        if ($query->num_rows() > 0) {
            return $query->result();
        } else {
            return false;
        }
    }

    

    public function get_item()
    {
        $query = $this->db->query("
        	SELECT * FROM m_item
        ");
        if ($query->num_rows() > 0) {
            return $query->result();
        } else {
            return false;
        }
    }



}
