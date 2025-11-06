<style>
    /* Ícone ligado - Verde */
    .icon-on {
        color: green;
    }

    /* Ícone desligado - Cinza */
    .icon-off {
        color: gray;
    }

    /* Estilo para botão desabilitado */
    .toggle-btn.disabled {
        pointer-events: none;
        /* Impede cliques */
        opacity: 0.5;
        /* Visualmente desabilitado */
    }
</style>

<div class="block block-rounded">
    <div class="block-content">
        <!-- Botão no canto superior direito -->
        <div class="text-end mb-3">
            <a href="/create-flow" class="btn btn-primary">
                <i class="fa fa-plus"></i> Novo Fluxo
            </a>
        </div>
        <div class="table-responsive">

            <table class="table table-bordered table-striped table-vcenter">
                <thead>
                    <th>Fluxo</th>
                    <th style="width: 60%;">Descrição</th>
                    <th class="text-center" style="width: 100px;">Ações</th>
                </thead>
                <tbody>
                    <?php if (!empty($lista)): ?>
                        <?php $countList = count($lista); ?>
                        <?php foreach ($lista as $flow): ?>
                            <tr data-flow-id="<?= $flow['id']; ?>">
                                <td class="fw-semibold">
                                    <a href="/view-flow?id=<?= $flow['id']; ?>"><?= htmlspecialchars($flow['nome']); ?></a>
                                </td>
                                <td class="fw-semibold">
                                    <?= htmlspecialchars($flow['descricao']); ?>
                                </td>
                                <td class="text-center">
                                    <div class="btn-group">
                                        <button type="button" class="btn btn-sm btn-alt-secondary js-bs-tooltip-enabled toggle-btn <?= ($countList <= 1 && $flow['atual']) ? 'disabled' : ''; ?>" data-bs-toggle="tooltip"
                                            aria-label="<?= $flow['atual'] ? 'Desligar' : 'Ligar'; ?>"
                                            data-bs-original-title="<?= $flow['atual'] ? 'Desligar' : 'Ligar'; ?>"
                                            <?= ($countList <= 1) ? 'disabled' : ''; ?>
                                            onclick="<?= ($countList) ? 'toggleStatus(this)' : 'return false;'; ?>">
                                            <i class="fa <?= $flow['atual'] ? 'fa-toggle-on icon-on' : 'fa-toggle-off icon-off'; ?>"></i>
                                        </button>

                                        <a href="/view-flow?id=<?= $flow['id']; ?>" class="btn btn-sm btn-alt-secondary" data-bs-toggle="tooltip" title="Visualizar">
                                            <i class="fa fa-eye"></i>
                                        </a>

                                        <a href="/edit-flow?id=<?= $flow['id']; ?>" class="btn btn-sm btn-alt-secondary" data-bs-toggle="tooltip" title="Editar">
                                            <i class="fa fa-pencil-alt"></i>
                                        </a>

                                        <?php if ($countList > 1): ?>
                                            <a href="/delete-flow?id=<?= $flow['id']; ?>" class="btn btn-sm btn-alt-secondary" data-bs-toggle="tooltip" title="Excluir">
                                                <i class="fa fa-times"></i>
                                            </a>
                                        <?php endif; ?>

                                        <!-- Botão de Produção/Teste -->
                                        <button type="button" class="btn btn-sm btn-alt-secondary js-bs-tooltip-enabled" data-bs-toggle="tooltip"
                                            aria-label="<?= $flow['teste'] ? 'Modo Teste' : 'Modo Produção'; ?>"
                                            data-bs-original-title="<?= $flow['teste'] ? 'Modo Teste' : 'Modo Produção'; ?>"
                                            onclick="toggleProductionTest(this)">
                                            <i class="fa <?= $flow['teste'] ? 'fa-bug' : 'fa-cog'; ?>"></i>
                                        </button>

                                    </div>
                                </td>

                            </tr>
                        <?php endforeach; ?>
                    <?php else: ?>
                        <tr>
                            <td colspan="3" class="text-center">Nenhum fluxo encontrado.</td>
                        </tr>
                    <?php endif; ?>
                </tbody>
            </table>
        </div>
    </div>
</div>

<script src="https://code.jquery.com/jquery-3.5.1.min.js"></script>

<script>
    function toggleStatus(button) {
        var icon = $(button).find('i');
        var novoStatus = icon.hasClass('fa-toggle-on') ? 0 : 1;
        var flowId = $(button).closest('tr').data('flow-id');

        $.ajax({
            url: '/update-flow-status',
            type: 'POST',
            dataType: 'json',
            data: {
                id: flowId,
                status: novoStatus
            },
            success: function(response) {
                if (response.status === 'success') {
                    // Desativa todos os outros botões e atualiza o ícone e título
                    $('button[data-bs-original-title="Desligar"]').not(button).each(function() {
                        var otherIcon = $(this).find('i');
                        otherIcon.removeClass('fa-toggle-on icon-on').addClass('fa-toggle-off icon-off');
                        $(this).attr('data-bs-original-title', 'Ligar').attr('aria-label', 'Ligar');
                    });

                    // Atualiza o ícone e título do botão clicado
                    icon.removeClass('fa-toggle-off icon-off').addClass('fa-toggle-on icon-on');
                    $(button).attr('data-bs-original-title', 'Desligar').attr('aria-label', 'Desligar');

                    // Mensagem de sucesso
                    alertify.success('Status atualizado com sucesso.');
                } else {
                    alertify.error(response.message);
                }
            },
            error: function(xhr, status, error) {
                console.log('Erro ao atualizar status:', error);
            }
        });
    }

    function toggleProductionTest(button) {
        // Aqui você pode implementar a lógica para alternar entre Produção/Teste
        const isProducing = button.querySelector('i').classList.contains('fa-cog');
        var flowId = $(button).closest('tr').data('flow-id');



        $.ajax({
            url: '/update-flow-production',
            type: 'POST',
            dataType: 'json',
            data: {
                id: flowId,
                teste: isProducing ? 1 : 0
            },
            success: function(response) {
                if (response.status === 'success') {
                    if (isProducing) {
                        // Muda para modo teste
                        button.querySelector('i').classList.remove('fa-cog');
                        button.querySelector('i').classList.add('fa-bug');
                        button.setAttribute('aria-label', 'Modo Teste');
                        button.setAttribute('data-bs-original-title', 'Modo Teste');
                        alertify.success('Modo Teste ativado com sucesso.');
                    } else {
                        // Muda para modo produção
                        button.querySelector('i').classList.remove('fa-bug');
                        button.querySelector('i').classList.add('fa-cog');
                        button.setAttribute('aria-label', 'Modo Produção');
                        button.setAttribute('data-bs-original-title', 'Modo Produção');
                        alertify.success('Modo Produção ativado com sucesso.');
                    }

                } else {
                    alertify.error(response.message || 'Erro ao atualizar o status. Tente novamente.');
                }
            },
            error: function(xhr, status, error) {
                console.log('Erro ao atualizar status:', error);
            }
        });



        // Atualiza o tooltip
        $(button).tooltip('hide').tooltip('show');
    }
</script>