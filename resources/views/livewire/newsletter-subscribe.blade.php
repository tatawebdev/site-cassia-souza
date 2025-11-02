<div>
    @if (session()->has('newsletter_success'))
        <div class="alert alert-success mb-2">{{ session('newsletter_success') }}</div>
    @endif
    @if (session()->has('newsletter_error'))
        <div class="alert alert-danger mb-2">{{ session('newsletter_error') }}</div>
    @endif

    <form wire:submit.prevent="subscribe">
        <div class="form-group position-relative mb-0">
            <input wire:model.defer="email" type="email" class="form_style" placeholder="Seu e-mail" name="email">
            <button type="submit">Inscrever-se<i class="fa-solid fa-arrow-right"></i></button>
        </div>
        @error('email') <div class="text-danger mt-1">{{ $message }}</div> @enderror
    </form>
</div>
