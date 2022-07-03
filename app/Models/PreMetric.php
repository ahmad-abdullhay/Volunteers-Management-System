<?php

namespace App\Models;

interface PreMetric
{

    public function getValue();

    static public function isWithEvent();
}
