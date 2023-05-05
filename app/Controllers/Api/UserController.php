<?php

namespace App\Controllers\Api;

use App\Controllers\BaseController;
use CodeIgniter\API\ResponseTrait;
use App\Models\UserModel;

class UserController extends BaseController
{
    use ResponseTrait;

    public function index()
    {
        $response['success'] = false;
        $response['message'] = '';
        $response['data'] = [];
        $userId = $this->request->getGet('user_id');

        if (empty($userId)) {
            $response['message'] = 'Parameter ID user tidak ada';
            return $this->respond($response, 200);
        }

        $userModel = new UserModel();

        $profile = $userModel
            ->where('id', $userId)
            ->first();

        if ($profile) {
            $response['success'] = true;
            $response['message'] = 'Berhasil menampilkan data';
            $response['data'] = $profile;
            return $this->respond($response, 200);
        } else {
            $response['message'] = 'Tidak dapat menampilkan profile user';
            return $this->respond($response, 200);
        }
    }

    public function update($profile_id)
    {
        $response['success'] = false;
        $response['message'] = '';
        $response['data'] = [];
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
        ];

        $userModel = new UserModel();
        $body = json_decode($this->request->getBody());

        $validate = $this->getValidator($rules, $message);
        if (!$validate['success']) {
            $response['message'] = $validate['message'];
            return $this->respond($response, 200);
        }

        if ($body->password) {
            $data = array(
                "fullname" => $body->fullname,
                "dob" => $body->dob,
                "email" => $body->email,
                "gender" => $body->gender,
                "password" => password_hash($body->password, PASSWORD_DEFAULT),
            );
        } else {
            $data = array(
                "fullname" => $body->fullname,
                "dob" => $body->dob,
                "email" => $body->email,
                "gender" => $body->gender,
            );
        }

        if ($userModel->update($profile_id, $data)) {
            $response['success'] = true;
            $response['message'] = 'Profile berhasil disimpan';
            $response['data'] = $data;
            return $this->respond($response, 200);
        } else {
            $response['success'] = false;
            $response['message'] = 'Profile gagal disimpan';
            $response['data'] = [];
            return $this->respond($response, 200);
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
