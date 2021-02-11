<?php

  class PatientModel extends CI_Model
  {

        /**
         * Function for adding a new patient record into the database
        */
      public function create_new_patient($params = null)
      {

            if(isset($params['patientFirstName']))
            {
              $patientFirstName = $params['patientFirstName'];
            }
            if(isset($params['patientLastName']))
            {
              $patientLastName = $params['patientLastName'];
            }
            if(isset($params['patientDateOfBirth']))
            {
              $patientDateOfBirth = $params['patientDateOfBirth'];
            }
            if(isset($params['userId']))
            {
              $patientTherapistId = $params['userId'];
            }
            if(isset($params['patientUsername']))
            {
              $patientUsername = $params['patientUsername'];
            }
            if(isset($params['patientPassword']))
            {
              $patientPassword = $params['patientPassword'];
              $hashed_ppassword = password_hash($patientPassword, PASSWORD_DEFAULT);
            }

            $sql = "INSERT INTO patients(patientFirstName, patientLastName, patientDateOfBirth, patientTherapistId, patientUsername, patientPassword) VALUES (?, ?, ?, ?, ?, ?);";
            $query = $this->db->query($sql, array($patientFirstName, $patientLastName, $patientDateOfBirth, $patientTherapistId, $patientUsername, $hashed_ppassword));
            return $query;
      }

      public function get_patient_information($params = null)
      {
        if(isset($params['patientId']))
        {
          $patientId = $params['patientId'];
        }
        $sql= "SELECT patientFirstName, patientLastName, patientDateOfBirth FROM patients WHERE patientId = ?;";
        $query = $this->db->query($sql, array($patientId));

        return $query;
      }

      public function get_patient_fname_lname($params = null)
      {
        if(isset($params['patientFullName']))
        {
          $patientFullName = $params['patientFullName'];
          $patientFullName = '%'. $patientFullName .'%';
        }

        if(isset($params['therapistId']))
        {
          $patientTherapistId = $params['therapistId'];
        }

        $sql= "SELECT patientFirstName, patientLastName, patientId FROM patients WHERE (CONCAT(patientFirstName, ' ', patientLastName) LIKE ?) AND patientTherapistId = ? LIMIT 5;";
        $query = $this->db->query($sql, array($patientFullName, $patientTherapistId));

        return $query;
      }

      /**
       * Returns the password hash that belongs to the given patient.
       */
      public function get_patient_password_hash($params = null)
      {
        if(isset($params['patientUsername']))
        {
          $patientUsername = $params['patientUsername'];
        }

        $sql = "SELECT patientPassword, patientId FROM Patients WHERE patientUsername = ?;";
        $query = $this->db->query($sql, array($patientUsername));

        return $query;
      }
  }
