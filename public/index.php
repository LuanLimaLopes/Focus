<?php
 
/**
 * Entry Point da Aplicação Focus
 * 
 * Este arquivo é o ponto de entrada principal.
 * Todas as requisições são redirecionadas para cá pelo .htaccess
 */
 
// Autoload do Composer
require_once __DIR__ . '/../vendor/autoload.php';
 
// Carrega funções auxiliares
require_once __DIR__ . '/../src/Helpers/functions.php';
 
// Carrega configurações
$config = require __DIR__ . '/../config/app.php';
 
// Configurações do PHP
date_default_timezone_set($config['timezone']);
ini_set('default_charset', $config['charset']);
 
// Modo debug
if ($config['debug']) {
    error_reporting(E_ALL);
    ini_set('display_errors', 1);
} else {
    error_reporting(0);
    ini_set('display_errors', 0);
}
 
// Sistema de Rotas Simples
$requestUri = $_SERVER['REQUEST_URI'];
$scriptName = $_SERVER['SCRIPT_NAME'];
 
// Remove o caminho base da URL
$baseUrl = str_replace('/index.php', '', $scriptName);
$route = str_replace($baseUrl, '', $requestUri);
 
// Remove query string
$route = strtok($route, '?');
 
// Remove trailing slash
$route = rtrim($route, '/');
 
// Se vazio, define como home
if (empty($route)) {
    $route = '/';
}
 
// Método HTTP
$method = $_SERVER['REQUEST_METHOD'];
 
// ==========================================
// DEFINIÇÃO DAS ROTAS
// ==========================================
 
use App\Controllers\TaskController;
 
try {
    // Instancia o controller
    $taskController = new TaskController();
 
    // Rotas GET
    if ($method === 'GET') {
        switch ($route) {
            case '/':
                // Página inicial - lista de tarefas
                $taskController->index();
                break;
            
            case '/tasks':
                // Lista de tarefas
                $taskController->index();
                break;
            
            case '/tasks/create':
                // Formulário de criação
                $taskController->create();
                break;
            
            default:
                // Verifica se é rota de edição: /tasks/edit/1
                if (preg_match('/^\/tasks\/edit\/(\d+)$/', $route, $matches)) {
                    $id = $matches[1];
                    $taskController->edit($id);
                } 
                // Verifica se é rota de exclusão: /tasks/delete/1
                else if (preg_match('/^\/tasks\/delete\/(\d+)$/', $route, $matches)) {
                    $id = $matches[1];
                    $taskController->delete($id);
                }
                // 404
                else {
                    http_response_code(404);
                    echo "<h1>404 - Página não encontrada</h1>";
                    echo "<p>Rota: {$route}</p>";
                    echo "<a href='" . url() . "'>Voltar para início</a>";
                }
                break;
        }
    }
    
    // Rotas POST
    elseif ($method === 'POST') {
        switch ($route) {
            case '/tasks/store':
                // Salvar nova tarefa
                $taskController->store();
                break;
            
            case '/tasks/update':
                // Atualizar tarefa existente
                $taskController->update();
                break;
            
            case '/tasks/toggle':
                // Marcar/desmarcar como concluída (AJAX)
                $taskController->toggle();
                break;
            
            default:
                http_response_code(404);
                echo json_encode(['error' => 'Rota não encontrada']);
                break;
        }
    }
    
} catch (Exception $e) {
    // Tratamento de erros
    if ($config['debug']) {
        echo "<h1>Erro:</h1>";
        echo "<pre>" . $e->getMessage() . "</pre>";
        echo "<pre>" . $e->getTraceAsString() . "</pre>";
    } else {
        echo "<h1>Ops! Algo deu errado.</h1>";
        echo "<p>Tente novamente mais tarde.</p>";
    }
}