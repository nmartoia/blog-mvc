<?php
namespace Blog\Models;

/** Class Todo **/
class Todo {

    private $id;
    private $name;
    private $com;
    private $date;
    private $user_id;
    private $img;
    private $tasks = [];

    public function getId() {
        return $this->id;
    }

    public function getName() {
        return $this->name;
    }
    public function getCom() {
        return $this->com;
    }
    public function getImg() {
        return $this->img;
    }
    public function getDate() {
        $date = date_create($this->date);
        return date_format($date, 'd/m/Y');
        //donne la date française si on veux la date americain suprimer le code si dessus et remplacer le par return $this->$date;
    }
    public function getUsername($id) {
        $manager = new UserManager();
        return $manager->username($id);
    }
    public function getUser_id() {
        return $this->user_id;
    }

    public function setId(Int $id) {
        $this->id = $id;
    }

    public function setName(String $name) {
        $this->name = $name;
    }
    public function setCom(String $com) {
        $this->com = $com;
    }
    public function setImg(String $img) {
        $this->img = $img;
    }
    public function setDate(String $date) {
        $this->date = $date;
    }
    public function setUser_id(String $user_id) {
        $this->user_id = $user_id;
    }

    public function tasks()
    {
        $manager = new TaskManager();
        if (!$this->tasks) {
            $this->tasks = $manager->getAll($this->getId());
        }

        return $this->tasks;
    }
    public function taskslimite($limite)
    {
        $manager = new TaskManager();
        if (!$this->tasks) {
            $this->tasks = $manager->limite($this->getId(), $limite);
        }

        return $this->tasks;
    }
}
