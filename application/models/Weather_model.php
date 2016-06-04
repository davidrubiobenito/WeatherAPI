<?php

class Weather_model extends CI_Model{

    public function __construct()
    {
        parent::__construct();
    }

    public function get($id_city = null)
    {
        if(!is_null($id_city))
        {
            $query = $this->db->select('*')->from('weather')->where('id_city', $id_city)->order_by('date', 'ASC')->get();

            if($query->num_rows() === 1)
            {
                return $query->row_array();
            }
            return null;
        }

        $query = $this->db->select('*')->from('weather')->get();

        if($query->num_rows()>0)
        {
            return $query->row_array();
        }

        return null;
    }

    private function save($weather)
    {
        $this->db->set($this->_setCity($weather))->insert('weather');

        if($this->db->affected_rows() === 1)
        {
            return $this->db->insert_id();
        }

        return null;
    }

    private function update($id , $weather)
    {
        $this->db->set($this->_setCity($weather))->where('id', $id)->update('weather');

        if($this->db->affected_rows() === 1)
        {
            return true;
        }

        return null;
    }

    private function delete($id)
    {
        $this->db->where('id', $id)->delete('weather');

        if($this->db->affected_rows() === 1)
        {
            return true;
        }

        return null;
    }

    private function _setCity($weather)
    {
        return array
        (
            'weather' => $weather['weather'],
            'date' => $weather['date'],
            'id_city' => $weather['id_city']
        );
    }
}