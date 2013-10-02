<?php

defined ('main') or die ('no direct access');

abstract class Database {
    protected static $db = false;

    public function Database() {
        if (!self::$db) {
            self::$db = new PDO('mysql:host=localhost;dbname=foocom', 'root', '');
            self::$db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        }
    }

    public function run($query, array $fields) {
        $statement = $this->prepare($query, $fields);
        $statement->execute();
        $statement->closeCursor();
    }

    protected function insert_id() {
        return self::$db->lastInsertId();
    }

    function query_for_row($query, array $fields) {
        $statement = $this->prepare($query, $fields);
        $statement->execute();
        $row = $statement->fetch(PDO::FETCH_ASSOC);
        $statement->closeCursor();
        return $row;
    }

    function query_for_one($query, array $fields) {
        $statement = $this->prepare($query, $fields);
        $statement->execute();
        $row = $statement->fetch(PDO::FETCH_NUM);
        $statement->closeCursor();
        return $row[0];
    }

    function query($sql, array $fields = array()) {
        $statement = $this->prepare($sql, $fields);
        $statement->execute();
        $rows = $statement->fetchAll(PDO::FETCH_ASSOC);
        $statement->closeCursor();
        return $rows;
    }

    private function prepare($query, array $fields) {
        $statement = self::$db->prepare($query);
        foreach ($fields as $key => $value) {
            $statement->bindValue(':' . $key, $value);
        }
        return $statement;
    }
}
