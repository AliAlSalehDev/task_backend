<?php

namespace App\Http\Controllers\Api\V1;

use App\Http\Controllers\Api\V1\Core\ApiBaseController;
use App\Http\Requests\Item\StoreItemRequest;
use App\Http\Requests\Item\UpdateItemRequest;
use App\Models\Item;
use App\Services\V1\Entity\ItemService;

class ItemController extends ApiBaseController
{
    protected $model = Item::class;
    protected $modelService = ItemService::class;
    protected $storeRequest = StoreItemRequest::class;
    protected $updateRequest = UpdateItemRequest::class;
}
