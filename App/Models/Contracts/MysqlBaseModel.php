<?php

namespace App\Models\Contracts;

use Medoo\Medoo;

class MysqlBaseModel extends BaseModel
{

  public function __construct($id = null)
  {
    try {
      //$this->connection = new \PDO("mysql:host={};dbname={}", , );
      //$this->connection = exec("set names utf8;");
      $this->connection = new Medoo([
        'type' => 'mysql',
        'host' => $_ENV['DB_HOST'],
        'database' => $_ENV['DB_NAME'],
        'username' => $_ENV['DB_USER'],
        'password' => $_ENV['DB_PASS'],

        // [optional]
        'charset' => 'utf8mb4',
        'collation' => 'utf8mb4_general_ci',
        'port' => 3306,

        // [optional] The table prefix. All table names will be prefixed as PREFIX_table.
        'prefix' => '',

        // [optional] To enable logging. It is disabled by default for better performance.
        'logging' => true,

        // [optional]
        // Error mode
        // Error handling strategies when the error has occurred.
        // PDO::ERRMODE_SILENT (default) | PDO::ERRMODE_WARNING | PDO::ERRMODE_EXCEPTION
        // Read more from https://www.php.net/manual/en/pdo.error-handling.php.
        // 'error' => PDO::ERRMODE_SILENT,
        'error' => \PDO::ERRMODE_EXCEPTION,


        // [optional] Medoo will execute those commands after the database is connected.
        'command' => [
          'SET SQL_MODE=ANSI_QUOTES'
        ]
      ]);
    } catch (\PDOException $e) {
      echo "Error: " . $e->getMessage();
    }

    if (!is_null($id)) {
      $this->find($id);
    }
  }

  public function remove(): int
  {
    $record_id = $this->{$this->primaryKey};
    return $this->delete([$this->primaryKey => $record_id]);
  }
  public function save(): int
  {
    $record_id = $this->{$this->primaryKey};
    return $this->update($this->attributes, [$this->primaryKey => $record_id]);
  }

  #Create (insert)
  public function create(array $data): int
  {
    $this->connection->insert($this->table, $data);
    return $this->connection->id();
  }

  #Read (select) single | multiple
  public function find($id): object
  {
    $result = $this->connection->get($this->table, '*', [$this->primaryKey => $id]);
    if (is_null($result))
      return (object)null;
    foreach ($result as $columns => $value) {
      $this->attributes[$columns] = $value;
    }
    return $this;
  }

  public function getAll(): array
  {
    return $this->get(['*'], []);
  }
  public function get($columns, array $where): array
  {
    $page = (isset($_GET['page']) && is_numeric($_GET['page'])) ? $_GET['page'] : 1;

    $start = ($page - 1) * $this->pageSize;
    $where['LIMIT'] = [$start, $this->pageSize];


    return $this->connection->select($this->table, $columns, $where);
  }

  #Update records
  public function update(array $data, array $where): int
  {
    $result = $this->connection->update($this->table, $data, $where);
    return  $result->rowCount();
  }

  #Delete
  public function delete(array $where): int
  {
    return $this->connection->delete($this->table, $where);
  }

  public function count(array $where): int
  {
    return $this->connection->count($this->table, $where);
  }
  public function sum($column, array $where): int
  {
    return $this->connection->sum($this->table, $column, $where);
  }
  
}
