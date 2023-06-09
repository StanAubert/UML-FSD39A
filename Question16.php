<?php
class Waiter {
    private array $tables = [];

    public function addTable(Table $table): Waiter {
        if (count($this->tables) < 4) {
            $this->tables[] = $table;
            $table->addWaiter($this);
        }

        return $this;
    }

    public function removeTable(Table $table): Waiter {
        $key = array_search($table, $this->tables, true);
        if ($key !== false) {
            unset($this->tables[$key]);
        }
        $table->removeWaiter($this);
        return $this;
    }

    public function getTables(): array {
        return $this->tables;
    }
}

class Table {

    private array $waiters = [];

    public function addWaiter(Waiter $waiter) : Table {
        $this->waiters[] = $waiter;
        $waiter->addTable($this);
        return $this;
    }

    public function removeWaiter(Waiter $waiter) : Table {
        $index = array_search($waiter, $this->waiters, true);
        if ($index !== false) {
            unset($this->waiters[$index]);
        }
        $waiter->removeTable($this);
        return $this;
    }

}
