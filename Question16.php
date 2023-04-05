<?php
class Waiter {
    
    private array $tables = [];

    public function __construct(private string $name) {}

    public function addTable(Table $table) : Waiter {

        if(count($this->tables) >= 4) {
            throw new Exception('Il y a déjà 4 tables attribuées');
        }
        $this->tables[] = $table;
        $table->addWaiter($this);
        return $this;
    }

    public function removeTable(Table $table) : Waiter {
        $index = array_search($table, $this->tables, true);
        if ($index !== false) {
            unset($this->tables[$index]);
            $table->removeWaiter($this);
        }
        return $this;
    }

    public function getTables() : array {
        return $this->tables;
    }

}

class Table {
    
    private array $waiters = [];

    public function __construct(private int $number) {}

    public function addWaiter(Waiter $waiter) : Table {
        $this->waiters[] = $waiter;
        return $this;
    }

    public function removeWaiter(Waiter $waiter) : Table {
        $index = array_search($waiter, $this->waiters, true);
        if ($index !== false) {
            unset($this->waiters[$index]);
        }
        return $this;
    }

    public function getWaiters() : array {
        return $this->waiters;
    }
}
