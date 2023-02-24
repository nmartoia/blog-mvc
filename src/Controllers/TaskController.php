<?php

namespace Blog\Controllers;

use Blog\Models\TaskManager;
use Blog\Validator;

/** Class UserController **/
class TaskController {
    private $manager;
    private $validator;

    public function __construct() {
        $this->manager = new TaskManager();
        $this->validator = new Validator();
    }

    public function index() {
        require VIEWS . 'Todo/homepage.php';
    }
    public function store() {
        if (!isset($_SESSION["user"]["username"])) {
            header("Location: /login");
            die();
        }
        $this->validator->validate([
            "nameTask"=>["required", "min:2", "alphaNumDash"]
        ]);
        $_SESSION['old'] = $_POST;

        if (!$this->validator->errors()) {
            $res = $this->manager->find($_POST["nameTask"], $_POST["list_id"]);

            if (empty($res)) {
                $this->manager->store();
                header("Location: /dashboard/".$_POST["nameList"]);
            } else {
                $_SESSION["error"]['name'] = "Le nom de la tache est déjà utilisé !";
                header("Location: /dashboard/".$_POST["nameList"]);
            }
        } else {
            
            header("Location: /dashboard/".$_POST["nameList"]);
        }
    }

    public function update($slug) {
        if (!isset($_SESSION["user"]["username"])) {
            header("Location: /login");
            die();
        }
        $this->validator->validate([
            "nameTodo"=>["required", "min:2", "alphaNumDash"]
        ]);
        $_SESSION['old'] = $_POST;

        if (!$this->validator->errors()) {
            $res = $this->manager->find($_POST["nameTodo"], $_SESSION["user"]["id"]);

            if (empty($res) || $res->getName() == $slug) {
                $search = $this->manager->update($slug);
                header("Location: /dashboard/" . $_POST['nameTodo']);
            } else {
                $_SESSION["error"]['nameTodo'] = "Le nom de la liste est déjà utilisé !";
                header("Location: /dashboard/" . $slug);
            }

        } else {
            header("Location: /dashboard/" . $slug);
        }
    }
    public function check($slug,$slag) {
        if (!isset($_SESSION["user"]["username"])) {
            header("Location: /login");
            die();
        }
        $id=$this->manager->findpar($slug,$_SESSION['user']['id']);
        $res = $this->manager->valid($slag, $id);
        header("Location: /dashboard/".$slug);
    }

    public function delete($slug,$slag,$id)
    {
        if (!isset($_SESSION["user"]["username"])) {
            header("Location: /login");
            die();
        }
        $this->manager->delete($slug,$slag,$id);
        header("Location: /dashboard/".$slug);
    }

    public function showAll($id) {
        if (!isset($_SESSION["user"]["username"])) {
            header("Location: /login");
            die();
        }
        $task = $this->manager->getAll($id);

        require VIEWS . 'Todo/index.php';
    }

    public function show($slug) {
        $tache = $this->manager->find($slug, $_SESSION["old"]["nameTodo"]);
        if (!$tache) {
            header("Location: /error");
        }
        require VIEWS . 'Todo/show.php';
    }

}
