<?php session_start(); $rol = $_SESSION['rol']; ?>

<!-- jQuery -->
<script src="https://code.jquery.com/jquery-3.6.0.min.js" integrity="sha256-/xUj+3OJU5yExlq6GSYGSHk7tPXikynS7ogEvDej/m4=" crossorigin="anonymous"></script>
<script src="https://code.jquery.com/ui/1.13.0/jquery-ui.js"></script>

<!-- Bootstrap -->
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-MrcW6ZMFYlzcLA8Nl+NtUVF0sA7MsXsP1UyJoMp4YLEuNSfAP+JcXn/tWtIaxVXM" crossorigin="anonymous"></script>

<!-- Chart -->
<script src="https://cdnjs.cloudflare.com/ajax/libs/Chart.js/3.5.1/chart.min.js" integrity="sha512-Wt1bJGtlnMtGP0dqNFH1xlkLBNpEodaiQ8ZN5JLA5wpc1sUlk/O5uuOMNgvzddzkpvZ9GLyYNa8w2s7rqiTk5Q==" crossorigin="anonymous" referrerpolicy="no-referrer"></script>

<!-- dataTables -->
<script type="text/javascript" charset="utf8" src="https://cdn.datatables.net/1.11.3/js/jquery.dataTables.min.js"></script>
<script type="text/javascript" charset="utf8" src="https://cdn.datatables.net/responsive/2.2.9/js/dataTables.responsive.min.js"></script>
<script type="text/javascript" charset="utf8" src="https://cdn.datatables.net/searchpanes/1.4.0/js/dataTables.searchPanes.min.js"></script>
<script type="text/javascript" charset="utf8" src="https://cdn.datatables.net/select/1.3.3/js/dataTables.select.min.js"></script>
<script type="text/javascript" charset="utf8" src="https://cdn.datatables.net/buttons/2.1.0/js/dataTables.buttons.min.js"></script>
<script type="text/javascript" charset="utf8" src="https://cdnjs.cloudflare.com/ajax/libs/jszip/3.1.3/jszip.min.js"></script>
<script type="text/javascript" charset="utf8" src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.53/pdfmake.min.js"></script>
<script type="text/javascript" charset="utf8" src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.53/vfs_fonts.js"></script>
<script type="text/javascript" charset="utf8" src="https://cdn.datatables.net/buttons/2.1.0/js/buttons.html5.min.js"></script>
<script type="text/javascript" charset="utf8" src="https://cdn.datatables.net/buttons/2.1.0/js/buttons.print.min.js"></script>

<!-- App -->
<script type="text/javascript" src="/dist/js/script.js"></script>

<?php if ( $_SERVER['REQUEST_URI'] == '/' && $rol == 2 ) { ?>
    <script type="text/javascript" src="/dist/js/dashboardVendedor.js"></script>
<?php } ?>

<?php if ( $_SERVER['REQUEST_URI'] == '/usuarios/' ) { ?>
    <script type="text/javascript" src="/dist/js/usuarios.js"></script>
<?php } ?>

<?php if ( $_SERVER['REQUEST_URI'] == '/productos/' ) { ?>
    <script type="text/javascript" src="/dist/js/productos.js"></script>
<?php } ?>

<?php if ( $_SERVER['REQUEST_URI'] == '/eventos/' ) { ?>
    <script type="text/javascript" src="/dist/js/eventos.js"></script>
<?php } ?>

<?php
    $URL = strpos( $_SERVER['REQUEST_URI'], 'codigoEvento' );
    if ( $URL === false ) { } else { ?>
        <script type="text/javascript" src="/dist/js/evento.js"></script>
    <?php }
?>