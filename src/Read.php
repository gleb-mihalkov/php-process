<?php
namespace Process
{
    use Exception;

    /**
     * The base class of the process of element's reading.
     */
    abstract class Read extends BaseGet
    {
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

                $item = $this->main();

                if ($item === null)
                {
                    $this->_end();
                }

                return $item;
            }
            catch (Exception $error)
            {
                $this->_error($error);
            }
        }
    }
}