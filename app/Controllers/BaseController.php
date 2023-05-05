<?php

namespace App\Controllers;

use CodeIgniter\Controller;
use CodeIgniter\HTTP\CLIRequest;
use CodeIgniter\HTTP\IncomingRequest;
use CodeIgniter\HTTP\RequestInterface;
use CodeIgniter\HTTP\ResponseInterface;
use Psr\Log\LoggerInterface;

abstract class BaseController extends Controller
{
    protected $request;
    protected $helpers = [];
    protected $router;

    public function initController(RequestInterface $request, ResponseInterface $response, LoggerInterface $logger)
    {
        parent::initController($request, $response, $logger);
        helper(['form']);
        helper(['url']);
        helper(['general_helper']);
        $this->router = service('router');
        $this->session = session();
    }

    public function getCheckingStatus($checkingResult)
    {
        $data['status'] = '';
        $data['color'] = '';

        if ($checkingResult <= 70) {
            $data['status'] = 'Dangerous';
            $data['color'] = '0xFFD72F5D';
        } else if ($checkingResult > 70 && $checkingResult <= 90) {
            $data['status'] = 'slightly dangerous';
            $data['color'] = '0xFFD72F5D';
        } else if ($checkingResult > 90 && $checkingResult <= 180) {
            $data['status'] = 'Normal';
            $data['color'] = '0xFF9DCEFF';
        } else if ($checkingResult > 180 && $checkingResult <= 250) {
            $data['status'] = 'slightly dangerous';
            $data['color'] = '0xFFD72F5D';
        } else if ($checkingResult > 250) {
            $data['status'] = 'slightly dangerous';
            $data['color'] = '0xFFD72F5D';
        }

        return $data;
    }
}
