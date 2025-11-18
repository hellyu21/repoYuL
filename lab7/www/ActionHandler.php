<?php
class ActionHandler {
    
    public function handle($message) {
        $action = $message['action'] ?? 'unknown';
        $data = $message['data'] ?? [];
    }
    private function handleAddPet($data) {
        $ownerName = $data['owner_name'] ?? '';
        $petName = $data['pet_name'] ?? '';
        $petAge = $data['pet_age'] ?? null;
        $petType = $data['pet_type'] ?? '';
        $petGender = $data['pet_gender'] ?? '';
        $vaccinated = isset($data['vaccinated']) ? 'Да' : 'Нет';
        $notes = $data['notes'] ?? '';
    }
    private function handleUpdatePet($data) {
        $id = $data['id'] ?? 'unknown';
        $ownerName = $data['owner_name'] ?? '';
        $petName = $data['pet_name'] ?? '';
    }
    private function handleDeletePet($data) {
        $id = $data['id'] ?? 'unknown';
    }
}