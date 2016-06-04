<?php

class Cities_model extends CI_Model{

    public function __construct()
    {
        parent::__construct();
    }

    public function get($id = null)
    {
        if(!is_null($id))
        {
            $query = $this->db->select('*')->from('cities')->where('id', $id)->get();

            if($query->num_rows() === 1)
            {
                return $query->row_array();
            }
            return null;
        }

        $query = $this->db->select('*')->from('cities')->get();

        if($query->num_rows()>0)
        {
            return $query->row_array();
        }

        return null;
    }

    private function save($city)
    {
        $this->db->set($this->_setCity($city))->insert('cities');

        if($this->db->affected_rows() === 1)
        {
            return $this->db->insert_id();
        }

        return null;
    }

    private function update($id , $city)
    {
        $this->db->set($this->_setCity($city))->where('id', $id)->update('cities');

        if($this->db->affected_rows() === 1)
        {
            return true;
        }

        return null;
    }

    private function delete($id)
    {
        $this->db->where('id', $id)->delete('cities');

        if($this->db->affected_rows() === 1)
        {
            return true;
        }

        return null;
    }

    private function _setCity($city)
    {
        return array
        (
            'id' => $city['id'],
            'name' => $city['name']
        );
    }

}