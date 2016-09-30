<?php

namespace CustomException;

/**
 * CustomException\ExceptionInterface
 * @see http://php.net/manual/en/language.exceptions.php Class provided by ask at nilpo dot com in User notes section.
 */
interface ExceptionInterface
{
    /* Protected methods inherited from Exception class */
    public function getMessage();                 // Exception message 
    public function getCode();                    // User-defined Exception code
    public function getFile();                    // Source filename
    public function getLine();                    // Source line
    public function getTrace();                   // An array of the backtrace()
    public function getTraceAsString();           // Formated string of trace
    
    /* Overrideable methods inherited from Exception class */
    public function __toString();                 // formated string for display
    public function __construct($message = null, $code = 0);
}
