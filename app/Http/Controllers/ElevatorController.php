<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\ElevatorManagement\Building;


class ElevatorController extends Controller
{
    public function simulateElevatorSystem()
    {
        // dd(123);

        // 輸入電梯數、樓層數
        $building = new Building(2, 10);
        $building->simulate(1);
        
        
        return '電梯系統已經完成模擬';
    }
}
