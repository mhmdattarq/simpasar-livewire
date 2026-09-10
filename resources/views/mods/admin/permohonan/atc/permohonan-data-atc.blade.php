@push('css')
    <style>
        .dataTables_wrapper .dataTables_paginate .paginate_button {
            padding: 0;
            margin: 0 2px;
        }

        #tablePermohonan_filter,
        #tablePermohonan_length {
            margin-bottom: 12px;
        }

        #tablePermohonan th,
        #tablePermohonan td {
            vertical-align: middle;
        }

        .table-responsive {
            min-height: 260px;
        }

        #tablePermohonan {
            width: 100% !important;
        }
    </style>
@endpush

@push('js-stack')
    <script>
        function initPermohonanTable() {
            var tableEl = document.getElementById('tablePermohonan');
            if (!tableEl) return;

            if ($.fn.DataTable && $.fn.DataTable.isDataTable('#tablePermohonan')) {
                $('#tablePermohonan').DataTable().destroy();
            }

            if ($.fn.DataTable) {
                window.dtTable = $('#tablePermohonan').DataTable({
                    processing: true,
                    serverSide: true,
                    responsive: false,
                    scrollX: false,
                    autoWidth: false,
                    pageLength: 25,
                    dom: 'lrtip',
                    order: [
                        [1, 'desc']
                    ],
                    ajax: '{{ route('admin.permohonan.dt') }}',
                    columns: [{
                            data: null,
                            orderable: false,
                            searchable: false,
                            className: 'text-center text-muted fs-13',
                            render: function(data, type, row, meta) {
                                return meta.row + meta.settings._iDisplayStart + 1;
                            }
                        },
                        {
                            data: 'created_at',
                            name: 'created_at',
                            orderable: true,
                            searchable: false,
                            render: function(data) {
                                if (!data) return '-';
                                let date = new Date(data);
                                let day = String(date.getDate()).padStart(2, '0');
                                let month = String(date.getMonth() + 1).padStart(2, '0');
                                let year = date.getFullYear();
                                return `${day}-${month}-${year}`;
                            }
                        },
                        {
                            data: 'nama',
                            name: 'nama',
                            orderable: true,
                            searchable: true,
                            render: function(data, type, row) {
                                return `
                                    <div class="fw-bold text-dark">${row.nama}</div>
                                    <small class="text-muted">NIK: ${row.nik}</small>
                                `;
                            }
                        },
                        {
                            data: 'pasar.nama_pasar',
                            name: 'pasar.nama_pasar',
                            orderable: true,
                            searchable: true,
                            render: function(data, type, row) {
                                let namaPasar = row.pasar ? row.pasar.nama_pasar : '-';
                                let unit = row.tipe_tempat ? row.tipe_tempat.toUpperCase() + ' No. ' + (row.nomor_tempat ?? '-') : '-';
                                return `
                                    <div class="fw-semibold">${namaPasar}</div>
                                    <small class="text-muted">${unit}</small>
                                `;
                            }
                        },
                        {
                            data: 'status',
                            name: 'status',
                            orderable: true,
                            searchable: true,
                            className: 'text-center',
                            render: function(data) {
                                if (data === 'lengkap') {
                                    return '<span class="badge bg-warning-subtle text-warning border border-warning-subtle px-2 py-1"><i class="fas fa-hourglass-half me-1"></i> Lengkap</span>';
                                } else if (data === 'disetujui') {
                                    return '<span class="badge bg-info-subtle text-info border border-info-subtle px-2 py-1"><i class="fas fa-check-circle me-1"></i> Disetujui, Belum Terverifikasi</span>';
                                } else if (data === 'verifikasi') {
                                    return '<span class="badge bg-primary-subtle text-primary border border-primary-subtle px-2 py-1"><i class="fas fa-clipboard-check me-1"></i> Menunggu Verifikasi</span>';
                                } else if (data === 'selesai') {
                                    return '<span class="badge bg-success-subtle text-success border border-success-subtle px-2 py-1"><i class="fas fa-check me-1"></i> Selesai</span>';
                                } else if (data === 'ditolak') {
                                    return '<span class="badge bg-danger-subtle text-danger border border-danger-subtle px-2 py-1"><i class="fas fa-times-circle me-1"></i> Ditolak</span>';
                                }
                                return '<span class="badge bg-secondary-subtle text-secondary px-2 py-1">' + data + '</span>';
                            }
                        },
                        {
                            data: 'keterangan',
                            name: 'keterangan',
                            orderable: false,
                            searchable: true,
                            render: function(data, type, row) {
                                if (data && data !== '-') {
                                    return `<span class="fs-13">${data}</span>`;
                                }
                                var fallbackMap = {
                                    'lengkap': 'Dokumen Berhasil Terkirim, Silahkan tunggu persetujuan dari Admin!',
                                    'disetujui': 'Surat permohonan telah disetujui, Belum Terverifikasi!',
                                    'verifikasi': 'Surat Pernyataan menjadi pedagang berhasil di unggah, Silahkan tunggu verifikasi dari Admin!',
                                    'selesai': 'Permohonan telah diverifikasi dan selesai'
                                };
                                var text = fallbackMap[row.status] || data || '-';
                                return `<span class="fs-13">${text}</span>`;
                            }
                        },
                        {
                            data: null,
                            orderable: false,
                            searchable: false,
                            className: 'text-center',
                            render: function(data, type, row) {
                                let canApprove = (row.status === 'lengkap');
                                let canVerify = (row.status === 'verifikasi');

                                let approveBtn = canApprove
                                    ? `<button type="button" class="btn btn-success btn-sm py-1 px-2 me-1" wire:click="openApproveModal(${row.id})" title="Persetujuan Permohonan"><i class="fas fa-check me-1"></i> Persetujuan</button>`
                                    : `<button type="button" class="btn btn-secondary btn-sm py-1 px-2 me-1 opacity-50" disabled><i class="fas fa-check me-1"></i> Persetujuan</button>`;

                                let verifyBtn = canVerify
                                    ? `<button type="button" class="btn btn-primary btn-sm py-1 px-2" wire:click="verifyPermohonan(${row.id})" title="Verifikasi Pedagang"><i class="fas fa-shield-alt me-1"></i> Verifikasi</button>`
                                    : `<button type="button" class="btn btn-secondary btn-sm py-1 px-2 opacity-50" disabled><i class="fas fa-shield-alt me-1"></i> Verifikasi</button>`;

                                return `
                                    <div class="d-inline-flex align-items-center">
                                        <button type="button" class="btn btn-warning btn-sm py-1 px-2 me-1" wire:click="reviewPermohonan(${row.id})" title="Review Berkas">
                                            <i class="fas fa-eye me-1"></i> Review
                                        </button>
                                        ${approveBtn}
                                        ${verifyBtn}
                                    </div>
                                `;
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
                    }
                });
            }
        }

        if (document.readyState === 'loading') {
            document.addEventListener('DOMContentLoaded', initPermohonanTable);
        } else {
            initPermohonanTable();
        }

        document.addEventListener('livewire:navigated', initPermohonanTable);

        // Listener reload Datatable dari Livewire
        window.addEventListener('reloadDT', function(e) {
            if (window.dtTable) {
                window.dtTable.ajax.reload(null, false);
            }
        });
    </script>
@endpush
