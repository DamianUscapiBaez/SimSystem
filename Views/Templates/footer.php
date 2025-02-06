<div class="footer_part">
    <div class="container-fluid">
        <div class="row">
            <div class="col-lg-12">
                <div class="footer_iner text-center">
                    <p>
                        2022 creado por Sim System
                        <!-- <a href="#"> <i class="ti-heart"></i> </a> -->
                        <!-- <a href="#">Dashboard</a> -->
                    </p>
                </div>
            </div>
        </div>
    </div>
</div>
</section>
<script>
    function mostrarHora() {
        const elementoHora = document.getElementById('hora');

        function actualizarHora() {
            const ahora = new Date();
            const hora = ahora.getHours().toString().padStart(2, '0');
            const minutos = ahora.getMinutes().toString().padStart(2, '0');
            const segundos = ahora.getSeconds().toString().padStart(2, '0');

            const horaActual = `${hora}:${minutos}:${segundos}`;
            elementoHora.textContent = horaActual;
        }

        // Actualizar la hora cada segundo
        setInterval(actualizarHora, 1000);

        // Mostrar la hora inicial
        actualizarHora();
    }

    // Iniciar la función cuando la página se cargue
    document.addEventListener('DOMContentLoaded', mostrarHora);
</script>

<script src="<?= medias() ?>/plantilla/js/jquery1-3.4.1.min.js"></script>

<script src="<?= medias() ?>/plantilla/js/popper1.min.js"></script>

<script src="<?= medias() ?>/plantilla/js/bootstrap1.min.js"></script>

<script src="<?= medias() ?>/plantilla/js/metisMenu.js"></script>

<script src="<?= medias() ?>/plantilla/vendors/count_up/jquery.waypoints.min.js"></script>

<script src="<?= medias() ?>/plantilla/vendors/chartlist/Chart.min.js"></script>

<script src="<?= medias() ?>/plantilla/vendors/count_up/jquery.counterup.min.js"></script>

<script src="<?= medias() ?>/plantilla/vendors/niceselect/js/jquery.nice-select.min.js"></script>

<script src="<?= medias() ?>/plantilla/vendors/owl_carousel/js/owl.carousel.min.js"></script>

<script src="<?= medias() ?>/plantilla/vendors/datatable/js/jquery.dataTables.min.js"></script>
<script src="<?= medias() ?>/plantilla/vendors/datatable/js/dataTables.responsive.min.js"></script>
<script src="<?= medias() ?>/plantilla/vendors/datatable/js/dataTables.buttons.min.js"></script>
<script src="<?= medias() ?>/plantilla/vendors/datatable/js/buttons.flash.min.js"></script>
<script src="<?= medias() ?>/plantilla/vendors/datatable/js/jszip.min.js"></script>
<script src="<?= medias() ?>/plantilla/vendors/datatable/js/pdfmake.min.js"></script>
<script src="<?= medias() ?>/plantilla/vendors/datatable/js/vfs_fonts.js"></script>
<script src="<?= medias() ?>/plantilla/vendors/datatable/js/buttons.html5.min.js"></script>
<script src="<?= medias() ?>/plantilla/vendors/datatable/js/buttons.print.min.js"></script>

<script src="<?= medias() ?>/plantilla/vendors/datepicker/datepicker.js"></script>
<script src="<?= medias() ?>/plantilla/vendors/datepicker/datepicker.en.js"></script>
<script src="<?= medias() ?>/plantilla/vendors/datepicker/datepicker.custom.js"></script>
<script src="<?= medias() ?>/plantilla/js/chart.min.js"></script>
<script src="<?= medias() ?>/plantilla/vendors/chartjs/roundedBar.min.js"></script>

<script src="<?= medias() ?>/plantilla/vendors/progressbar/jquery.barfiller.js"></script>

<script src="<?= medias() ?>/plantilla/vendors/tagsinput/tagsinput.js"></script>

<script src="<?= medias() ?>/plantilla/vendors/text_editor/summernote-bs4.js"></script>
<script src="<?= medias() ?>/plantilla/vendors/am_chart/amcharts.js"></script>

<script src="<?= medias() ?>/plantilla/vendors/scroll/perfect-scrollbar.min.js"></script>
<script src="<?= medias() ?>/plantilla/vendors/scroll/scrollable-custom.js"></script>

<!-- <script src="<?= medias() ?>/plantilla/vendors/vectormap-home/vectormap-2.0.2.min.js"></script>
  <script src="<?= medias() ?>/plantilla/vendors/vectormap-home/vectormap-world-mill-en.js"></script> -->

<script src="<?= medias() ?>/plantilla/vendors/apex_chart/apex-chart2.js"></script>
<script src="<?= medias() ?>/plantilla/vendors/apex_chart/apex_dashboard.js"></script>

<script src="<?= medias() ?>/plantilla/vendors/chart_am/core.js"></script>
<script src="<?= medias() ?>/plantilla/vendors/chart_am/charts.js"></script>
<script src="<?= medias() ?>/plantilla/vendors/chart_am/animated.js"></script>
<script src="<?= medias() ?>/plantilla/vendors/chart_am/kelly.js"></script>
<script src="<?= medias() ?>/plantilla/vendors/chart_am/chart-custom.js"></script>

<!-- <script src="<?= medias() ?>/plantilla/js/dashboard_init.js"></script> -->
<script src="<?= medias() ?>/plantilla/js/custom.js"></script>
<!-- <script src="<?= media() ?>/libs/js/jquery.min.js"></script>
    <script src="<?= media() ?>/libs/js/popper.min.js"></script>
    <script src="<?= media() ?>/libs/js/bootstrap.min.js"></script> -->
<!-- apps -->
<script>
    const base_url = "<?= base_url(); ?>";
</script>
<!--This page JavaScript -->
<!-- <script src="<?= media() ?>/dist/js/dashboard1.min.js"></script> -->
<!-- <script src="<?= media(); ?>/libs/js/jquery.dataTables.js"></script>
    <script src="<?= media() ?>/libs/js/dataTables.bootstrap.min.js"></script> -->
<script src="<?= media(); ?>/libs/js/sweetalert.min.js"></script>
<!-- <script src="<?= media(); ?>/libs/js/bootstrap-select.min.js"></script> -->
<script src="<?= media(); ?>/libs/js/JsBarcode.all.min.js"></script>
<!-- <script src="<?= media(); ?>/libs/js/quagga.min.js"></script> -->

<!-- <script type="text/javascript" language="javascript" src="<?= media(); ?>/libs/js/dataTables.buttons.min.js"></script>
    <script type="text/javascript" language="javascript" src="<?= media(); ?>/libs/js/jszip.min.js"></script>
    <script type="text/javascript" language="javascript" src="<?= media(); ?>/libs/js/pdfmake.min.js"></script>
    <script type="text/javascript" language="javascript" src="<?= media(); ?>/libs/js/vfs_fonts.js"></script>
    <script type="text/javascript" language="javascript" src="<?= media(); ?>/libs/js/buttons.html5.min.js"></script>
    <script type="text/javascript" language="javascript" src="<?= media(); ?>/libs/js/fontawesome.js"></script>
    <script type="text/javascript" language="javascript" src="<?= media(); ?>/libs/js/chart.min.js"></script> -->
<script type="text/javascript" src="<?= media() ?>/js/functions/<?= $data["page_functions_js"]; ?>"></script>
</body>

</html>