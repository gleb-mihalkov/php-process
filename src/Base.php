<?php
namespace Process
{
    /**
     * Базовый класс процесса.
     */
    abstract class Base
    {
        /**
         * Показывает, запущен ли процесс.
         * @var boolean
         */
        public $isStarted = false;

        /**
         * Показывает, произошла ли в процессе ошибка.
         * @var boolean
         */
        public $isError = false;

        /**
         * Показывает, завершен ли процесс.
         * @var boolean
         */
        public $isEnded = false;



        /**
         * Выполняется перед началом процесса. Виртуальный метод.
         * @return void
         */
        protected function start()
        {
            $this->isStarted = true;
        }

        /**
         * Выполняется при возникновении исключения во время процесса.
         * @param  Exception $error Исключение.
         * @return mixed            False, если исключение следует подавить.
         *                          В любом другом случае исключение будет выброшено
         *                          наверх для дальнейшей обработки.
         */
        protected function error($error)
        {
            $this->isError = true;
        }

        /**
         * Выполняется после завершения процесса, вне зависимости от того, возникло ли
         * исключение или нет.
         * @return void
         */
        protected function end()
        {
            $this->isEnded = true;
        }



        /**
         * Если процесс выполняется в данный момент, принудительно останавливает его.
         * @return void
         */
        public function stop()
        {
            if (!$this->isStarted || $this->isEnded) return;
            $this->end();
        }




        /**
         * Если процесс не запущен, вызывает метод start(). Данный метод перегружать не рекомендуется.
         * @return void
         */
        protected function _start()
        {
            if ($this->isStarted) return;
            $this->start();
        }

        /**
         * Если процесс не завершен, вызывает метод end().  Данный метод перегружать не рекомендуется.
         * @return void
         */
        protected function _end()
        {
            if ($this->isEnded) return;
            $this->end();
        }

        /**
         * Обрабатывает возникшее исключение.  Данный метод перегружать не рекомендуется.
         * @param  \Exception $error Исключение.
         * @return void
         */
        protected function _error($error)
        {
            $isSuppress = $this->error($error) === false;
            $this->_end();

            if ($isSuppress) return;
            throw $error;
        }
    }
}