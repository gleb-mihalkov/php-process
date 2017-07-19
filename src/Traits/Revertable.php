<?php
namespace Process\Traits
{
    /**
     * Добавляет процессу методы commit() и revert() для применения
     * изменений в случае успеха и их отката в случае ошибки.
     */
    trait Revertable
    {
        /**
         * Вызывается для потверждения изменений при успешном завершении процесса.
         * Несмотря на модификатор protected, метод можно вызвать извне.
         * Если метод вызван напрямую, процесс останавливается.
         * @return void
         */
        protected function commit() {}

        /**
         * Вызывается для отмены изменений при завершении процесса с ошибкой.
         * Несмотря на модификатор protected, метод можно вызвать извне.
         * Если метод вызван напрямую, процесс останавливается.
         * @return void
         */
        protected function revert() {}

        /**
         * Показывает, были ли подтверждены изменения в процессе.
         * @var boolean
         */
        public $isCommited = false;

        /**
         * Показывает, были ли отменены изменения в процессе.
         * @var boolean
         */
        public $isReverted = false;



        /**
         * Показывает, было ли обработано завершение процесса.
         * @return boolean True или false.
         */
        private function isResolved()
        {
            $isResolved = $this->isCommited || $this->isReverted;
            return $isResolved;
        }

        /**
         * Разрешает изменения в процессе указанным способом.
         * @param  string  $type   Способ разрешения изменений - 'commit' или 'revert'.
         * @param  boolean $isStop Показывает, следует ли остановить процесс после разрешения изменений.
         * @return void
         */
        private function resolve($type, $isStop = false)
        {
            if ($this->isResolved()) return;

            $flag = $type === 'commit' ? 'isCommited' : 'isReverted';
            $this->$flag = true;

            $action = $type === 'commit' ? 'commit' : 'revert';
            $this->$action();

            if ($isStop) $this->stop();
        }

        /**
         * Вызывается при неудачном завершении процесса.
         * @return void
         */
        protected function error($e)
        {
            parent::error($e);
            $this->resolve('revert');
        }

        /**
         * Вызывается при любом завершении процесса.
         * @return void
         */
        protected function end()
        {
            parent::end();

            if ($this->isError) return;
            
            $this->resolve('commit');
        }

        /**
         * Вызывается при попытке вызова защищенных методов commit и revert.
         * @param  string       $name Имя метода.
         * @param  array<mixed> $args Список аргументов.
         * @return mixed              Результат выполнения методов.
         */
        public function __call($name, $args)
        {
            if ($name !== 'commit' && $name !== 'revert') return;
            $this->resolve($name, true);
        }
    }
}