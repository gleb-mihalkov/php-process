<?php
namespace Process
{
    use Exception;

    /**
     * The base class of the process of element's enumeration.
     */
    abstract class Fetch extends BaseGet
    {
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

                foreach ($this->main() as $item)
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