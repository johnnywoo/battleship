<?php

class Board {
    // ships[x][y] = bool
    private $ships = [];

    public function addShip($x, $y) {
        $this->ships[$x][$y] = true;
        return $this;
    }

    public function getNumberOfShips() {
        return array_sum(array_map('count', $this->ships));
    }
}
