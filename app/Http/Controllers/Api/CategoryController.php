<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Category;
use App\Repositories\Interfaces\CategoryInterface;
use App\Services\CategoryServices;
use Illuminate\Http\Request;

class CategoryController extends Controller
{
    protected $categoryService;
    protected $categoryInterface;

    public function __construct(
        CategoryServices $categoryServices,
        CategoryInterface $categoryInterfaces
    ) {
        $this->categoryService = $categoryServices;
        $this->categoryInterface = $categoryInterfaces;
    }
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        return $this->categoryService->getAllDataCategory($request);
    }

    /**
     * Display the specified resource.
     */
    public function show(Category $category)
    {
        return $this->categoryInterface->showDataCategory($category);
    }
}
