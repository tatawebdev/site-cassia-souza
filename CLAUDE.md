# Site Cássia Souza Advocacia

Laravel 12 + Livewire 3. Site institucional público + painel (Inertia/React, atrás de login).
Contexto de produto, público e regras de conteúdo: [PRODUCT.md](PRODUCT.md).

## Refatoração em andamento: tema antigo → tema novo

O site está migrando, página por página, do template Bootstrap ("Lawfinity") para um tema
próprio em Tailwind. Até a migração terminar, **toda página segue este processo**:

1. **A versão antiga sai do caminho, mas continua no ar**: a view vai para `resources/views/antigo/`
   e ganha a rota `/antigo/<caminho>` (nome `antigo.<nome>`), usando o componente Livewire antigo.
2. **A versão nova assume o endereço original** (e o nome de rota original), feita em
   `resources/views/novo/` com Tailwind.
3. Páginas internas usam o layout padrão `<x-novo.pagina>` (header, banner com breadcrumb,
   título e descrição, conteúdo e a seção de contato no fim):

   ```blade
   <x-novo.pagina titulo="..." descricao="..."
       :breadcrumbs="[['label' => 'Home', 'url' => route('inicio')], ['label' => 'Página atual']]">
       ...seções...
   </x-novo.pagina>
   ```

   É o equivalente de `$banner` + `$breadcrumbs` do layout antigo (`components.layouts.app`).
4. Não mexer no tema antigo além de correções; ele é removido quando a migração acabar.

Migradas: home (`/`), sobre (`/sobre-nos`), listagem `/servicos` e as 7 páginas `/servicos/<slug>`
(um único modelo, `novo/servico.blade.php`, com o conteúdo em `config/servicos.php` e as perguntas
em `config/faqs.php`) e contato (`/contato`). Ainda no tema antigo: política de privacidade e a rota curinga de SEO
`/{termo}/{cidade?}/{estado?}`.

### Tema novo

- Views: `resources/views/novo/` (páginas e `partials/header`, `partials/footer`);
  componentes em `resources/views/components/novo/` (`layout`, `pagina`, `contato`, `avaliacoes`).
- CSS: `resources/css/novo.css` + `tailwind.novo.config.js` (preflight ligado, só escaneia o tema novo).
  Depois de mudar o config do Tailwind, reinicie o `composer dev`: o Vite não recarrega o config.
- Identidade: roxo `plum` #590854 (em degradê `cs-plum-bg`), `champagne` #EFCF9F, fundo `mist`;
  títulos em Newsreader 600, texto em Public Sans. Visual rico (fotos reais da Cássia, cards,
  profundidade); evitar selos/rótulos decorativos e "cara de template".
- Menu/JS: Alpine (vem com o Livewire). Sem Bootstrap/jQuery no tema novo.
- Serviços (menu, home, rodapé): `config/servicos.php`.
- Componentes Livewire compartilhados com o tema antigo (`contact-form`, `newsletter-subscribe`)
  são estilizados pelo `novo.css` via `.cs-form` / `.cs-newsletter`; o modal da newsletter usa
  estilos inline para funcionar nos dois temas.

## Avaliações do Google

Não há API: o perfil da Cássia é de área de atendimento e a Places API não devolve os textos.
Fluxo: salvar a página "Ler avaliações" do Perfil da Empresa (logado na conta da Cássia, depois
de rolar até carregar todas) e rodar `php artisan avaliacoes:importar arquivo.html`. Isso gera
`config/avaliacoes.php` (só 4+ estrelas, sem as respostas) e baixa as fotos para
`public/assets/avaliacoes/`; ambos vão pelo Git no deploy.

## reCAPTCHA

v2 "Não sou um robô" no formulário de contato e na confirmação da newsletter
(`RECAPTCHA_SITE_KEY` / `RECAPTCHA_SECRET_KEY` no `.env`; sem a chave, os formulários funcionam
sem ele). Validação em `App\Rules\Recaptcha`; script carregado uma vez por `partials/recaptcha-loader`.

## Blog (WordPress, blog.cassiasouzaadvocacia.com.br)

- Fica no servidor em `www/blog` (fora do Laravel e fora do Git); cópia local em `blog/` (no `.gitignore`).
- `php artisan blog:baixar` traz arquivos + dump do banco (`blog/blog-banco.sql`, nunca subir) via o SSH do deploy.
- Não há deploy: cada arquivo sobe direto (SFTP do VS Code com upload ao salvar, ou `scp` com a chave do deploy).
- Tema ativo: **filho do Blocksy** em `wp-content/themes/cassia-souza` (cabeçalho/rodapé iguais ao site,
  chamada para contato e quadro da autora no fim dos posts; categoria → serviço em `functions.php`).
  Para voltar ao Blocksy puro: opção `stylesheet` = `blocksy` em `wp_options`.
- O PHP de linha de comando do servidor é 5.6 e o cliente é `mariadb` (exige `--skip-ssl`).

## Ambiente e deploy

- Local: `composer dev` (servidor na 8000 + Vite). O `.env` local aponta para o MySQL de
  **produção** (conexão leva ~20s); sessão e cache locais ficam em `file`. Não rodar migrations
  locais sem querer.
- Testes: `php -d extension=pdo_sqlite vendor/bin/phpunit` (o PHP local não carrega o SQLite por
  padrão e o `artisan test` perde o `-d`).
- Produção é hospedagem compartilhada: **sem cron/agendador e sem worker de fila**. Tarefas
  periódicas rodam no deploy ou depois da resposta (`dispatch(...)->afterResponse()`).
- Deploy: `php artisan deploy --m="mensagem"` (build do Vite, `git add -A`, commit, push e, via SSH,
  `git reset --hard`, composer, `migrate --force` e caches). `public/build` vai versionado.
