<?php

use Livewire\Component;
use Livewire\Attributes\On;

new class extends Component {
    public $data = [];

    #[On('modal-delete-setDeleteId')]
    public function setDeleteId($data)
    {
        $this->data = is_array($data) && isset($data['data']) ? $data['data'] : $data;
    }

    public function process($id)
    {
        $dtHook = ['id' => $id];
        $this->dispatch($this->data['dispatch'] ?? 'PasarData-delete', $dtHook);
    }
};
?>

<div>
    <div class="modal fade" id="modalDelete" tabindex="-1" role="dialog" aria-labelledby="modalDeleteTitle"
        aria-hidden="true" wire:ignore.self>
        <div class="modal-dialog modal-dialog-centered" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h6 class="modal-title m-0" id="modalDeleteTitle">{{ $data['title'] ?? 'Konfirmasi Hapus' }}</h6>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <div class="row">
                        <div class="col-lg-3 text-center align-self-center">
                            <i class="iconoir-warning-triangle text-danger" style="font-size: 54px;"></i>
                        </div><!--end col-->
                        <div class="col-lg-9">
                            <h5 class="text-danger">{{ $data['title'] ?? 'Konfirmasi Hapus' }}</h5>
                            <p class="mb-0 text-muted">{{ $data['msg'] ?? 'Apakah Anda yakin ingin menghapus data ini?' }}</p>
                        </div><!--end col-->
                    </div><!--end row-->
                </div><!--end modal-body-->
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary btn-sm" data-bs-dismiss="modal">Batal</button>
                    <button type="button" class="btn btn-danger btn-sm" data-bs-dismiss="modal" wire:click="process({{ $data['id'] ?? 0 }})">Hapus</button>
                </div><!--end modal-footer-->
            </div><!--end modal-content-->
        </div><!--end modal-dialog-->
    </div><!--end modal-->
</div>
