<?php

class Database {

    public static $connection;

    public static function setUpConnection() {
        if (!isset(Database::$connection)) {
            Database::$connection = new mysqli("localhost", "root", "IharaThathsara31@#", "edu", "3306");
            if (Database::$connection->connect_error) {
                die("Connection failed: " . Database::$connection->connect_error);
            }
        }
    }

    public static function iud($query, $params = [], $types = "") {
        Database::setUpConnection();
        $stmt = Database::$connection->prepare($query);
        if ($stmt === false) {
            die("Prepare failed: " . Database::$connection->error);
        }
        if (!empty($params)) {
            $stmt->bind_param($types, ...$params);
        }
        $stmt->execute();
        $stmt->close();
    }

    public static function search($query, $params = [], $types = "") {
        Database::setUpConnection();
        if (empty($params)) {
            $result = Database::$connection->query($query);
        } else {
            $stmt = Database::$connection->prepare($query);
            if ($stmt === false) {
                die("Prepare failed: " . Database::$connection->error);
            }
            $stmt->bind_param($types, ...$params);
            $stmt->execute();
            $result = $stmt->get_result();
            $stmt->close();
        }
        return $result;
    }
}

?>