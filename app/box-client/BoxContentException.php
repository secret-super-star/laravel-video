<?php

namespace radzserg\BoxContent;
use Exception;

/**
 * BoxViewException extends the default exception class.
 * It does not do anything fancy except be a unique kind of Exception.
 */
class BoxContentException extends Exception
{
    /**
     * @var string
     */
    public $errorCode;
}
