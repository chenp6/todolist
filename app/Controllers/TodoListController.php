<?php

namespace App\Controllers;

use App\Controllers\BaseController;
use App\Models\TodoListModel;
use CodeIgniter\API\ResponseTrait;

class TodoListController extends BaseController
{

    use ResponseTrait;

    protected TodoListModel $todoListModel;

    public function __construct()
    {
        $this->todoListModel = new TodoListModel();
    }


    public function index()
    {
        
        $todoList = $this->todoListModel->findAll();
        return $this->respond([
            "msg"=>"success",
            "data"=>$todoList
        ]);
    }

    public function view()
    {
        return view('todo');
    }


    public function show(?int $key = null)
    {
        if ($key === null) {
            return $this->failNotFound("Enter the todo key");
        }
        $todo = $this->todoListModel->find($key);

        if ($todo === null) {
            return $this->failNotFound("Todo is not found");
        }
        return $this->respond([
            "msg" => "success",
            "data" => $todo
        ]);
    }

    public function create()
    {
        $data = $this->request->getJSON();
        $title = $data->title ?? null;
        $content = $data->content ?? null;


        if($title === null || $content === null){
            return $this->fail("Pass in data is not found",404);
        }

        if($title === "" || $content === ""){
            return $this->fail("Pass in data is not found",404);
        }

        $createdKey = $this->todoListModel->insert([
            "t_title" => $title,
            "t_content" => $content,
            "created_at" => date("Y-m-d H:i:s"),
            "updated_at" => date("Y-m-d H:i:s")
        ]);

        if($createdKey === false){
            return $this->fail("create failed");
        }else{
            return $this->respond([
                "msg" => "create successfully",
                "data" => $createdKey
            ]);
        }
    }


    public function update(?int $key = null){
        $data = $this->request->getJSON();
        $title = $data->title ?? null;
        $content = $data->content ?? null;


        if($key === null){
            return $this->failNotFound("Key is not found");
        }


        $willUpdateData = $this->todoListModel->find($key);

        if($willUpdateData === null){
            return $this->failNotFound("This data is not found");
        }

        if($title !== null){
            $willUpdateData["t_title"] = $title;
        }

        if($content !== null){
            $willUpdateData["t_content"] = $content;
        }

        $isUpdated = $this->todoListModel->update($key,$willUpdateData);


        if($isUpdated === false){
            return $this->fail("Update failed");
        }else{
            return $this->respond([
                "msg" => "Update successfully"
            ]);
        }

    }

    function delete(?int $key = null){
        if($key === null){
            return $this->failNotFound("Key is not found");
        }

        if($this->todoListModel->find($key) === null){
            return $this->todoListModel->delete($key);
        }

        $isDeleted = $this->todoListModel->delete($key);


        if($isDeleted === false){
            return $this->fail("Delete failed");
        }else{
            return $this->respond([
                "msg" => "Delete successfully"
            ]);
        }
    }



}
