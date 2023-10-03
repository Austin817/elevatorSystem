<?php

namespace App\ElevatorManagement;
use Illuminate\Support\Facades\Log;

class Building {
    private $elevators;
    private $floors;

    public function __construct($numElevators, $numFloors) {
        $this->elevators = [];
        $this->floors = $numFloors;

        for ($i = 0; $i < $numElevators; $i++) {
            $this->elevators[] = new Elevator();
        }
    }

    public function requestElevator($floor, $targetFloor) {
        $closestElevator = null;
        $closestDistance = PHP_INT_MAX;

        foreach ($this->elevators as $elevator) {
            $distance = abs($elevator->getCurrentFloor() - $floor);
            if ($distance < $closestDistance) {
                $closestElevator = $elevator;
                $closestDistance = $distance;
            }
        }

        $closestElevator->loadPassenger($floor, $targetFloor);

        // 依目的樓層設置電梯方向
        if ($targetFloor > $floor) {
            $closestElevator->setDirection(1);
        } elseif ($targetFloor < $floor) {
            $closestElevator->setDirection(-1);
        }

        return $closestElevator;
    }

    public function simulate($numPassengers) {
        for ($i = 0; $i < $numPassengers; $i++) {
            $floor = rand(1, $this->floors);
            $targetFloor = rand(1, $this->floors);

            $elevator = $this->requestElevator($floor, $targetFloor);
            echo "乘客在 $floor 樓，按下電梯到 $targetFloor 樓.\n";
            // Log::info("Passenger on floor $floor pressed the elevator button to go to floor $targetFloor.");
        }

        for ($time = 0; $time < 100; $time++) { // Simulate 100 seconds
            foreach ($this->elevators as $elevator) {
                $elevator->unloadPassengers();
                $elevator->move();

                // 取得電梯狀態和乘客狀態
                $currentFloor = $elevator->getCurrentFloor();
                $passengerCount = count($elevator->getPassengers());

                echo "電梯在 $currentFloor 樓， 有 $passengerCount 個乘客.\n";
                // Log::info("Elevator on floor $currentFloor with $passengerCount passengers.");
            }
        }
        
    }
}
