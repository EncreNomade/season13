<?php

abstract class Payment {
    
    
    
    abstract public function passOrder($order);
    abstract public function getSuccessView();
    abstract public function getCancelView();
}