$(document).ready(function () {
    $('.loading').fadeOut(500);
});

$(document).on('click', '[data-scroll-top]', function () {
    window.scrollTo({ top: 0, behavior: 'smooth' });
});

window.addEventListener('alert', event => {
    toastr[event.detail.data.type](event.detail.data.message, event.detail.data.title ?? '', {
        closeButton: true,
        debug: false,
        newestOnTop: false,
        progressBar: false,
        positionClass: "toast-top-center",
        preventDuplicates: false,
        onclick: null,
        showDuration: "1000",
        hideDuration: "1000",
        timeOut: "5000",
        extendedTimeOut: "1000",
        showEasing: "swing",
        hideEasing: "linear",
        showMethod: "fadeIn",
        hideMethod: "fadeOut"
    })
});

window.addEventListener('notify', (event) => {
    const payload = event.detail?.data ?? event.detail ?? {};
    const type = (payload.type || 'info').toLowerCase();
    const title = payload.title ? `<strong>${payload.title}</strong><br>` : '';
    const message = payload.message ?? '';

    const notyf = new Notyf({
        duration: 5000,
        ripple: true,
        dismissible: true,
        position: { x: 'right', y: 'top' }
    });

    notyf.open({
        type: ['success', 'error', 'warning', 'info'].includes(type) ? type : 'info',
        message: `${title}${message}`
        // message: `${title}${message}`
    });
});



$(".modal").on("show.bs.modal", function (e) {
    var emit = $(e.relatedTarget).data('emit');
    if (emit !== undefined) {
        var json = $(e.relatedTarget).data('json');
        Livewire.dispatch(emit, { data: json });
    }
});

window.addEventListener('closeModal', param => {
    $('#' + param.detail.id).modal('hide');
});

window.addEventListener('showModal', param => {
    $('#' + param.detail.id).modal('show');
});

window.addEventListener('reloadDT', param => {
    eval(param.detail.data).ajax.reload();
});

function initSearchCol(table, headerId, inputClass) {
    $(headerId).on('input', 'input.' + inputClass, function () {
        table.column($(this).closest('th').index()).search(this.value).draw();
    });

    $(headerId).on('change', 'select.' + inputClass, function () {
        table.column($(this).closest('th').index()).search(this.value).draw();
    });
}

$(document).on('change', '.checkall', function () {
    $('.' + this.id).prop('checked', this.checked);
});

$(document).on('change', 'input[type="checkbox"][class^="checkall"]:not(.checkall)', function () {
    let group = this.className.split(' ').find(c => c.startsWith('checkall'));
    let total = $('.' + group).length;
    let checked = $('.' + group + ':checked').length;
    $('#' + group).prop('checked', total === checked);
});


window.initDropzone = function (selector, accepted = 'application/pdf,.pdf', maxFilesize = 5) {

    Dropzone.autoDiscover = false;

    const el = document.querySelector(selector);
    if (!el || el.dropzone) return;

    const lwModel = el.getAttribute('data-lw-model');
    if (!lwModel) throw new Error('Dropzone: data-lw-model belum di-set');

    const root = el.closest('[wire\\:id]');
    if (!root) throw new Error('Dropzone: wire:id root Livewire tidak ketemu');

    const componentId = root.getAttribute('wire:id');
    const $wire = Livewire.find(componentId);

    const previewTemplate = `
      <div class="dz-preview dz-file-preview">
        <div class="dz-details">
          <div class="dz-thumbnail">
            <img data-dz-thumbnail>
            <span class="dz-nopreview">No preview</span>
            <div class="dz-success-mark"></div>
            <div class="dz-error-mark"></div>
            <div class="dz-error-message"><span data-dz-errormessage></span></div>
            <div class="progress">
              <div class="progress-bar progress-bar-primary" role="progressbar"
                   aria-valuemin="0" aria-valuemax="100" data-dz-uploadprogress></div>
            </div>
          </div>
          <div class="dz-filename" data-dz-name></div>
          <div class="dz-size" data-dz-size></div>
        </div>
      </div>
    `;

    const dz = new Dropzone(el, {
        url: '/',                 // dummy (Dropzone tidak dipakai upload)
        autoProcessQueue: false,  // upload via Livewire
        previewTemplate,          // ✅ tetap pakai style kamu
        parallelUploads: 1,
        maxFiles: 1,
        maxFilesize,
        acceptedFiles: accepted,
        addRemoveLinks: true
    });

    dz.on('addedfile', function (file) {
        if (dz.files.length > 1) dz.removeFile(dz.files[0]);

        $wire.upload(
            lwModel,
            file,
            (tmpFilename) => { file._lwTmp = tmpFilename; }, // ✅ simpan token
            () => { },
            (progress) => {
                const bar = file.previewElement?.querySelector('[data-dz-uploadprogress]');
                if (bar) bar.style.width = progress + '%';
            }
        );
    });

    dz.on('removedfile', function (file) {
        $wire.set(lwModel, null); // ✅ property pasti kosong
        if (file._lwTmp) $wire.removeUpload(lwModel, file._lwTmp); // ✅ hapus temp yg benar
    });

};

window.addEventListener('clearDropzone', (e) => {
    const selector = e.detail?.data ?? e.detail ?? '#dropzone-basic';
    const el = document.querySelector(selector);
    if (!el || !el.dropzone) return;

    // hapus semua file + preview dari UI dropzone
    el.dropzone.removeAllFiles(true);
});

(function () {

    // window.initDatePicker = function (selector, lwModel) {
    //     const el = $(selector);
    //     if (!el.length || el.data('daterangepicker')) return;
    //     const hidden = el.next('input[type="hidden"]');
    //     const root = el[0].closest('[wire\\:id]');
    //     const $wire = root ? Livewire.find(root.getAttribute('wire:id')) : null;
    //     const setAll = (m) => {
    //         el.val(m.format('DD/MM/YYYY'));
    //         hidden.val(m.format('YYYY-MM-DD'));
    //         $wire && $wire.set(lwModel, m.format('YYYY-MM-DD'));
    //     };
    //     const start = hidden.val()
    //         ? moment(hidden.val(), 'YYYY-MM-DD')
    //         : moment();
    //     el.daterangepicker({
    //         singleDatePicker: true,
    //         autoApply: true,
    //         startDate: start,
    //         locale: {
    //             format: 'DD/MM/YYYY',
    //             // applyLabel: 'Pilih',
    //             cancelLabel: 'Batal'
    //         },
    //         opens: 'right'
    //     });
    //     el.val(start.format('DD/MM/YYYY'));
    //     el.on('apply.daterangepicker', (ev, picker) => setAll(picker.startDate));
    //     el.on('hide.daterangepicker', () => setAll(el.data('daterangepicker').startDate));
    //     el.on('change', () => setAll(moment(el.val(), 'DD/MM/YYYY')));
    // };

    window.initDatePicker = function (selector, lwModel) {
        const el = $(selector);
        if (!el.length || el.data('daterangepicker')) return;

        const hidden = el.next('input[type="hidden"]');
        const root = el[0].closest('[wire\\:id]');
        const $wire = root ? Livewire.find(root.getAttribute('wire:id')) : null;

        const setAll = (m) => {
            el.val(m.format('DD/MM/YYYY'));
            hidden.val(m.format('YYYY-MM-DD'));
            $wire && $wire.set(lwModel, m.format('YYYY-MM-DD'));
        };

        const start = hidden.val()
            ? moment(hidden.val(), 'YYYY-MM-DD')
            : moment();

        el.daterangepicker({
            singleDatePicker: true,
            autoApply: true,
            startDate: start,
            locale: {
                format: 'DD/MM/YYYY',
                applyLabel: 'Pilih',
                cancelLabel: 'Batal'
            },
            opens: 'right'
        });

        el.val(start.format('DD/MM/YYYY'));

        el.on('apply.daterangepicker', (ev, picker) => {
            setAll(picker.startDate);
        });

        el.on('change', () => {
            const m = moment(el.val(), 'DD/MM/YYYY', true);
            if (m.isValid()) setAll(m);
        });
    };

    window.addEventListener('reinitDatepicker', (event) => {
        const payload = Array.isArray(event.detail) ? event.detail[0] : event.detail;
        const { selector, date } = payload;

        // retry sampai element muncul (maks 20x x 25ms = 500ms)
        let tries = 0;
        const tick = () => {
            const el = $(selector);

            if (el.length) {
                const m = moment(date, 'YYYY-MM-DD');

                // kalau dp belum ada, kamu bisa init ulang atau skip
                const drp = el.data('daterangepicker');
                if (drp) {
                    drp.setStartDate(m);
                    drp.setEndDate(m);
                }
                el.val(m.format('DD/MM/YYYY'));
                return;
            }

            if (++tries < 20) return setTimeout(tick, 25);
        };

        tick();
    });

})();










