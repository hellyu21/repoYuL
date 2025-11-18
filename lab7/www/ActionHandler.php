<?php
class ActionHandler {
    
    public function handle($message) {
        $action = $message['action'] ?? 'unknown';
        $data = $message['data'] ?? [];
        
        echo "🔄 Обработка действия: {$action}\n";
        
        switch ($action) {
            case 'add_pet':
                return $this->handleAddPet($data);
                
            case 'update_pet':
                return $this->handleUpdatePet($data);
                
            case 'delete_pet':
                return $this->handleDeletePet($data);
                
            default:
                echo "⚠️ Неизвестное действие: {$action}\n";
                return false;
        }
    }
    
    private function handleAddPet($data) {
        $ownerName = $data['owner_name'] ?? '';
        $petName = $data['pet_name'] ?? '';
        $petAge = $data['pet_age'] ?? null;
        $petType = $data['pet_type'] ?? '';
        $petGender = $data['pet_gender'] ?? '';
        $vaccinated = isset($data['vaccinated']) ? 'Да' : 'Нет';
        $notes = $data['notes'] ?? '';
        $logData = [
            'action' => 'add_pet',
            'owner_name' => $ownerName,
            'pet_name' => $petName,
            'pet_age' => $petAge,
            'pet_type' => $petType,
            'pet_gender' => $petGender,
            'vaccinated' => $vaccinated,
            'notes' => $notes,
            'timestamp' => date('Y-m-d H:i:s')
        ];
        
        file_put_contents('processed_pets.log', json_encode($logData) . PHP_EOL, FILE_APPEND);
        
        echo "✅ Питомец добавлен: $petName (Владелец: $ownerName)\n";
        return true;
    }
    private function handleUpdatePet($data) {
        $id = $data['id'] ?? 'unknown';
        $ownerName = $data['owner_name'] ?? '';
        $petName = $data['pet_name'] ?? '';
        
        $logData = [
            'action' => 'update_pet',
            'id' => $id,
            'owner_name' => $ownerName,
            'pet_name' => $petName,
            'timestamp' => date('Y-m-d H:i:s')
        ];
        
        file_put_contents('processed_pets.log', json_encode($logData) . PHP_EOL, FILE_APPEND);
        
        echo "✅ Питомец обновлен: $petName (ID: $id)\n";
        return true;
    }
    private function handleDeletePet($data) {
        $id = $data['id'] ?? 'unknown';
        
        $logData = [
            'action' => 'delete_pet',
            'id' => $id,
            'timestamp' => date('Y-m-d H:i:s')
        ];
        
        file_put_contents('processed_pets.log', json_encode($logData) . PHP_EOL, FILE_APPEND);
        
        echo "✅ Питомец удален: ID $id\n";
        return true;
    }
}