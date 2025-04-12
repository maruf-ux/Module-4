<?php

trait FileHandler {
    private $filePath;

    public function setFilePath($filePath) {
        $this->filePath = $filePath;
    }

    public function readData() {
        if (!file_exists($this->filePath)) {
            return [];
        }
        $data = file_get_contents($this->filePath);
        return json_decode($data, true) ?? [];
    }

    public function writeData($data) {
        file_put_contents($this->filePath, json_encode($data, JSON_PRETTY_PRINT));
    }
}
?>