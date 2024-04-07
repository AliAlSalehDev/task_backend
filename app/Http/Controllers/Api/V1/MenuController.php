<?php

namespace App\Http\Controllers\Api\V1;

use App\Http\Controllers\Api\V1\Core\ApiBaseController;
use App\Http\Requests\Menu\StoreMenuRequest;
use App\Http\Requests\Menu\UpdateMenuRequest;
use App\Models\Menu;
use App\Services\V1\Entity\MenuService;

class MenuController extends ApiBaseController
{
    protected $model = Menu::class;
    protected $modelService = MenuService::class;
    protected $storeRequest = StoreMenuRequest::class;
    protected $updateRequest = UpdateMenuRequest::class;

}
