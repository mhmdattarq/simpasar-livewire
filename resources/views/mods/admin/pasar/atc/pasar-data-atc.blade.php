@push('css')
    <style>
        .dataTables_wrapper .dataTables_paginate .paginate_button {
            padding: 0;
            margin: 0 2px;
        }

        #myTable_filter,
        #myTable_length {
            margin-bottom: 12px;
        }

        #myTable th,
        #myTable td {
            vertical-align: middle;
        }

        .table-responsive {
            min-height: 260px;
        }

        .dropdown-menu {
            z-index: 1060 !important;
        }
    </style>
@endpush

@push('js-stack')
    <script>
        function initPasarTable() {
            var tableEl = document.getElementById('myTable');
            if (!tableEl) return;

            if ($.fn.DataTable && $.fn.DataTable.isDataTable('#myTable')) {
                $('#myTable').DataTable().destroy();
            }

            if ($.fn.DataTable) {
                var dtTable = $('#myTable').DataTable({
                    processing: true,
                    serverSide: true,
                    responsive: false,
                    scrollX: false,
                    pageLength: 25,
                    dom: 'lrtip',
                    order: [
                        [2, 'asc']
                    ],
                    ajax: '{{ route('admin.pasar.dt') }}',
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
                                let url = "{{ route('admin.pasar.edit', ':id') }}";
                                let editUrl = url.replace(':id', row.id);

                                return `
                                    <div class="dropdown">
                                        <button type="button" class="btn btn-primary dropdown-toggle btn-sm" data-bs-toggle="dropdown" data-bs-display="static" aria-expanded="false">
                                            <i class="iconoir-more-horiz"></i>
                                        </button>
                                        <div class="dropdown-menu shadow">
                                            <a class="dropdown-item" href="${editUrl}">
                                                <i class="iconoir-edit-pencil me-2 text-warning"></i> Edit
                                            </a>
                                            <button type="button" class="dropdown-item text-danger" data-bs-toggle="modal" data-bs-target="#exampleModalCenter">
                                                <i class="iconoir-trash me-2"></i> Hapus
                                            </button>
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
                            data: 'nama_pasar',
                            name: 'nama_pasar',
                            orderable: true,
                            searchable: true
                        },
                        {
                            data: 'alamat_pasar',
                            name: 'alamat_pasar',
                            orderable: true,
                            searchable: true
                        },
                        {
                            data: 'total_kios',
                            name: 'total_kios',
                            orderable: true,
                            searchable: false,
                            className: 'text-center'
                        },
                        {
                            data: 'total_los',
                            name: 'total_los',
                            orderable: true,
                            searchable: false,
                            className: 'text-center'
                        },
                        {
                            data: 'total_pelataran',
                            name: 'total_pelataran',
                            orderable: true,
                            searchable: false,
                            className: 'text-center'
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
            document.addEventListener('DOMContentLoaded', initPasarTable);
        } else {
            initPasarTable();
        }

        document.addEventListener('livewire:navigated', initPasarTable);

        function deleteConfirm(id, nama) {
            if (confirm('Apakah Anda yakin ingin menghapus pasar "' + nama + '"?')) {
                Livewire.dispatch('PasarData-deleteConfirm', {
                    id: id,
                    nama: nama
                });
            }
        }
    </script>
@endpush
