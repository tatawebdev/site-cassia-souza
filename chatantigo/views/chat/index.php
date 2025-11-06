<!doctype html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width,initial-scale=1.0">

    <title>Cassia Souza Advocacia</title>

    <meta name="description" content="Cassia Souza Advocacia">
    <meta name="author" content="pixelcave">
    <meta name="robots" content="index, follow">

    <!-- Open Graph Meta -->
    <meta property="og:title" content="Cassia Souza Advocacia">
    <meta property="og:site_name" content="Dashmix">
    <meta property="og:description" content="Cassia Souza Advocacia">
    <meta property="og:type" content="website">
    <meta property="og:url" content="">
    <meta property="og:image" content="">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">

    <!-- Icons -->
    <!-- The following icons can be replaced with your own, they are used by desktop and mobile browsers -->
    <link rel="shortcut icon" href="assets/media/favicons/favicon.png">
    <link rel="icon" type="image/png" sizes="192x192" href="assets/media/favicons/favicon-192x192.png">
    <link rel="apple-touch-icon" sizes="180x180" href="assets/media/favicons/apple-touch-icon-180x180.png">
    <!-- END Icons -->
    <script src="https://code.jquery.com/jquery-3.5.1.min.js"></script>
    <link rel="stylesheet" href="/assets/alertifyjs/alertify.css" />
    <link rel="stylesheet" href="/assets/js/plugins/sweetalert2/sweetalert2.min.css">
    <link rel="stylesheet" id="css-main" href="assets/css/dashmix.min.css">

    <!-- You can include a specific file from css/themes/ folder to alter the default color theme of the template. eg: -->
    <!-- <link rel="stylesheet" id="css-theme" href="assets/css/themes/xwork.min.css"> -->
    <link rel="stylesheet" id="css-theme" href="assets/css/themes/xdream.min.css">
    <!-- END Stylesheets -->
</head>

<body>

    <script>
        let Userid = null;
    </script>
    <script src="assets/js/dashmix.app.min.js"></script>
    <script src="/assets/sistema/chat.js"></script>

    <script type="module">
        import {
            initializeApp
        } from "https://www.gstatic.com/firebasejs/10.5.2/firebase-app.js";
        import {
            getMessaging,
            getToken,
            onMessage
        } from "https://www.gstatic.com/firebasejs/10.5.2/firebase-messaging.js";

        const firebaseConfig = {
            apiKey: "AIzaSyDC_juTBl65iSz_TZsjYQEtUyIRURLQap0",
            authDomain: "chat-cassia-souza-adv.firebaseapp.com",
            projectId: "chat-cassia-souza-adv",
            storageBucket: "chat-cassia-souza-adv.appspot.com",
            messagingSenderId: "969461920153",
            appId: "1:969461920153:web:89874b4322d96f77eda308",
            measurementId: "G-DMYW90V0D7"
        };

        const vapidKey = 'BMcsGmQg3luA4MCokshTgRcCW7C6jfF9mHplEUCc-hyXSGlFn6wKC_8zbA5vCk4_9TK3HJHM5N36sFiSk6MClFs';

        const app = initializeApp(firebaseConfig);
        const messaging = getMessaging(app);

        if ("serviceWorker" in navigator) {
            navigator.serviceWorker
                .register("./firebase-messaging-sw.js")
                .then((registration) => {
                    // console.log("Registro bem-sucedido, escopo é:", registration.scope);
                    return getToken(messaging, {
                        vapidKey
                    });
                })
                .then((currentToken) => {
                    if (currentToken) {
                        $.ajax({
                            url: '/chat/enviar-currentToken',
                            method: 'POST',
                            dataType: "json",
                            data: {
                                currentToken
                            },
                            success: function(response) {
                                console.log(response)
                                if (response.status === 'success') {

                                }
                            },
                            error: function(xhr, status, error) {
                                console.log("Erro ao salvar os dados: ", error);
                            },
                            complete: function() {}
                        });
                        // console.log('Token atual para o cliente: ', currentToken);
                    } else {
                        console.log('Nenhum token de registro disponível. Solicite permissão para gerar um.');
                    }
                })
                .catch((err) => {
                    console.log('Ocorreu um erro ao recuperar o token. ', err);
                });
        } else {
            console.log("Service workers não são suportados neste navegador.");
        }

        // Correção aqui: remove o 'messaging' como argumento
        onMessage(messaging, (payload) => {
            console.log('Message received. ', payload);
            // const notificationTitle = payload.notification.title || 'Notification';
            // const notificationOptions = {
            //     body: payload.notification.body || 'You have a new message.',
            // };
            if (payload.data.conversandoCom != 'bot')
                Chat.addMessage(Userid, payload.data.mensagem, (payload.data.remetente == 'user' ? '' : 'self'));

            // Exibir uma notificação
            // new Notification(notificationTitle, notificationOptions);
        });

        // onBackgroundMessage(messaging, function(payload) {
        //     console.log('Received background message ', payload);

        //     Chat.addMessage(5, payload.notification.title);
        //     Chat.addHeader
        //     // const notificationTitle = payload.notification.title;
        //     // const notificationOptions = {
        //     //     body: payload.notification.body,
        //     //     icon: payload.notification.icon
        //     // };

        //     // self.registration.showNotification(notificationTitle, notificationOptions);
        // });
    </script>
    <style>
        .display-none {
            display: none !important;
            /* O !important garante que a regra tenha prioridade */
        }

        .whatsapp-link {
            text-decoration: none;
            color: #25D366;
            /* Cor padrão do WhatsApp */
            font-size: 24px;
            /* Tamanho do ícone */
        }

        .whatsapp-link:hover {
            color: #128C7E;
            /* Cor ao passar o mouse */
        }

        /* Estilo para o contêiner de chat */
        #bodyChat {
            height: 100vh;
            overflow-y: auto;
            padding: 10px;
        }

        /* Estilo para a barra de rolagem em navegadores WebKit (Chrome, Safari) */
        #bodyChat::-webkit-scrollbar {
            width: 8px;
            /* largura da barra de rolagem */
        }

        #bodyChat::-webkit-scrollbar-track {
            background: #f1f1f1;
            /* cor de fundo da trilha da barra de rolagem */
            border-radius: 8px;
            /* bordas arredondadas da trilha */
        }

        #bodyChat::-webkit-scrollbar-thumb {
            background: #888;
            /* cor da barra de rolagem */
            border-radius: 8px;
            /* bordas arredondadas da barra de rolagem */
        }

        #bodyChat::-webkit-scrollbar-thumb:hover {
            background: #555;
            /* cor da barra de rolagem ao passar o mouse */
        }

        #chatForm {
            background: #fff !important;
            /* cor da barra de rolagem ao passar o mouse */
        }

        .img-avatar {
            width: 32px;
            height: 32px;
            line-height: 32px;
            text-align: center;
            font-size: 14px;
            color: #000;
            border-radius: 50%;
            background-color: #f0f0f0;
            padding: 6px;
            display: flex !important;
            justify-content: center;
            align-items: center;
        }

        .block-title {
            display: flex;
            /* para alinhar o ícone e o link */
            align-items: center;
            /* alinha verticalmente os itens no centro */
        }

        .fs-sm {
            font-size: 14px;
            /* tamanho da fonte do nome, ajuste conforme necessário */
        }

        .fw-semibold {
            font-weight: 600;
            /* peso da fonte, ajuste conforme necessário */
        }

        .ms-2 {
            margin-left: 0.5rem;
            /* espaço entre o ícone e o nome */
        }
    </style>

    <div id="page-container" class="sidebar-o side-scroll">

        <!-- Sidebar -->
        <!--
        Sidebar Mini Mode - Display Helper classes

        Adding 'smini-hide' class to an element will make it invisible (opacity: 0) when the sidebar is in mini mode
        Adding 'smini-show' class to an element will make it visible (opacity: 1) when the sidebar is in mini mode
          If you would like to disable the transition animation, make sure to also add the 'no-transition' class to your element

        Adding 'smini-hidden' to an element will hide it when the sidebar is in mini mode
        Adding 'smini-visible' to an element will show it (display: inline-block) only when the sidebar is in mini mode
        Adding 'smini-visible-block' to an element will show it (display: block) only when the sidebar is in mini mode
      -->
        <nav id="sidebar" aria-label="Main Navigation">
            <!-- Side Header -->
            <div class="content-header bg-primary">
                <!-- Logo -->
                <a class="fw-semibold text-white tracking-wide" href="index.html">
                    Contatos
                </a>
                <!-- END Logo -->

                <!-- Options -->
                <div>
                    <!-- Close Sidebar, Visible only on mobile screens -->
                    <!-- Layout API, functionality initialized in Template._uiApiLayout() -->
                    <a class="d-lg-none text-white ms-2" data-toggle="layout" data-action="sidebar_close" href="javascript:void(0)">
                        <i class="fa fa-times-circle"></i>
                    </a>
                    <!-- END Close Sidebar -->
                </div>
                <!-- END Options -->
            </div>
            <!-- END Side Header -->

            <!-- Sidebar Scrolling -->
            <div class="js-sidebar-scroll">
                <!-- People -->
                <div>
                    <!-- <form class="push" action="db_chat.html" method="POST" onsubmit="return false;">
                        <div class="input-group">
                            <input class="form-control form-control-alt" placeholder="Search People..">
                            <span class="input-group-text input-group-text-alt">
                                <i class="fa fa-fw fa-search"></i>
                            </span>
                        </div>
                    </form> -->

                    <div id='bodyChat'>
                    </div>


                </div>
                <!-- END People -->
            </div>
            <!-- END Sidebar Scrolling -->
        </nav>
        <!-- END Sidebar -->

        <!-- Main Container -->
        <main id="main-container">
            <!-- Page Content -->
            <!-- Chat functionality is initialized in js/pages/be_comp_chat.min.js which was auto compiled from _js/pages/be_comp_chat.js -->
            <!--
            You can use the following JS function to add a header message to a chat window:
            Chat.addHeader(chatId, chatMsg, chatMsgLevel)

            chatId         : the data-chat-id attribute of the chat window
            chatMsg        : the header message you would like to add
            chatMsgLevel   : 'self' aligns the header to the right (default is left)

            You can use the following JS function to add a message to a chat window:
            Chat.addMessage(chatId, chatMsg, chatMsgLevel)

            chatId         : the data-chat-id attribute of the chat window
            chatMsg        : the message you would like to add
            chatMsgLevel   : 'self' the user sends the message (default is when the user receives the message)
        -->

            <div class="block hero flex-column mb-0 bg-body-dark display-none" id="myBlock">
                <!-- Chat #5 Header -->
                <div class="block-header w-100 bg-body-dark" style="min-height: 68px;">
                    <h3 class="block-title">
                        <i id='icone-avatar' class="img-avatar img-avatar32 fas fa-robot"></i>
<span style="display: flex; flex-direction: column;" >
<a class="fs-sm fw-semibold ms-2" href="javascript:void(0)" id="name"></a>  <a class="fs-sm fw-semibold ms-2" href="javascript:void(0)" id="userName"></a>

</span>
                    </h3>
                    <div class="block-options">

                        <button href="#" target='_blank' id="iconeRobot" class="btn-block-option robot-link">
                            <i style="font-size: 21px;" class="fas fa-robot"></i>
                        </button>

                        <a href="#" target='_blank' id="iconeWhatApp" class="btn-block-option whatsapp-link">
                            <i style="font-size: 21px;" class="fab fa-whatsapp"></i>
                        </a>
                        <button type="button" class="btn-block-option d-lg-none" data-toggle="layout" data-action="sidebar_toggle">
                            <i style="font-size: 21px;" class="fa fa-users"></i>
                        </button>
                    </div>
                </div>
                <!-- END Chat #5 Header -->

                <!-- Chat #5 Messages -->
                <div class="js-chat-messages block-content block-content-full text-break overflow-y-auto w-100 flex-grow-1 px-lg-8 px-xlg-10 bg-body" data-chat-id="1"></div>

                <!-- Chat #5 Input -->
                <div id="chatForm" class="js-chat-form block-content p-3 w-100 d-flex align-items-center bg-body-dark " style="min-height: 70px; height: 70px;">
                    <form class="w-100" method="post">
                        <div class="input-group dropup">
                            <input type="text" id='chat-mensagem' class="js-chat-input form-control form-control-alt border-0 bg-transparent" data-target-chat-id="5" placeholder="Digite uma Mensagem">
                            <button type="submit" onclick="enviarMensagemWhatsApp()" class="btn btn-link">
                                <i class="fab fa-telegram-plane opacity-50"></i>
                                <span class="d-none d-sm-inline ms-1 fw-semibold">Enviar</span>
                            </button>
                        </div>
                    </form>
                </div>
                <!-- END Chat #5 Input -->
            </div>
            <!-- END Page Content -->
        </main>
        <!-- END Main Container -->
    </div>
    <!-- END Page Container -->

    <!--
      Dashmix JS

      Core libraries and functionality
      webpack is putting everything together at assets/_js/main/app.js
    -->

    <!-- Page JS Code -->
    <script src="assets/js/pages/be_comp_chat.min.js"></script>

    <script src="/assets/js/plugins/sweetalert2/sweetalert2.min.js"></script>
    <script src="assets/js/pages/be_comp_dialogs.min.js"></script>


    <script src="/assets/alertifyjs/alertify.js"></script>
    <script>

    </script>


</body>

</html>