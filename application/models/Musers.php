<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Musers extends CI_Model
{

    public function __construct()
    {
        parent::__construct();
    }

    public function login($userName, $userPass)
    {
        $this->db->reconnect();
        $query = $this->db->query("SELECT * FROM users WHERE UserName=? AND UserPass=? AND StatusId=?", array($userName, md5($userPass), STATUS_ACTIVED));
        $users = $query->result_array();
        if (!empty($users)) {
            $user = $users[0];
            if ($user['subscribed_date'] == 0) {
                $user['IsVip'] = 0;
            } else {
                $renewal_time = $user['subscribed_date'];
                switch ($user['subscribed_type']) {
                    case 0:
                        $renewal_time += 3600 * 24 * 30;
                        break;
                    case 1:
                        $renewal_time += 3600 * 24 * 30 * 3;
                        break;
                    case 2:
                        $renewal_time += 3600 * 24 * 183;
                        break;
                    case 3:
                        $renewal_time += 3600 * 24 * 365;
                        break;
                    default:
                        # code...
                        break;
                }
                $date = new DateTime();
                if ($date->getTimestamp() > $renewal_time) {
                     $user['IsVip'] = 0;
                } else {
                     $user['IsVip'] = 1;
                }
            }
            return $user;
        }
        return false;
    }

    public function insert($valueData)
    {
        $this->db->reconnect();
        $valueData = replaceSqlString($valueData);
        $query = $this->db->query("SELECT UserId FROM users WHERE UserName=? OR Email=? LIMIT 1",
            array($valueData['UserName'], $valueData['Email']));
        $users = $query->result_array();
        if (empty($users)) {
            $this->db->insert('users', $valueData);
            if ($this->db->insert_id()) return $this->db->insert_id();
            return false;
        } else return -1;
    }

    public function insertFacebookLogin($valueData)
    {
        $this->db->select('UserId');
        $this->db->from('users');
        $this->db->where(array('oauth_provider' => $valueData['oauth_provider'], 'Email' => $valueData['Email']));
        $prevQuery = $this->db->get();
        $prevCheck = $prevQuery->num_rows();

        if ($prevCheck > 0) {
            $prevResult = $prevQuery->row_array();
            $update = $this->db->update('users', $valueData, array('UserId' => $prevResult['UserId']));
            $userID = $prevResult['UserId'];
        } else {
            $insert = $this->db->insert('users', $valueData);
            $userID = $this->db->insert_id();
        }

        return $userID ? $userID : FALSE;
    }

    public function update($valueData, $userId)
    {
        $this->db->reconnect();
        $valueData = replaceSqlString($valueData);
        $users = array();
        if (isset($valueData['UserName']) && isset($valueData['Email'])) {
            $query = $this->db->query("SELECT UserId FROM users WHERE UserId!=? AND (UserName=? OR Email=?)",
                array($userId, $valueData['UserName'], $valueData['Email']));
            $users = $query->result_array();
        }
        if (empty($users)) {
            $this->db->where('UserId', $userId);
            $this->db->update('users', $valueData);
            return true;
        } else return -1;
    }

    public function updatePassword($userId, $newPass)
    {
        $this->db->reconnect();
        $this->db->where('UserId', $userId);
        $this->db->update('users', array('UserPass' => md5($newPass), 'Token' => ''));
        return true;
    }

    public function delete($userId)
    {
        $this->db->reconnect();
        $this->db->trans_begin();
//        $this->db->delete('uservideos', array('UserId' => $userId));
//        $this->db->delete('viewlogs', array('UserId' => $userId));
        $this->db->delete('users', array('UserId' => $userId));
        if ($this->db->trans_status() === false) {
            $this->db->trans_rollback();
            return false;
        } else {
            $this->db->trans_commit();
            return true;
        }
        return false;
    }

    public function get($userId)
    {
        $this->db->reconnect();
        $query = $this->db->query("SELECT * FROM users WHERE UserId=?", array($userId));
        $users = $query->result_array();
        if (!empty($users)) return $users[0];
        return false;
    }

    public function getByEmail($email)
    {
        $this->db->reconnect();
        $query = $this->db->query("SELECT * FROM users WHERE Email=?", array($email));
        $users = $query->result_array();
        if (!empty($users)) return $users[0];
        return false;
    }

    public function getByToken($token)
    {
        $this->db->reconnect();
        $query = $this->db->query("SELECT * FROM users WHERE Token=?", array($token));
        $users = $query->result_array();
        if (!empty($users)) return $users[0];
        return false;
    }

    public function getByFacebookId($fbId)
    {
        $this->db->reconnect();
        $query = $this->db->query("SELECT * FROM users WHERE FacebookId=?", array($fbId));
        $users = $query->result_array();
        if (!empty($users)) return $users[0];
        return false;
    }

    public function updateSubscription($userId, $auth_code, $subscribed_date, $subscribed_type) {
        $user = $this->get($userId);

        if (!$user) {
            return false;
        } else {
            $user['paystack_auth_code'] = $auth_code;
            $user['subscribed_date'] = $subscribed_date;
            $user['IsVip'] = 1;
            $user['subscribed_type'] = $subscribed_type;
            $this->db->update('users', $user, array('UserId' => $user['UserId']));
        }
        return true;
    }
}