<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Detail_model extends CI_Model {

    public function insert_detail($data){
        return $this->db->insert('details', $data);
    }

    public function get_all(){
        return $this->db->get('details')->result();
    }

    public function get_by_id($id){
        return $this->db->get_where('details', ['id'=>$id])->row();
    }

    public function update_detail($id, $data){
        $this->db->where('id', $id);
        return $this->db->update('details', $data);
    }

    public function delete_detail($id){
        return $this->db->delete('details', ['id'=>$id]);
    }
}
