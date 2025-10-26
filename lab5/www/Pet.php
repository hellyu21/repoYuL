<?php
class Pet {
    private $pdo;

    public function __construct($pdo) {
        $this->pdo = $pdo;
    }

    public function add($owner_name, $pet_age, $pet_type, $has_vaccinations, $pet_gender) {
        $stmt = $this->pdo->prepare(
            "INSERT INTO pets (owner_name, pet_age, pet_type, has_vaccinations, pet_gender) VALUES (?, ?, ?, ?, ?)"
        );
        $stmt->execute([$owner_name, $pet_age, $pet_type, $has_vaccinations, $pet_gender]);
    }

    public function getAll() {
        $stmt = $this->pdo->query("SELECT * FROM pets");
        return $stmt->fetchAll();
    }

    public function update($id, $owner_name) {
        $stmt = $this->pdo->prepare("UPDATE pets SET name=? WHERE id=?");
        $stmt->execute([$owner_name, $id]);
    }

    public function delete($id) {
        $stmt = $this->pdo->prepare("DELETE FROM pets WHERE id=?");
        $stmt->execute([$id]);
    }
}
