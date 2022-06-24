<?php

require_once dirname(__FILE__) . '/../config.php';

class BaseDao
{
    protected $connection;
    private $table;

    public function __construct($table)
    {
        $this->table = $table;
        try {
            $this->connection = new PDO('mysql:host='.Config::DB_HOST().';port='.Config::DB_PORT().';dbname='.Config::DB_SCHEME(), Config::DB_USERNAME(), Config::DB_PASSWORD());
            $this->connection->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        } catch (PDOException $e) {
            throw $e;
        }
    }

    public static function parse_order($order)
    {
        switch (substr($order, 0, 1)) {
            case '-': $order_direction = "ASC"; break;
            case '+': $order_direction = "DESC"; break;
            default: throw new Exception("Invalid order format. Use +/- as the first character."); break;
        };

        $order_column = substr($order, 1);

        return [$order_column, $order_direction];
    }

    protected function insert($table, $entity)
    {
        $query = "INSERT INTO ${table}(";
        foreach ($entity as $param => $value) {
            $query .= $param . ', ';
        }

        $query = substr($query, 0, -2);
        $query .= ') VALUES (';
        foreach ($entity as $param => $value) {
            $query .= ':' . $param . ', ';
        }
        $query = substr($query, 0, -2);
        $query .= ')';
        $stmt = $this->connection->prepare($query);
        $stmt->execute($entity);
        $entity['id'] = $this->connection->lastInsertId();
        return $entity;
    }

    protected function execute_update($id, $table, $entity, $id_column = 'id')
    {
        $query = "UPDATE ${table} SET ";
        foreach ($entity as $param => $value) {
            $query .= $param . '= :' . $param . ', ';
        }
        $query = substr($query, 0, -2);
        $query .= " WHERE ${id_column} = :id";

        $stmt = $this->connection->prepare($query);
        $entity['id'] = $id;
        $stmt->execute($entity);
    }

    protected function query($query, $params)
    {
        $stmt = $this->connection->prepare($query);
        $stmt->execute($params);
        return $user = $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    protected function query_unique($query, $params)
    {
        $results = $this->query($query, $params);
        return reset($results);
    }

    public function add($entity)
    {
        return $this->insert($this->table, $entity);
    }

    public function get_by_id($id)
    {
        return $this->query_unique('SELECT * FROM '.$this->table.' WHERE id = :id', ['id' => $id]);
    }

    public function update($id, $entity)
    {
        $this->execute_update($id, $this->table, $entity);
    }

    public function get_all($offset = 0, $limit = 25, $order = "-id")
    {
        switch (substr($order, 0, 1)) {
            case '-': $order_direction = "ASC"; break;
            case '+': $order_direction = "DESC"; break;
            default: throw new Exception("Invalid order format. Use +/- as the first character."); break;
        };

        $order_column = substr($order, 1);


        return $this->query('SELECT * FROM '.$this->table." ORDER BY ${order_column} ${order_direction} LIMIT ${limit} OFFSET ${offset}", []);
    }

    public function get_with_search($search, $offset, $limit, $order = "-id")
    {
        list($order_column, $order_direction) = self::parse_order($order);

        return $this->query("SELECT * FROM admin WHERE LOWER(name) LIKE CONCAT('%', :name, '%') ORDER BY ${order_column} ${order_direction} LIMIT ${limit} OFFSET ${offset}", ["name" => strtolower($search)]);
    }

    public function change_value($id, $table, $value)
    {
        $this->execute_update($id, $table, $value);
    }
}
