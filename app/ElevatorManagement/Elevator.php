<?php

namespace App\ElevatorManagement;
use Illuminate\Support\Facades\Log;

class Elevator {
    private $currentFloor;
    private $passengers;
    private $direction; // 1 for up, -1 for down, 0 for stopped

    public function __construct() {
        $this->currentFloor = 1;
        $this->passengers = [];
        $this->direction = 0;
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
        }
        return false;
    }

    public function unloadPassengers() {
        foreach ($this->passengers as $key => $passenger) {
            if ($passenger["targetFloor"] == $this->currentFloor) {
                unset($this->passengers[$key]);
            }
        }
    }

    public function move() {
        if ($this->direction == 1) {
            $this->currentFloor++;
        } elseif ($this->direction == -1) {
            $this->currentFloor--;
        }
    }

    public function setDirection($direction) {
        $this->direction = $direction;
    }
}

