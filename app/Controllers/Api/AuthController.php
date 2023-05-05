<?php

namespace App\Controllers\Api;

use App\Controllers\BaseController;
use CodeIgniter\API\ResponseTrait;
use App\Models\UserModel;

class AuthController extends BaseController
{
    use ResponseTrait;

    public function index()
    {
        return $this->respond(
            ['status' => 'Auth Controller'],
            200,
        );
    }

    public function login()
    {
        $response['success'] = false;
        $response['message'] = '';
        $response['data'] = [];
        $rules = [
            "email" => [
                "rules" => "required|valid_email"
            ],
            "password" => [
                "rules" => "required"
            ],
        ];

        $message = [
            'email' => [
                'required' => 'Email tidak boleh kosong',
                'valid_email' => 'Format email salah',
            ],
            'password' => [
                'required' => 'Password tidak boleh kosong',
            ],
        ];

        $userModel = new UserModel();
        $email = $this->request->getVar('email');
        $password = $this->request->getVar('password');

        $validate = $this->getValidator($rules, $message);

        if (!$validate['success']) {
            $response['message'] = $validate['message'];
            return $this->respond($response, 200);
        }

        $user = $userModel
            ->where(array('email' => $email))
            ->first();

        if ($user != null) {
            if (password_verify($password, $user->password)) {
                $response['success'] = true;
                $response['message'] = 'Login success.';
                $response['data'] = $user;
                return $this->respond($response, 200);
            } else {
                $response['success'] = false;
                $response['message'] = 'Wrong password.';
                $response['data'] = array(
                    "email" => $user->email,
                );
                return $this->respond($response, 200);
            }
        } else {
            $response['success'] = false;
            $response['message'] = 'Check your account.';
            $response['data'] = [];
            return $this->respond($response, 200);
        }
    }

    public function register()
    {
        $response['success'] = false;
        $response['message'] = '';
        $response['data'] = [];
        $rules = [
            "fullname" => [
                "rules" => "required"
            ],
            "dob" => [
                "rules" => "required"
            ],
            "email" => [
                "rules" => "required|valid_email"
            ],
            "gender" => [
                "rules" => "required"
            ],
            "password" => [
                "rules" => "required"
            ],
        ];

        $message = [
            'fullname' => [
                'required' => 'Nama lengkap tidak boleh kosong',
            ],
            'dob' => [
                'required' => 'TTL tidak boleh kosong',
            ],
            'email' => [
                'required' => 'Email tidak boleh kosong',
                'valid_email' => 'Format email salah',
            ],
            'gender' => [
                'required' => 'Jenis kelamin tidak boleh kosong',
            ],
            'password' => [
                'required' => 'Password tidak boleh kosong',
            ],
        ];

        $userModel = new UserModel();
        $body = json_decode($this->request->getBody());
        $data = array(
            "fullname" => $body->fullname,
            "dob" => $body->dob,
            "email" => $body->email,
            "gender" => $body->gender,
            "password" => password_hash($body->password, PASSWORD_DEFAULT),
        );

        $validate = $this->getValidator($rules, $message);

        if (!$validate['success']) {
            $response['message'] = $validate['message'];
            return $this->respond($response, 200);
        }

        $checkUser = $userModel
            ->where('email', $body->email)
            ->first();

        if ($checkUser != null) {
            $response['success'] = false;
            $response['message'] = 'Email already exists.';
            return $this->respond($response, 200);
        } else {
            if ($userModel->save($data)) {
                $user = $userModel
                    ->where('email', $body->email)
                    ->first();

                $response['success'] = true;
                $response['message'] = 'Registration success.';
                $response['data'] = $user;
                return $this->respond($response, 200);
            } else {
                $response['success'] = false;
                $response['message'] = 'Registration failed.';
                $response['data'] = [];
                return $this->respond($response, 200);
            }
        }
    }

    public function getValidator($rules = array(), $messages = array())
    {
        $success = false;
        $message = '';

        if (!$this->validate($rules, $messages)) {
            foreach ($this->validator->getErrors() as $value);
            $message =
                $value;
        } else {
            $success = true;
        }

        $data = array(
            'success' => $success,
            'message' => $message
        );

        return $data;
    }
}
