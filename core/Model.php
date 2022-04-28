<?php

use Database\DBConnection;

abstract class Model{

    protected $db;
    protected $table;

    public function __construct(DBConnection $db){
        $this->db = $db;
    }

    public function all(){
        $stmt = $this->db->getPDO()->query("SELECT * FROM {$this->table}");
        return $stmt->fetchAll();
    }

    public function findById(int $id) {
        $stmt = $this->db->getPDO()->prepare("SELECT * FROM {$this->table}  WHERE id = ? ");
        $stmt->execute([$id]);
        return $stmt->fetch();
    }


    //Gère les résultats uniques à voir pour les autres
    public function where($condition,$sign, $value){
        $stmt = $this->db->getPDO()->prepare("SELECT * FROM {$this->table}  WHERE {$condition} {$sign} ? ");
        $stmt->execute([$value]);

        return $stmt->fetch();

        /*if( count(get_object_vars($stmt->fetch())) == 1){
            return $stmt->fetch()->$element ;
        }else{
            return $stmt->fetch();
        }*/
    }


}