<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Services\Admin\StatusService;

class StatusController extends Controller
{
    private $statusService;
    public function __construct(StatusService $statusService)
    {
        $this->statusService = $statusService;
    }

    public function getVersion()
    {
        $version = $this->statusService->getVersion();
        return api_response($version);
    }
}
