<?php

class ActivitiesModel extends CI_Model
{
    /**
     * Returns the number of activities stored in the database.
     */
    public function get_count_of_all_activities()
    {
        $sql = "SELECT COUNT(*) AS 'count' FROM Activities;";
        $query = $this->db->query($sql);

        return $query;
    }

    /**
     * Returns the name of a specific activity.
     */
    public function get_activity_name($params = null)
    {
        if(isset($params['activityId']))
        {
            $activityId = $params['activityId'];
        }

        $sql = "SELECT activityName FROM Activities WHERE activityId = ?";
        $query = $this->db->query($sql, array($activityId));

        return $query;
    }

    /**
     * Returns an activity's instructions.
     */
    public function get_activity_instructions($params = null)
    {
        if(isset($params['activityId']))
        {
            $activityId = $params['activityId'];
        }

        $sql = "SELECT instructions FROM Activities WHERE activityId = ?;";
        $query = $this->db->query($sql, array($activityId));

        return $query;
    }
}