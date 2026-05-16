<div class="page-header">
    <h2><?= $task ? '✏️ Editar Tarefa' : '➕ Nova Tarefa' ?></h2>
</div>

<div class="form-container">
    <form 
        action="<?= url($task ? 'tasks/update' : 'tasks/store') ?>" 
        method="POST" 
        class="task-form"
    >
        <?php if ($task): ?>
            <input type="hidden" name="id" value="<?= $task['id'] ?>">
        <?php endif; ?>

        <!-- Título -->
        <div class="form-group">
            <label for="title">Título *</label>
            <input 
                type="text" 
                id="title" 
                name="title" 
                class="form-control" 
                value="<?= $task ? e($task['title']) : '' ?>"
                required
                autofocus
                placeholder="Digite o título da tarefa"
            >
        </div>

        <!-- Descrição -->
        <div class="form-group">
            <label for="description">Descrição</label>
            <textarea 
                id="description" 
                name="description" 
                class="form-control" 
                rows="4"
                placeholder="Adicione detalhes sobre a tarefa (opcional)"
            ><?= $task ? e($task['description']) : '' ?></textarea>
        </div>

        <!-- Data de Vencimento -->
        <div class="form-group">
            <label for="due_date">Data de Vencimento</label>
            <input 
                type="date" 
                id="due_date" 
                name="due_date" 
                class="form-control"
                value="<?= $task['due_date'] ?? '' ?>"
            >
        </div>

        <!-- Prioridade -->
        <div class="form-group">
            <label for="priority">Prioridade</label>
            <select id="priority" name="priority" class="form-control">
                <option value="low" <?= ($task['priority'] ?? '') === 'low' ? 'selected' : '' ?>>
                    Baixa
                </option>
                <option value="medium" <?= ($task['priority'] ?? 'medium') === 'medium' ? 'selected' : '' ?>>
                    Média
                </option>
                <option value="high" <?= ($task['priority'] ?? '') === 'high' ? 'selected' : '' ?>>
                    Alta
                </option>
            </select>
        </div>

        <!-- Botões -->
        <div class="form-actions">
            <a href="<?= url('tasks') ?>" class="btn btn-secondary">Cancelar</a>
            <button type="submit" class="btn btn-primary">
                <?= $task ? 'Atualizar' : 'Criar' ?> Tarefa
            </button>
        </div>
    </form>
</div>