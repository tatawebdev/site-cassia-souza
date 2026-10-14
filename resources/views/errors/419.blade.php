{{-- Sessão expirada: costuma acontecer quando um formulário fica aberto por muito tempo --}}
<x-novo.erro codigo="419" titulo="Sua sessão expirou."
    texto="A página ficou aberta por muito tempo e, por segurança, a sessão foi encerrada. Volte, atualize a página e envie de novo.">
    <a href="javascript:history.back()"
        class="inline-flex items-center gap-2.5 rounded-full border border-white/30 px-7 py-4 font-semibold text-white transition-colors hover:border-champagne">
        Voltar à página anterior
    </a>
</x-novo.erro>
