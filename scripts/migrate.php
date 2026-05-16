<?php

/**
 * Script de Migração - Cria a tabela de tarefas
 * 
 * Execute apenas uma vez: php scripts/migrate.php
 */

require_once __DIR__ . '/../vendor/autoload.php';

use App\Database\Connection;

echo "🚀 Iniciando migração do banco de dados...\n\n";

try {
    $pdo = Connection::getInstance();

    // SQL para criar a tabela tasks
    $sql = "
        CREATE TABLE IF NOT EXISTS tasks (
            id INTEGER PRIMARY KEY AUTOINCREMENT,
            title VARCHAR(255) NOT NULL,
            description TEXT,
            due_date DATE,
            priority VARCHAR(20) DEFAULT 'medium',
            completed BOOLEAN DEFAULT 0,
            created_at DATETIME NOT NULL,
            updated_at DATETIME NOT NULL
        )
    ";

    $pdo->exec($sql);
    
    echo "✅ Tabela 'tasks' criada com sucesso!\n";
    echo "📍 Banco de dados: " . dirname(__DIR__) . "/storage/database/tasks.db\n\n";

    // Insere algumas tarefas de exemplo
    echo "📝 Inserindo tarefas de exemplo...\n";
    
    $examples = [
        [
            'title' => 'Bem-vindo ao Focus!',
            'description' => 'Este é um exemplo de tarefa. Você pode editar ou excluir.',
            'priority' => 'high',
            'due_date' => date('Y-m-d', strtotime('+1 day'))
        ],
        [
            'title' => 'Tarefa de exemplo 2',
            'description' => 'Organize sua rotina com o Focus.',
            'priority' => 'medium',
            'due_date' => date('Y-m-d', strtotime('+3 days'))
        ],
        [
            'title' => 'Tarefa concluída',
            'description' => 'Este é um exemplo de tarefa já concluída.',
            'priority' => 'low',
            'due_date' => date('Y-m-d', strtotime('-1 day')),
            'completed' => 1
        ],
    ];

    $insertSql = "INSERT INTO tasks (title, description, priority, due_date, completed, created_at, updated_at) 
                  VALUES (:title, :description, :priority, :due_date, :completed, :created_at, :updated_at)";

    foreach ($examples as $task) {
        $stmt = $pdo->prepare($insertSql);
        $stmt->execute([
            ':title' => $task['title'],
            ':description' => $task['description'],
            ':priority' => $task['priority'],
            ':due_date' => $task['due_date'],
            ':completed' => $task['completed'] ?? 0,
            ':created_at' => date('Y-m-d H:i:s'),
            ':updated_at' => date('Y-m-d H:i:s'),
        ]);
        
        echo "  ✓ {$task['title']}\n";
    }

    echo "\n✅ Migração concluída com sucesso!\n";
    echo "🌐 Acesse: http://localhost:8080/focus/\n\n";

} catch (PDOException $e) {
    echo "❌ Erro na migração: " . $e->getMessage() . "\n";
    exit(1);
}