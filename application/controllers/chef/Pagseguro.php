<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');
class Pagseguro extends CI_Controller
{
    var $data = array();

    public function __construct()
    {
        parent::__construct();
        if (!$this->session->userdata('user')) {
            redirect('login');
        }
        
    }
    public function index() 
    {
        $this->data['page_title'] = 'INTEGRAÇÃO COM PAGSEGURO';
        $this->load->model('chef_model', 'chef');
        $user_id = $this->session->userdata('user')->user_id;
        if($this->input->server('QUERY_STRING') and strpos($this->input->server('QUERY_STRING'), 'notificationCode=') === 0){
            $this->load->library('lib_splitpagseguro');
            parse_str($this->input->server('QUERY_STRING'));
            $authorization = $this->lib_splitpagseguro->notificationAuthorization($notificationCode);
            if($authorization){
                $this->load->model('user_model','user');
                $app = $this->session->userdata('user');
                $app->pagseguroAppCode = $authorization->code;
                $this->session->set_userdata('user', $app);
                $set['pagseguroAppCode'] = $authorization->code;
                $set['publicKey'] = $authorization->account->publicKey;
                $set['pagseguroLib'] = 'lib_splitpagseguro';
                $whereUser['user_id'] = $this->session->userdata('user')->user_id;
                $this->user->update($set, $whereUser);
                $this->data['integracao'] = true;
            }
        }
        $user = $this->chef->info($user_id);
        $this->data['user'] = array('picture' => $user['picture']);
		$this->data['integracao'] = $user['pagseguroAppCode'];
        $this->load->view('chef/pagseguro', $this->data);
    }

    public function autorizar() 
    {
        $this->load->library('lib_splitpagseguro');
        $request = $this->lib_splitpagseguro->authorizationRequest($this->session->userdata('user')->user_id);
        $this->session->set_userdata('app', $sess_app);
        redirect($request->redirectURL, 'location');
    }

}
