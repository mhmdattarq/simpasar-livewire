<?php

use Livewire\Attributes\On;
use Livewire\Component;

new class extends Component
{
    public $data = [];

    #[On('modal-delete-setDeleteId')]
    public function setDeleteId($data)
    {
        $this->data = is_array($data) && isset($data['data']) ? $data['data'] : $data;
    }

    #[On('modal-setModalData')]
    public function setModalData($data)
    {
        $this->data = is_array($data) && isset($data['data']) ? $data['data'] : $data;
    }

    public function process($id = null)
    {
        $dtHook = [
            'id' => $id,
            'payload' => $this->data['payload'] ?? null,
        ];
        $this->dispatch($this->data['dispatch'] ?? 'PasarData-delete', $dtHook);
    }
};
?>

<div>
    <div class="modal fade" id="{{ $data['modalId'] ?? 'modalDelete' }}" tabindex="-1" role="dialog"
        aria-labelledby="universalModalTitle" aria-hidden="true" wire:ignore.self>
        <div class="modal-dialog {{ $data['size'] ?? 'modal-dialog-centered' }}" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h6 class="modal-title m-0" id="universalModalTitle">
                        {{ $data['title'] ?? 'Konfirmasi Tindakan' }}
                    </h6>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>

                <div class="modal-body {{ isset($data['type']) && $data['type'] === 'preview' ? 'p-0' : '' }}">
                    @if (isset($data['type']) && $data['type'] === 'preview')
                        {{-- Mode Preview (misal: Surat Permohonan) --}}
                        <div class="p-3">
                            @if (isset($data['view']))
                                @include($data['view'], $data['params'] ?? [])
                            @elseif(isset($data['html']))
                                {!! $data['html'] !!}
                            @endif
                        </div>
                    @else
                        {{-- Mode Konfirmasi / Delete Default --}}
                        <div class="row">
                            <div class="col-lg-3 text-center align-self-center">
                                <i class="{{ $data['icon'] ?? 'iconoir-warning-triangle text-danger' }}"
                                    style="font-size: 54px;"></i>
                            </div>
                            <div class="col-lg-9">
                                <h5 class="{{ $data['titleClass'] ?? 'text-danger' }}">
                                    {{ $data['title'] ?? 'Konfirmasi Hapus' }}
                                </h5>
                                <p class="mb-0 text-muted">
                                    {{ $data['msg'] ?? 'Apakah Anda yakin ingin memproses data ini?' }}
                                </p>
                            </div>
                        </div>
                    @endif
                </div>

                <div class="modal-footer">
                    <button type="button" class="btn {{ $data['btnCancelClass'] ?? 'btn-secondary' }} btn-sm"
                        data-bs-dismiss="modal">
                        {{ $data['btnCancelText'] ?? 'Batal' }}
                    </button>
                    <button type="button" class="btn {{ $data['btnActionClass'] ?? 'btn-danger' }} btn-sm"
                        data-bs-dismiss="modal" wire:click="process({{ $data['id'] ?? 0 }})">
                        @if (isset($data['btnActionIcon']))
                            <i class="{{ $data['btnActionIcon'] }} me-1"></i>
                        @endif
                        {{ $data['btnActionText'] ?? 'Hapus' }}
                    </button>
                </div>
            </div>
        </div>
    </div>
</div>
