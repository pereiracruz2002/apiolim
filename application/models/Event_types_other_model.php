<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

class Event_types_other_model extends MY_Model {
    var $id_col = 'event_type_other_id';
    
    public function info($event_id)
    {
        $where = array('event_types_other.event_id' => $event_id);
        $this->db->select("event_types_other.event_type_other_id, event_types_other.value");
        $return = $this->get_where($where)->row();
        
        return $return;
    }
}
