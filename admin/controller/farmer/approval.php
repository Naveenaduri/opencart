<?php
class ControllerFarmerApproval extends Controller {
	private $error = array();

	public function index() {

        $url='';
        $this->document->setTitle($this->language->get('Farmer Approval'));
        $data['breadcrumbs'] = array();

		$data['breadcrumbs'][] = array(
			'text' => $this->language->get('text_home'),
			'href' => $this->url->link('common/dashboard', 'user_token=' . $this->session->data['user_token'], true)
		);

		$data['breadcrumbs'][] = array(
			'text' => 'Farmers Approval',
			'href' => $this->url->link('farmer/approval', 'user_token=' . $this->session->data['user_token'], true)
        );
        
        $data['user_token'] = $this->session->data['user_token'];
        
        $data['header'] = $this->load->controller('common/header');
		$data['column_left'] = $this->load->controller('common/column_left');
        $data['footer'] = $this->load->controller('common/footer');
        
        $this->load->model('farmer/approval');

        $data['farmers']=array();
		$data['farmers'] = $this->model_farmer_approval->getFarmers();


		$this->response->setOutput($this->load->view('farmer/approval', $data));

	}
}