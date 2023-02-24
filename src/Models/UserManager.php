<?php
namespace Blog\Models;

use Blog\Models\User;
/** Class UserManager **/
class UserManager {

    private $bdd;

    public function __construct() {
        $this->bdd = new \PDO('mysql:host='.HOST.';dbname=' . DATABASE . ';charset=utf8;' , USER, PASSWORD);
        $this->bdd->setAttribute(\PDO::ATTR_ERRMODE, \PDO::ERRMODE_EXCEPTION);
    }

    public function getBdd()
    {
        return $this->bdd;
    }

    public function find($username) {
        $stmt = $this->bdd->prepare("SELECT * FROM User WHERE username = ?");
        $stmt->execute(array(
            $username
        ));
        $stmt->setFetchMode(\PDO::FETCH_CLASS,"Blog\Models\User");

        return $stmt->fetch();
    }
    public function username($userid) {
        $stmt = $this->bdd->prepare('SELECT username FROM User WHERE id = ?');
        $stmt->execute(array(
            $userid
        ));
        $ligne = $stmt->fetch();
        return  $ligne['username'];
    }
    public function all() {
        $stmt = $this->bdd->query('SELECT * FROM User');

        return $stmt->fetchAll(\PDO::FETCH_CLASS,"Blog\Models\User");
    }

    public function store($password) {
        $stmt = $this->bdd->prepare("INSERT INTO User(username, password) VALUES (?, ?)");
        $stmt->execute(array(
            $_POST["username"],
            $password
        ));
    }
}
