<!DOCTYPE html>
<html lang="pt-BR">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <script src="https://code.jquery.com/jquery-3.5.1.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.9.3/dist/umd/popper.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
    <title>Gerenciamento de Opções do Chatbot</title>
</head>

<body>

    <div class="container mt-5">
        <h2>Gerenciamento de Opções do Chatbot</h2>
        <button class="btn btn-primary mb-3" data-toggle="modal" data-target="#addOptionModal">Adicionar Opção</button>

        <table class="table">
            <thead>
                <tr>
                    <th>Título da Interação</th>
                    <th>Tipo de Interação</th>
                    <th>Ações</th>
                </tr>
            </thead>
            <tbody id="optionsTableBody">
                <!-- As opções serão inseridas aqui -->
            </tbody>
        </table>
    </div>

    <!-- Modal para adicionar nova opção -->
    <div class="modal fade" id="addOptionModal" tabindex="-1" role="dialog" aria-labelledby="addOptionModalLabel" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="addOptionModalLabel">Adicionar Opção</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <form id="optionForm">
                        <div class="form-group tipoInteration">
                            <label for="optionType">Tipo de Interação</label>
                            <select class="form-control" id="optionType" required>
                                <option value="" disabled selected>Selecione o tipo...</option>
                                <option value="message_button">Message Button</option>
                                <option value="message_interactive">Message Interactive</option>
                            </select>
                        </div>
                        <div class="form-group">
                            <label for="tituloInteracao">Título da Interação</label>
                            <input type="text" class="form-control" id="tituloInteracao" required>
                        </div>
                        <div class="form-group" id="descricaoGroup" style="display: none;">
                            <label for="descricaoInteracao">Descrição da Interação</label>
                            <textarea class="form-control" id="descricaoInteracao" rows="3"></textarea>
                        </div>
                        <div class="form-group" id="secaoTituloGroup" style="display: none;">
                            <label for="secaoTitulo">Seção Título</label>
                            <input type="text" class="form-control" id="secaoTitulo">
                        </div>
                    </form>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Fechar</button>
                    <button type="button" class="btn btn-primary" id="saveOptionButton">Salvar Opção</button>
                </div>
            </div>
        </div>
    </div>

    <script>
        $(document).ready(function() {
            let selectOn = true;
            let tipo_interacao = 'message_button'

            // Carregar opções do servidor
            loadOptions();

            // Evento para mudar o formulário baseado no tipo de interação selecionado
            $('#optionType').change(function() {
                var selectedType = $(this).val();
                if (selectedType === 'message_button') {
                    $('#tipoInteration').hide();
                    $('#secaoTituloGroup').hide();
                    $('#descricaoGroup').hide();
                } else if (selectedType === 'message_interactive') {
                    $('#descricaoGroup').show();
                    $('#secaoTituloGroup').show();
                }
            });

            // Evento para salvar a nova opção
            $('#saveOptionButton').click(function() {
                var title = $('#tituloInteracao').val();
                var type = $('#optionType').val();
                var description = $('#descricaoInteracao').val();
                var sectionTitle = $('#secaoTitulo').val();

                data = {
                    id_step: <?= intval($_GET['id_step']) ?>,
                    titulo_interacao: title,
                    descricao_interacao: description,
                    secao_titulo: sectionTitle
                };
                if (selectOn) {
                    data.tipo_interacao = type
                }

                // Envia dados para o servidor via AJAX
                $.ajax({
                    url: '/create-interations', // Substitua pelo seu arquivo PHP
                    type: 'POST',
                    data: data,
                    dataType: "json",

                    success: function(response) {
                        console.log(response)
                        // Adiciona a nova opção na tabela


                        // Limpa o formulário e fecha o modal
                        $('#optionForm')[0].reset();
                        $('#descricaoGroup').hide();
                        $('#secaoTituloGroup').hide();
                        $('#addOptionModal').modal('hide');
                        loadOptions();



                    },
                    error: function(xhr, status, error) {
                        console.log(error);
                    }
                });
            });
        });

        // Função para carregar opções do servidor
        function loadOptions() {
            $('#optionsTableBody').empty();
            $.ajax({
                url: '/list-interations-json?id_step=<?= intval($_GET['id_step']) ?>', // Substitua pelo seu arquivo PHP
                type: 'POST',
                success: function(response) {
                    console.log(response)
                    selectOn = true
                    var options = JSON.parse(response);

                    options.forEach(function(option) {
                        selectOn = option.option_id === null

                        if (option.option_id !== null) {
                            tipo_interacao = option.tipo_interacao;

                            $('#optionsTableBody').append(`
                        <tr>
                            <td>${option.titulo_interacao}</td>
                            <td>${option.tipo_interacao}</td>
                            <td>
                                <button class="btn btn-danger btn-sm" onclick="deleteOption(this, ${option.option_id})">Excluir</button>
                            </td>
                        </tr>
                    `);
                        }
                    });
                    $('#optionType').val(tipo_interacao);
                    if (tipo_interacao === 'message_button') {
                        $('#tipoInteration').hide();
                        $('#secaoTituloGroup').hide();
                        $('#descricaoGroup').hide();

                    } else if (tipo_interacao === 'message_interactive') {
                        $('#descricaoGroup').show();
                        $('#secaoTituloGroup').show();
                    }
                    if (selectOn) $('.tipoInteration').show();
                    else $('.tipoInteration').hide();
                },
                error: function(xhr, status, error) {
                    console.log(error);
                }
            });
        }

        // Função para excluir uma opção
        function deleteOption(button, id) {
            // Envia solicitação de exclusão para o servidor
            $.ajax({
                url: '/delete-interations', // Substitua pelo seu arquivo PHP
                type: 'POST',
                data: {
                    id: id
                },
                dataType: "json",
                success: function(response) {
                    console.log(response)

                    loadOptions()
                },
                error: function(xhr, status, error) {
                    console.log(error);
                }
            });
        }
    </script>

</body>

</html>