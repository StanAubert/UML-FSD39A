<?php
class Waiter {
    private array $tables = [];

    public function addTable(Table $table): Waiter {
        if (count($this->tables) < 4) {
            $this->tables[] = $table;
            $table->setWaiter($this);
        }

        return $this;
    }

    public function removeTable(Table $table): Waiter {
        $key = array_search($table, $this->tables, true);
        if ($key !== false) {
            unset($this->tables[$key]);
        }

        return $this;
    }

    public function getTables(): array {
        return $this->tables;
    }
}

class Table {
    private Waiter $waiter;

    public function setWaiter(Waiter $waiter): Table {
        if ($this->waiter !== null) {
            $this->waiter->removeTable($this);
        }

        $this->waiter = $waiter;

        if ($waiter !== null) {
            $waiter->addTable($this);
        }

        return $this;
    }

}
