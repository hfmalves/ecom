!function(a){"use strict";var e,t=localStorage.getItem("language"),s="en";function n(e){document.getElementById("header-lang-img")&&("en"==e?document.getElementById("header-lang-img").src="assets/images/flags/us.jpg":"sp"==e?document.getElementById("header-lang-img").src="assets/images/flags/spain.jpg":"gr"==e?document.getElementById("header-lang-img").src="assets/images/flags/germany.jpg":"it"==e?document.getElementById("header-lang-img").src="assets/images/flags/italy.jpg":"ru"==e&&(document.getElementById("header-lang-img").src="assets/images/flags/russia.jpg"),localStorage.setItem("language",e),null==(t=localStorage.getItem("language"))&&n(s),a.getJSON("assets/lang/"+t+".json",function(e){a("html").attr("lang",t),a.each(e,function(e,t){"head"===e&&a(document).attr("title",t.title),a("[key='"+e+"']").text(t)})}))}function c(){for(var e=document.getElementById("topnav-menu-content").getElementsByTagName("a"),t=0,a=e.length;t<a;t++)"nav-item dropdown active"===e[t].parentElement.getAttribute("class")&&(e[t].parentElement.classList.remove("active"),null!==e[t].nextElementSibling&&e[t].nextElementSibling.classList.remove("show"))}function r(e){1==a("#light-mode-switch").prop("checked")&&"light-mode-switch"===e?(a("html").removeAttr("dir"),a("#dark-mode-switch").prop("checked",!1),a("#rtl-mode-switch").prop("checked",!1),a("#dark-rtl-mode-switch").prop("checked",!1),a("#bootstrap-style").attr("href","assets/css/bootstrap.min.css"),a("body").attr("data-layout-mode","light"),a("#app-style").attr("href","assets/css/app.min.css"),sessionStorage.setItem("is_visited","light-mode-switch")):1==a("#dark-mode-switch").prop("checked")&&"dark-mode-switch"===e?(a("html").removeAttr("dir"),a("#light-mode-switch").prop("checked",!1),a("#rtl-mode-switch").prop("checked",!1),a("#dark-rtl-mode-switch").prop("checked",!1),a("body").attr("data-layout-mode","dark"),sessionStorage.setItem("is_visited","dark-mode-switch")):1==a("#rtl-mode-switch").prop("checked")&&"rtl-mode-switch"===e?(a("#light-mode-switch").prop("checked",!1),a("#dark-mode-switch").prop("checked",!1),a("#dark-rtl-mode-switch").prop("checked",!1),a("#bootstrap-style").attr("href","assets/css/bootstrap-rtl.min.css"),a("#app-style").attr("href","assets/css/app-rtl.min.css"),a("html").attr("dir","rtl"),a("body").attr("data-layout-mode","light"),sessionStorage.setItem("is_visited","rtl-mode-switch")):1==a("#dark-rtl-mode-switch").prop("checked")&&"dark-rtl-mode-switch"===e&&(a("#light-mode-switch").prop("checked",!1),a("#rtl-mode-switch").prop("checked",!1),a("#dark-mode-switch").prop("checked",!1),a("#bootstrap-style").attr("href","assets/css/bootstrap-rtl.min.css"),a("#app-style").attr("href","assets/css/app-rtl.min.css"),a("html").attr("dir","rtl"),a("body").attr("data-layout-mode","dark"),sessionStorage.setItem("is_visited","dark-rtl-mode-switch"))}function o(){document.webkitIsFullScreen||document.mozFullScreen||document.msFullscreenElement||(console.log("pressed"),a("body").removeClass("fullscreen-enable"))}a("#side-menu").metisMenu(),a("#vertical-menu-btn").on("click",function(e){e.preventDefault(),a("body").toggleClass("sidebar-enable"),992<=a(window).width()?a("body").toggleClass("vertical-collpsed"):a("body").removeClass("vertical-collpsed")}),a("#sidebar-menu a").each(function(){var e=window.location.href.split(/[?#]/)[0];this.href==e&&(a(this).addClass("active"),a(this).parent().addClass("mm-active"),a(this).parent().parent().addClass("mm-show"),a(this).parent().parent().prev().addClass("mm-active"),a(this).parent().parent().parent().addClass("mm-active"),a(this).parent().parent().parent().parent().addClass("mm-show"),a(this).parent().parent().parent().parent().parent().addClass("mm-active"))}),a(document).ready(function(){var e;0<a("#sidebar-menu").length&&0<a("#sidebar-menu .mm-active .active").length&&(300<(e=a("#sidebar-menu .mm-active .active").offset().top)&&(e-=300,a(".vertical-menu .simplebar-content-wrapper").animate({scrollTop:e},"slow")))}),a(".navbar-nav a").each(function(){var e=window.location.href.split(/[?#]/)[0];this.href==e&&(a(this).addClass("active"),a(this).parent().addClass("active"),a(this).parent().parent().addClass("active"),a(this).parent().parent().parent().addClass("active"),a(this).parent().parent().parent().parent().addClass("active"),a(this).parent().parent().parent().parent().parent().addClass("active"),a(this).parent().parent().parent().parent().parent().parent().addClass("active"))}),a('[data-bs-toggle="fullscreen"]').on("click",function(e){e.preventDefault(),a("body").toggleClass("fullscreen-enable"),document.fullscreenElement||document.mozFullScreenElement||document.webkitFullscreenElement?document.cancelFullScreen?document.cancelFullScreen():document.mozCancelFullScreen?document.mozCancelFullScreen():document.webkitCancelFullScreen&&document.webkitCancelFullScreen():document.documentElement.requestFullscreen?document.documentElement.requestFullscreen():document.documentElement.mozRequestFullScreen?document.documentElement.mozRequestFullScreen():document.documentElement.webkitRequestFullscreen&&document.documentElement.webkitRequestFullscreen(Element.ALLOW_KEYBOARD_INPUT)}),document.addEventListener("fullscreenchange",o),document.addEventListener("webkitfullscreenchange",o),document.addEventListener("mozfullscreenchange",o),a(".right-bar-toggle").on("click",function(e){a("body").toggleClass("right-bar-enabled")}),a(document).on("click","body",function(e){0<a(e.target).closest(".right-bar-toggle, .right-bar").length||a("body").removeClass("right-bar-enabled")}),function(){if(document.getElementById("topnav-menu-content")){for(var e=document.getElementById("topnav-menu-content").getElementsByTagName("a"),t=0,a=e.length;t<a;t++)e[t].onclick=function(e){"#"===e.target.getAttribute("href")&&(e.target.parentElement.classList.toggle("active"),e.target.nextElementSibling.classList.toggle("show"))};window.addEventListener("resize",c)}}(),[].slice.call(document.querySelectorAll('[data-bs-toggle="tooltip"]')).map(function(e){return new bootstrap.Tooltip(e)}),[].slice.call(document.querySelectorAll('[data-bs-toggle="popover"]')).map(function(e){return new bootstrap.Popover(e)}),[].slice.call(document.querySelectorAll(".offcanvas")).map(function(e){return new bootstrap.Offcanvas(e)}),window.sessionStorage&&((e=sessionStorage.getItem("is_visited"))?(a(".right-bar input:checkbox").prop("checked",!1),a("#"+e).prop("checked",!0),r(e)):"rtl"===a("html").attr("dir")&&"dark"===a("body").attr("data-layout-mode")?(a("#dark-rtl-mode-switch").prop("checked",!0),a("#light-mode-switch").prop("checked",!1),sessionStorage.setItem("is_visited","dark-rtl-mode-switch"),r(e)):"rtl"===a("html").attr("dir")?(a("#rtl-mode-switch").prop("checked",!0),a("#light-mode-switch").prop("checked",!1),sessionStorage.setItem("is_visited","rtl-mode-switch"),r(e)):"dark"===a("body").attr("data-layout-mode")?(a("#dark-mode-switch").prop("checked",!0),a("#light-mode-switch").prop("checked",!1),sessionStorage.setItem("is_visited","dark-mode-switch"),r(e)):sessionStorage.setItem("is_visited","light-mode-switch")),a("#light-mode-switch, #dark-mode-switch, #rtl-mode-switch, #dark-rtl-mode-switch").on("change",function(e){r(e.target.id)}),a("#password-addon").on("click",function(){0<a(this).siblings("input").length&&("password"==a(this).siblings("input").attr("type")?a(this).siblings("input").attr("type","input"):a(this).siblings("input").attr("type","password"))}),null!=t&&t!==s&&n(t),a(".language").on("click",function(e){n(a(this).attr("data-lang"))}),a(window).on("load",function(){a("#statuspreloader-").fadeOut(),a("#preloader").delay(350).fadeOut("slow")}),Waves.init(),a("#checkAll").on("change",function(){a(".table-check .form-check-input").prop("checked",a(this).prop("checked"))}),a(".table-check .form-check-input").change(function(){a(".table-check .form-check-input:checked").length==a(".table-check .form-check-input").length?a("#checkAll").prop("checked",!0):a("#checkAll").prop("checked",!1)})}(jQuery);
function formHandler(endpoint, initForm = {}, options = {}) {
    return {
        form: { ...initForm },
        errors: {},
        loading: false,
        step: 'login',
        opts: Object.assign({ redirect: false, resetOnSuccess: false }, options),

        refreshCsrf(data) {
            if (data && data.csrf) {
                // limpa os antigos
                Object.keys(this.form).forEach(k => {
                    if (k.startsWith('csrf_')) delete this.form[k];
                });
                // mete o novo
                this.form[data.csrf.token] = data.csrf.hash;

                // 🔥 guarda último csrf global
                window.__lastCsrf = { token: data.csrf.token, hash: data.csrf.hash };

                // 🔥 dispara evento global
                document.dispatchEvent(new CustomEvent('csrf-update', {
                    detail: { token: data.csrf.token, hash: data.csrf.hash }
                }));
            }
        },


        async submit() {
            this.loading = true;
            this.errors = {};
            try {
                const csrfKey = Object.keys(this.form).find(k => k.startsWith('csrf_'));
                const csrfValue = this.form[csrfKey];

                const resp = await fetch(endpoint, {
                    method: "POST",
                    headers: {
                        "Content-Type": "application/json",
                        "X-CSRF-TOKEN": csrfValue,
                    },
                    body: JSON.stringify(this.form),
                });

                const isJSON = (resp.headers.get("content-type") || "").includes("application/json");
                const data = isJSON ? await resp.json() : {};
                this.refreshCsrf(data);

                // 🔹 Caso 1: erros de validação
                if (data.status === "error" && data.errors) {
                    this.errors = {};
                    for (const k in data.errors) {
                        this.errors[k] = Array.isArray(data.errors[k])
                            ? data.errors[k][0]
                            : data.errors[k];
                    }
                    return;
                }

                // 🔹 Caso 2: erro geral
                if (data.status === "error" && data.message) {
                    showToast(data.message, "danger");
                    return;
                }

                // 🔹 Caso 3: erro HTTP
                if (!resp.ok) {
                    showToast(`Erro ${resp.status}: ${resp.statusText}`, "danger");
                    return;
                }

                // 🔹 Sucesso
                if (data.message) {
                    showToast(data.message, "success");
                }
                if (data.status === "2fa_required") {
                    this.step = "2fa";
                    return;
                }
                if (data.redirect) {
                    window.location.href = data.redirect;
                    return;
                }
                if (this.opts.redirect && typeof this.opts.redirect === "string") {
                    window.location.href = this.opts.redirect;
                    return;
                }
                if (this.opts.resetOnSuccess) {
                    for (const k in this.form) {
                        this.form[k] = typeof this.form[k] === 'boolean' ? false : '';
                    }
                }
            } catch (e) {
                showToast("Erro de ligação ao servidor.", "danger");
            } finally {
                this.loading = false;
            }
        },

        async submit2FA(urlVerify) {
            this.loading = true;
            this.errors = {};

            try {
                const csrfKey = Object.keys(this.form).find(k => k.startsWith('csrf_'));
                const csrfValue = this.form[csrfKey];

                const resp = await fetch(urlVerify, {
                    method: "POST",
                    headers: {
                        "Content-Type": "application/json",
                        "X-CSRF-TOKEN": csrfValue,
                    },
                    body: JSON.stringify({
                        email: this.form.email,
                        code: this.form.code,
                        ...Object.fromEntries(
                            Object.entries(this.form).filter(([k]) => k.startsWith('csrf_'))
                        )
                    }),
                });

                const data = await resp.json();
                this.refreshCsrf(data);

                if (data.status === "success" && data.redirect) {
                    window.location.href = data.redirect;
                } else if (data.status === "error") {
                    this.errors.code = data.message || "Código inválido.";
                    showToast(this.errors.code, "danger");
                }
            } catch (e) {
                showToast("Erro na validação 2FA.", "danger");
            } finally {
                this.loading = false;
            }
        }
    };
}

function showToast(message, type = "info", title = "") {
    if (typeof toastr === "undefined") {
        console.error("Toastr não foi carregado.");
        return;
    }
    switch (type) {
        case "success":
            toastr.success(message, title);
            break;
        case "error":
        case "danger": // alias para error
            toastr.error(message, title);
            break;
        case "warning":
            toastr.warning(message, title);
            break;
        default:
            toastr.info(message, title);
    }
}
window.showToast = showToast;
function systemModal() {
    return {
        async open(source, size = 'md', entity = null) {
            try {
                let content = '';

                // Pega conteúdo
                if (typeof source === 'string' && source.startsWith('#')) {
                    const el = document.querySelector(source);
                    if (!el) throw new Error("Elemento não encontrado: " + source);
                    content = el.innerHTML;
                } else if (typeof source === 'string' && source.trim().startsWith('<')) {
                    content = source;
                } else {
                    const res = await fetch(source);
                    if (!res.ok) throw new Error(res.statusText);
                    content = await res.text();
                }

                // Cria wrapper
                const wrapper = document.createElement('div');
                wrapper.innerHTML = `
                    <div class="modal fade" id="exampleModalDynamic" tabindex="-1" aria-hidden="true">
                        <div class="modal-dialog modal-dialog-centered ${this.sizeClass(size)}">
                            <div class="modal-content">${content}</div>
                        </div>
                    </div>
                `;
                document.body.appendChild(wrapper);

                const modalEl = wrapper.querySelector('#exampleModalDynamic');
                const modal = new bootstrap.Modal(modalEl);

                modalEl.addEventListener('shown.bs.modal', () => {
                    const formEl = wrapper.querySelector('[x-data]');
                    if (!formEl) return;

                    // Preenche/limpa form
                    if (entity) {
                        formEl.dispatchEvent(new CustomEvent('fill-form', { detail: entity }));
                    } else {
                        formEl.dispatchEvent(new CustomEvent('reset-form'));
                    }

                    // Escuta CSRF update global
                    document.addEventListener('csrf-update', e => {
                        if (formEl.__x) formEl.__x.$data.form[e.detail.token] = e.detail.hash;
                    });
                });

                modalEl.addEventListener('hidden.bs.modal', () => wrapper.remove());
                modal.show();

            } catch (e) {
                console.error("Erro ao carregar modal:", e);
            }
        },
        sizeClass(size) {
            if (size === 'sm') return 'modal-sm';
            if (size === 'lg') return 'modal-lg';
            if (size === 'xl') return 'modal-xl';
            return 'modal-md';
        }
    };
}

function csrfHandler(form) {
    // fallback imediato ao abrir
    if (window.__lastCsrf) {
        Object.keys(form).forEach(k => { if (k.startsWith('csrf_')) delete form[k] });
        form[window.__lastCsrf.token] = window.__lastCsrf.hash;
    }

    // ouvir futuros updates
    document.addEventListener('csrf-update', e => {
        Object.keys(form).forEach(k => { if (k.startsWith('csrf_')) delete form[k] });
        form[e.detail.token] = e.detail.hash;

        // debug opcional
        console.log("CSRF atualizado para:", e.detail);
    });
}

