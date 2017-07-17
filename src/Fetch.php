<?php
namespace Process
{
    use Exception as NativeException;

    /**
     * The base class of the process of element's enumeration.
     */
    abstract class Fetch extends Base
    {
        /**
         * The body of the process.
         * @return Iterator<mixed> Enumeration.
         */
        abstract protected function fetch();



        /**
         * Executes the body of the process, causing all event methods.
         * @return Iterator<mixed> Enumeration.
         */
        public function process()
        {
            if ($this->isEnded) return;

            try
            {
                $this->_start();

                foreach ($this->fetch() as $item)
                {
                    if ($this->isEnded) return;
                    yield $item;
                }

                $this->_end();
            }
            catch (NativeException $error)
            {
                $this->_error($error);
            }
        }
    }
}