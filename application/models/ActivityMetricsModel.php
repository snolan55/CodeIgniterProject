<?php

  class ActivityMetricsModel extends CI_Model
  {

      public function get_patient_progress($params = null)
      {
        if(isset($params['patientId']))
        {
          $activityMetricsPatientId = $params['patientId'];
        }

        $sql= "SELECT activityMetricsId, activityMetricsInterventionSessionId, activityMetricsActivityId, activityAttempt, activityTime, activityScore FROM ActivityMetrics WHERE activityMetricsPatientId = ?;";
        $query = $this->db->query($sql, array($activityMetricsPatientId));

        return $query;
      }

      public function number_of_completed_activities($params = null)
      {
        if(isset($params['patientId']))
        {
          $interventionSessionPatientId = $params['patientId'];
        }
        $sql = "SELECT interventionSessionActivitiesCompleted FROM InterventionSessions WHERE interventionSessionPatientId = ?;";
        $query = $this->db->query($sql, array($interventionSessionPatientId));

        return $query;
      }

  }
