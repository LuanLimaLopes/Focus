<?php
 
namespace App\Database;
 
use PDO;
use PDOException;
 
/**
 * Classe de Conexão com Banco de Dados
 * Padrão Singleton - garante uma única instância da conexão
 */
class Connection
{
    private static ?PDO $instance = null;
 
    /**
     * Construtor privado para evitar instanciação direta
     */
    private function __construct() {}
 
    /**
     * Previne clonagem da instância
     */
    private function __clone() {}
 
    /**
     * Obtém a instância única da conexão
     * 
     * @return PDO
     * @throws PDOException
     */
    public static function getInstance(): PDO
    {
        if (self::$instance === null) {
            self::$instance = self::createConnection();
        }
 
        return self::$instance;
    }
 
    /**
     * Cria a conexão com o banco de dados
     * 
     * @return PDO
     * @throws PDOException
     */
    private static function createConnection(): PDO
    {
        try {
            $config = require __DIR__ . '/../../config/database.php';
            
            $driver = $config['driver'];
            $database = $config['database'];
            $options = $config['options'];
 
            // Garante que o diretório do banco existe
            $dbDir = dirname($database);
            if (!is_dir($dbDir)) {
                mkdir($dbDir, 0755, true);
            }
 
            // DSN para SQLite
            $dsn = "{$driver}:{$database}";
 
            // Cria a conexão
            $pdo = new PDO($dsn, null, null, $options);
 
            return $pdo;
 
        } catch (PDOException $e) {
            // Em produção, logar o erro ao invés de exibir
            die("Erro na conexão com o banco: " . $e->getMessage());
        }
    }
 
    /**
     * Executa uma query SQL
     * 
     * @param string $sql
     * @param array $params
     * @return \PDOStatement
     */
    public static function query(string $sql, array $params = []): \PDOStatement
    {
        $pdo = self::getInstance();
        $stmt = $pdo->prepare($sql);
        $stmt->execute($params);
        
        return $stmt;
    }
}