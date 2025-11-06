<div class="container">
    <div class="form-container">
        <h2 class="mb-4 text-center">Criar Novo Fluxo</h2>

        <form action="/create-flow" method="POST" novalidate>
            <div class="mb-3">
                <label for="nome" class="form-label">Nome do Fluxo</label>
                <input type="text" id="nome" name="nome" class="form-control" placeholder="Digite o nome do fluxo" required>
                <div class="invalid-feedback">
                    Por favor, insira o nome do fluxo.
                </div>
            </div>

            <div class="mb-4">
                <label for="descricao" class="form-label">Descrição</label>
                <textarea id="descricao" name="descricao" class="form-control" rows="4" placeholder="Digite a descrição do fluxo" required></textarea>
                <div class="invalid-feedback">
                    Por favor, insira a descrição do fluxo.
                </div>
            </div>

            <div class="d-flex justify-content-between">
                <a href="/flows" class="btn btn-secondary">Cancelar</a>
                <button type="submit" class="btn btn-primary">Criar Fluxo</button>
            </div>
        </form>
    </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
<script>
    // Validação do formulário utilizando Bootstrap
    (() => {
        'use strict';
        const forms = document.querySelectorAll('form');
        Array.prototype.slice.call(forms).forEach(form => {
            form.addEventListener('submit', event => {
                if (!form.checkValidity()) {
                    event.preventDefault();
                    event.stopPropagation();
                }
                form.classList.add('was-validated');
            }, false);
        });
    })();
</script>