            </main>
            <!--end::App Main-->
            <!--begin::Footer-->
            <footer class="app-footer">
            <!--<footer class="app-footer bg-warning" data-bs-theme="light">-->
                <!--begin::To the end-->
                <div class="float-end d-none d-sm-inline">Anything you want</div>
                <!--end::To the end-->
                <!--begin::Copyright-->
                <strong>
                    Copyright &copy; 2014-2025&nbsp;
                    <a href="https://adminlte.io" class="text-decoration-none">AdminLTE.io</a>.
                </strong>
                All rights reserved.
                <!--end::Copyright-->
            </footer>
            <!--end::Footer-->
        </div>
        <!--end::App Wrapper-->
        <!--begin::Script-->
        <!--begin::Third Party Plugin(OverlayScrollbars)-->
        <script src="https://cdn.jsdelivr.net/npm/overlayscrollbars@2.11.0/browser/overlayscrollbars.browser.es6.min.js" crossorigin="anonymous" ></script>
        <!--end::Third Party Plugin(OverlayScrollbars)--><!--begin::Required Plugin(popperjs for Bootstrap 5)-->
        <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.8/dist/umd/popper.min.js" crossorigin="anonymous" ></script>
        <!--end::Required Plugin(popperjs for Bootstrap 5)--><!--begin::Required Plugin(Bootstrap 5)-->
        <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.7/dist/js/bootstrap.min.js" crossorigin="anonymous"></script>
        <!--end::Required Plugin(Bootstrap 5)--><!--begin::Required Plugin(AdminLTE)-->
        <script src="<?= BASE_URL ?>adminlte/dist/js/adminlte.js"></script>
        <!--end::Required Plugin(AdminLTE)--><!--begin::OverlayScrollbars Configure-->
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
        <!--end::OverlayScrollbars Configure-->
        <!-- OPTIONAL SCRIPTS -->
        <!-- sortablejs -->
        <script
                src="https://cdn.jsdelivr.net/npm/sortablejs@1.15.0/Sortable.min.js"
                crossorigin="anonymous"
        ></script>
        <!-- sortablejs -->
        <script>
            new Sortable(document.querySelector('.connectedSortable'), {
                group: 'shared',
                handle: '.card-header',
            });

            const cardHeaders = document.querySelectorAll('.connectedSortable .card-header');
            cardHeaders.forEach((cardHeader) => {
                cardHeader.style.cursor = 'move';
            });
        </script>
        <!-- apexcharts -->
        <script src="https://cdn.jsdelivr.net/npm/apexcharts@3.37.1/dist/apexcharts.min.js" integrity="sha256-+vh8GkaU7C9/wbSLIcwq82tQ2wTf44aOHA8HlBMwRI8=" crossorigin="anonymous" ></script>
        <!-- ChartJS -->
        <script>
            // NOTICE!! DO NOT USE ANY OF THIS JAVASCRIPT
            // IT'S ALL JUST JUNK FOR DEMO
            // ++++++++++++++++++++++++++++++++++++++++++

            const sales_chart_options = {
                series: [
                    {
                        name: 'Digital Goods',
                        data: [28, 48, 40, 19, 86, 27, 90],
                    },
                    {
                        name: 'Electronics',
                        data: [65, 59, 80, 81, 56, 55, 40],
                    },
                ],
                chart: {
                    height: 300,
                    type: 'area',
                    toolbar: {
                        show: false,
                    },
                },
                legend: {
                    show: false,
                },
                colors: ['#0d6efd', '#20c997'],
                dataLabels: {
                    enabled: false,
                },
                stroke: {
                    curve: 'smooth',
                },
                xaxis: {
                    type: 'datetime',
                    categories: [
                        '2023-01-01',
                        '2023-02-01',
                        '2023-03-01',
                        '2023-04-01',
                        '2023-05-01',
                        '2023-06-01',
                        '2023-07-01',
                    ],
                },
                tooltip: {
                    x: {
                        format: 'MMMM yyyy',
                    },
                },
            };

            const sales_chart = new ApexCharts(
                document.querySelector('#revenue-chart'),
                sales_chart_options,
            );
            sales_chart.render();
        </script>
        <!-- jsvectormap -->
        <script
                src="https://cdn.jsdelivr.net/npm/jsvectormap@1.5.3/dist/js/jsvectormap.min.js"
                integrity="sha256-/t1nN2956BT869E6H4V1dnt0X5pAQHPytli+1nTZm2Y="
                crossorigin="anonymous"
        ></script>
        <script
                src="https://cdn.jsdelivr.net/npm/jsvectormap@1.5.3/dist/maps/world.js"
                integrity="sha256-XPpPaZlU8S/HWf7FZLAncLg2SAkP8ScUTII89x9D3lY="
                crossorigin="anonymous"
        ></script>
        <!--end::Script-->

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
                    return $.getJSON(<?= BASE_URL ?>+"ajax/ajax.php?action=get_companies", function(data) {
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
                        url: <?= BASE_URL ?>+"ajax/ajax.php?action=set_company",
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
<!--end::Body-->
</html>
