<?php

/**
 * Created by IntelliJ IDEA.
 * User: rifat
 * Date: 9/7/17
 * Time: 6:16 AM
 */

namespace DotEnvEditor;

use Exception;

class DotEnvException extends Exception
{
    public function __construct($message, $code, Exception $previous = NULL)
    {
        parent::__construct($message, $code, $previous);
    }
    public function __toString()
    {
        return __CLASS__ . ":[{$this->code}]: {$this->message}\n";
    }
}