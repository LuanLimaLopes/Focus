<?php

/**
 * Funções Auxiliares Globais
 */

/**
 * Carrega uma view e passa dados para ela
 * 
 * @param string $view Nome da view (ex: 'tasks/index')
 * @param array $data Dados a serem passados para a view
 * @return void
 */
function view(string $view, array $data = []): void
{
    // Inicia sessão se ainda não foi iniciada
    if (session_status() === PHP_SESSION_NONE) {
        session_start();
    }
    
    // Extrai os dados para variáveis
    extract($data);
    
    // Define o conteúdo a ser carregado
    $content = $view;
    
    // Carrega o layout principal
    $layoutPath = __DIR__ . "/../Views/layouts/main.php";
    
    if (file_exists($layoutPath)) {
        require $layoutPath;
    } else {
        die("Layout não encontrado: layouts/main.php");
    }
}

/**
 * Redireciona para uma URL
 * 
 * @param string $path Caminho relativo
 * @return void
 */
function redirect(string $path): void
{
    $config = require __DIR__ . '/../../config/app.php';
    $baseUrl = $config['url'];
    
    header("Location: {$baseUrl}/{$path}");
    exit;
}

/**
 * Retorna a URL base da aplicação
 * 
 * @param string $path Caminho adicional
 * @return string
 */
function url(string $path = ''): string
{
    $config = require __DIR__ . '/../../config/app.php';
    $baseUrl = rtrim($config['url'], '/');
    $path = ltrim($path, '/');
    
    return $path ? "{$baseUrl}/{$path}" : $baseUrl;
}

/**
 * Escapa HTML para evitar XSS
 * 
 * @param string $string
 * @return string
 */
function e(string $string): string
{
    return htmlspecialchars($string, ENT_QUOTES, 'UTF-8');
}

/**
 * Debug helper - exibe variável formatada
 * 
 * @param mixed $data
 * @param bool $die
 * @return void
 */
function dd($data, bool $die = true): void
{
    echo '<pre>';
    var_dump($data);
    echo '</pre>';
    
    if ($die) {
        die();
    }
}

/**
 * Retorna a data/hora atual formatada
 * 
 * @param string $format
 * @return string
 */
function now(string $format = 'Y-m-d H:i:s'): string
{
    return date($format);
}