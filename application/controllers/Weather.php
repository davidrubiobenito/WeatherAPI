<?php
defined('BASEPATH') OR exit('No direct script access allowed');

require_once APPPATH . '/libraries/REST_Controller.php';

class Weather extends REST_Controller {

    public function __construct()
    {
        parent::__construct();
        $this->load->model('weather_model');
    }

    public function index_get()
    {
//        echo 'todas las ciudades';
        $cities = $this->weather_model->get();

        if(!is_null($cities))
        {
            $this->response(array('response' => $cities), 200);
        }
        else{
            $this->response(array('error' => 'No hay pronósticos en la base de datos ...'), 404);
        }
    }

    public function find_get($id){
//        echo 'ciudad número '. $id;
        if(!$id)
        {
            $this->response(null , 404);
        }

        $city = $this->weather_model->get($id);
        if(!is_null($city))
        {
            $this->response(array('response' => $city ), 200);
        }
        else
        {
            $this->response(array('error' => 'Pronóstico no encontrado'), 404);
        }
    }

    public function index_post(){
        if(!$this->post('city'))
        {
            $this->response(null, 400);
        }
        $id = $this->weather_model->save($this->save('city'));

        if(!is_null($id))
        {
            $this->response(array('response' => $id), 200);
        }
        else
        {
            $this->response(array('error' => 'Algo ha fallado en el servidor'), 400);
        }
    }

    public function index_put($id)
    {
        if(!$this->put('city') || !$id)
        {
            $this->response(null, 400);
        }

        $update = $this->weather_model->update($id, $this->put('city'));

        if(!is_null($update))
        {
            $this->response(array('response' => 'Pronóstico editado correctamente'), 200);
        }
        else
        {
            $this->response(array('error' => 'Algo ha fallado en el servidor'), 400);
        }

    }

    public function index_delete($id)
    {
        if(!id)
        {
            $this->response(null, 400);
        }

        $delete = $this->weather_model->delete($id);

        if(!is_null($delete))
        {
            $this->response(array('response' => 'Pronóstico borrado correctamente'), 200);
        }
        else
        {
            $this->response(array('error' => 'Algo ha fallado en el servidor'), 400);
        }

    }

}