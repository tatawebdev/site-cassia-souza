<div class="container flow-container">
    <h2 class="mb-4 text-center">Excluir Fluxo</h2>

    <p>Tem certeza que deseja excluir o fluxo: <strong><?= htmlspecialchars($flow['nome']) ?></strong>?</p>

    <form method="POST" action="">
        <div class="d-flex justify-content-between mt-4">
            <input type="hidden" name="id" value="<?= htmlspecialchars($flow['id']) ?>">
            <a href="/view-flow?id=<?= $flow['id'] ?>" class="btn btn-secondary">Cancelar</a>
            <button type="submit" class="btn btn-danger">Excluir</button>
        </div>
    </form>
</div>