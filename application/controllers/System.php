<?php

class System extends CI_Controller
{
    public function index()
    {
        $this->login();
    }

    /**
     * Loads to login view.
     */
    public function login()
    {
        $this->load->view('login');
    }

    /**
     * The authentication method that determines whether
     * the given login credentials are valid. If so, the user
     * is logged in. If not, they are redirected to the login page
     * and are notified of their errors.
     */
    public function login_user()
    {
        $this->load->library('form_validation');
        $this->form_validation->set_rules('username', 'Username', 'required');
        $this->form_validation->set_rules('password', 'Password', 'required');

        // Run the above validation tests
        if($this->form_validation->run())   /* CASE: Tests passed */
        {
            $username = $this->input->post('username');
            $password = $this->input->post('password');
            $account_type = $this->input->post('account-type');

            if ($account_type === 'patient')
            {
                $options['patientUsername'] = $username;
                $results = $this->PatientModel->get_patient_password_hash($options);
                if ($results->num_rows() > 0) /* CASE: There is a user with the given username */
                {
                    $patientId = $results->result()[0]->patientId;

                    // Validate password
                    $password_hash = $results->result()[0]->patientPassword;
                    if (password_verify($password, $password_hash)) /* Returns true if the password string matches the hash from the DB */
                    {
                        // Create session
                        $session_information = array(
                            'username' => $username,
                            'accountType' => 'patient',
                            'userId' => $patientId
                        );

                        $this->session->set_userdata($session_information);
                        redirect(base_url() . 'index.php/Dashboard/patient');
                    }
                    else
                    {
                        $this->session->set_flashdata('login_error', 'Invalid Password.');
                        redirect(base_url() . 'index.php/System/login');
                    }
                }
                else /* CASE: There is no user in the database with the given username */
                {
                    $this->session->set_flashdata('login_error', 'Invalid Username.');
                    redirect(base_url() . 'index.php/System/login');
                }
            }
            elseif ($account_type === 'therapist')
            {
                $options['therapistUsername'] = $username;
                $results = $this->TherapistModel->get_therapist_password_hash($options);
                if ($results->num_rows() > 0) /* CASE: There is a user with the given username */
                {
                    $therapistId = $results->result()[0]->therapistId;

                    // Validate password
                    $password_hash = $results->result()[0]->therapistPassword;
                    if (password_verify($password, $password_hash)) /* Returns true if the password string matches the hash from the DB */
                    {
                        // Create session
                        $session_information = array(
                            'username' => $username,
                            'accountType' => 'therapist',
                            'userId' => $therapistId
                        );

                        $this->session->set_userdata($session_information);
                        redirect(base_url() . 'index.php/Dashboard/therapist');
                    }
                    else
                    {
                        $this->session->set_flashdata('login_error', 'Invalid Password.');
                        redirect(base_url() . 'index.php/System/login');
                    }
                }
                else /* CASE: There is no user in the database with the given username */
                {
                    $this->session->set_flashdata('login_error', 'Invalid Username.');
                    redirect(base_url() . 'index.php/System/login');
                }
            }
            /* account-type === 'admin' */
            else
            {
                $options['administratorUsername'] = $username;
                $results = $this->AdministratorModel->get_administrator_password_hash($options);
                if ($results->num_rows() > 0) /* CASE: There is a user with the given username */
                {
                    $administratorId = $results->result()[0]->administratorId;

                    // Validate password
                    $password_hash = $results->result()[0]->administratorPassword;
                    if (password_verify($password, $password_hash)) /* Returns true if the password string matches the hash from the DB */
                    {
                        // Create session
                        $session_information = array(
                            'username' => $username,
                            'accountType' => 'admin',
                            'userId' => $administratorId
                        );

                        $this->session->set_userdata($session_information);
                        redirect(base_url() . 'index.php/Dashboard/administrator');
                    }
                    else
                    {
                        $this->session->set_flashdata('login_error', 'Invalid Password.');
                        redirect(base_url() . 'index.php/System/login');
                    }
                }
                else /* CASE: There is no user in the database with the given username */
                {
                    $this->session->set_flashdata('login_error', 'Invalid Username.');
                    redirect(base_url() . 'index.php/System/login');
                }
            }
        }
        /* CASE: Tests failed */
        else
        {
            $this->login();
        }
    }

    public function logout()
    {
        $this->session->unset_userdata('username');
        $this->session->unset_userdata('accountType');
        $this->session->unset_userdata('userId');
        redirect(base_url() . 'index.php/System/login');
    }

    /**
      * This is the controller that loads the registration views depending on
      * which type of user is currently signed in.
      */
      public function load_registration_page()
      {
          /* Signed in as a Therapist */
          if ($this->session->userdata('accountType') == 'therapist')
          {
              $this->load->view('patient_registration');
          }
          /* Trying to access page while logged out */
          elseif ($this->session->userdata('accountType') == '')
          {
              redirect(base_url() . 'index.php/System/login');
          }
          /* Signed in as a Patient or an Administrator */
          else
          {
              if($this->session->userdata('accountType') == 'patient')
              {
                  redirect(base_url() . 'index.php/Dashboard/patient');
              }
              /* accountType == 'admin' */
              else
              {
                  $this->load->view('therapist_registration');
              }
          }

      }
}
