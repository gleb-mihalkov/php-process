<?php
namespace Process
{
    use Exception as NativeException;

    /**
     * The base class of the exception of the process.
     */
    class Exception extends NativeException
    {
        /**
         * Creates the instance of the class.
         * @param Exception $error Previous exception.
         */
        public function __construct($error)
        {
            $message = $error->getMessage();
            $code = $error->getCode();
            parent::__construct($message, $code, $error);
        }
    }
}