<?php

namespace Base;

/**
 * Class Component
 *
 * Simple class to fill properties through constructor config params
 */
class Component
{
    function __construct($config = [])
    {
        foreach ($config as $k => $v) {
            $this->$k = $v;
        }
    }
}