/**
 * Theme JS Configuration (Customized for SIM Pasar)
 */
try {
    var dropdownMenus = document.querySelectorAll(".dropdown-menu.stop");
    dropdownMenus.forEach(function(e) {
        e.addEventListener("click", function(e) {
            e.stopPropagation();
        });
    });
} catch(e) {}

try {
    if (typeof lucide !== 'undefined') {
        lucide.createIcons();
    }
} catch(e) {}

// Light / Dark Mode Toggle
try {
    var themeColorToggle = document.getElementById("light-dark-mode");
    if (themeColorToggle) {
        themeColorToggle.addEventListener("click", function(e) {
            if ("light" === document.documentElement.getAttribute("data-bs-theme")) {
                document.documentElement.setAttribute("data-bs-theme", "dark");
            } else {
                document.documentElement.setAttribute("data-bs-theme", "light");
            }
        });
    }
} catch(e) {}

// Sidebar Toggle (Auto-close feature disabled)
try {
    var collapsedToggle = document.querySelector(".mobile-menu-btn");
    const overlay = document.querySelector(".startbar-overlay");

    if (collapsedToggle) {
        collapsedToggle.addEventListener("click", function() {
            if (document.body.getAttribute("data-sidebar-size") === "collapsed") {
                document.body.setAttribute("data-sidebar-size", "default");
            } else {
                document.body.setAttribute("data-sidebar-size", "collapsed");
            }
        });
    }

    if (overlay) {
        overlay.addEventListener("click", function() {
            if (window.innerWidth < 768) {
                document.body.setAttribute("data-sidebar-size", "collapsed");
            }
        });
    }

    // Default sidebar size is default (open), only collapse on small mobile (< 768px)
    const checkSidebarSize = () => {
        if (window.innerWidth < 768) {
            document.body.setAttribute("data-sidebar-size", "collapsed");
        } else {
            document.body.setAttribute("data-sidebar-size", "default");
        }
    };

    window.addEventListener("resize", checkSidebarSize);
    checkSidebarSize();
} catch(e) {}

// Tooltips & Popovers
try {
    const tooltips = document.querySelectorAll('[data-bs-toggle="tooltip"]');
    [...tooltips].map(e => new bootstrap.Tooltip(e));

    const popovers = [].slice.call(document.querySelectorAll('[data-bs-toggle="popover"]'));
    popovers.map(function(e) {
        return new bootstrap.Popover(e);
    });
} catch(e) {}

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
window.addEventListener("scroll", function(e) {
    windowScroll();
});

// Vertical Menu Activation
const initVerticalMenu = () => {
    var collapseItems = document.querySelectorAll(".navbar-nav li .collapse");
    
    document.querySelectorAll(".navbar-nav li [data-bs-toggle='collapse']").forEach(function(e) {
        e.addEventListener("click", function(ev) {
            ev.preventDefault();
        });
    });

    collapseItems.forEach(function(item) {
        item.addEventListener("show.bs.collapse", function(t) {
            const openParent = t.target.closest(".collapse.show");
            document.querySelectorAll(".navbar-nav .collapse.show").forEach(function(e) {
                if (e !== t.target && e !== openParent) {
                    new bootstrap.Collapse(e).hide();
                }
            });
        });
    });

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

document.addEventListener("DOMContentLoaded", initVerticalMenu);
document.addEventListener("livewire:navigated", initVerticalMenu);