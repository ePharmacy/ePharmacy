<?php

require_once dirname(__FILE__) . '/../dao/LogsDao.class.php';
require_once dirname(__FILE__) . '/BaseService.class.php';

class LogsService extends BaseService
{
    public function __construct()
    {
        $this->dao = new LogsDao();
    }

    public function get_all_comments($offset, $limit, $order)
    {
        return $this->dao->get_all($offset, $limit, $order);
    }
}
