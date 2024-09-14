<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Services\StatementService;

class StatementController extends Controller
{
    public function index(Request $request)
    {
        $statements = StatementService::getList($request);

        return response()->json($statements);
    }
}
