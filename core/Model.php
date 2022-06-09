<?php

use Database\DBConnection;

abstract class Model
{

    protected $db;
    protected $table;
    protected $id;

    public function __construct(DBConnection $db)
    {
        $this->db = $db;
    }

    public function all()
    {
        $stmt = $this->db->getPDO()->query("SELECT * FROM {$this->table}");
        return $stmt->fetchAll();
    }

    public function allFromView($view)
    {
        $stmt = $this->db->getPDO()->query("SELECT * FROM {$view}");
        return $stmt->fetchAll();
    }

    public function findBy($element, $value)
    {
        $stmt = $this->db->getPDO()->prepare("SELECT * FROM {$this->table}  WHERE {$element} = {$value} ");
        $stmt->execute([$value]);
        return $stmt->fetch();
    }

    public function findById(int $id)
    {
        $stmt = $this->db->getPDO()->prepare("SELECT * FROM {$this->table}  WHERE {$this->id} = ? ");
        $stmt->execute([$id]);
        return $stmt->fetch();
    }

    public function findByFromView($view, $columnName, $columnValue)
    {
        $stmt = $this->db->getPDO()->prepare("SELECT * FROM :view  WHERE  :column_name = :column_value;");
        $stmt->execute(array(
            'view' => $view,
            'column_name' => $columnName,
            'column_value' => $columnValue,
        ));
        return $stmt->fetch();
    }


    //Gère les résultats uniques à voir pour les autres
    public function where($condition, $sign, $value)
    {
        $stmt = $this->db->getPDO()->prepare("SELECT * FROM {$this->table}  WHERE {$condition} {$sign} ? ");
        $stmt->execute([$value]);

        return $stmt->fetch();

        /*if( count(get_object_vars($stmt->fetch())) == 1){
            return $stmt->fetch()->$element ;
        }else{
            return $stmt->fetch();
        }*/
    }


    public function removeById($id)
    {
        $stmt = $this->db->getPDO()->prepare("DELETE FROM {$this->table}  WHERE {$this->id} = ? ");
        return $stmt->execute([$id]);
    }

    /*
    //Ajouter des éléments dans les tables
    public function create(array $data, ?array $relations = null)
    {
        $firstParenthesis = "";
        $secondParenthesis = "";
        $i = 1;

        foreach ($data as $key => $value){
            $comma = $i === count($data) ? "" : ", ";
            $firstParenthesis .= "{$key}{$comma}";
            $secondParenthesis .= ";{$key}{$comma}";
            $i++;
        }

        return $this->db->getPDO()->query("INSERT INTO {$this->table} ($firstParenthesis) VALUE ($secondParenthesis)", $data);
    }
    */

}