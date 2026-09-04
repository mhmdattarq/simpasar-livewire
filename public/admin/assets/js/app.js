/**
 * Theme JS Configuration (Customized & Optimized for SIM Pasar SPA)
 */

const initAppFeatures = () => {
    // 1. Dropdown stop propagation
    document.querySelectorAll(".dropdown-menu.stop").forEach(function(e) {
        e.onclick = function(ev) {
            ev.stopPropagation();
        };
    });

    // 2. Mobile Menu / Sidebar Toggle
    const collapsedToggle = document.querySelector(".mobile-menu-btn");
    const overlay = document.querySelector(".startbar-overlay");

    if (collapsedToggle) {
        collapsedToggle.onclick = function() {
            if (document.body.getAttribute("data-sidebar-size") === "collapsed") {
                document.body.setAttribute("data-sidebar-size", "default");
            } else {
                document.body.setAttribute("data-sidebar-size", "collapsed");
            }
        };
    }

    if (overlay) {
        overlay.onclick = function() {
            if (window.innerWidth < 768) {
                document.body.setAttribute("data-sidebar-size", "collapsed");
            }
        };
    }

    // 3. Light / Dark Mode Toggle
    const themeColorToggle = document.getElementById("light-dark-mode");
    if (themeColorToggle) {
        themeColorToggle.onclick = function() {
            if ("light" === document.documentElement.getAttribute("data-bs-theme")) {
                document.documentElement.setAttribute("data-bs-theme", "dark");
            } else {
                document.documentElement.setAttribute("data-bs-theme", "light");
            }
        };
    }

    // 4. Lucide icons
    if (typeof lucide !== 'undefined') {
        lucide.createIcons();
    }

    // 5. Tooltips & Popovers
    if (typeof bootstrap !== 'undefined') {
        if (bootstrap.Tooltip) {
            document.querySelectorAll('[data-bs-toggle="tooltip"]').forEach(e => {
                bootstrap.Tooltip.getOrCreateInstance(e);
            });
        }
        if (bootstrap.Popover) {
            document.querySelectorAll('[data-bs-toggle="popover"]').forEach(e => {
                bootstrap.Popover.getOrCreateInstance(e);
            });
        }
    }
};

// Delegated Table Action Dropdown (Global & Persistent across all SPA pages)
$(document).on('click', '.table .dropdown-toggle', function(e) {
    e.preventDefault();
    e.stopPropagation();
    var $menu = $(this).closest('.dropdown, .btn-group').find('.dropdown-menu');
    var isShown = $menu.hasClass('show');
    $('.table .dropdown-menu.show').removeClass('show');
    $('.table .dropdown-toggle').attr('aria-expanded', 'false');
    if (!isShown) {
        $menu.addClass('show');
        $(this).attr('aria-expanded', 'true');
    }
});

// Close table dropdowns when clicking outside
$(document).on('click', function(e) {
    if (!$(e.target).closest('.table .dropdown, .table .btn-group').length) {
        $('.table .dropdown-menu.show').removeClass('show');
        $('.table .dropdown-toggle').attr('aria-expanded', 'false');
    }
});

// Automatically close dropdown when any item inside is clicked or modal opens
$(document).on('click', '.dropdown-menu a, .dropdown-menu button', function() {
    if (!$(this).closest('.dropdown-menu.stop').length) {
        $('.dropdown-menu.show').removeClass('show');
        $('[data-bs-toggle="dropdown"], .dropdown-toggle').attr('aria-expanded', 'false');
    }
});

$(document).on('show.bs.modal', function() {
    $('.dropdown-menu.show').removeClass('show');
    $('[data-bs-toggle="dropdown"], .dropdown-toggle').attr('aria-expanded', 'false');
});

$(document).on('shown.bs.modal', function() {
    // Jika ada lebih dari 1 backdrop akibat spam klik, buang kelebihannya
    const backdrops = $('.modal-backdrop');
    if (backdrops.length > 1) {
        backdrops.not(':last').remove();
    }
});

$(document).on('hidden.bs.modal', function() {
    $('.modal-backdrop').remove();
    $('body').removeClass('modal-open').css({ overflow: '', paddingRight: '' });
});

// Close all open dropdowns and modals before leaving page in SPA
document.addEventListener("livewire:navigating", () => {
    $('.dropdown-menu.show').removeClass('show');
    $('.dropdown-toggle').attr('aria-expanded', 'false');
    $('.modal').modal('hide');
    $('.modal-backdrop').remove();
    $('body').removeClass('modal-open').css('overflow', '').css('padding-right', '');
});

// Vertical Menu Active State & Collapse Handling
const initVerticalMenu = () => {
    if (document.querySelector(".navbar-nav")) {
        document.querySelectorAll(".navbar-nav a").forEach(function(t) {
            var currentUrl = window.location.href.split(/[?#]/)[0];
            if (t.href === currentUrl) {
                t.classList.add("active");
                if (t.parentNode) t.parentNode.classList.add("active");
                let parentCollapse = t.closest(".collapse");
                while (parentCollapse) {
                    parentCollapse.classList.add("show");
                    if (parentCollapse.parentElement && parentCollapse.parentElement.children[0]) {
                        parentCollapse.parentElement.children[0].classList.add("active");
                        parentCollapse.parentElement.children[0].setAttribute("aria-expanded", "true");
                    }
                    parentCollapse = parentCollapse.parentElement ? parentCollapse.parentElement.closest(".collapse") : null;
                }
            }
        });
    }
};

// Navbar Sticky on Scroll
function windowScroll() {
    var e = document.getElementById("topbar-custom");
    if (e != null) {
        if (document.body.scrollTop >= 50 || document.documentElement.scrollTop >= 50) {
            e.classList.add("nav-sticky");
        } else {
            e.classList.remove("nav-sticky");
        }
    }
}
window.addEventListener("scroll", windowScroll);

// Initialize on first load & on every Livewire SPA navigation
document.addEventListener("DOMContentLoaded", () => {
    initAppFeatures();
    initVerticalMenu();
});

document.addEventListener("livewire:navigated", () => {
    initAppFeatures();
    initVerticalMenu();
});