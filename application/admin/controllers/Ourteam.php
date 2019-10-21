<?php

defined('BASEPATH') OR exit('No direct script access allowed');

/**
 * Dashboard class.
 * 
 * @extends CI_Controller
 */
class Ourteam extends Admin_Controller {

    function __construct() {
        parent::__construct();
        $this->load->helper(array('url'));
        $this->load->model('general_model');
    }

    /**
     * index function.
     * 
     * @access public
     * @return void
     */
    public function index() {
        if ($this->session->userdata('admin_id')) {
                $team = $this->general_model->get_all_general_data("*", "CI_team", array('is_deleted' => 0), 'result_array');
                $this->data['Team'] = $team;
                $this->render('ourTeam/ourTeamlist_view');
            
        } else {
            redirect('Login', 'refresh');
        }
    }
    
    public function add_team() {
            if ($this->session->userdata('admin_id')) {
            if ($this->input->post()) {
                 $this->load->helper('form');
                $this->load->library('form_validation');
                $this->form_validation->set_rules('teamname', 'Team Name', 'trim|required');
                $this->form_validation->set_rules('teampos', 'Team Postion', 'trim|required');
                $this->form_validation->set_rules('description', 'Description', 'trim|required');
                if ($this->form_validation->run() == false) {
                    $this->session->set_flashdata('error_message', "Please fill required fields.");
                    $this->session->set_userdata('USER_DETAIL', $_POST);
                    redirect('Ourteam/add_team', 'refresh');
                } else {
                    $teamname = $this->input->post('teamname');
                    $teampos = $this->input->post('teampos');
                    $description = $this->input->post('description');
                        if ($this->general_model->check_exist_data('id', 'CI_team', array('teamName' => $teamname, 'is_deleted' => 0))) {
                        $this->session->set_flashdata('error_message', "Team Name already exist.");
                        redirect('Ourteam/add_team', 'refresh');
                    } else {
                        $data = array(
                            'teamName' => $teamname,
                            'teamPos' => $teampos,
                            'description' => $description,
                            'is_deleted' => 0,
                            'created_date' => date('Y-m-d H:i:s'),
                            'updated_date' => date('Y-m-d H:i:s')
                        );
                        $inserted_id = $this->general_model->create_general_data($data, 'CI_team');
                        if ($inserted_id) {
                            $this->session->set_flashdata('success_message', "Team added successfully");
                            redirect('Ourteam', 'refresh');
                        }
                    }
                }
            }else{
                $this->render('ourTeam/Ourteam_view');
            }
        } else {
            redirect('Login', 'refresh');
        }
    }

    public function edit_team($id ='') {
        if ($this->session->userdata('admin_id')) {
            if ($id != '') {
                $sid = $this->url_decrypt($id);
                $Team = $this->general_model->check_exist_data('*', 'CI_team', array('id' => $sid, 'is_deleted' => 0));
                $this->data['Team'] = $Team;
                $this->render('ourTeam/editTeam_view');
            } else {
                $this->session->set_flashdata('error_message', "Something wents wrong!");
                redirect('Ourteam', 'refresh');
            }
        } else {
            redirect('Login', 'refresh');
        }
    }
    public function Update_team() {
        if ($this->session->userdata('admin_id')) {
            if ($this->input->post()) {
                $this->load->helper('form');
                $this->load->library('form_validation');
                $this->form_validation->set_rules('teamname', 'Team Name', 'trim|required');
                $this->form_validation->set_rules('teampos', 'Team Postion', 'trim|required');
                $this->form_validation->set_rules('description', 'Description', 'trim|required');
                if ($this->form_validation->run() == false) {
                    $sid = $this->url_encrypt($this->input->post('teamid'));
                    $this->session->set_flashdata('error_message', "Please fill required fields.");
                    $this->session->set_userdata('USER_DETAIL', $_POST);
                    redirect("Ourteam/edit_team/$sid", 'refresh');
                } else {
                    $teamname = $this->input->post('teamname');
                    $teampos = $this->input->post('teampos');
                    $description = $this->input->post('description');
                    $teamid = $this->input->post('teamid');

                    $data = array(
                            'teamName' => $teamname,
                            'teamPos' => $teampos,
                            'description' => $description,
                            'updated_date' => date('Y-m-d H:i:s')
                        );
                    $update_id = $this->general_model->update_general_data($data, 'CI_team', array('id' => $teamid));
                    if ($update_id) {
                        $this->session->set_flashdata('success_message', "Team updated successfully");
                        redirect('Ourteam', 'refresh');
                    }
                }
            } else {
                $this->session->set_flashdata('error_message', "Something wents wrong!");
                redirect('Ourteam', 'refresh');
            }
        } else {
            redirect('Login', 'refresh');
        }
    }
    
    public function Delete_team() {
        if ($this->session->userdata('admin_id')) {
            $data = array();
            if ($_POST['id'] != '') {
                $sid = $this->url_decrypt($_POST['id']);
                $data = array(
                    'is_deleted' => 1
                );
                $update_id = $this->general_model->update_general_data($data, 'CI_team', array('id' => $sid));
                if ($update_id) {
                    $data['success'] = 'success';
                    $data['id'] = $sid;
                    echo json_encode($data);
                    exit;
                }
            } else {
                $data['unsuccess'] = 'unsuccess';
                echo json_encode($data);
                exit;
            }
        } else {
            redirect('Login', 'refresh');
        }
    }
}
