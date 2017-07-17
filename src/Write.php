<?php
namespace Process
{
    use Exception as NativeException;

    /**
     * The base class of the process of element's writing.
     */
    abstract class Write extends Base
    {
        /**
         * The body of the process.
         * @param  mixed $item The element or null if writing must be finished.
         * @return void
         */
        abstract protected function write($item);



        /**
         * Executes the body of the process, causing all event methods.
         * @param  mixed $item The element or null if writing must be finished.
         * @return void
         */
        protected function process($item)
        {
            if ($this->isEnded) return;

            try
            {
                $this->_start();

                if ($item === null)
                {
                    $this->_end();
                    return;
                }

                $this->write($item);
            }
            catch (NativeException $error)
            {
                $this->_error($error);
            }
        }
    }
}