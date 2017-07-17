<?php
namespace Process
{
    /**
     * The base class of the process.
     */
    abstract class Base
    {
        /**
         * Executes the body of the process, causing all event methods.
         * This method must be overrided in the child classes.
         * @return mixed Result of execution.
         */
        protected function process() {}



        /**
         * Shows if the process is started.
         * @var boolean
         */
        public $isStarted = false;

        /**
         * Shows if an error occurred.
         * @var boolean
         */
        public $isError = false;

        /**
         * Shows if process is ended.
         * @var boolean
         */
        public $isEnded = false;



        /**
         * Running before you start the process.
         * @return void
         */
        protected function start()
        {
            $this->isStarted = true;
        }

        /**
         * Is executed if during process execution the error occurred.
         * @param  Exception $error Error.
         * @return boolean          True if the specified exception should throw up
         *                          for further processing, otherwise false.
         */
        protected function error($error)
        {
            $this->isError = true;
            return true;
        }

        /**
         * Is executed after the ending of the process, no matter error or not.
         * @return void
         */
        protected function end()
        {
            $this->isEnded = true;
        }



        /**
         * Stops the process.
         * @return void
         */
        public function stop()
        {
            if (!$this->isStarted || $this->isEnded) return;
            $this->end();
        }




        /**
         * Calls start(), if it has not been called previously.
         * @return void
         */
        protected function _start()
        {
            if ($this->isStarted) return;
            $this->start();
        }

        /**
         * Calls the end() if it has not been called previously.
         * @return void
         */
        protected function _end()
        {
            if ($this->isEnded) return;
            $this->end();
        }

        /**
         * Handles an exception that occurred during execution of the process.
         * @param  Exception $error Exception.
         * @return void
         */
        protected function _error($error)
        {
            $isSuppress = !$this->error($error);
            $this->_end();

            if ($isSuppress) return;

            throw new Exception($error);
        }
    }
}