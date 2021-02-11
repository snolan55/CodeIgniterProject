<?php

class LockedActivitiesModel extends CI_Model
{
    /**
     * Inserts a new activity into the LockedActivities Table.
     */
    public function insert_activity($params = null)
    {
        if(isset($params['interventionSessionId']))
        {
            $interventionSessionId = $params['interventionSessionId'];
        }

        if(isset($params['activityId']))
        {
            $activityId = $params['activityId'];
        }

        $sql = "INSERT INTO LockedActivities(lockedActivityInterventionSessionId, lockedActivityActivityId) VALUES (?, ?);";
        $query = $this->db->query($sql, array($interventionSessionId, $activityId));
        return $query;
    }

    /**
     * Returns all locked activities that belong to the given session.
     */
    public function get_locked_activities($params = null)
    {
        if(isset($params['interventionSessionId']))
        {
            $interventionSessionId = $params['interventionSessionId'];
        }

        $sql = "SELECT lockedActivityActivityId FROM LockedActivities WHERE lockedActivityInterventionSessionId = ?;";
        $query = $this->db->query($sql, array($interventionSessionId));
        
        return $query;
    }
}