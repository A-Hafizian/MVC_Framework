<?php

namespace App\Models\Contracts;

class JsonBaseModel extends BaseModel
{
    private $db_folder;
    private $table_filepath;
    
    public function __construct()
    {
        $this->db_folder = BASEPATH . 'storage/jsondb';
        $this->table_filepath = $this->db_folder . '/' . $this->table . '.json';
    }
    
    public function write_table($data)
    {
        file_put_contents($this->table_filepath, json_encode($data));
    }
    
    public function read_table() : array
    {
        return json_decode(file_get_contents($this->table_filepath));
   
    }
    
    #Create (insert)
    public function create(array $data): int
    {
        $table_data = $this->read_table();
        $table_data[] = $data;
        $this->write_table($table_data);
        my_varDump($table_data);
        return 1;
    }

    #Read (select) single | multiple
    public function find($id): object
    {
        $table_data = $this->read_table();
        foreach ( $table_data as $row){
            if ($row->{$this->primaryKey} == $id) {
                return $row;
            }
        }

        return null;
    }

    public function get(array $columns, array $where): array
    {
        return [];
    }

    #Update records
    public function update(array $data, array $where): int
    {
        return 1;
    }

    #Delete
    public function delete(array $where): int
    {
        return 1;
    }
}
