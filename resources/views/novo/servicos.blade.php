<x-novo.pagina
    titulo="Serviços"
    descricao="Do planejamento à regularização de dívidas: encontre a frente tributária que resolve a situação da sua empresa."
    imagem="assets/images/banner-servicos.jpg"
    tipo-pagina="CollectionPage"
    :schema="[\App\Support\Schema::listaServicos(), \App\Support\Schema::faq(config('faqs'), route('servicos'))]"
    :pagina-schema="['mainEntity' => ['@id' => route('servicos').'#lista'], 'hasPart' => ['@id' => route('servicos').'#faq']]"
    :breadcrumbs="[['label' => 'Home', 'url' => route('inicio')], ['label' => 'Serviços']]">

    <section aria-labelledby="situacoes-titulo" class="bg-mist py-[clamp(72px,9vw,128px)]">
        <div class="cs-wrap">
            <div class="grid items-end gap-6 lg:grid-cols-[1.1fr_0.9fr] lg:gap-16">
                <h2 id="situacoes-titulo" class="font-display text-[clamp(34px,4vw,54px)] font-semibold leading-[1.05] tracking-[-0.015em] text-plum-night">
                    Qual é a situação da sua empresa?
                </h2>
                <p class="max-w-[30em] text-[17px] leading-relaxed text-ink-soft">
                    Cada serviço começa pelo problema que ele resolve. Encontre o seu caso e veja como trabalhamos.
                </p>
            </div>

            <x-novo.servicos-grade class="mt-12" />
        </div>
    </section>

    <x-novo.avaliacoes class="bg-white" />

    <x-novo.faq :faqs="config('faqs')" class="bg-mist" />
</x-novo.pagina>
