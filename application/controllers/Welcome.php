<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Welcome extends CI_Controller {

	/**
	 * Index Page for this controller.
	 *
	 * Maps to the following URL
	 * 		http://example.com/index.php/welcome
	 *	- or -
	 * 		http://example.com/index.php/welcome/index
	 *	- or -
	 * Since this controller is set as the default controller in
	 * config/routes.php, it's displayed at http://example.com/
	 *
	 * So any other public methods not prefixed with an underscore will
	 * map to /index.php/welcome/<method_name>
	 * @see https://codeigniter.com/user_guide/general/urls.html
	 */

	function __construct(){
		parent::__construct();
		$this->load->model('M_main');
	}

	public function index()
	{
		$this->child_data(0);
	}

	public function child_data($idParent)
	{
		$strukturs = $this->M_main->getStrukturById($idParent);
		if ($idParent != 0) {
			$strukturParent = $this->M_main->findStrukturById($idParent);
			$idBack = $strukturParent[0]->id_parent;
			$dataHeader['judul'] = $strukturParent[0]->judul;
		} else {
			$idBack = $idParent;
			$judul = "Multilevel Nested Data";
			$dataHeader['judul'] = $judul;
		}

		$countChild = $this->M_main->countByIdParent($idParent);
		$data['isChild'] = $countChild == 0 ? true : false ;
		$data['idParent'] = $idParent;
		$data['strukturs'] = $strukturs;
		$data['idBack'] = $idBack;
		// echo '<pre>'.$strukturs.'</pre>';
		// Ambil data child $idParent
		$this->load->view('header', $dataHeader);
		$this->load->view('main',$data);
		$this->load->view('footer');
	}

	public function form_add($idParent)
	{
		// Ambil data child $idParent
		$nomor = $this->M_main->countByIdParent($idParent);
		$dataHeader['judul'] = '';
		$data['id'] = '';
		$data['nomor'] = $nomor+1;
		$data['idParent'] = $idParent;
		$data['judul'] = '';
		
		$this->load->view('header',$dataHeader);
		$this->load->view('form',$data);
		$this->load->view('footer');
	}

	public function form_edit($id)
	{
		$dataForm = $this->M_main->findStrukturById($id);
		$dataHeader['judul'] = '';
		$data['id'] = $id;
		$data['idParent'] = $dataForm[0]->id_parent;
		$data['judul'] = $dataForm[0]->judul;
		$data['nomor'] = $dataForm[0]->nomor;
		
		$this->load->view('header',$dataHeader);
		$this->load->view('form', $data);
		$this->load->view('footer');
	}

	public function ajax_insert_struktur()
	{
		$id_parent = $this->input->post('id_parent');
		$nomor = $this->input->post('nomor');
		$judul = $this->input->post('judul');
		echo $this->M_main->insertStruktur($id_parent,$nomor,$judul);
	}

	public function ajax_update_struktur()
	{
		$id = $this->input->post('id');
		$id_parent = $this->input->post('id_parent');
		$nomor = $this->input->post('nomor');
		$judul = $this->input->post('judul');
		echo $this->M_main->updateStruktur($id, $id_parent ,$nomor, $judul);
	}

	public function ajax_delete_struktur($id)
	{
		echo $this->M_main->deleteStruktur($id);
	}

	public function ajax_get_struktur()
	{
		echo json_encode($this->M_main->get_struktur_json());
	}
}
