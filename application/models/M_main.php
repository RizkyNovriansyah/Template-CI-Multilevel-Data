<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class M_main extends CI_Model {

	function __construct()
	{
		parent::__construct();
	}

	function insertStruktur($idParent, $nomor, $judul)
	{
		$data = array(
			'id_parent' => $idParent,
			'nomor' => $nomor,
			'judul' => $judul,
			'active' => 1
		);
		
		$this->db->insert('struktur', $data);

		return ($this->db->affected_rows() != 1) ? false : true;
	}

	function updateStruktur($id,$idParent, $nomor, $judul)
	{
		$this->db->set('judul', $judul);
		$this->db->set('nomor', $nomor);
		$this->db->set('id_parent', $idParent);
		$this->db->where('id', $id);
		$this->db->update('struktur');
		return ($this->db->affected_rows() != 1) ? false : true;
	}

	function deleteStruktur($id)
	{
		$this->db->set('active', 0);
		$this->db->where('id', $id);
		$this->db->update('struktur');
		return ($this->db->affected_rows() != 1) ? false : true;
	}

	function getStrukturById($idParent)
	{
		$this->db->where('id_parent',$idParent);
		$query = $this->db->get('struktur');
		$result = $query->result();
		return $result;
	}

	function findStrukturById($idParent)
	{
		$this->db->where('id',$idParent);
		$query = $this->db->get('struktur');
		$result = $query->result();
		return $result;
	}
	
	function countByIdParent($idParent)
	{
		$this->db->like('id_parent', $idParent);
		$this->db->from('struktur');
		return $this->db->count_all_results();
	}


	public function get_struktur_json(){

        $this->db->select('*');
        $this->db->from('struktur');
		$this->db->where('id_parent', 0);
		$this->db->where('active', 1);

        $parent = $this->db->get();
        
        $strukturs = $parent->result();
        $i=0;
        foreach($strukturs as $struktur){
			$strukturs[$i]->sub = $this->sub_strukturs($struktur->id);
			if (count($strukturs[$i]->sub) == 0) {
				$strukturs[$i]->sub = 'child';
			}
            $i++;
        }
        return $strukturs;
    }

    public function sub_strukturs($id){

        $this->db->select('*');
        $this->db->from('struktur');
		$this->db->where('id_parent', $id);
		$this->db->where('active', 1);

        $child = $this->db->get();
        $strukturs = $child->result();
        $i=0;
        foreach($strukturs as $struktur){
			$strukturs[$i]->sub = $this->sub_strukturs($struktur->id);
			if (count($strukturs[$i]->sub) == 0) {
				$strukturs[$i]->sub = 'child';
			}
            $i++;
        }
        return $strukturs;       
    }
}

/* End of file M_main.php */
/* Location: ./application/models/M_main.php */