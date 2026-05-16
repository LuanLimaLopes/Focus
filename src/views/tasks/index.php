<!-- Estatísticas -->
<div class="stats">
    <div class="stat-card">
        <div class="stat-value"><?= $stats['total'] ?? 0 ?></div>
        <div class="stat-label">Total</div>
    </div>
    <div class="stat-card">
        <div class="stat-value"><?= $stats['pending'] ?? 0 ?></div>
        <div class="stat-label">Pendentes</div>
    </div>
    <div class="stat-card">
        <div class="stat-value"><?= $stats['completed'] ?? 0 ?></div>
        <div class="stat-label">Concluídas</div>
    </div>
</div>

<!-- Título -->
<div class="page-header">
    <h2>
        <?php if ($filter === 'pending'): ?>
            📌 Tarefas Pendentes
        <?php elseif ($filter === 'completed'): ?>
            ✅ Tarefas Concluídas
        <?php else: ?>
            📋 Todas as Tarefas
        <?php endif; ?>
    </h2>
</div>

<!-- Lista de Tarefas -->
<?php if (empty($tasks)): ?>
    <div class="empty-state">
        <p>Nenhuma tarefa encontrada.</p>
        <a href="<?= url('tasks/create') ?>" class="btn btn-primary">Criar primeira tarefa</a>
    </div>
<?php else: ?>
    <div class="tasks-list">
        <?php foreach ($tasks as $task): ?>
            <div class="task-card <?= $task['completed'] ? 'completed' : '' ?>" data-id="<?= $task['id'] ?>">
                <!-- Checkbox -->
                <div class="task-checkbox">
                    <input 
                        type="checkbox" 
                        class="task-toggle" 
                        data-id="<?= $task['id'] ?>"
                        <?= $task['completed'] ? 'checked' : '' ?>
                    >
                </div>

                <!-- Conteúdo -->
                <div class="task-content">
                    <h3 class="task-title"><?= e($task['title']) ?></h3>
                    
                    <?php if (!empty($task['description'])): ?>
                        <p class="task-description"><?= e($task['description']) ?></p>
                    <?php endif; ?>

                    <div class="task-meta">
                        <!-- Prioridade -->
                        <span class="badge badge-<?= $task['priority'] ?>">
                            <?php
                            $priorities = ['low' => 'Baixa', 'medium' => 'Média', 'high' => 'Alta'];
                            echo $priorities[$task['priority']] ?? 'Média';
                            ?>
                        </span>

                        <!-- Data de vencimento -->
                        <?php if (!empty($task['due_date'])): ?>
                            <span class="task-date">
                                📅 <?= date('d/m/Y', strtotime($task['due_date'])) ?>
                            </span>
                        <?php endif; ?>
                    </div>
                </div>

                <!-- Ações -->
                <div class="task-actions">
                    <a href="<?= url("tasks/edit/{$task['id']}") ?>" class="btn btn-sm btn-secondary" title="Editar">
                        ✏️
                    </a>
                    <a 
                        href="<?= url("tasks/delete/{$task['id']}") ?>" 
                        class="btn btn-sm btn-danger" 
                        onclick="return confirm('Tem certeza que deseja excluir esta tarefa?')"
                        title="Excluir"
                    >
                        🗑️
                    </a>
                </div>
            </div>
        <?php endforeach; ?>
    </div>
<?php endif; ?>