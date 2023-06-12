<?php

namespace App\Controllers;

use App\Controllers\BaseController;
use App\Models\LoginModel;
use CodeIgniter\API\ResponseTrait;

class LoginController extends BaseController
{
    use ResponseTrait;

    protected LoginModel $loginModel;


    public function __construct()
    {
        $this->loginModel = new LoginModel();
    }

    public function view()
    {
        return view('login');
    }


    public function validateUser(?string $username = null,?string $password = null)
    {
        if ($username === null) {
            return $this->failNotFound("Enter the todo key");
        }

        $user = $this->loginModel->find($username);

        if ($user["password"] === $password) {
            return $this->respond([
                "msg" => "valid"
            ]);
        }else{
            return $this->respond([
                "msg" => "invalid",
            ]);
        }
    }
}
