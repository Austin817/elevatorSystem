<?php

namespace App\ElevatorManagement;
use Illuminate\Support\Facades\Log;

class Elevator {
    private $elevatorNumber;
    private $currentFloor;
    private $passengers;
    private $direction; // 1 for up, -1 for down, 0 for stopped

    public function __construct($elevatorNumber) {
        $this->elevatorNumber = $elevatorNumber;
        $this->currentFloor = 1;
        $this->passengers = [];
        $this->direction = 0;
    }

    public function getElevatorNumber() {
        return $this->elevatorNumber;
    }

    public function getCurrentFloor() {
        return $this->currentFloor;
    }

    public function getPassengers() {
        return $this->passengers;
    }

    public function loadPassenger($floor, $targetFloor) {
        if (count($this->passengers) < 5) {
            $this->passengers[] = ["floor" => $floor, "targetFloor" => $targetFloor];
            return true;

            // sleep(1);
        }
        return false;
    }

    public function unloadPassengers() {
        foreach ($this->passengers as $key => $passenger) {
            if ($passenger["targetFloor"] == $this->currentFloor) {
                unset($this->passengers[$key]);

                // sleep(1);
            }
        }
    }

    public function move() {
        if ($this->direction == 1) {
            $this->currentFloor++;
        } elseif ($this->direction == -1) {
            $this->currentFloor--;
        }
        
        // sleep(1);
    }

    public function setDirection($direction) {
        $this->direction = $direction;
    }
}

