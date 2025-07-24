            </main>
            <footer class="app-footer">
                <div class="float-end d-none d-sm-inline">Anything you want</div>
                <strong>
                    Copyright 𝓕ℬ© 2025&nbsp;
                </strong>
                All rights reserved.
            </footer>
        </div>
        <script src="https://cdn.jsdelivr.net/npm/overlayscrollbars@2.11.0/browser/overlayscrollbars.browser.es6.min.js" crossorigin="anonymous" ></script>
        <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.8/dist/umd/popper.min.js" crossorigin="anonymous" ></script>
        <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.7/dist/js/bootstrap.min.js" crossorigin="anonymous"></script>
        <script src="<?= BASE_URL ?>adminlte/dist/js/adminlte.js"></script>
        <script>
            const SELECTOR_SIDEBAR_WRAPPER = '.sidebar-wrapper';
            const Default = {
                scrollbarTheme: 'os-theme-light',
                scrollbarAutoHide: 'leave',
                scrollbarClickScroll: true,
            };
            document.addEventListener('DOMContentLoaded', function () {
                const sidebarWrapper = document.querySelector(SELECTOR_SIDEBAR_WRAPPER);
                if (sidebarWrapper && OverlayScrollbarsGlobal?.OverlayScrollbars !== undefined) {
                    OverlayScrollbarsGlobal.OverlayScrollbars(sidebarWrapper, {
                        scrollbars: {
                            theme: Default.scrollbarTheme,
                            autoHide: Default.scrollbarAutoHide,
                            clickScroll: Default.scrollbarClickScroll,
                        },
                    });
                }
            });
        </script>

        <script>
            // Color Mode Toggler
            (() => {
                "use strict";

                const storedTheme = localStorage.getItem("theme");

                const getPreferredTheme = () => {
                    if (storedTheme) {
                        return storedTheme;
                    }

                    return window.matchMedia("(prefers-color-scheme: dark)").matches
                        ? "dark"
                        : "light";
                };

                const setTheme = function (theme) {
                    if (
                        theme === "auto" &&
                        window.matchMedia("(prefers-color-scheme: dark)").matches
                    ) {
                        document.documentElement.setAttribute("data-bs-theme", "dark");
                    } else {
                        document.documentElement.setAttribute("data-bs-theme", theme);
                    }
                };

                setTheme(getPreferredTheme());

                const showActiveTheme = (theme, focus = false) => {
                    const themeSwitcher = document.querySelector("#bd-theme");

                    if (!themeSwitcher) {
                        return;
                    }

                    const themeSwitcherText = document.querySelector("#bd-theme-text");
                    const activeThemeIcon = document.querySelector(".theme-icon-active i");
                    const btnToActive = document.querySelector(
                        `[data-bs-theme-value="${theme}"]`
                    );
                    const svgOfActiveBtn = btnToActive.querySelector("i").getAttribute("class");

                    for (const element of document.querySelectorAll("[data-bs-theme-value]")) {
                        element.classList.remove("active");
                        element.setAttribute("aria-pressed", "false");
                    }

                    btnToActive.classList.add("active");
                    btnToActive.setAttribute("aria-pressed", "true");
                    activeThemeIcon.setAttribute("class", svgOfActiveBtn);
                    const themeSwitcherLabel = `${themeSwitcherText.textContent} (${btnToActive.dataset.bsThemeValue})`;
                    themeSwitcher.setAttribute("aria-label", themeSwitcherLabel);

                    if (focus) {
                        themeSwitcher.focus();
                    }
                };

                window
                    .matchMedia("(prefers-color-scheme: dark)")
                    .addEventListener("change", () => {
                        if (storedTheme !== "light" || storedTheme !== "dark") {
                            setTheme(getPreferredTheme());
                        }
                    });

                window.addEventListener("DOMContentLoaded", () => {
                    showActiveTheme(getPreferredTheme());

                    for (const toggle of document.querySelectorAll("[data-bs-theme-value]")) {
                        toggle.addEventListener("click", () => {
                            const theme = toggle.getAttribute("data-bs-theme-value");
                            localStorage.setItem("theme", theme);
                            setTheme(theme);
                            showActiveTheme(theme, true);
                        });
                    }
                });
            })();
        </script>

        <script>
            $(document).ready(function() {

                // Firma listesini çek ve dropdown'a doldur
                function loadCompanies() {
                    return $.getJSON(<?= BASE_URL ?>+"ajax/ajax?action=get_companies", function(data) {
                        const $dropdown = $("#company-switcher");
                        $dropdown.empty();
                        data.forEach(function(company) {
                            $dropdown.append(`<option value="${company.id}">${company.name}</option>`);
                        });

                        // Seçili olan firma varsa onu seç
                        const currentId = window.currentCompanyId || null;
                        if (currentId) {
                            $dropdown.val(currentId);
                            $("#current-company-name").text(data.find(c => c.id == currentId)?.name || "Tanımsız");
                        }
                    });
                }

                // Firma değişikliği bildir
                function setCompany(companyId) {
                    return $.ajax({
                        url: <?= BASE_URL ?>+"ajax/ajax?action=set_company",
                        method: "POST",
                        data: { company_id: companyId },
                        dataType: "json" // beklenen dönüş tipi
                    });
                }


                // Event handler

                if ($("#company-switcher").length) {
                    $("#company-switcher").on("change", function () {
                        const companyId = $(this).val();
                        setCompany(companyId).done(function (response) {
                            if (response.success) {
                                $("#current-company-name").text(response.name);

                                toastr.success("Firma değiştirildi!");
                                setTimeout(() => location.reload(), 1000);
                                /*alert("Firma değiştirildi!");
                                location.reload();*/
                            } else {
                                toastr.error("Hata: " + response.error);
                                //alert("Hata: " + response.error);
                                console.log(response);
                            }
                        }).fail(function () {
                            toastr.error("Sunucu hatası: " + error);
                        });
                    });
                }

                // Yükle
                loadCompanies();
            });

        </script>
    </body>
</html>
