<?php

class AdministratorModel extends CI_Model
{
    /**
     * Returns the password hash that belongs to the given administrator.
     */
    public function get_administrator_password_hash($params = null)
    {
        if(isset($params['administratorUsername']))
        {
            $administratorUsername = $params['administratorUsername'];
        }

        $sql = "SELECT administratorPassword, administratorId FROM Administrators WHERE administratorUsername = ?;";
        $query = $this->db->query($sql, array($administratorUsername));

        return $query;
    }
}