<?php

use Livewire\Component;
use Livewire\Attributes\On;

new class extends Component {
    public $isShow = false;
    public $type = 'success';
    public $msg = '';

    public function mount()
    {
        if (session()->has('alert-show')) {
            $this->show(session('alert-show'));
        }
    }

    #[On('alert-show')]
    public function show($data = [])
    {
        if (is_array($data)) {
            $this->type = $data['type'] ?? 'success';
            $this->msg = $data['message'] ?? ($data['msg'] ?? '');
        } else {
            $this->msg = (string) $data;
        }

        $this->isShow = true;
    }
};
?>

<div>
    <div class="toast-container position-fixed top-0 end-0 p-3" style="z-index: 9999;">
        @if ($isShow)
            <div class="toast show align-items-center text-white bg-{{ $type }} border-0 shadow" role="alert"
                aria-live="assertive" aria-atomic="true"
                x-data="{ show: true }"
                x-init="setTimeout(() => { show = false; $wire.set('isShow', false); }, 4000)"
                x-show="show"
                x-transition>
                <div class="d-flex">
                    <div class="toast-body">
                        <i class="iconoir-check-circle me-1 align-middle fs-16"></i>
                        {{ $msg }}
                    </div>
                    <button type="button" class="btn-close btn-close-white me-2 m-auto"
                        wire:click="$set('isShow', false)" aria-label="Close"></button>
                </div>
            </div>
        @endif
    </div>
</div>
