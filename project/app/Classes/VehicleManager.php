<?php

require_once __DIR__ . '/../Classes/FileHandler.php';
require_once __DIR__ . '/../Classes/VehicleActions.php';
require_once __DIR__ . '/../Classes/VehicleBase.php';

class VehicleManager implements VehicleActions {
    use FileHandler;

    private $vehicles = [];
    private $nextId = 1;

    public function __construct(string  $filePath) {
        $this->setFilePath($filePath);
        $this->vehicles = $this->readData();
        if(!empty($this->vehicles)){
            $this->nextId = max(array_keys($this->vehicles)) + 1;
        }
    }

    public function addVehicle($data) {
        $data['id'] = $this->nextId;
        $this->vehicles[$this->nextId] = $data;
        $this->writeData($this->vehicles);
        $this->nextId++;
        return $data['id'];
    }

    public function editVehicle($id, $data) {
        if (isset($this->vehicles[$id])) {
            $this->vehicles[$id] = array_merge($this->vehicles[$id], $data);
            $this->writeData($this->vehicles);
            return true;
        }
        return false;
    }

    public function deleteVehicle($id) {
        if (isset($this->vehicles[$id])) {
            unset($this->vehicles[$id]);
            $this->writeData($this->vehicles);
            return true;
        }
        return false;
    }

    public function getVehicles() {
        return $this->vehicles;
    }
    
    public function getVehicle($id) {
        return isset($this->vehicles[$id]) ? $this->vehicles[$id] : null;
    }
}
?>