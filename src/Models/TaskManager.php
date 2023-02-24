<?php
namespace Blog\Models;

use Blog\Models\Task;
/** Class UserManager **/
class TaskManager {

    private $bdd;

    public function __construct() {
        $this->bdd = new \PDO('mysql:host='.HOST.';dbname=' . DATABASE . ';charset=utf8;' , USER, PASSWORD);
        $this->bdd->setAttribute(\PDO::ATTR_ERRMODE, \PDO::ERRMODE_EXCEPTION);
    }

    public function find($name, $userId)
    {
        $stmt = $this->bdd->prepare("SELECT * FROM task WHERE name = ? AND list_id = ?");
        $stmt->execute(array(
            $name,
            $userId
        ));

        return $stmt->fetch();
    }
    public function findpar($name, $userId)
    {
        $stmt = $this->bdd->prepare("SELECT id FROM List WHERE name = ? AND user_id = ?");
        $stmt->execute(array(
            $name,
            $userId
        ));
        return $stmt->fetch();
    }
    public function store() {
        $date = date('Y-m-d');
        $stmt = $this->bdd->prepare("INSERT INTO task(name, list_id,date,user_id) VALUES (?, ?,?,?)");
        $stmt->execute(array(
            $_POST["nameTask"],
            $_POST["list_id"],
            $date,
            $_SESSION['user']['id']
        ));
    }

    public function update($slug) {
        $stmt = $this->bdd->prepare("UPDATE task SET name = ? WHERE name = ? AND list_id = ?");
        $stmt->execute(array(
            $_POST['nameTodo'],
            $slug,
            $_SESSION["user"]["id"]
        ));
    }

    public function delete($slug,$slag,$id) {

        $stmt = $this->bdd->prepare("DELETE FROM task WHERE name = ? AND id = ? AND user_id = ?");
        $stmt->execute(array(
            $slag,
            $id,
            $_SESSION["user"]["id"]
        ));
    }
    public function valid($nametodo,$listid) {
            $ligne = $this->find($nametodo,$listid);
            if($ligne['checkTask']==""){
                $stmt = $this->bdd->prepare("UPDATE task SET checkTask = 1 WHERE name = '".$ligne['name']."' AND list_id = '".$ligne['list_id']."'");
                $stmt->execute();
            }else{
                $stmt = $this->bdd->prepare("UPDATE task SET checkTask = '' WHERE name = '".$ligne['name']."' AND list_id = '".$ligne['list_id']."'");
                $stmt->execute();
            }        
    }
    public function getAll($id)
    {
        $stmt = $this->bdd->prepare('SELECT * FROM task WHERE list_id = ?');
        $stmt->execute(array(
            $id
        ));

        return $stmt->fetchAll(\PDO::FETCH_CLASS,"Blog\Models\Task");
    }
    public function limite($id, $limite)
    {
        $stmt = $this->bdd->prepare('SELECT * FROM task WHERE list_id = ? LIMIT '.$limite);
        $stmt->execute(array(
            $id,
        ));

        return $stmt->fetchAll(\PDO::FETCH_CLASS,"Blog\Models\Task");
    }
}
