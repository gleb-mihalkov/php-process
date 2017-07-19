<?php
namespace Process
{
    use Process\Interfaces\Get as Get;
    use Exception;

    /**
     * The base class of the process of element's enumeration.
     */
    abstract class Fetch extends Base implements Get
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
            catch (Exception $error)
            {
                $this->_error($error);
            }
        }
    }
}