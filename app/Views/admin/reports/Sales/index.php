<?= $this->extend('layout/main') ?>
<?= $this->section('title') ?>
Dashboard
<?= $this->endSection() ?>
<?= $this->section('content') ?>
<div class="row">
    <div class="col-4">
        <div class="card">
            <div class="card-body">
                <h4 class="card-title">Resumo Agrupado de 3 meses</h4>
                <div id="column_chart"
                     data-colors='["--vz-primary", "--vz-danger", "--vz-success"]'
                     class="apex-charts"
                     dir="ltr"></div>
            </div>
        </div>
    </div>
    <div class="col-8">
        <div class="card">
            <div class="card-body">
                <h4 class="card-title">Vendas dos Últimos 30 Dias</h4>
                <div id="column_chart_datalabel"
                     data-colors='["--vz-primary"]'
                     class="apex-charts"
                     dir="ltr"></div>
            </div>
        </div>
    </div>
</div>


        <script src="https://cdn.jsdelivr.net/npm/apexcharts"></script>

        <script>
            // Função genérica para puxar cores
            function getChartColorsArray(e){
                if(null!==document.getElementById(e)){
                    var t=document.getElementById(e).getAttribute("data-colors");
                    if(t){
                        t=JSON.parse(t);
                        return t.map(function(e){
                            var t=e.replace(" ","");
                            if(-1===t.indexOf(",")){
                                var r=getComputedStyle(document.documentElement).getPropertyValue(t);
                                return r||t;
                            }
                            var o=e.split(",");
                            return 2!=o.length?t:"rgba("+getComputedStyle(document.documentElement).getPropertyValue(o[0])+","+o[1]+")";
                        });
                    }
                }
                console.warn("data-colors Attribute not found on:",e);
                return [];
            }

            // =====================================================================
            // 📊 GRÁFICO 1 - Resumo Mensal (Vendas / Devoluções / Cupões)
            // =====================================================================
            const reportData = <?= json_encode($report) ?>;
            const monthNames = ["Jan", "Fev", "Mar", "Abr", "Mai", "Jun", "Jul", "Ago", "Set", "Out", "Nov", "Dez"];

            const categories = reportData.map(r => {
                const [year, month] = r.month.split('-');
                return `${monthNames[parseInt(month) - 1]} ${year}`;
            });
            const sales = reportData.map(r => parseFloat(r.total_sales));
            const returns = reportData.map(r => parseFloat(r.total_returns));
            const coupons = reportData.map(r => parseFloat(r.total_coupons));

            const columnChartColors = ['#0d6efd', '#dc3545', '#198754'];

            var optionsMonthly = {
                chart: {
                    height: 350,
                    type: "bar",
                    toolbar: { show: false },
                },
                plotOptions: {
                    bar: {
                        horizontal: false,
                        columnWidth: "55%",
                        endingShape: "rounded"
                    },
                },
                dataLabels: { enabled: false },
                stroke: { show: true, width: 2, colors: ["transparent"] },
                series: [
                    { name: "Vendas", data: sales },
                    { name: "Devoluções", data: returns },
                    { name: "Cupões", data: coupons },
                ],
                colors: columnChartColors,
                xaxis: { categories: categories },
                yaxis: { title: { text: "€ (Total mensal)" } },
                grid: { borderColor: "#f1f1f1" },
                fill: { opacity: 1 },
                tooltip: {
                    y: { formatter: function(val){ return "€ " + val.toFixed(2); } }
                }
            };

            new ApexCharts(document.querySelector("#column_chart"), optionsMonthly).render();


            // =====================================================================
            // 📈 GRÁFICO 2 - Vendas dos Últimos 30 Dias (com labels)
            // =====================================================================
            const recentSales = <?= json_encode($recentSales) ?>;

            const categoriesDaily = recentSales.map(r => {
                const d = new Date(r.date);
                const day = String(d.getDate()).padStart(2, '0');
                const month = monthNames[d.getMonth()];
                return `${day} ${month}`; // Ex: "05 Set"
            });
            const salesDaily = recentSales.map(r => parseFloat(r.total_sales));

            const columnChartDatalabelColors = ['#0d6efd'];

            const optionsDaily = {
                chart: {
                    height: 350,
                    type: "bar",
                    toolbar: { show: false }
                },
                plotOptions: {
                    bar: { dataLabels: { position: "top" } }
                },
                dataLabels: {
                    enabled: true,
                    formatter: val => "€ " + val.toFixed(2),
                    offsetY: -20,
                    style: {
                        fontSize: "12px",
                        colors: ["#304758"]
                    }
                },
                series: [{ name: "Vendas", data: salesDaily }],
                colors: columnChartDatalabelColors,
                xaxis: {
                    categories: categoriesDaily,
                    labels: { rotate: -45 },
                },
                yaxis: {
                    title: { text: "€ (Total de Vendas)" }
                },
                grid: { borderColor: "#f1f1f1" },
                fill: {
                    gradient: {
                        shade: "light",
                        type: "horizontal",
                        shadeIntensity: .25,
                        opacityFrom: 1,
                        opacityTo: 1,
                        stops: [50, 0, 100, 100]
                    }
                }
            };

            new ApexCharts(document.querySelector("#column_chart_datalabel"), optionsDaily).render();

        </script>



    </div> <!-- end col -->
</div> <!-- end row -->
<?= $this->endSection() ?>
