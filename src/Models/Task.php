<?php
namespace Blog\Models;

/** Class Todo **/
class task {

    private $id;
    private $name;
    private $user_id;
    private $date;
    private $tasks = [];

    public function getId() {
        return $this->id;
    }

    public function getNames() {
        return $this->name;
    }
    public function getDate() {
        $date = date_create($this->date);
        return date_format($date, 'd/m/Y');
        //donne la date française si on veux la date americain suprimer le code si dessus et remplacer le par return $this->$date;
    }
    public function getUser_id() {
        return $this->user_id;
    }
    public function getUsername($id) {
        $manager = new UserManager();
        return $manager->username($id);
    }
    public function setId(Int $id) {
        $this->id = $id;
    }

    public function setName(String $name) {
        $this->name = $name;
    }
    public function setDate(String $date) {
        $this->date = $date;
    }
    public function setUser_id(String $user_id) {
        $this->user_id = $user_id;
    }
    
  /*  public function tasks()
    {
        $manager = new TaskManager();
        if (!$this->tasks) {
            $this->tasks = $manager->getAll($this->getId());
        }

        return $this->tasks;
    } */
}
