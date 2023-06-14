<?php
namespace Model;
use PDO;
class Db
{
    private static $host = 'localhost';
    private static $user = 'root';
    private static $pwd = 'root';
    private static $dbName = 'scandiweb';

    public static function connect()
    {
        try {
            $dsn = 'mysql:host=' . self::$host . ';dbname=' . self::$dbName . ';';
            $pdo = new PDO($dsn, self::$user, self::$pwd);
            $pdo->setAttribute(PDO::ATTR_DEFAULT_FETCH_MODE, PDO::FETCH_ASSOC);
            return $pdo;
        } catch (\Throwable $th) {
            echo "Error! " . $th->getMessage();
        }
    }
    public static function query($query, $params = [])
    {
        $statement = self::connect()->prepare($query);
        $check = $statement->execute($params);
        if (explode(' ', $query)[0] == "SELECT") {
            return $statement->fetchAll();
        } else {
            return $check;
        }
    }
    public static  function productLastId($table): array
    {

        $statement =  self::connect()->query("select max(id) as last  from " . $table);
        return $statement->fetch();
    }
}
