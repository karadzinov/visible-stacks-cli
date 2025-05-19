<?php
use Illuminate\Container\Container;

class MyContainer extends Container
{
    public function runningUnitTests()
    {
        return false;
    }
}

