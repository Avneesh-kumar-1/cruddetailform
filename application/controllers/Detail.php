<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Detail extends CI_Controller
{
    public function __construct()
    {
        parent::__construct();
        $this->load->model('Detail_model');
        $this->load->helper(['form', 'url']);
        $this->load->library(['form_validation', 'upload']);
    }

    public function index()
    {
        $this->load->view('detail_form');
    }

  
    public function save()
    {
      
        $this->form_validation->set_rules('name', 'Name','required');
        $this->form_validation->set_rules('email', 'Email', 'required|valid_email');
        $this->form_validation->set_rules('gender', 'Gender', 'required');
        $this->form_validation->set_rules('hobbies[]', 'Hobbies', 'required');
        $this->form_validation->set_rules('description', 'Description', 'required');

        if ($this->form_validation->run() == FALSE) {
            echo json_encode(['status' => 'error', 'errors' => validation_errors()]);
            return;
        }

        if (empty($_FILES['image']['name'])) {
            echo json_encode(['status' => 'error', 'errors' => 'Image is required']);
            return;
        }

        $image_name = '';
        if (!empty($_FILES['image']['name'])) {
            $config['upload_path']   = './uploads/images/';
            $config['allowed_types'] = 'jpg|jpeg|png|gif';
            $config['max_size']      = 2048; 
            $this->upload->initialize($config);

            if ($this->upload->do_upload('image')) {
                $image_name = $this->upload->data('file_name');
            } else {
                echo json_encode(['status' => 'error', 'errors' => $this->upload->display_errors()]);
                return;
            }
        }

        if (empty($_FILES['files']['name'][0])) {
            echo json_encode(['status' => 'error', 'errors' => 'At least one file is required']);
            return;
        }

        $files = [];
        if (!empty($_FILES['files']['name'][0])) {
            $count_files = count($_FILES['files']['name']);
            for ($i = 0; $i < $count_files; $i++) {
                $_FILES['file']['name']     = $_FILES['files']['name'][$i];
                $_FILES['file']['type']     = $_FILES['files']['type'][$i];
                $_FILES['file']['tmp_name'] = $_FILES['files']['tmp_name'][$i];
                $_FILES['file']['error']    = $_FILES['files']['error'][$i];
                $_FILES['file']['size']     = $_FILES['files']['size'][$i];

                $config['upload_path']   = './uploads/files/';
                $config['allowed_types'] = 'pdf|doc|docx|txt';
                $config['max_size']      = 5120; 
                $this->upload->initialize($config);

                if ($this->upload->do_upload('file')) {
                    $files[] = $this->upload->data('file_name');
                } else {
                    echo json_encode([
                        'status' => 'error',
                        'errors' => 'File '.$_FILES['file']['name'].' : '.$this->upload->display_errors()
                    ]);
                    return;
                }
            }
        }

      
        $data = [
            'name'        => $this->input->post('name'),
            'email'       => $this->input->post('email'),
            'gender'      => $this->input->post('gender'),
            'hobbies'     => implode(',', $this->input->post('hobbies')),
            'image'       => $image_name,
            'files'       => implode(',', $files),
            'description' => $this->input->post('description')
        ];

        $this->Detail_model->insert_detail($data);
        echo json_encode(['status' => 'success', 'message' => 'Data saved successfully']);
    }

  
    public function list()
    {
        $data['details'] = $this->Detail_model->get_all();
        $this->load->view('detail_list', $data);
    }

   
    public function edit($id)
    {
        $detail = $this->Detail_model->get_by_id($id);

        if (!$detail) {
            show_error('Record not found', 404);
            return;
        }

        $data['detail'] = $detail;
        $this->load->view('detail_edit', $data);
    }

    public function update($id)
    {
        $detail = $this->Detail_model->get_by_id($id);

        if (!$detail) {
            echo json_encode(['status' => 'error', 'errors' => 'Record not found']);
            return;
        }

        $this->form_validation->set_rules('name', 'Name', 'required');
        $this->form_validation->set_rules('email', 'Email', 'required|valid_email');
        $this->form_validation->set_rules('gender', 'Gender', 'required');
        $this->form_validation->set_rules('hobbies[]', 'Hobbies', 'required');
        $this->form_validation->set_rules('description', 'Description', 'required');

        if ($this->form_validation->run() == FALSE) {
            echo json_encode(['status' => 'error', 'errors' => validation_errors()]);
            return;
        }

        $image_name = $detail->image;
        if (!empty($_FILES['image']['name'])) {
            $config['upload_path']   = './uploads/images/';
            $config['allowed_types'] = 'jpg|jpeg|png|gif';
            $config['max_size']      = 2048;
            $this->upload->initialize($config);

            if ($this->upload->do_upload('image')) {
                $image_name = $this->upload->data('file_name');

                if ($detail->image && file_exists('./uploads/images/'.$detail->image)) {
                    unlink('./uploads/images/'.$detail->image);
                }
            } else {
                echo json_encode(['status' => 'error', 'errors' => $this->upload->display_errors()]);
                return;
            }
        }

        $files = $detail->files ? explode(',', $detail->files) : [];
        if (!empty($_FILES['files']['name'][0])) {
            $count_files = count($_FILES['files']['name']);
            for ($i = 0; $i < $count_files; $i++) {
                $_FILES['file']['name']     = $_FILES['files']['name'][$i];
                $_FILES['file']['type']     = $_FILES['files']['type'][$i];
                $_FILES['file']['tmp_name'] = $_FILES['files']['tmp_name'][$i];
                $_FILES['file']['error']    = $_FILES['files']['error'][$i];
                $_FILES['file']['size']     = $_FILES['files']['size'][$i];

                $config['upload_path']   = './uploads/files/';
                $config['allowed_types'] = 'pdf|doc|docx|txt';
                $config['max_size']      = 5120;
                $this->upload->initialize($config);

                if ($this->upload->do_upload('file')) {
                    $files[] = $this->upload->data('file_name');
                } else {
                    echo json_encode([
                        'status' => 'error',
                        'errors' => 'File '.$_FILES['file']['name'].' : '.$this->upload->display_errors()
                    ]);
                    return;
                }
            }
        }

      
        $data = [
            'name'        => $this->input->post('name'),
            'email'       => $this->input->post('email'),
            'gender'      => $this->input->post('gender'),
            'hobbies'     => implode(',', $this->input->post('hobbies')),
            'description' => $this->input->post('description'),
            'image'       => $image_name,
            'files'       => implode(',', $files)
        ];

        $this->Detail_model->update_detail($id, $data);
        echo json_encode(['status' => 'success', 'message' => 'Data updated successfully']);
    }


    public function delete($id)
    {
        $detail = $this->Detail_model->get_by_id($id);

        if (!$detail) {
            echo json_encode(['status' => 'error', 'errors' => 'Record not found']);
            return;
        }

        if ($detail->image && file_exists('./uploads/images/'.$detail->image)) {
            unlink('./uploads/images/'.$detail->image);
        }

      
        if ($detail->files) {
            $fileArr = explode(',', $detail->files);
            foreach ($fileArr as $f) {
                if (file_exists('./uploads/files/'.$f)) {
                    unlink('./uploads/files/'.$f);
                }
            }
        }

        $this->Detail_model->delete_detail($id);
        echo json_encode(['status' => 'success', 'message' => 'Record deleted successfully']);
    }
}
