<?php
namespace Process
{
    use Process\Interfaces\Set as Set;
    use Exception;

    /**
     * The base class of the process of element's writing.
     */
    abstract class Write extends Base implements Set
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
        public function process($item)
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
            catch (Exception $error)
            {
                $this->_error($error);
            }
        }
    }
}