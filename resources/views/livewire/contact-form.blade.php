<div>
    @if (session()->has('contact_success'))
        <div class="alert alert-success">{{ session('contact_success') }}</div>
    @endif
    @if (session()->has('contact_error'))
        <div class="alert alert-danger">{{ session('contact_error') }}</div>
    @endif

    <form wire:submit.prevent="submit" class="position-relative">
        <div class="form-group input1 float-left">
            <input wire:model.defer="nome" type="text" class="form_style" placeholder="Nome">
            @error('nome') <span class="text-danger">{{ $message }}</span> @enderror
        </div>
        <div class="form-group float-left">
            <input wire:model.defer="phone" type="tel" class="form_style" placeholder="Telefone">
            @error('phone') <span class="text-danger">{{ $message }}</span> @enderror
        </div>
        <div class="form-group input1 float-left">
            <input wire:model.defer="email" type="email" class="form_style" placeholder="E-mail">
            @error('email') <span class="text-danger">{{ $message }}</span> @enderror
        </div>
        <div class="form-group float-left">
            <select wire:model.defer="area" class="form-control">
                <option value="">Área de interesse</option>
                <option>Consultoria Tributária</option>
                <option>Planejamento Fiscal</option>
                <option>Contencioso Tributário</option>
            </select>
            @error('area') <span class="text-danger">{{ $message }}</span> @enderror
        </div>
        <div class="form-group message">
            <textarea wire:model.defer="msg" class="form_style" placeholder="Mensagem" rows="3"></textarea>
            @error('msg') <span class="text-danger">{{ $message }}</span> @enderror
        </div>

        <button type="submit" class="appointment">Enviar solicitação<i class="fa-solid fa-arrow-right"></i></button>
    </form>
</div>
