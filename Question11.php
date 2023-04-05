<?php

class Vehicle {

private array $technicians;

public function __construct(private string $registerNumber) {
    $this->registerNumber = $registerNumber;
    $this->technicians = [];
}

public function addTechnician(Technician $technician): void {
    if (!in_array($technician, $this->technicians, true)) {
        $this->technicians[] = $technician;
        $technician->setVehicle($this);
    }
}

public function removeTechnician(Technician $technician): void {
    $index = array_search($technician, $this->technicians, true);
    if ($index !== false) {
        array_splice($this->technicians, $index, 1);
        $technician->removeVehicle();
    }
}

public function getTechnicians(): array {
    return $this->technicians;
}

public function __toString(): string {
    $techniciansList = implode(", ", array_map(fn($t) => $t->getName(), $this->technicians));
    return "Vehicule numero: {$this->registerNumber}. Entretenu par : {$techniciansList}";
}

}

class Technician {

private array $vehicles;

public function __construct(private string $name) {
    $this->vehicles = [];
    $this->name = $name;
}


public function addvehicle(Vehicle $vehicle): void {
    if (!in_array($vehicle, $this->vehicles, true)) {
        $this->vehicles[] = $vehicle;
        $vehicle->addTechnician($this);
    }
}

public function removevehicle(Vehicle $vehicle): void {
    $index = array_search($vehicle, $this->vehicles, true);
    if ($index !== false) {
        array_splice($this->vehicles, $index, 1);
        $vehicle->removeTechnician($this);
    }
}


public function __toString(): string {
    $vehicleList = implode(", ", array_map(fn($v) => $v->getRegisterNumber(), $this->vehicles));
    return "technicien: {$this->name}. Entretien : {$vehicleList}";
}

}

$vA = new Vehicle('AB-123-CD');
$vB = new Vehicle('EF-456-GH');
$paul = new Technician('Paul');
$juliette = new Technician('Juliette');
$jalila = new Technician('Jalila');

$paul->setVehicle($vA);
$juliette->setVehicle($vA);
$jalila->setVehicle($vB);
var_dump($vA);