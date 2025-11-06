<style>
    body {
        background-color: #f8f9fa;
    }

    .flow-container {
        max-width: 800px;
        margin: 50px auto;
        padding: 20px;
        background-color: white;
        box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
        border-radius: 8px;
    }
</style>

<h2 class="mb-4 text-center">Editar Fluxo</h2>

<form method="POST" action="">
    <input type="hidden" name="id" value="<?= htmlspecialchars($flow['id']) ?>">
    <div class="mb-3">
        <label for="name" class="form-label">Nome do Fluxo</label>
        <input type="text" class="form-control" id="name" name="name" value="<?= htmlspecialchars($flow['nome']) ?>" required>
    </div>

    <div class="mb-3">
        <label for="description" class="form-label">Descrição</label>
        <textarea class="form-control" id="description" name="description" rows="4" required><?= htmlspecialchars($flow['descricao']) ?></textarea>
    </div>

    <div class="d-flex justify-content-between mt-4">
        <a href="/flows" class="btn btn-secondary">Cancelar</a>
        <button type="submit" class="btn btn-primary">Salvar Alterações</button>
    </div>
</form>