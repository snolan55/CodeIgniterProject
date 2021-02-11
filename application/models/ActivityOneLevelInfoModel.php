<?php

/**
 * Model for the Related Memory Activity.
 */
class ActivityOneLevelInfoModel extends CI_Model
{
    /**
     * Retrieves information for an activity's level.
     * This data is then used to autonomously render the activity
     * and its current level.
     */
    public function get_level_details($params = null)
    {
        if(isset($params['levelId']))
        {
            $levelId = $params['levelId'];
        }

        $sql = "SELECT options, draggable, timer, optionOne, optionTwo, optionThree, answerOne, answerTwo, answerThree, levelType FROM ActivityOneLevelInfo WHERE activityOneLevelInfoLevelId = ?;";

        $query = $this->db->query($sql, array($levelId));
        return $query;
    }

    /**
     * Returns a count of all levels that belong to the related memory activity.
     */
    public function get_count_of_all_levels()
    {
        $sql = "SELECT COUNT(*) AS 'count' FROM ActivityOneLevelInfo;";
        $query = $this->db->query($sql);

        return $query;
    }
}