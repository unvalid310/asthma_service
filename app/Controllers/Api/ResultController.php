<?php

namespace App\Controllers\Api;

use App\Controllers\BaseController;
use CodeIgniter\API\ResponseTrait;

use App\Models\HistoryModel;

class ResultController extends BaseController
{
    use ResponseTrait;

    public function index()
    {
        //
        $response['success'] = true;
        $response['message'] = '';
        $response['data'] = [];

        $date = ($this->request->getGet('date')) ? $this->request->getGet('date') : date('Y-m-d');
        $userId = $this->request->getGet('user_id');
        $historyModel = new HistoryModel();

        $data = $historyModel
            ->where(['user_id' => $userId, 'date' => $date])
            ->first();

        if ($data) {
            $maxValue = array('Body' => $data->body, 'Eenvironment' => $data->envi, 'Mind' => $data->mind);
            $value = max($maxValue);
            $key = array_search($value, $maxValue);

            $response['message'] = 'Data has been loaded.';
            $response['data'] = [
                'date' => $date,
                'body' => $data->body,
                'envi' => $data->envi,
                'mind' => $data->mind,
                'max' => $value,
                'indicator' => $key,
            ];

            return $this->respond($response, 200);
        } else {
            $response['success'] = false;
            $response['message'] = 'Data is empty';

            return $this->respond($response, 200);
        }
    }

    public function history()
    {
        # code...
        $response['success'] = true;
        $response['message'] = '';
        $response['data'] = [];

        $userId = $this->request->getGet('user_id');
        $historyModel = new HistoryModel();

        $data = $historyModel
            ->where('user_id', $userId)
            ->orderBy('date', 'desc')
            ->find();

        if ($data) {
            $result = [];
            foreach ($data as $key => $item) {
                # code...
                $maxValue = array($item->body, $item->envi, $item->mind);

                $result[$key] = array(
                    'date' => $item->date,
                    'body' => doubleval($item->body),
                    'envi' => doubleval($item->envi),
                    'mind' => doubleval($item->mind),
                    'max' => doubleval(max($maxValue)),
                );
            }
            $response['message'] = 'Data has been loaded.';
            $response['data'] = $result;

            return $this->respond($response, 200);
        } else {
            $response['success'] = false;
            $response['message'] = 'Data is empty';

            return $this->respond($response, 200);
        }
    }
}
