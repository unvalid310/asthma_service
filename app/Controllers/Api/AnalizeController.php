<?php

namespace App\Controllers\Api;

use App\Controllers\BaseController;
use CodeIgniter\API\ResponseTrait;

use App\Models\BodyModel;
use App\Models\EnvironmemtModel;
use App\Models\MindModel;
use App\Models\HistoryModel;

class AnalizeController extends BaseController
{
    use ResponseTrait;

    public function index()
    {
        //
        $userId = $this->request->getGet('user_id');

        $response['success'] = true;
        $response['message'] = '';
        $response['data'] = [];

        $bodyValue = 0;
        $enviValue = 0;
        $mindValue = 0;

        $bodyModel = new BodyModel();
        $dataBody = $bodyModel
        ->where([
            'DATE(created_at)' => date('Y-m-d'),
            // 'user_id' => $userId,
            ])
            ->first();


        $enviModel = new EnvironmemtModel();
        $dataEnvi = $enviModel
        ->where([
            'DATE(created_at)' => date('Y-m-d'),
            // 'user_id' => $userId,
            ])
            ->first();


        $mindModel = new MindModel();
        $dataMind = $mindModel
        ->where([
            'DATE(created_at)' => date('Y-m-d'),
            // 'user_id' => $userId,
            ])
            ->first();

        if ($dataBody) {
            # code...
            $arrayBody = array($dataBody->heart_rate, $dataBody->spo2, $dataBody->sleeping_quality);
            $bodyValue = round(array_sum($arrayBody)/count($arrayBody), 2);
        }

        if ($dataEnvi) {
            # code...
            $arrayEnvi = array($dataEnvi->temperature, $dataEnvi->humidity, $dataEnvi->co2);
            $enviValue = round(array_sum($arrayEnvi)/count($arrayEnvi), 2);
        }

        if ($dataMind) {
            # code...
            $arrayMind = array($dataMind->q1, $dataMind->q2, $dataMind->q3, $dataMind->q4, $dataMind->q5, $dataMind->q6, $dataMind->q7, $dataMind->q8, $dataMind->q9, $dataMind->q10);
            $mindValue = round(array_sum($arrayMind)/count($arrayMind), 2);
        }


        $maxValue = array($bodyValue, $enviValue, $mindValue);

        $response['data'] = [
            'body' => $bodyValue,
            'envi' => $enviValue,
            'mind' => $mindValue,
            'max'=>max($maxValue),
        ];

        return $this->respond($response, 200);
    }

    public function body()
    {
        # code...
        $response['success'] = false;
        $response['message'] = '';
        $response['data'] = [];

        $bodyModel = new BodyModel();
        $userId = $this->request->getGet('user_id');


        $data = $bodyModel
            ->where([
                'DATE(created_at)' => date('Y-m-d'),
                'user_id' => $userId,
            ])
            ->first();

        if ($data) {
            $response['success'] = true;
            $response['message'] = 'Body analize has been load.';
            $response['data'] = $data;
            return $this->respond($response, 200);
        } else {
            $response['success'] = false;
            $response['message'] = 'Body analize is empty.';
            $response['data'] = [];
            return $this->respond($response, 200);
        }
    }

    public function postBody()
    {
        # code...
        $response['success'] = false;
        $response['message'] = '';
        $response['data'] = [];
        $rules = [
            "user_id" => [
                "rules" => "required"
            ],
            "heart_rate" => [
                "rules" => "required"
            ],
            "spo2" => [
                "rules" => "required"
            ],
            "sleeping_quality" => [
                "rules" => "required"
            ],
        ];

        $message = [
            'user_id' => [
                'required' => 'User Id tidak boleh kosong',
            ],
            'heart_rate' => [
                'required' => 'Heart rate tidak boleh kosong',
            ],
            'spo2' => [
                'required' => 'SpO2 tidak boleh kosong',
            ],
            'sleeping_quality' => [
                'required' => 'Sleeping quality tidak boleh kosong',
            ],
        ];

        $bodyModel = new BodyModel();
        $historyModel = new HistoryModel();
        $body = json_decode($this->request->getBody());

        $validate = $this->getValidator($rules, $message);
        if (!$validate['success']) {
            $response['message'] = $validate['message'];
            return $this->respond($response, 200);
        }

        $data = array(
            'user_id' => $body->user_id,
            'heart_rate' => $body->heart_rate,
            'spo2' => $body->spo2,
            'sleeping_quality' => $body->sleeping_quality
        );

        $dataBody = array($body->heart_rate, $body->spo2, $body->sleeping_quality);
        $resultData = array(
            'user_id' => $body->user_id,
            'date' => date('Y-m-d'),
            'body' => round(array_sum($dataBody)/count($dataBody), 2)
        );

        $existHistory = $historyModel
            ->where([
                'date' => date('Y-m-d'),
                'user_id' => $body->user_id,
            ])
            ->first();

        if ($existHistory) {
            $historyModel->update($existHistory->id, $resultData);
        } else {
            $historyModel->save($resultData);
        }

        $existData = $bodyModel
            ->where([
                'DATE(created_at)' => date('Y-m-d'),
                'user_id' => $body->user_id,
            ])
            ->first();

        if ($existData) {
            $response['success'] = false;
            $response['message'] = 'Body analize data is already.';
            $response['data'] = [];
            return $this->respond($response, 200);
        }

        $save = $bodyModel->save($data);

        if ($save) {
            $response['success'] = true;
            $response['message'] = 'Body analize has been saved.';
            $response['data'] = $data;
            return $this->respond($response, 200);
        } else {
            $response['success'] = false;
            $response['message'] = 'Body analize failed to saved.';
            $response['data'] = [];
            return $this->respond($response, 200);
        }
    }

    public function updateBody($id)
    {
        # code...
        $response['success'] = false;
        $response['message'] = '';
        $response['data'] = [];
        $rules = [
            "user_id" => [
                "rules" => "required"
            ],
            "heart_rate" => [
                "rules" => "required"
            ],
            "spo2" => [
                "rules" => "required"
            ],
            "sleeping_quality" => [
                "rules" => "required"
            ],
        ];

        $message = [
            'user_id' => [
                'required' => 'User Id tidak boleh kosong',
            ],
            'heart_rate' => [
                'required' => 'Heart rate tidak boleh kosong',
            ],
            'spo2' => [
                'required' => 'SpO2 tidak boleh kosong',
            ],
            'sleeping_quality' => [
                'required' => 'Sleeping quality tidak boleh kosong',
            ],
        ];

        $bodyModel = new BodyModel();
        $historyModel = new HistoryModel();

        $body = json_decode($this->request->getBody());

        $validate = $this->getValidator($rules, $message);
        if (!$validate['success']) {
            $response['message'] = $validate['message'];
            return $this->respond($response, 200);
        }

        $data = array(
            'user_id' => $body->user_id,
            'heart_rate' => $body->heart_rate,
            'spo2' => $body->spo2,
            'sleeping_quality' => $body->sleeping_quality
        );

        $dataBody = array($body->heart_rate, $body->spo2, $body->sleeping_quality);
        $resultData = array(
            'user_id' => $body->user_id,
            'date' => date('Y-m-d'),
            'body' => round(array_sum($dataBody)/count($dataBody), 2)
        );

        $existHistory = $historyModel
            ->where([
                'date' => date('Y-m-d'),
                'user_id' => $body->user_id,
            ])
            ->first();

        if ($existHistory) {
            $historyModel->update($existHistory->id, $resultData);
        } else {
            $historyModel->save($resultData);
        }


        $save = $bodyModel->update($id, $data);

        if ($save) {
            $response['success'] = true;
            $response['message'] = 'Body analize has been saved.';
            $response['data'] = $data;
            return $this->respond($response, 200);
        } else {
            $response['success'] = false;
            $response['message'] = 'Body analize failed to saved.';
            $response['data'] = [];
            return $this->respond($response, 200);
        }
    }

    public function envi()
    {
        # code...
        $response['success'] = false;
        $response['message'] = '';
        $response['data'] = [];

        $enviModel = new EnvironmemtModel();
        $userId = $this->request->getGet('user_id');


        $data = $enviModel
            ->where([
                'DATE(created_at)' => date('Y-m-d'),
                'user_id' => $userId,
            ])
            ->first();

        if ($data) {
            $response['success'] = true;
            $response['message'] = 'Environment analize has been load.';
            $response['data'] = $data;
            return $this->respond($response, 200);
        } else {
            $response['success'] = false;
            $response['message'] = 'Environment analize is empty.';
            $response['data'] = [];
            return $this->respond($response, 200);
        }
    }

    public function postEnvi()
    {
        # code...
        $response['success'] = false;
        $response['message'] = '';
        $response['data'] = [];
        $rules = [
            "user_id" => [
                "rules" => "required"
            ],
            "temperature" => [
                "rules" => "required"
            ],
            "humidity" => [
                "rules" => "required"
            ],
            "co2" => [
                "rules" => "required"
            ],
        ];

        $message = [
            'user_id' => [
                'required' => 'User Id tidak boleh kosong',
            ],
            'temperature' => [
                'required' => 'Heart rate tidak boleh kosong',
            ],
            'humidity' => [
                'required' => 'SpO2 tidak boleh kosong',
            ],
            'co2' => [
                'required' => 'Sleeping quality tidak boleh kosong',
            ],
        ];

        $enviModel = new EnvironmemtModel();
        $historyModel = new HistoryModel();

        $body = json_decode($this->request->getBody());

        $validate = $this->getValidator($rules, $message);
        if (!$validate['success']) {
            $response['message'] = $validate['message'];
            return $this->respond($response, 200);
        }

        $data = array(
            'user_id' => $body->user_id,
            'temperature' => $body->temperature,
            'humidity' => $body->humidity,
            'co2' => $body->co2
        );

        $dataEnvi = array($body->temperature, $body->humidity, $body->co2);
        $resultData = array(
            'user_id' => $body->user_id,
            'date' => date('Y-m-d'),
            'envi' => round(array_sum($dataEnvi)/count($dataEnvi), 2)
        );

        $existHistory = $historyModel
            ->where([
                'date' => date('Y-m-d'),
                'user_id' => $body->user_id,
            ])
            ->first();

        if ($existHistory) {
            $historyModel->update($existHistory->id, $resultData);
        } else {
            $historyModel->save($resultData);
        }

        $existData = $enviModel
            ->where([
                'DATE(created_at)' => date('Y-m-d'),
                'user_id' => $body->user_id,
            ])
            ->first();

        if ($existData) {
            $response['success'] = false;
            $response['message'] = 'Environment analize data is already.';
            $response['data'] = [];
            return $this->respond($response, 200);
        }

        $save = $enviModel->save($data);

        if ($save) {
            $response['success'] = true;
            $response['message'] = 'Environment analize has been saved.';
            $response['data'] = $data;
            return $this->respond($response, 200);
        } else {
            $response['success'] = false;
            $response['message'] = 'Environment analize failed to saved.';
            $response['data'] = [];
            return $this->respond($response, 200);
        }
    }

    public function updateEnvi($id)
    {
        # code...
        $response['success'] = false;
        $response['message'] = '';
        $response['data'] = [];
        $rules = [
            "user_id" => [
                "rules" => "required"
            ],
            "temperature" => [
                "rules" => "required"
            ],
            "humidity" => [
                "rules" => "required"
            ],
            "co2" => [
                "rules" => "required"
            ],
        ];

        $message = [
            'user_id' => [
                'required' => 'User Id tidak boleh kosong',
            ],
            'temperature' => [
                'required' => 'Heart rate tidak boleh kosong',
            ],
            'humidity' => [
                'required' => 'SpO2 tidak boleh kosong',
            ],
            'co2' => [
                'required' => 'Sleeping quality tidak boleh kosong',
            ],
        ];

        $enviModel = new EnvironmemtModel();
        $historyModel = new HistoryModel();

        $body = json_decode($this->request->getBody());

        $validate = $this->getValidator($rules, $message);
        if (!$validate['success']) {
            $response['message'] = $validate['message'];
            return $this->respond($response, 200);
        }

        $data = array(
            'user_id' => $body->user_id,
            'temperature' => $body->temperature,
            'humidity' => $body->humidity,
            'co2' => $body->co2
        );

        $dataEnvi = array($body->temperature, $body->humidity, $body->co2);
        $resultData = array(
            'user_id' => $body->user_id,
            'date' => date('Y-m-d'),
            'envi' => round(array_sum($dataEnvi)/count($dataEnvi), 2)
        );

        $existHistory = $historyModel
            ->where([
                'date' => date('Y-m-d'),
                'user_id' => $body->user_id,
            ])
            ->first();

        if ($existHistory) {
            $historyModel->update($existHistory->id, $resultData);
        } else {
            $historyModel->save($resultData);
        }

        $save = $enviModel->update($id, $data);

        if ($save) {
            $response['success'] = true;
            $response['message'] = 'Environment analize has been saved.';
            $response['data'] = $data;
            return $this->respond($response, 200);
        } else {
            $response['success'] = false;
            $response['message'] = 'Environment analize failed to saved.';
            $response['data'] = [];
            return $this->respond($response, 200);
        }
    }

    public function mind()
    {
        # code...
        $response['success'] = false;
        $response['message'] = '';
        $response['data'] = [];

        $mindModel = new MindModel();
        $userId = $this->request->getGet('user_id');


        $data = $mindModel
            ->where([
                'DATE(created_at)' => date('Y-m-d'),
                'user_id' => $userId,
            ])
            ->first();

        if ($data) {
            $response['success'] = true;
            $response['message'] = 'Mind analize has been load.';
            $response['data'] = $data;
            return $this->respond($response, 200);
        } else {
            $response['success'] = false;
            $response['message'] = 'Mind analize is empty.';
            $response['data'] = [];
            return $this->respond($response, 200);
        }
    }

    public function postMind()
    {
        # code...
        $response['success'] = false;
        $response['message'] = '';
        $response['data'] = [];
        $rules = [
            "user_id" => [
                "rules" => "required"
            ],
            "q1" => [
                "rules" => "required"
            ],
            "q2" => [
                "rules" => "required"
            ],
            "q3" => [
                "rules" => "required"
            ],
            "q4" => [
                "rules" => "required"
            ],
            "q5" => [
                "rules" => "required"
            ],
            "q6" => [
                "rules" => "required"
            ],
            "q7" => [
                "rules" => "required"
            ],
            "q8" => [
                "rules" => "required"
            ],
            "q9" => [
                "rules" => "required"
            ],
            "q10" => [
                "rules" => "required"
            ],
        ];

        $message = [
            'user_id' => [
                'required' => 'User Id tidak boleh kosong',
            ],
            'q1' => [
                'required' => 'Questionare tidak boleh kosong',
            ],
            'q2' => [
                'required' => 'Questionare tidak boleh kosong',
            ],
            'q3' => [
                'required' => 'Questionare tidak boleh kosong',
            ],
            'q4' => [
                'required' => 'Questionare tidak boleh kosong',
            ],
            'q5' => [
                'required' => 'Questionare tidak boleh kosong',
            ],
            'q6' => [
                'required' => 'Questionare tidak boleh kosong',
            ],
            'q7' => [
                'required' => 'Questionare tidak boleh kosong',
            ],
            'q8' => [
                'required' => 'Questionare tidak boleh kosong',
            ],
            'q9' => [
                'required' => 'Questionare tidak boleh kosong',
            ],
            'q10' => [
                'required' => 'Questionare tidak boleh kosong',
            ],
        ];

        $MindModel = new MindModel();
        $historyModel = new HistoryModel();

        $body = json_decode($this->request->getBody());

        $validate = $this->getValidator($rules, $message);
        if (!$validate['success']) {
            $response['message'] = $validate['message'];
            return $this->respond($response, 200);
        }

        $data = array(
            'user_id' => $body->user_id,
            'q1' => $body->q1,
            'q2' => $body->q2,
            'q3' => $body->q3,
            'q4' => $body->q4,
            'q5' => $body->q5,
            'q6' => $body->q6,
            'q7' => $body->q7,
            'q8' => $body->q8,
            'q9' => $body->q9,
            'q10' => $body->q10
        );

        $dataMind = array($body->q1, $body->q2, $body->q3, $body->q4, $body->q5, $body->q6, $body->q7, $body->q8, $body->q9, $body->q10);
        $resultData = array(
            'user_id' => $body->user_id,
            'date' => date('Y-m-d'),
            'mind' => round(array_sum($dataMind)/count($dataMind), 2)
        );

        $existHistory = $historyModel
            ->where([
                'date' => date('Y-m-d'),
                'user_id' => $body->user_id,
            ])
            ->first();

        if ($existHistory) {
            $historyModel->update($existHistory->id, $resultData);
        } else {
            $historyModel->save($resultData);
        }

        $existData = $MindModel
            ->where([
                'DATE(created_at)' => date('Y-m-d'),
                'user_id' => $body->user_id,
            ])
            ->first();

        if ($existData) {
            $response['success'] = false;
            $response['message'] = 'Mind analize data is already.';
            $response['data'] = [];
            return $this->respond($response, 200);
        }

        $save = $MindModel->save($data);

        if ($save) {
            $response['success'] = true;
            $response['message'] = 'Mind analize has been saved.';
            $response['data'] = $data;
            return $this->respond($response, 200);
        } else {
            $response['success'] = false;
            $response['message'] = 'Mind analize failed to saved.';
            $response['data'] = [];
            return $this->respond($response, 200);
        }
    }

    public function updateMind($id)
    {
        # code...
        $response['success'] = false;
        $response['message'] = '';
        $response['data'] = [];
        $rules = [
            "user_id" => [
                "rules" => "required"
            ],
            "q1" => [
                "rules" => "required"
            ],
            "q2" => [
                "rules" => "required"
            ],
            "q3" => [
                "rules" => "required"
            ],
            "q4" => [
                "rules" => "required"
            ],
            "q5" => [
                "rules" => "required"
            ],
            "q6" => [
                "rules" => "required"
            ],
            "q7" => [
                "rules" => "required"
            ],
            "q8" => [
                "rules" => "required"
            ],
            "q9" => [
                "rules" => "required"
            ],
            "q10" => [
                "rules" => "required"
            ],
        ];

        $message = [
            'user_id' => [
                'required' => 'User Id tidak boleh kosong',
            ],
            'q1' => [
                'required' => 'Questionare tidak boleh kosong',
            ],
            'q2' => [
                'required' => 'Questionare tidak boleh kosong',
            ],
            'q3' => [
                'required' => 'Questionare tidak boleh kosong',
            ],
            'q4' => [
                'required' => 'Questionare tidak boleh kosong',
            ],
            'q5' => [
                'required' => 'Questionare tidak boleh kosong',
            ],
            'q6' => [
                'required' => 'Questionare tidak boleh kosong',
            ],
            'q7' => [
                'required' => 'Questionare tidak boleh kosong',
            ],
            'q8' => [
                'required' => 'Questionare tidak boleh kosong',
            ],
            'q9' => [
                'required' => 'Questionare tidak boleh kosong',
            ],
            'q10' => [
                'required' => 'Questionare tidak boleh kosong',
            ],
        ];

        $MindModel = new MindModel();
        $historyModel = new HistoryModel();

        $body = json_decode($this->request->getBody());

        $validate = $this->getValidator($rules, $message);
        if (!$validate['success']) {
            $response['message'] = $validate['message'];
            return $this->respond($response, 200);
        }

        $data = array(
            'user_id' => $body->user_id,
            'q1' => $body->q1,
            'q2' => $body->q2,
            'q3' => $body->q3,
            'q4' => $body->q4,
            'q5' => $body->q5,
            'q6' => $body->q6,
            'q7' => $body->q7,
            'q8' => $body->q8,
            'q9' => $body->q9,
            'q10' => $body->q10
        );

        $dataMind = array($body->q1, $body->q2, $body->q3, $body->q4, $body->q5, $body->q6, $body->q7, $body->q8, $body->q9, $body->q10);
        $resultData = array(
            'user_id' => $body->user_id,
            'date' => date('Y-m-d'),
            'mind' => round(array_sum($dataMind)/count($dataMind), 2)
        );

        $existHistory = $historyModel
            ->where([
                'date' => date('Y-m-d'),
                'user_id' => $body->user_id,
            ])
            ->first();

        if ($existHistory) {
            $historyModel->update($existHistory->id, $resultData);
        } else {
            $historyModel->save($resultData);
        }

        $save = $MindModel->update($id, $data);

        if ($save) {
            $response['success'] = true;
            $response['message'] = 'Mind analize has been saved.';
            $response['data'] = $data;
            return $this->respond($response, 200);
        } else {
            $response['success'] = false;
            $response['message'] = 'Mind analize failed to saved.';
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
