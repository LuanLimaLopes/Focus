<?php

namespace App\Models;

use App\Database\Connection;
use PDO;

/**
 * Model Task - Gerencia as tarefas no banco de dados
 */
class Task
{
    /**
     * Retorna todas as tarefas
     * 
     * @param string|null $filter Filtro: 'pending', 'completed', ou null para todas
     * @return array
     */
    public static function all(?string $filter = null): array
    {
        $sql = "SELECT * FROM tasks";
        
        // Aplica filtro se fornecido
        if ($filter === 'pending') {
            $sql .= " WHERE completed = 0";
        } elseif ($filter === 'completed') {
            $sql .= " WHERE completed = 1";
        }
        
        $sql .= " ORDER BY created_at DESC";
        
        $stmt = Connection::query($sql);
        return $stmt->fetchAll();
    }

    /**
     * Busca uma tarefa por ID
     * 
     * @param int $id
     * @return array|false
     */
    public static function find(int $id): array|false
    {
        $sql = "SELECT * FROM tasks WHERE id = ?";
        $stmt = Connection::query($sql, [$id]);
        
        return $stmt->fetch();
    }

    /**
     * Cria uma nova tarefa
     * 
     * @param array $data
     * @return bool
     */
    public static function create(array $data): bool
    {
        $sql = "INSERT INTO tasks (title, description, due_date, priority, completed, created_at, updated_at) 
                VALUES (:title, :description, :due_date, :priority, 0, :created_at, :updated_at)";
        
        $params = [
            ':title' => $data['title'],
            ':description' => $data['description'] ?? null,
            ':due_date' => $data['due_date'] ?? null,
            ':priority' => $data['priority'] ?? 'medium',
            ':created_at' => now(),
            ':updated_at' => now(),
        ];
        
        try {
            Connection::query($sql, $params);
            return true;
        } catch (\PDOException $e) {
            return false;
        }
    }

    /**
     * Atualiza uma tarefa existente
     * 
     * @param int $id
     * @param array $data
     * @return bool
     */
    public static function update(int $id, array $data): bool
    {
        $sql = "UPDATE tasks 
                SET title = :title, 
                    description = :description, 
                    due_date = :due_date, 
                    priority = :priority,
                    updated_at = :updated_at
                WHERE id = :id";
        
        $params = [
            ':id' => $id,
            ':title' => $data['title'],
            ':description' => $data['description'] ?? null,
            ':due_date' => $data['due_date'] ?? null,
            ':priority' => $data['priority'] ?? 'medium',
            ':updated_at' => now(),
        ];
        
        try {
            Connection::query($sql, $params);
            return true;
        } catch (\PDOException $e) {
            return false;
        }
    }

    /**
     * Deleta uma tarefa
     * 
     * @param int $id
     * @return bool
     */
    public static function delete(int $id): bool
    {
        $sql = "DELETE FROM tasks WHERE id = ?";
        
        try {
            Connection::query($sql, [$id]);
            return true;
        } catch (\PDOException $e) {
            return false;
        }
    }

    /**
     * Marca/desmarca tarefa como concluída
     * 
     * @param int $id
     * @return bool
     */
    public static function toggle(int $id): bool
    {
        $sql = "UPDATE tasks 
                SET completed = NOT completed, 
                    updated_at = :updated_at 
                WHERE id = :id";
        
        $params = [
            ':id' => $id,
            ':updated_at' => now(),
        ];
        
        try {
            Connection::query($sql, $params);
            return true;
        } catch (\PDOException $e) {
            return false;
        }
    }

    /**
     * Retorna estatísticas das tarefas
     * 
     * @return array
     */
    public static function stats(): array
    {
        $sql = "SELECT 
                    COUNT(*) as total,
                    SUM(CASE WHEN completed = 1 THEN 1 ELSE 0 END) as completed,
                    SUM(CASE WHEN completed = 0 THEN 1 ELSE 0 END) as pending
                FROM tasks";
        
        $stmt = Connection::query($sql);
        return $stmt->fetch();
    }
}