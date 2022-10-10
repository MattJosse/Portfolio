<?php

class Database
{

    public static function connect()
    {
        $dbName   = 'impasse';
        $dbServer = '127.0.0.1';
        $dbUser   = 'root';
        $dbPass   = 'modal';

        $dsn = 'mysql:dbname=' . $dbName . ';host=' . $dbServer;
        $dbh = null;
        try {
            $dbh = new PDO($dsn, $dbUser, $dbPass, array(PDO::MYSQL_ATTR_INIT_COMMAND => "SET NAMES utf8mb4"));
            $dbh->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        } catch (PDOException $e) {
            return false;
        }

        return $dbh;
    }

    public static function getCatalogue($dbh, $code = false)
    {
        $query = "SELECT * FROM catalogue";
        if ($code != false) {
            $query = "SELECT * FROM catalogue WHERE code = ?";
        }
        $sth = $dbh->prepare($query);
        $sth->execute(array($code));
        $result = $sth->fetchALL(PDO::FETCH_ASSOC);

        return $result;
    }

    public static function getDetailCours($dbh, $code)
    {
        $cour=Database::getCatalogue($dbh,$code);
        
        $query = "SELECT professor FROM professor WHERE code = ?";
        $sth = $dbh->prepare($query);
        $sth->execute(array($code));
        $profs = $sth->fetchALL(PDO::FETCH_COLUMN);
        


        return array($cour,$profs);
    }
    public static function getIfUserExists($dbh,$login){
        $query = "SELECT * FROM user WHERE login = ?";
        $sth = $dbh->prepare($query);
        $sth->execute(array($login));
        $nb = $sth->rowCount();
        return ($nb==0);
        
    }

    public static function insertUser($dbh,$login,$password,$nom,$prenom,$email){
        $query = "INSERT INTO oauth_users (username,password,first_name,last_name,email) VALUES(?,?,?,?,?)";
        $sth = $dbh->prepare($query);
        $sth->execute(array($login,$password,$nom,$prenom,$email));
        return true;
        
    }
}
