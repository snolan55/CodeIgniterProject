<?php

  class TherapistModel extends CI_Model
  {
      /**
       * Function for adding a new Therapist record into the database
       */
    public function create_new_therapist($params = null)
    {

        if(isset($params['therapistFirstName']))
        {
          $therapistFirstName = $params['therapistFirstName'];
        }
        if(isset($params['therapistLastName']))
        {
          $therapistLastName = $params['therapistLastName'];
        }
        if(isset($params['userId']))
        {
          $therapistAdministratorId = $params['userId'];
        }
        if(isset($params['therapistUsername']))
        {
          $therapistUsername = $params['therapistUsername'];
        }
        if(isset($params['therapistPassword']))
        {
          $therapistPassword = $params['therapistPassword'];
          $hashed_tpassword = password_hash($therapistPassword, PASSWORD_DEFAULT);
        }

        $sql = "INSERT INTO therapists(therapistFirstName, therapistLastName, therapistAdministratorId, therapistUsername, therapistPassword) VALUES (?, ?, ?, ?, ?);";
        $query = $this->db->query($sql, array($therapistFirstName, $therapistLastName, $therapistAdministratorId, $therapistUsername, $hashed_tpassword));
        return $query;
      }

      public function get_therapist_information($params = null)
      {
        if(isset($params['therapistId']))
        {
          $therapistId = $params['therapistId'];
        }
        $sql= "SELECT therapistFirstName, therapistLastName FROM therapists WHERE therapistId = ?;";
        $query = $this->db->query($sql, array($therapistId));

        return $query;
      }

      /**
       * Returns the password hash that belongs to the given therapist.
       */
      public function get_therapist_password_hash($params = null)
      {
        if(isset($params['therapistUsername']))
        {
          $therapistUsername = $params['therapistUsername'];
        }

        $sql = "SELECT therapistPassword, therapistId FROM Therapists WHERE therapistUsername = ?;";
        $query = $this->db->query($sql, array($therapistUsername));

        return $query;
      }
  }
