<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class MY_Controller extends CI_Controller 
{
    public function __construct()
    {
        parent::__construct();
        $this->load->model('ajax_model');
    }

    public function index()
	{
		$this->load->view('index');
	}

    public function create()
	{
		$name = $this->input->post('name');
		$message = $this->input->post('message');
		$age = $this->input->post('age');

        $data = array(
            'name' => $name,
            'message' => $message,
            'age' => $age,
        );

        $insert = $this->ajax_model->createData($data);
        echo json_encode($insert);
	}

    public function fetchData()
	{
        $resultList = $this->ajax_model->fetchAllData("*", "employee", array());
        // echo"<pre>";
        // print_r($resultList);
        // echo"</pre>";
        // exit();
        $result = array();
        $button = '';
        $i = 1;
        foreach ($resultList as $key => $value)
        {
            $button = '<a class="btn-sm btn-success text-light" onclick="editFun('.$value['id'].')" href="#">Edit</a> ';

            $button .= ' <a class="btn-sm btn-danger text-light" onclick="deleteFun('.$value['id'].')" href="#">Delete</a>';

            $result['data'][] = array(
                $i++,
                $value['name'],
                $value['message'],
                $value['age'],
                $button
            );
        }
        echo json_encode($result);
	}

    public function editData()
    {
		$id = $this->input->post('id');
        $resultData = $this->ajax_model->fetchSingleData("*", "employee", array('id'=>$id));
        echo json_encode($resultData);
    }

    public function update()
    {
        $id = $this->input->post('id');
        $name = $this->input->post('name');
		$message = $this->input->post('message');
		$age = $this->input->post('age');

        $data = array(
            'name' => $name,
            'message' => $message,
            'age' => $age,
        );

        $update = $this->ajax_model->updateData("employee", $data, array('id'=>$id));
        if ($update == true) 
        {
           echo 1;
        } 
        else 
        {
           echo 2;
        }
        
    }

    public function deleteSingleData()
    {
        $id = $this->input->post('id');
        $resultData = $this->ajax_model->deleteData("employee", array('id'=>$id));
        if ($resultData == true) 
        {
           echo 1;
        } 
        else 
        {
           echo 2;
        }
    }
}