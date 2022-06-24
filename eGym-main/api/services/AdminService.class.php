<?php

require_once dirname(__FILE__) . '/../dao/AdminDao.class.php';
require_once dirname(__FILE__) . '/../dao/LogsDao.class.php';
require_once dirname(__FILE__) . '/BaseService.class.php';

require_once dirname(__FILE__) . '/../3pclients/SMTPClient.class.php';


class AdminService extends BaseService
{
    private $smtpClient;

    public function __construct()
    {
        //Note: implement logs dao
        $this->dao = new AdminDao();
        $this->logsDao = new LogsDao();
    }
    
    public function get_admins($search, $offset, $limit, $order)
    {
        if ($search) {
            return $this->dao->get_admins_with_search($search, $offset, $limit, $order);
        } else {
            return $this->dao->get_all($offset, $limit, $order);
        }
    }

    public function register($admin)
    {
        try {
            $newAdmin = parent::add([
                "name" => $admin['name'],
                "email" => $admin['email'],
                "password" => md5($admin['password']),
                "active_status" => 'INACTIVE',
                "registration_status" => 'PENDING',
                "id_category" => 5,
                "registration_token" => md5(random_bytes(16))
            ]);

            $this->smtpClient->send_registration_token($newAdmin);
        } catch (\Exception $e) {
            throw $e;
        }

        return $newAdmin;
    }

    public function confirm($token)
    {
        $admin = $this->dao->get_admins_by_token($token);

        if (!isset($admin['id'])) {
            throw new Exception("Token expired or invalid.", 400);
        }

        $this->dao->update($admin['id'], ["active_status" => "ACTIVE"]);
        $this->dao->update($admin['id'], ["registration_status" => "REGISTERED"]);
        $this->dao->update($admin['id'], ["registration_token" => NULL]);

        return $admin;
    }

    public function login($admin)
    {
        $db_admin = $this->dao->get_admin_by_email($admin['email']);
        
        if (!isset($db_admin['id'])) {
            throw new Exception("Admin not found.", 400);
        }
        if (!isset($db_admin['email'])) {
            throw new Exception("Email required.");
        }
        if (!isset($db_admin['password'])) {
            throw new Exception("Password required.");
        }
        if ($db_admin['registration_status'] != "REGISTERED") {
            throw new Exception("You have not confirmed the registration. Check your email for the confirmation link.", 400);
        }
        if ($db_admin['password'] != md5($admin['password'])) {
            throw new Exception("Invalid password.");
        }

       return $db_admin;
    }

    public function forgot_password($admin)
    {
        $db_admin = $this->dao->get_admin_by_email($admin['email']);
        
        if (!isset($db_admin['id'])) {
            throw new Exception("Admin not found.", 400);
        }

        $db_admin = $this->update($db_admin['id'], ['registration_token' => md5(random_bytes(16))]);

        $this->smtpClient->send_recovery_token($db_admin);
    }

    public function reset_password($admin)
    {
        $db_admin = $this->dao->get_admins_by_token($admin['registration_token']);

        if (!isset($db_admin['id'])) {
            throw new Exception("Token expired or invalid.");
        }

        $this->dao->update($db_admin['id'], ['password' => md5($admin['password']), 'registration_token' => NULL]);

        return $db_admin;
    }

    public function add_comment($comment)
    {
        try {
            $newComment = $this->logsDao->add([
                "comment" => $comment['comment'],
                "id_admin" => $comment['id_admin']
            ]);
        } catch (\Exception $e) {
            throw $e;
        }
        return $newComment;
    }
}
