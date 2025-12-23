<?php

namespace App\Http\Controllers\Api\V1;

use App\Http\Controllers\Controller;
use App\Policies\V1\ProductPolicy;
use App\Traits\ApiResponses;
use Illuminate\Http\Request;
// use Illuminate\Foundation\Auth\Access\AuthorizesRequests;

class ApiController extends Controller
{
    use ApiResponses;
    // AuthorizesRequests
    // protected $policyClass;
    public function include(string $relationship): bool
    {
        $param = request()->get('include');
        if (!isset($param)) {
            return false;
        }
        $includedValues = explode(',', strtolower($param));
        return in_array(strtolower($relationship), $includedValues);
    }
    // public function isAble($ability, $targetModel)
    // {
    //     return $this->authorize($ability, [$targetModel, $this->policyClass]);
    // }
}
