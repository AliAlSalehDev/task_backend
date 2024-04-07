<?php

namespace App\Http\Controllers\Api\V1;

use App\Http\Controllers\Api\V1\Core\ApiBaseController;
use App\Http\Requests\Category\StoreCategoryRequest;
use App\Http\Requests\Category\UpdateCategoryRequest;
use App\Models\Category;
use App\Services\V1\Entity\CategoryService;

class CategoryController extends ApiBaseController
{
    protected $model = Category::class;
    protected $modelService = CategoryService::class;
    protected $storeRequest = StoreCategoryRequest::class;
    protected $updateRequest = UpdateCategoryRequest::class;
}
