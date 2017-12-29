<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');
class Event_guests_model extends MY_Model
{
    var $id_col = 'event_guest_id';
    
    public function get_guests($event_id, $status = 'waiting')
    {
        $where = array('event_guests.event_id' => $event_id, 'event_guests.status' => $status);
        $this->db
        ->select("
            event_guests.user_id,
            user.name,
            user.lastname,
            user.email
        ")
        ->join("
            user", "event_guests.user_id=user.user_id
        ");
        $output['guests'] = $this->get_where($where)->result_array();
        
        $where = array('event_id' => $event_id);
        $this->db->select("events.*");
        $this->db->from("events");
        $this->db->where($where);
        $output['event'] = $this->db->get()->result()[0];
        
        return $output;
    }
}
