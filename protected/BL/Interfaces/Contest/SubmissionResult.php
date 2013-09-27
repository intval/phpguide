<?php

namespace phpg\bl\Interfaces\Contest;


class SubmissionResult
{
    public $id;
    public $error;
    public $passedTests;

    public function __toString()
    {
        return json_encode($this);
    }
} 