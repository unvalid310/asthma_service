<?php

namespace App\Controllers\Api;

use App\Controllers\BaseController;
use CodeIgniter\API\ResponseTrait;

use App\Models\BodyModel;
use App\Models\EnvironmemtModel;
use App\Models\MindModel;
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

        $bodyValue = null;
        $enviValue = null;
        $mindValue = null;

        $bodyModel = new BodyModel();
        $dataBody = $bodyModel
        ->where([
            'DATE(created_at)' => $date,
            'user_id' => $userId,
            ])
            ->first();

        $enviModel = new EnvironmemtModel();
        $dataEnvi = $enviModel
        ->where([
            'DATE(created_at)' => $date,
            'user_id' => $userId,
            ])
            ->first();

        $mindModel = new MindModel();
        $dataMind = $mindModel
        ->where([
            'DATE(created_at)' => $date,
            'user_id' => $userId,
            ])
            ->first();

        if ($dataBody) {
            # code...
            $arrayBody = array($dataBody->heart_rate*0.3, $dataBody->spo2*0.2, $dataBody->sleeping_quality*0.1);
            $bodyValue = round((array_sum($arrayBody)/count($arrayBody))*0.6, 2);
        }

        if ($dataEnvi) {
            # code...
            $arrayEnvi = array($dataEnvi->temperature*0.06, $dataEnvi->humidity*0.05, $dataEnvi->co2*0.05, $dataEnvi->pm25*0.04);
            $enviValue = round((array_sum($arrayEnvi)/count($arrayEnvi))*0.2, 2);
        }

        if ($dataMind) {
            # code...
            $mindValue = $dataMind;
        }

        $response['data'] = [
            'body' => $bodyValue,
            'envi' => $enviValue,
            'mind' => $mindValue,
        ];

        return $this->respond($response, 200);
    }

    public function history()
    {
        # code...
        $response['success'] = true;
        $response['message'] = '';
        $response['data'] = [];

        $userId = $this->request->getGet('user_id');

        if ($this->request->getGet('bulan')) {
            $bulan = $this->request->getGet('bulan');
        } else {
            $bulan = date('m');
        }

        if ($this->request->getGet('tahun')) {
            $tahun = $this->request->getGet('tahun');
        } else {
            $tahun = date('Y');
        }

        $historyModel = new HistoryModel();

        $data = $historyModel
            ->where('user_id', $userId)
            ->where('MONTH(date)', $bulan)
            ->where('YEAR(date)', $tahun)
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
