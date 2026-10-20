{{-- Política de Privacidade (tema novo). Texto idêntico ao da versão antiga
     (resources/views/antigo/politica-privacidade.blade.php), com o CNPJ preenchido
     e a data da última atualização. --}}
@php
    $secoes = [
        'coleta' => '1. Sobre a coleta de dados',
        'uso' => '2. Sobre o uso de seus dados pessoais',
        'acesso' => '3. Sobre o acesso aos seus dados pessoais',
        'controle' => '4. Como controlar seus dados pessoais?',
        'mudancas' => '5. Mudanças na Política de Privacidade',
        'lei' => '6. Lei aplicável',
    ];
@endphp

<x-novo.pagina
    titulo="Política de Privacidade"
    descricao="Como coletamos, usamos e protegemos as informações de quem visita o site, de acordo com a LGPD."
    imagem="assets/images/banner-sobre-nos.jpg"
    :contato="false"
    :breadcrumbs="[['label' => 'Home', 'url' => route('inicio')], ['label' => 'Política de Privacidade']]">

    <section class="bg-white py-[clamp(56px,7vw,96px)]">
        <div class="cs-wrap grid gap-12 lg:grid-cols-[240px_minmax(0,720px)] lg:justify-center lg:gap-16">
            <nav aria-label="Nesta página" class="lg:sticky lg:top-8 lg:self-start">
                <p class="text-sm font-semibold text-plum-night">Nesta página</p>
                <ol class="mt-3 grid gap-1 border-l border-line">
                    @foreach ($secoes as $id => $rotulo)
                        <li>
                            <a href="#{{ $id }}"
                                class="-ml-px block border-l-2 border-transparent py-1.5 pl-4 text-[15px] text-ink-soft transition-colors hover:border-plum hover:text-plum">{{ $rotulo }}</a>
                        </li>
                    @endforeach
                </ol>
            </nav>

            <article class="text-[17px] leading-[1.75] text-ink [&_h2]:mt-12 [&_h2]:scroll-mt-8 [&_h2]:font-display [&_h2]:text-[clamp(26px,2.6vw,32px)] [&_h2]:font-semibold [&_h2]:leading-tight [&_h2]:text-plum-night [&_h3]:mt-8 [&_h3]:font-display [&_h3]:text-[22px] [&_h3]:font-semibold [&_h3]:text-plum-night [&_p]:mt-4">
                <p class="!mt-0 text-[15px] text-ink-soft">
                    Última atualização: <time datetime="2026-10-15">15 de outubro de 2026</time>
                </p>
                <p>
                    Nós da <strong>Cassia Souza Advocacia Tributária</strong>, CNPJ <strong>57.078.276/0001-00</strong>, temos o compromisso de proteger a sua privacidade.
                    Através da nossa Política de Privacidade, buscamos esclarecer quais informações são coletadas dos
                    usuários que acessam o nosso site e respectivos serviços e de que forma esses dados são manipulados
                    e utilizados. Para oferecermos nossos serviços, por meio do nosso site e dos dispositivos
                    sincronizados com ele, coletamos dados e informações com o intuito de proporcionar uma experiência
                    melhor para você, usuário.
                </p>
                <p>
                    A sua privacidade é muito importante para nós. Criamos este espaço para expor a nossa Política de
                    Privacidade que é fundamental para que você possa entender como as suas informações e dados serão
                    coletados, utilizados, compartilhados e armazenados por meio do site e seus respectivos serviços.
                    Caso não concorde com nossa Política de Privacidade, o usuário não deve utilizar nosso website.
                </p>

                <h2 id="coleta">1. Sobre a coleta de dados</h2>
                <p>
                    A quantidade e o tipo de informações coletadas pela nossa empresa são estritamente necessárias para
                    responder ao seu contato e para lhe divulgar e oferecer informações, novidades e eventos do mundo
                    jurídico que possam ser do seu interesse.
                </p>

                <h3>1.1. Cookies</h3>
                <p>
                    Cookies são identificadores que são transferidos para o seu navegador ou dispositivo, que nos
                    informam como e quando as páginas e recursos em nosso website são visitados, quantas pessoas as
                    acessam e algumas informações sobre seus dispositivos. “Tag” é uma denominação genérica para trechos
                    de código que permitem a coleta de dados de usuários de um website, possibilitam a implementação de
                    funcionalidades (ex.: vídeos, imagens, entre outros) e permitem a utilização de cookies.
                </p>
                <p>
                    Quando você visita nosso site, são inseridos cookies no seu navegador (por exemplo Firefox, Edge,
                    Chrome), a fim de entender seu comportamento como usuário e melhor atendê-lo. A coleta é feita de
                    forma automática de determinados dados pessoais para que possamos operacionalizar nosso website
                    (cookies estritamente necessários) e obter informações agregadas sobre nossos usuários. Nossos
                    websites também podem possuir cookies de terceiros que são utilizados para publicidade.
                </p>

                <h3>1.2. Gestão dos cookies e configurações do navegador</h3>
                <p>
                    O usuário poderá se opor ao registro de cookies pelo site, bastando desativar esta opção no próprio
                    navegador ou dispositivo. A desativação de cookies pode afetar a disponibilidade de algumas
                    ferramentas e funcionalidades do site, comprometendo seu funcionamento ou removendo preferências
                    salvas.
                </p>

                <h3>1.3. Avisos no navegador</h3>
                <p>
                    Se você ativar os avisos de artigos novos, o seu navegador gera um identificador anônimo que
                    guardamos para enviar as notificações, por meio do Firebase Cloud Messaging, do Google. Não
                    guardamos seu nome, e-mail, endereço IP nem outros dados junto com ele. Para parar de receber,
                    basta bloquear as notificações deste site nas configurações do navegador; o identificador deixa
                    de valer e é apagado do nosso banco no envio seguinte.
                </p>

                <h2 id="uso">2. Sobre o uso de seus dados pessoais</h2>
                <p>
                    Todos os dados e informações sobre você são tratados como confidenciais, protegendo a sua
                    privacidade e somente serão utilizados para os fins aqui descritos e com o seu consentimento. Em
                    atendimento às disposições legais, os registros de acesso dos usuários serão coletados e
                    armazenados por, pelo menos, seis meses. Qualquer dado que venhamos a utilizar é somente para
                    prestação de nossos serviços e sempre com o intuito de melhorar a sua experiência como usuário.
                </p>

                <h2 id="acesso">3. Sobre o acesso aos seus dados pessoais</h2>
                <p>
                    Somente funcionários autorizados terão acesso aos seus dados, e nenhum dado pessoal será divulgado
                    publicamente. Mantemos medidas de segurança e atualizações no sistema para garantir a proteção dos
                    dados. Os dados serão mantidos somente enquanto forem necessários para as finalidades descritas
                    nesta Política ou conforme prazos legais aplicáveis.
                </p>
                <p>
                    Reservamo-nos o direito de acessar, ler, preservar e fornecer quaisquer dados e informações sobre os
                    Usuários quando necessário para cumprir obrigação legal, ordem judicial, fazer cumprir contratos ou
                    proteger direitos e segurança do nosso escritório, funcionários e outros usuários.
                </p>

                <h2 id="controle">4. Como controlar seus dados pessoais?</h2>
                <p>
                    O usuário sempre poderá optar por não divulgar seus dados, mas alguns dados podem ser necessários
                    para obter certos conteúdos ou serviços (ex.: newsletter). O usuário pode, a qualquer momento,
                    requerer que seus dados sejam devolvidos, atualizados, corrigidos ou deletados do nosso banco de
                    dados.
                </p>
                <p>
                    Para garantir a segurança do procedimento, poderemos solicitar confirmação de identidade antes de
                    atender requisições. Responderemos solicitações legítimas dentro de 30 (trinta) dias corridos, ou
                    informaremos novo prazo se necessário. Em caso de dúvidas sobre o exercício dos seus direitos, entre
                    em contato por meio da <a href="{{ route('contato') }}" class="font-semibold text-plum underline decoration-plum/40 underline-offset-4 hover:decoration-plum">página de Contato</a> do site.
                </p>

                <h3>4.1. Por quanto tempo os dados são armazenados?</h3>
                <p>
                    Manteremos os dados pessoais apenas pelo tempo necessário para cumprir as finalidades para as quais
                    foram coletados, inclusive para cumprimento de obrigações legais ou contratuais. Os dados serão
                    excluídos quando o usuário requisitar ou quando não forem mais necessários, salvo exigência legal em
                    contrário.
                </p>

                <h2 id="mudancas">5. Mudanças na Política de Privacidade</h2>
                <p>
                    Esta Política de Privacidade pode ser atualizada conforme mudanças na legislação ou em nossos
                    procedimentos. Recomendamos que usuários revisem esta página periodicamente. Quando alterações
                    relevantes exigirem novo consentimento, publicaremos a nova versão da política.
                </p>

                <h2 id="lei">6. Lei aplicável</h2>
                <p>
                    Este documento é regido pelas leis da República Federativa do Brasil, especialmente a Lei nº
                    13.709/2018 (LGPD). Fica eleito o foro de domicílio do Cliente para dirimir quaisquer dúvidas
                    decorrentes deste documento.
                </p>

                <div class="mt-12 rounded-2xl bg-mist p-6 text-[15px] text-ink-soft">
                    Dúvidas sobre os seus dados? Fale com a gente pelo
                    <x-link-whatsapp rel="nofollow" class="font-semibold text-plum underline decoration-plum/40 underline-offset-4">WhatsApp</x-link-whatsapp>
                    ou pelo e-mail
                    <a href="mailto:cassia_souza@adv.oabsp.org.br" class="font-semibold text-plum underline decoration-plum/40 underline-offset-4">cassia_souza@adv.oabsp.org.br</a>.
                </div>
            </article>
        </div>
    </section>
</x-novo.pagina>
