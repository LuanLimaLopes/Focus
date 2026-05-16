<?php
 
/**
 * Configurações do Banco de Dados
 */
 
return [
    // Driver do banco (sqlite, mysql, pgsql)
    'driver' => 'sqlite',
    
    // Caminho do arquivo SQLite
    'database' => dirname(__DIR__) . '/storage/database/tasks.db',
    
    // Charset
    'charset' => 'utf8mb4',
    
    // Opções do PDO
    'options' => [
        PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
        PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
        PDO::ATTR_EMULATE_PREPARES => false,
    ],
];