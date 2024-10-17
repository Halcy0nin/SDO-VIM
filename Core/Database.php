<?php

// ============================================
//             This is the Database Class
// ============================================
//  You can use this class to initialize the
//  mysql database to be used.
//  
//  You can also add more functions here to serve
//  as an API to interact with the Database.
//  
//  query() function prepares a  query to the
//  database with the corresponding parameters for
//  the query string.
//  
//  get() will return all the result from the query
//  action
//
//  find() will retrieve a single result from the
//  query result
//  
//  findOrFail() will retrieve a single result and
//  return it if found or throw an error if otherwise
//

namespace Core;

use PDO;
use Core\ValidationException;
use PDOException;

class Database
{
    public $connection;
    public $statement;

    public function __construct($config, $username = 'root', $password = '')
    {

        $dsn = 'mysql:' . http_build_query($config, '', ';');

        $this->connection = new PDO($dsn, $username, $password, [
            PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC
        ]);
    }

    public function query($query, $params = [])
    {
        $this->statement = $this->connection->prepare($query);
        $this->statement->execute($params);

        return $this;
    }

    public function paginate($query, $params = [])
{
    $this->statement = $this->connection->prepare($query);

    foreach ($params as $key => $value) {
        $type = is_int($value) ? PDO::PARAM_INT : PDO::PARAM_STR;
        $this->statement->bindValue(is_int($key) ? $key + 1 : ":$key", $value, $type);
    }

    $this->statement->execute();

    return $this;
}


    public function get()
    {
        try {
            return $this->statement->fetchAll();
        } catch (PDOException $e) {
            ValidationException::throw(['database' => $e], []);
        }
    }

    public function find()
    {
        try {
            return $this->statement->fetch();
        } catch (PDOException $e) {
            ValidationException::throw(['database' => $e], []);
        }
    }

    public function findOrFail()
    {
        $result = $this->find();

        if (!$result) {
            ValidationException::throw(['database' => 'No result found.'], []);
        }

        return $result;
    }
}
