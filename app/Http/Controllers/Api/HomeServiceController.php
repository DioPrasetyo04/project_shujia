<?php

namespace App\Http\Controllers\Api;

use App\Models\HomeService;
use Illuminate\Http\Request;
use App\Services\HomeServices;
use App\Http\Controllers\Controller;
use App\Repositories\Interfaces\HomeServiceInterface;

class HomeServiceController extends Controller
{
    protected $HomeService;
    protected $homeRepository;

    public function __construct(
        HomeServices $homeServices,
        HomeServiceInterface $homeServiceInterface
    ) {
        $this->HomeService = $homeServices;
        $this->homeRepository = $homeServiceInterface;
    }
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        return $this->HomeService->getAllDataWithCategory($request);
    }

    /**
     * Display the specified resource.
     */
    public function show(HomeService $homeService)
    {
        return $this->homeRepository->showDataHomeService($homeService);
    }
}
