<?php

namespace Blog\Controllers;

use Blog\Models\TodoManager;
use Blog\Validator;

/** Class UserController **/
class TodoController
{
    private $manager;
    private $validator;

    public function __construct()
    {
        $this->manager = new TodoManager();
        $this->validator = new Validator();
    }

    public function index()
    {
        require VIEWS . 'Todo/homepage.php';
    }

    public function create()
    {
        if (!isset($_SESSION["user"]["username"])) {
            header("Location: /login");
            die();
        }
        require VIEWS . 'Todo/create.php';
    }

    public function store()
    {
        if (!isset($_SESSION["user"]["username"])) {
            header("Location: /login");
            die();
        }
        $this->validator->validate([
            "name" => ["required", "min:2", "alphaNumDash"]
        ]);
        $this->validator->validate([
            "com" => ["required", "min:2", "alphaNumDash"]
        ]);
        if ($_FILES['fille']['error'] && $_FILES['fille']['error'] != 4) {

            switch ($_FILES['fille']['error']) {

                case 1:
                    header("Location:dashboard/nouveau");

                    break;

                case 2:
                    header("Location:dashboard/nouveau");
                    break;

                case 3: // UPLOAD_ERR_PARTIAL
                    header("Location:dashboard/nouveau");
                    break;
            }
        }
        $_SESSION['old'] = $_POST;
        if (!$this->validator->errors()) {
            $id = uniqid();
            if (isset($_FILES['fille']['name']) && $_FILES['fille']['error'] == UPLOAD_ERR_OK) {
                $ext = pathinfo($_FILES['fille']['name'], PATHINFO_EXTENSION);
                if ($ext == 'png' || $ext == 'gif' || $ext == 'jpg' || $ext == 'svg') {
                    $chemin_destination = 'img/';
                    $idext = $id . '.' . $ext;
                    $res = $this->manager->find($_POST["name"], $_SESSION["user"]["id"]);
                    if ($_POST["com"] != "") {
                        if (empty($res)) {
                            $this->manager->store($idext);
                            move_uploaded_file($_FILES['fille']['tmp_name'], $chemin_destination . $id . '.' . $ext);
                            header("Location: /dashboard/" . $_POST["name"]);
                        } else {
                            $_SESSION["error"]['name'] = "Le nom de la liste est déjà utilisé !";
                            header("Location: /dashboard/nouveau");
                        }
                    } else {
                        $_SESSION["error"]['name'] = "desc vide";
                        header("Location: /dashboard/");
                    }
                } else {
                    $_SESSION["error"]['name'] = "une erreur";
                    header("Location: /dashboard/nouveau");
                }
            }
        }
    }

    public function update($slug, $slag)
    {
        if (!isset($_SESSION["user"]["username"])) {
            header("Location: /login");
            die();
        }
        $this->validator->validate([
            "nameTodo" => ["required", "min:2", "alphaNumDash"]
        ]);
        $this->validator->validate([
            "desc" => ["required", "min:2", "alphaNumDash"]
        ]);
        $_SESSION['old'] = $_POST;

        if (!$this->validator->errors()) {
            $res = $this->manager->find($_POST["nameTodo"], $_SESSION["user"]["id"]);
            if ($_POST["desc"] != "") {
                if (empty($res) || $res->getName() == $slug) {
                    $search = $this->manager->update($slug);
                    header("Location: /dashboard/" . $_POST['nameTodo']);
                } else {
                    $_SESSION["error"]['nameTodo'] = "Le nom de la liste est déjà utilisé !";
                    header("Location: /dashboard/" . $slug);
                }
            } else {
                $_SESSION["error"]['name'] = "desc vide";
                header("Location: /dashboard/" . $slug);
            }
        } else {
            header("Location: /dashboard/" . $slug);
        }
    }

    public function delete($slug)
    {
        if (!isset($_SESSION["user"]["username"])) {
            header("Location: /login");
            die();
        }
        $img = $this->manager->find($slug);
        $img1 = 'img/'.$img->getImg();
        unlink($img1);
        $this->manager->delete($slug);
        header("Location: /dashboard");
    }

    public function showAll()
    {
        $todos = $this->manager->getAll();

        require VIEWS . 'Todo/index.php';
    }

    public function show($slug)
    {
        $todo = $this->manager->find($slug);
        if (!$todo) {
            header("Location: /error");
        }
        require VIEWS . 'Todo/show.php';
    }
}
