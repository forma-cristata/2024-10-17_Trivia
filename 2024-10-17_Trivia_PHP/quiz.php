<?php
class Quiz
{
    // const ANSWERS = ["12", "pomona", "1918", "cabbage", "SN"];

    private int $percentage;
    private string $fraction;
    public function __construct($percentage, $fraction)
    {
        $this->percentage = $percentage;
        $this->fraction = $fraction;

    }

    public function getPercentage() {return $this->percentage;}
    public function getFraction() {return $this->fraction;}
}