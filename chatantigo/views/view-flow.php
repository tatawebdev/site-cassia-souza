<!DOCTYPE html>
<html lang="pt-br">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Diagrama Interativo</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/jstree/3.3.12/themes/default/style.min.css" />
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.13/css/select2.min.css" rel="stylesheet" />



    <style>
        #floating-buttons {
            background-color: white;
            border: 1px solid #ccc;
            border-radius: 5px;
            padding: 10px;
            box-shadow: 2px 2px 10px rgba(0, 0, 0, 0.1);
            transition: opacity 0.3s ease, transform 0.3s ease;
            /* Inicialmente invisível */
            transform: translateY(-10px);
            /* Inicialmente deslocado para cima */
            position: relative;
            /* Posição relativa */
            margin-bottom: 20px;
            /* Espaço abaixo dos botões */
            z-index: 10;
            /* Certifica-se de que está acima de outros elementos */
        }



        #floating-buttons button {
            margin: 5px;
            padding: 8px 12px;
            /* Adiciona preenchimento */
            border: none;
            /* Remove bordas */
            border-radius: 5px;
            /* Bordas arredondadas */
            font-size: 14px;
            /* Tamanho da fonte */
            cursor: pointer;
            /* Cursor de ponteiro */
            transition: background-color 0.3s, transform 0.2s;
            /* Transições para cor de fundo e transformação */
        }

        /* Estilos para os botões */
        #addButton {
            background-color: #28a745;
            /* Verde */
            color: white;
            /* Texto branco */
        }

        #editButton {
            background-color: #007bff;
            /* Azul */
            color: white;
            /* Texto branco */
        }

        #deleteButton {
            background-color: #dc3545;
            /* Vermelho */
            color: white;
            /* Texto branco */
        }

        /* Efeitos ao passar o mouse */
        #floating-buttons button:hover {
            transform: translateY(-2px);
            /* Eleva o botão ao passar o mouse */
        }

        #floating-buttons button:active {
            transform: translateY(0);
            /* Retorna à posição original ao clicar */
        }

        /* Estilo para o botão de fechar (X) */
        .justify-content-end {
            display: flex;
            justify-content: end;
            /* Transição para cor de fundo */
        }

        /* Efeito ao passar o mouse no botão de fechar */
        .close-button:hover {
            background-color: darkred;
            /* Cor escura ao passar o mouse */
        }

        .justify-end {
            display: flex;
            justify-content: flex-end;
            /* Usar flex-end para alinhar ao final */
            width: 100%;
            /* Define a largura como 100% */
        }
    </style>
</head>

<body>
    <div class="modal" id="modal-tolist-tabs" tabindex="-1" role="dialog" aria-labelledby="modal-tolist-tabs" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="block block-transparent bg-white mb-0">
                    <ul class="nav nav-tabs nav-tabs-block" role="tablist">
                        <li class="nav-item">
                            <button class="nav-link" id="btabs-static-home-tab" data-bs-toggle="tab" data-bs-target="#btabs-static-home" role="tab" aria-controls="btabs-static-home" aria-selected="true">
                                Novo Item
                            </button>
                        </li>
                        <li class="nav-item ms-auto">
                            <button class="nav-link active" id="btabs-static-settings-tab" data-bs-toggle="tab" data-bs-target="#btabs-static-settings" role="tab" aria-controls="btabs-static-settings" aria-selected="false">
                                <i class="si si-settings"></i>
                            </button>
                        </li>
                    </ul>
                    <div class="block-content tab-content">
                        <div class="tab-pane" id="btabs-static-home" role="tabpanel" aria-labelledby="btabs-static-home-tab" tabindex="0">
                            <div class="form-group">
                                <input type="hidden" id="listaID">
                                <label for="listaTituloInteracao">Título do Item</label>
                                <input type="text" class="form-control" id="listaTituloInteracao" required maxlength="24" placeholder="Título da interação" oninput="updateCount('listaTituloInteracao', 24, 'tituloCount')">
                                <small class="justify-end"><span id="tituloCount">0/24</span></small>
                            </div>
                            <div class="form-group">
                                <label for="listaDescricaoInteracao">Descrição do Item</label>
                                <textarea class="form-control" id="listaDescricaoInteracao" rows="3" maxlength="72" placeholder="Descrição da interação" oninput="updateCount('listaDescricaoInteracao', 72, 'descricaoCount')"></textarea>
                                <small class="justify-end"><span id="descricaoCount">0/72</span></small>
                            </div>
                            <div class="form-group">
                                <label for="listaSecaoTitulo">Título da Seção</label>
                                <input type="text" class="form-control" id="listaSecaoTitulo" maxlength="24" placeholder="Título da seção" oninput="updateCount('listaSecaoTitulo', 24, 'secaoCount')">
                                <small class="justify-end"><span id="secaoCount">0/24</span></small>
                            </div>
                        </div>
                        <div class="tab-pane active" id="btabs-static-settings" role="tabpanel" aria-labelledby="btabs-static-settings-tab" tabindex="0">
                            <form>
                                <div class="form-group">
                                    <label for="headerText">Texto do Cabeçalho</label>
                                    <div>
                                        <input type="text" class="form-control" id="headerText" maxlength="60" placeholder="Texto do Cabeçalho" oninput="updateCount('headerText', 60, 'headerCount')">
                                        <small class="justify-end"><span id="headerCount">0/60</span></small>
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label for="bodyText">Texto do Corpo</label>
                                    <div>
                                        <textarea class="form-control" id="bodyText" rows="3" maxlength="4096" placeholder="Texto do Corpo" required oninput="updateCount('bodyText', 4096, 'bodyCount')"></textarea>
                                        <small class="justify-end"><span id="bodyCount">0/4096</span></small>
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label for="footerText">Texto do Rodapé</label>
                                    <div>
                                        <input type="text" class="form-control" id="footerText" maxlength="60" placeholder="Texto do Rodapé" oninput="updateCount('footerText', 60, 'footerCount')">
                                        <small class="justify-end"><span id="footerCount">0/60</span></small>
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label for="buttonText">Texto do Botão</label>
                                    <div>
                                        <input type="text" class="form-control" id="buttonText" maxlength="20" placeholder="Texto do Botão" required oninput="updateCount('buttonText', 20, 'buttonCount')">
                                        <small class="justify-end"><span id="buttonCount">0/20</span></small>
                                    </div>
                                </div>
                            </form>
                        </div>
                    </div>
                    <div class="block-content block-content-full text-end bg-body">
                        <button type="button" class="btn btn-sm btn-alt-secondary" data-bs-dismiss="modal">Fechar</button>
                        <button type="button" class="btn btn-sm btn-primary" id='btn-tolist-concluido' data-s-dismiss="modal">Concluído</button>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script>
        function updateCount(inputId, maxLength, countId) {
            const inputField = document.getElementById(inputId);
            const countDisplay = document.getElementById(countId);
            const currentLength = inputField.value.length;

            // Atualiza o contador
            countDisplay.textContent = `${currentLength}/${maxLength}`;
        }
    </script>


    <div id="floating-buttons" style="height: 70px;">
        <div class="justify-content-end">

            <input type="text" id="nomeCampo">

            <button id="convertToButton" title="Transformar em Botão">
                <i class="fas fa-window-maximize"></i>
            </button>
            <button id="convertToMessage" title="Transformar em Mensagem">
                <i class="fas fa-comment"></i> <!-- Corrigido para o ícone correto de mensagem -->
            </button>
            <button id="convertToList" title="Transformar em Lista">
                <i class="fas fa-list"></i> <!-- Corrigido para o ícone correto de lista -->
            </button>
            <!-- <button id="configureKeywordButton" title="Configurar Palavra-Chave">
                <i class="fas fa-key"></i> 
            </button> -->
            <button id="configureResponseButton" title="Adicionar" style="display: none;">
                <i class="fas fa-cog"></i>
            </button>

            <button id="addButton" title="Adicionar" style="display: none;">
                <i class="fas fa-plus"></i>
            </button>
            <button id="editButton" title="Editar" style="display: none;">
                <i class="fas fa-edit"></i>
            </button>
            <button id="interactionsButton" title="Interações" style="display: none;">
                <i class="fas fa-comments"></i>
            </button>
            <button id="saveMoveButton" title="Salvar" style="display: none;">
                <i class="fas fa-save"></i>
            </button>
            <button id="invertNodeButton" title="Inverter" style="display: inline;">
                <i class="fas fa-exchange-alt"></i>
            </button>
            <button id="deleteButton" title="Excluir" style="display: none;">
                <i class="fas fa-trash"></i>
            </button>

        </div>
    </div>


    <div id="jstree"></div>

    <div class="modal fade modal-pergunta" id="modalForm" tabindex="-1" role="dialog" aria-labelledby="modalLabel" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="modalLabel">Etapa</h5>
                    <!-- <button type="button" class="close" data-bs-dismiss="modal" aria-label="Fechar">
                    <span aria-hidden="true">&times;</span>
                </button> -->
                </div>
                <div class="modal-body">
                    <form id="formNode" style="height: 50vh;">
                        <div class="form-group" style="height: 80%;">
                            <label for="perguntaLabel">Pergunta</label>
                            <div id="editor" style="height: 300px;"></div>
                            <input type="hidden" id="pergunta" name="pergunta" required>
                        </div>


                        <input type="hidden" id="nodeId">
                        <input type="hidden" id="actionMode" value='cadastrar'>
                    </form>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Fechar</button>
                    <button type="button" class="btn btn-primary" id="saveButton">Salvar</button>
                </div>
            </div>
        </div>
    </div>
    <div class="modal fade" id="myModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">Editar Informações do Nó</h5>
                    <button type="button" class="close" data-bs-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <!-- Formulário dentro do modal -->
                    <form id="nodeForm">
                        <div class="form-group">
                            <label for="infoNodeId">ID do Nó</label>
                            <input type="text" class="form-control" id="infoNodeId" readonly>
                        </div>
                        <div class="form-group">
                            <label for="infoNodeName">Nome do Nó</label>
                            <input type="text" class="form-control" id="infoNodeName" required>
                        </div>
                        <div class="form-group">
                            <label for="infoNodeDescription">Descrição</label>
                            <textarea class="form-control" id="infoNodeDescription" rows="3"></textarea>
                        </div>
                    </form>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Fechar</button>
                    <button type="button" class="btn btn-primary" id="saveNodeChanges">Salvar Alterações</button>
                </div>
            </div>
        </div>
    </div>

    <div class="modal fade" id="modal-configurar-resposta" tabindex="-1" role="dialog" aria-labelledby="modal-default-slideup" aria-hidden="true">
        <div class="modal-dialog modal-dialog-slideup" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Configurar Resposta</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body pb-1">
                    <div class="form-group">
                        <select id="selectNomeFuncao" class="form-control" style="width: 100%;" required>
                            <option value="">Selecione uma Função...</option>
                        </select>
                    </div>

                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-sm btn-alt-secondary" data-bs-dismiss="modal">Close</button>
                    <button type="button" class="btn btn-sm btn-primary " id='configurar-resposta-salvar' data-bs-dismiss="modal">Salva</button>
                </div>
            </div>
        </div>
    </div>


    <div class="modal fade" id="addOptionModal" tabindex="-1" role="dialog" aria-labelledby="addOptionModalLabel" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="addOptionModalLabel">Adicionar Opção</h5>
                    <button type="button" class="close" data-bs-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <form id="optionForm">
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
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Fechar</button>
                    <button type="button" class="btn btn-primary" id="saveOptionButton">Salvar Opção</button>
                </div>
            </div>
        </div>



    </div>

    <script src="https://code.jquery.com/jquery-3.5.1.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.9.3/dist/umd/popper.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.13/js/select2.min.js"></script>

    <style>
        .ql-editor hr {
            border: none;
            border-top: 1px solid black;
            /* Estilo da linha */
            margin: 10px 0;
            /* Espaçamento em volta da linha */
        }
    </style>
    <script>
        $(document).ready(function() {
            $('#selectNomeFuncao').select2({
                dropdownParent: $('#modal-configurar-resposta'),
                ajax: {
                    url: '/functions/list/json', // URL para o servidor
                    dataType: 'json',
                    delay: 250,
                    data: function(params) {
                        // console.log('Parâmetros enviados:', params); // Verifique os parâmetros enviados

                        return {
                            q: params.term // Parâmetro da consulta
                        };
                    },
                    processResults: function(data) {
                        // console.log('Dados recebidos:', data); // Verifique a resposta recebida do servidor
                        return {
                            results: data.map(function(item) {
                                return {
                                    id: item.name, // ID da pergunta
                                    text: item.name // Texto da pergunta
                                };
                            })
                        };
                    },
                    cache: false
                },
                minimumInputLength: 1, // Mínimo de caracteres para iniciar a busca
            });

        });
    </script>


    <script>
        const flowId = '<?= $flowId ?>'
        let selectedNodeData = null;
        let selectedNodesData = [];
        let Nodes = [];
        let modalEdit = {};
        let onSaveMoveButton = false;
        let Moves = [];
        let visible = [];
    </script>


    <script type="module" src="/assets/sistema/etapa/interacoes.js"></script>
    <script type="module" src="/assets/sistema/etapa/etapa.js"></script>

    <script src="https://cdnjs.cloudflare.com/ajax/libs/jstree/3.3.12/jstree.min.js"></script>

    <!-- Quill CSS -->
    <link href="https://cdn.quilljs.com/1.3.6/quill.snow.css" rel="stylesheet">

    <!-- Quill JS -->
    <script src="https://cdn.quilljs.com/1.3.6/quill.js"></script>
    <script>
        // Inicializa o editor Quill
        // Importando BlockEmbed para criar o Blot de hr
        var BlockEmbed = Quill.import('blots/block/embed');

        // Definindo o blot para linha horizontal
        class HorizontalRule extends BlockEmbed {
            static create() {
                let node = super.create();
                node.setAttribute('contenteditable', 'false'); // Linha não editável
                return node;
            }
        }

        // Registrando o blot
        HorizontalRule.blotName = 'hr'; // Nome usado no Quill
        HorizontalRule.tagName = 'hr'; // Tag HTML gerada
        Quill.register(HorizontalRule);

        // Inicializando o editor Quill
        var quill = new Quill('#editor', {
            theme: 'snow',
            modules: {
                toolbar: {
                    container: [
                        ['bold', 'italic', 'underline'], // Formatação
                        ['customHr'] // Botão personalizado
                    ],
                    handlers: {
                        'customHr': function() {
                            // Obtém a seleção atual
                            var range = this.quill.getSelection();
                            if (range) {
                                // Insere um <br> antes de adicionar o <hr>
                                this.quill.insertText(range.index, '\n', Quill.sources.USER); // Quebra de linha <br>
                                this.quill.insertEmbed(range.index + 1, 'hr', true); // Insere o <hr> após a quebra de linha
                            }
                        }
                    }
                }
            }
        });

        // Adiciona o símbolo '|' no botão personalizado
        var customButton = document.querySelector('.ql-customHr');
        customButton.innerHTML = '|';
    </script>

</body>

</html>