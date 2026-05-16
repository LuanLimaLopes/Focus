<?php

namespace App\Controllers;

use App\Models\Task;

/**
 * Controller de Tarefas
 * Gerencia todas as ações relacionadas às tarefas
 */
class TaskController
{
    /**
     * Lista todas as tarefas
     * GET /tasks ou /
     */
    public function index(): void
    {
        // Pega filtro da query string (?filter=pending)
        $filter = $_GET['filter'] ?? null;
        
        // Busca tarefas do banco
        $tasks = Task::all($filter);
        
        // Busca estatísticas
        $stats = Task::stats();
        
        // Carrega a view
        view('tasks/index', [
            'tasks' => $tasks,
            'stats' => $stats,
            'filter' => $filter
        ]);
    }

    /**
     * Exibe formulário de criação
     * GET /tasks/create
     */
    public function create(): void
    {
        view('tasks/form', [
            'task' => null,
            'action' => 'create'
        ]);
    }

    /**
     * Salva nova tarefa no banco
     * POST /tasks/store
     */
    public function store(): void
    {
        // Validação básica
        if (empty($_POST['title'])) {
            $_SESSION['error'] = 'O título é obrigatório!';
            redirect('tasks/create');
            return;
        }

        // Prepara dados
        $data = [
            'title' => trim($_POST['title']),
            'description' => trim($_POST['description'] ?? ''),
            'due_date' => $_POST['due_date'] ?? null,
            'priority' => $_POST['priority'] ?? 'medium',
        ];

        // Salva no banco
        if (Task::create($data)) {
            $_SESSION['success'] = 'Tarefa criada com sucesso!';
            redirect('tasks');
        } else {
            $_SESSION['error'] = 'Erro ao criar tarefa!';
            redirect('tasks/create');
        }
    }

    /**
     * Exibe formulário de edição
     * GET /tasks/edit/{id}
     */
    public function edit(int $id): void
    {
        $task = Task::find($id);

        if (!$task) {
            $_SESSION['error'] = 'Tarefa não encontrada!';
            redirect('tasks');
            return;
        }

        view('tasks/form', [
            'task' => $task,
            'action' => 'edit'
        ]);
    }

    /**
     * Atualiza tarefa existente
     * POST /tasks/update
     */
    public function update(): void
    {
        $id = (int) $_POST['id'];

        // Validação
        if (empty($_POST['title'])) {
            $_SESSION['error'] = 'O título é obrigatório!';
            redirect("tasks/edit/{$id}");
            return;
        }

        // Prepara dados
        $data = [
            'title' => trim($_POST['title']),
            'description' => trim($_POST['description'] ?? ''),
            'due_date' => $_POST['due_date'] ?? null,
            'priority' => $_POST['priority'] ?? 'medium',
        ];

        // Atualiza
        if (Task::update($id, $data)) {
            $_SESSION['success'] = 'Tarefa atualizada com sucesso!';
            redirect('tasks');
        } else {
            $_SESSION['error'] = 'Erro ao atualizar tarefa!';
            redirect("tasks/edit/{$id}");
        }
    }

    /**
     * Deleta uma tarefa
     * GET /tasks/delete/{id}
     */
    public function delete(int $id): void
    {
        if (Task::delete($id)) {
            $_SESSION['success'] = 'Tarefa excluída com sucesso!';
        } else {
            $_SESSION['error'] = 'Erro ao excluir tarefa!';
        }

        redirect('tasks');
    }

    /**
     * Marca/desmarca como concluída (AJAX)
     * POST /tasks/toggle
     */
    public function toggle(): void
    {
        header('Content-Type: application/json');

        $id = (int) ($_POST['id'] ?? 0);

        if ($id && Task::toggle($id)) {
            echo json_encode(['success' => true]);
        } else {
            echo json_encode(['success' => false, 'error' => 'Erro ao atualizar']);
        }
    }
}