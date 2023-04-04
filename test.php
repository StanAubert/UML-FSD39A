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

private ?Vehicle $vehicle;

public function __construct(private string $name) {
    $this->vehicle = null;
    $this->name = $name;
}

public function setVehicle(?Vehicle $vehicle) : Technician {
    $this->vehicle = $vehicle;
    if ($vehicle) {
        $vehicle->setTechnician($this);
    }
    return $this;
}

public function removeVehicle(): void {
    $this->vehicle = null;
}


public function __toString(): string {
    $vehicleInfo = $this->vehicle ? "Vehicle with register number: {$this->vehicle->getRegisterNumber()}" : "No vehicle assigned";
    return "Technician named {$this->name}. Assigned to: {$vehicleInfo}";
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