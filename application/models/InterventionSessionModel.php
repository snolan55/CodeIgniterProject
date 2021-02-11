<?php

class InterventionSessionModel extends CI_Model
{
    /**
     * Increments the number of activities completed in a session.
     */
    public function increment_activities_completed($params = null)
    {
        if(isset($params['interventionSessionId']))
        {
            $interventionSessionId = $params['interventionSessionId'];
        }

        $sql = "UPDATE InterventionSessions SET interventionSessionActivitiesCompleted = interventionSessionActivitiesCompleted + 1 WHERE interventionSessionId = ?;";
        $query = $this->db->query($sql, array($interventionSessionId));

        return $query;
    }
    /**
     * Updates the fail counter for a session.
     */
    public function update_fail_counter($params = null)
    {
        if(isset($params['failCounter']))
        {
            $failCounter = $params['failCounter'];
        }

        if(isset($params['interventionSessionId']))
        {
            $interventionSessionId = $params['interventionSessionId'];
        }

        $sql = "UPDATE InterventionSessions SET failCounterForCurrentActivity = ? WHERE interventionSessionId = ?;";
        $query = $this->db->query($sql, array($failCounter, $interventionSessionId));

        return $query;
    }

    /**
     * Flags a session as done once completed.
     */
    public function update_session_completion_status($params = null)
    {
        if(isset($params['interventionSessionId']))
        {
            $interventionSessionId = $params['interventionSessionId'];
        }

        $sql = "UPDATE InterventionSessions SET interventionSessionCompleted = ? WHERE interventionSessionId = ?;";
        $query = $this->db->query($sql, array(true, $interventionSessionId));

        return $query;
    }

    /**
     * Updates an intervention session's current activity.
     */
    public function update_activity($params = null)
    {
        if(isset($params['activityId']))
        {
            $activityId = $params['activityId'];
        }

        if(isset($params['interventionSessionId']))
        {
            $interventionSessionId = $params['interventionSessionId'];
        }

        if(isset($params['levelId']))
        {
            $levelId = $params['levelId'];
        }

        $sql = "UPDATE InterventionSessions SET interventionSessionNextActivityToBePlayed = ?, interventionSessionCurrentLevelForActivity = ? WHERE interventionSessionId = ?;";
        $query = $this->db->query($sql, array($activityId, $levelId, $interventionSessionId));

        return $query;
    }

    /**
     * Retrieves all incomplete Intervention Sessions from the database
     * that belong to a particular patient.
     */
    public function get_incomplete_intervention_sessions_for_patient($params = null)
    {
        if(isset($params['patientId']))
        {
            $patientId = $params['patientId'];
        }

        $interventionSessionCompleted = 0; // Incomplete sessions are flagged with a FALSE boolean

        $sql = "SELECT t2.therapistFirstName, t2.therapistLastName, t1.interventionSessionId, t1.interventionSessionDateAssigned, t1.interventionSessionActivitiesCompleted, t1.interventionSessionNextActivityToBePlayed, t1.interventionSessionCurrentLevelForActivity FROM InterventionSessions t1, Therapists t2 WHERE t1.interventionSessionPatientId = ? AND t1.interventionSessionCompleted = ? AND t1.interventionSessionTherapistId = t2.therapistId;";

        $query = $this->db->query($sql, array($patientId, $interventionSessionCompleted));
        return $query;
    }

    /**
     * Retrieves the ID of the next activity to be played in the session and
     * along with the ID of its corresponding level.
     */
    public function get_upcoming_activity_details($params = null)
    {
        if(isset($params['interventionSessionId']))
        {
            $interventionSessionId = $params['interventionSessionId'];
        }

        $sql = "SELECT interventionSessionNextActivityToBePlayed, interventionSessionCurrentLevelForActivity, failCounterForCurrentActivity FROM InterventionSessions WHERE interventionSessionId = ?;";

        $query = $this->db->query($sql, array($interventionSessionId));
        return $query;
    }

    public function create_intervention_session($params = null)
    {
        if(isset($params['patientId']))
        {
          $interventionSessionPatientId = $params['patientId'];
        }
        if(isset($params['therapistId']))
        {
          $interventionSessionTherapistId = $params['therapistId'];
        }
        if(isset($params['dateAssigned']))
        {
          $interventionSessionDateAssigned = $params['dateAssigned'];
        }

        $sql = "INSERT INTO InterventionSessions(interventionSessionPatientId, interventionSessionTherapistId, interventionSessionDateAssigned) VALUES (?, ?, ?);";
        $query = $this->db->query($sql, array($interventionSessionPatientId, $interventionSessionTherapistId, $interventionSessionDateAssigned));
        return $query;
    }
    public function count_of_all_incomplete_sessions($params = null)
    {
      if(isset($params['patientId']))
      {
        $patientId = $params['patientId'];
      }
      $sql = "SELECT COUNT(*) AS 'count' FROM InterventionSessions WHERE interventionSessionCompleted = 0 AND interventionSessionPatientId = ?;";
      $query = $this->db->query($sql, array($patientId));
      return $query; 
    }

}
