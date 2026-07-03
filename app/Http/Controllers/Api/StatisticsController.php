<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Statistics;
use Illuminate\Http\Request;

class StatisticsController extends Controller
{
    public function statistics(Request $request)
    {
        $body = json_decode($request->getContent(), true);
        Statistics::save($body);
    }
}
