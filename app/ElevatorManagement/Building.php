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

        // Set the elevator's direction based on the destination floor
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
            echo "Passenger on floor $floor pressed the elevator button to go to floor $targetFloor.\n";
            // Log::info("Passenger on floor $floor pressed the elevator button to go to floor $targetFloor.");
        }

        for ($time = 0; $time < 100; $time++) { // Simulate 100 seconds
            foreach ($this->elevators as $elevator) {
                $elevator->unloadPassengers();
                $elevator->move();

                // 取得電梯狀態和乘客狀態
                // $currentFloor = $elevator->getCurrentFloor();
                // $passengerCount = count($elevator->getPassengers());

                // echo "Elevator on floor $currentFloor with $passengerCount passengers.\n";
                // Log::info("Elevator on floor $currentFloor with $passengerCount passengers.");
            }
        }
        
    }
}
