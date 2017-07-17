<?php
namespace Process
{
    use Exception as NativeException;

    /**
     * The base class of the process of element's reading.
     */
    abstract class Read extends Base
    {
        /**
         * The body of the process.
         * @return mixed The element or null if reading is finished.
         */
        abstract protected function read();



        /**
         * Executes the body of the process, causing all event methods.
         * @return mixed The element or null if the reading is finished.
         */
        public function process()
        {
            if ($this->isEnded) return null;

            try
            {
                $this->_start();

                $item = $this->read();

                if ($item === null)
                {
                    $this->_end();
                }

                return $item;
            }
            catch (NativeException $error)
            {
                $this->_error($error);
            }
        }
    }
}