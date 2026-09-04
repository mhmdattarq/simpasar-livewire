@push('css')
    <style>
        .dataTables_wrapper .dataTables_paginate .paginate_button {
            padding: 0;
            margin: 0 2px;
        }

        #tableLos_filter,
        #tableLos_length {
            margin-bottom: 12px;
        }

        #tableLos th,
        #tableLos td {
            vertical-align: middle;
        }

        .table-responsive {
            min-height: 260px;
        }

        #tableLos {
            width: 100% !important;
        }

        #tableLos .dropdown {
            position: relative;
            display: inline-block;
        }

        #tableLos .dropdown-menu {
            position: absolute;
            top: 100%;
            left: 0;
            z-index: 1060 !important;
        }
    </style>
@endpush

@push('js-stack')
    <script>
        function initLosTable() {
            var tableEl = document.getElementById('tableLos');
            if (!tableEl) return;

            if ($.fn.DataTable && $.fn.DataTable.isDataTable('#tableLos')) {
                $('#tableLos').DataTable().destroy();
            }

            if ($.fn.DataTable) {
                window.dtTable = $('#tableLos').DataTable({
                    processing: true,
                    serverSide: true,
                    responsive: false,
                    scrollX: false,
                    autoWidth: false,
                    pageLength: 25,
                    dom: 'lrtip',
                    order: [
                        [2, 'asc']
                    ],
                    ajax: '{{ route('admin.los.dt') }}',
                    columns: [{
                            data: null,
                            name: 'id',
                            orderable: false,
                            searchable: false,
                            className: 'text-center',
                            render: function(data, type, row, meta) {
                                return '<input class="form-check-input check-data-item" type="checkbox" value="' +
                                    data.id + '">';
                            }
                        },
                        {
                            data: null,
                            name: 'id',
                            orderable: false,
                            searchable: false,
                            className: 'text-center',
                            render: function(data, type, row) {
                                let url = "{{ route('admin.los.edit', ':id') }}";
                                let editUrl = url.replace(':id', row.id);

                                return `
                                    <div class="dropdown">
                                        <button type="button" class="btn btn-primary dropdown-toggle btn-sm" aria-expanded="false">
                                            <i class="iconoir-more-horiz"></i>
                                        </button>
                                        <div class="dropdown-menu shadow">
                                            <a class="dropdown-item" href="${editUrl}" wire:navigate>
                                                <i class="iconoir-edit-pencil me-2 text-warning"></i> Edit
                                            </a>
                                            <a class="dropdown-item text-danger" href="javascript:void(0)" data-bs-toggle="modal" data-bs-target="#modalDelete" wire:click="hookModalDelete(${data.id},'${data.nomor_los}')">
                                                <i class="iconoir-trash me-2"></i> Hapus
                                            </a>
                                        </div>
                                    </div>
                                `;
                            }
                        },
                        {
                            data: null,
                            orderable: false,
                            searchable: false,
                            className: 'text-center',
                            render: function(data, type, row, meta) {
                                return meta.row + meta.settings._iDisplayStart + 1;
                            }
                        },
                        {
                            data: 'nomor_los',
                            name: 'nomor_los',
                            orderable: true,
                            searchable: true
                        },
                        {
                            data: 'ukuran_los',
                            name: 'ukuran_los',
                            orderable: true,
                            searchable: true,
                            render: function(data) {
                                return data ? data : '-';
                            }
                        },
                        {
                            data: 'harga_sewa',
                            name: 'harga_sewa',
                            orderable: true,
                            searchable: false,
                            className: 'text-center',
                            render: function(data) {
                                return data ? 'Rp ' + Number(data).toLocaleString('id-ID') : '-';
                            }
                        },
                        {
                            data: 'satuan_retribusi',
                            name: 'satuan_retribusi',
                            orderable: true,
                            searchable: false,
                            className: 'text-center text-capitalize'
                        },
                        {
                            data: 'status_los',
                            name: 'status_los',
                            orderable: true,
                            searchable: false,
                            className: 'text-center',
                            render: function(data) {
                                if (data === 'tersedia') {
                                    return '<span class="badge bg-success-subtle text-success">Tersedia</span>';
                                } else if (data === 'terisi') {
                                    return '<span class="badge bg-danger-subtle text-danger">Terisi</span>';
                                } else {
                                    return '<span class="badge bg-warning-subtle text-warning">Pengajuan</span>';
                                }
                            }
                        },
                        {
                            data: 'lokasi_los',
                            name: 'lokasi_los',
                            orderable: true,
                            searchable: false,
                            className: 'text-center',
                            render: function(data) {
                                return data ? data : '-';
                            }
                        },
                        {
                            data: 'pasar.nama_pasar',
                            name: 'pasar.nama_pasar',
                            orderable: true,
                            searchable: true,
                            className: 'text-center',
                            render: function(data, type, row) {
                                return row.pasar ? row.pasar.nama_pasar : '-';
                            }
                        },
                    ],
                    initComplete: function(settings) {
                        var table = settings.oInstance.api();
                        // Filter kolom thead
                        $('#header-filter input.search-col-dt').on('keyup change clear', function() {
                            var colIndex = $(this).closest('th').index();
                            if (table.column(colIndex).search() !== this.value) {
                                table.column(colIndex).search(this.value).draw();
                            }
                        });

                        // Check all trigger
                        $('.check-data-all').on('change', function() {
                            $('.check-data-item').prop('checked', this.checked);
                        });
                    }
                });
            }
        }

        if (document.readyState === 'loading') {
            document.addEventListener('DOMContentLoaded', initLosTable);
        } else {
            initLosTable();
        }

        document.addEventListener('livewire:navigated', initLosTable);
    </script>
@endpush
