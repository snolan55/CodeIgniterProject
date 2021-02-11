<?php

class Dashboard extends CI_Controller
{
    /**
     * Loads the patient's dashboard.
     */
    public function patient()
    {
        /* CASE: Signed in as a Patient */
        if ($this->session->userdata('accountType') == 'patient')
        {
            $data['username'] = $this->session->userdata('username');
            $data['accountType'] = $this->session->userdata('accountType');
            $this->load->view('patient_dashboard', $data);
        }
        /* CASE: Trying to access page while logged out */
        elseif ($this->session->userdata('accountType') == '')
        {
            redirect(base_url() . 'index.php/System/login');
        }
        /* CASE: Signed in as a Therapist or an Administrator */
        else
        {
            if($this->session->userdata('accountType') == 'therapist')
            {
                redirect(base_url() . 'index.php/Dashboard/therapist');
            }
            /* accountType == 'admin' */
            else
            {
                redirect(base_url() . 'index.php/Dashboard/administrator');
            }
        }
    }

    /**
     * Loads the therapist's dashboard.
     */
    public function therapist()
    {
        /* CASE: Signed in as a Therapist */
        if ($this->session->userdata('accountType') == 'therapist')
        {
            $data['username'] = $this->session->userdata('username');
            $data['accountType'] = $this->session->userdata('accountType');
            $this->load->view('therapist_dashboard', $data);
        }
        /* CASE: Trying to access page while logged out */
        elseif ($this->session->userdata('accountType') == '')
        {
            redirect(base_url() . 'index.php/System/login');
        }
        /* CASE: Signed in as a Patient or an Administrator */
        else
        {
            if($this->session->userdata('accountType') == 'patient')
            {
                redirect(base_url() . 'index.php/Dashboard/patient');
            }
            /* accountType == 'admin' */
            else
            {
                redirect(base_url() . 'index.php/Dashboard/administrator');
            }
        }
    }

    /**
     * Loads the administrator's dashboard.
     */
    public function administrator()
    {
        /* CASE: Signed in as an Administrator */
        if ($this->session->userdata('accountType') == 'admin')
        {
            $data['username'] = $this->session->userdata('username');
            $data['accountType'] = $this->session->userdata('accountType');
            $this->load->view('administrator_dashboard', $data);
        }
        /* CASE: Trying to access page while logged out */
        elseif ($this->session->userdata('accountType') == '')
        {
            redirect(base_url() . 'index.php/System/login');
        }
        /* CASE: Signed in as a Patient or a Therapist */
        else
        {
            if($this->session->userdata('accountType') == 'therapist')
            {
                redirect(base_url() . 'index.php/Dashboard/therapist');
            }
            /* accountType == 'patient' */
            else
            {
                redirect(base_url() . 'index.php/Dashboard/patient');
            }
        }
    }
}