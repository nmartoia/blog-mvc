<?php
namespace Blog\Models;

use Blog\Models\Todo;
/** Class UserManager **/
class TodoManager {

    private $bdd;

    public function __construct() {
        $this->bdd = new \PDO('mysql:host='.HOST.';dbname=' . DATABASE . ';charset=utf8;' , USER, PASSWORD);
        $this->bdd->setAttribute(\PDO::ATTR_ERRMODE, \PDO::ERRMODE_EXCEPTION);
    }

    public function find($name)
    {
        $stmt = $this->bdd->prepare("SELECT * FROM List WHERE name = ? ");
        $stmt->execute(array(
            $name
        ));
        $stmt->setFetchMode(\PDO::FETCH_CLASS,"Blog\Models\Todo");

        return $stmt->fetch();
    }

    public function store($id_img) {
        $date = date('Y-m-d');
        $stmt = $this->bdd->prepare("INSERT INTO List(name , com, date, user_id, img) VALUES (?, ?, ?, ?, ?)");
        $stmt->execute(array(
            $_POST["name"],
            $_POST["com"],
            $date,
            $_SESSION["user"]["id"],
            $id_img
        ));
    }

    public function update($slug) {
        $stmt = $this->bdd->prepare("UPDATE List SET name = ?, com = ? WHERE name = ? AND user_id = ?");
        $stmt->execute(array(
            $_POST['nameTodo'],
            $_POST['desc'],
            $slug,
            $_SESSION["user"]["id"]
        ));
    }

    public function delete($slug) {

        $stmt = $this->bdd->prepare("DELETE FROM List WHERE id = ? AND user_id = ?");
        $stmt->execute(array(
            $_POST["idList"],
            $_SESSION["user"]["id"]
        ));
        $stmt = $this->bdd->prepare("DELETE FROM Task WHERE list_id = ?");
        $stmt->execute(array(
            $_POST["idList"],
        ));
    }

    public function getAll()
    {
        $stmt = $this->bdd->prepare('SELECT * FROM List');
        $stmt->execute(array());

        return $stmt->fetchAll(\PDO::FETCH_CLASS,"Blog\Models\Todo");
    }
}
