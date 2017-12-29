<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Chef_model extends MY_Model
{

    var $id_col = 'user_id';
    var $fields = array(
    );

    function __construct()
    {
        
    }

    public function info($user_id)
    {
        $where = array(
            'user.user_id' => $user_id,
            'user.user_type_id' => 2
        );

        $this->db
                ->select("
                    user.*,
                    user_info.user_info_id,
                    user_info.info_key,
                    user_info.info_value
                ")
                ->join('user_info', 'user_info.user_id=user.user_id', 'left')
                ->order_by('user.user_id', 'asc');
        
        $user_data = $this->db->get_where('user', $where)->result_array();
        $output = array();
        
        foreach ($user_data as $info) {
            if(!$output) {
                $output = $info;
                $output['info'] = array();
            }
            
            if(isset($info['info_key']) && isset($info['info_value'])) {
                $output['info'][$info['info_key']] = array(
                    $info['info_value'], $info['user_info_id']
                );
            }
        }
        unset($output['user_info_id']);
        unset($output['info_key']);
        unset($output['info_value']);
        
        return $output;
    }

}
