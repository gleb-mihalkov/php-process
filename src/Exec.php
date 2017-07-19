<?php
namespace Process
{
    use Exception;

    /**
     * The base class of the process of execution.
     */
    abstract class Exec extends BaseGet
    {
        /**
         * Executes the body of the process, causing all event methods.
         * @return void
         */
        public function process()
        {
            if ($this->isEnded) return;

            try
            {
                $this->_start();
                $this->main();
                $this->_end();
            }
            catch (Exception $error)
            {
                $this->_error($error);
            }
        }
    }
}