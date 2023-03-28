<?php require_once '../../config.php';?>

<?php require_once APPRAIZ . '/view/template/header.inc'; ?>

<?php $db = new Conexao(); ?>
<!-- start page title -->
<div class="row">
    <div class="col-12">
        <div class="page-title-box d-flex align-items-center justify-content-between">
            <h4 class="mb-0 font-size-18">Dashboard</h4>
        </div>
    </div>
</div>
<!-- end page title -->

<div class="row">
    <div class="col-xl-4 col-md-6">
        <div class="card">
            <div class="card-body">
                <i class="bx bx-layer float-right m-0 h2 text-muted"></i>
                <h6 class="text-muted text-uppercase mt-0">Entidades Mantenedoras</h6>
                <h3 class="mb-3" data-plugin="counterup">
                    <?php echo $db->pegaUm('SELECT COUNT(*) from fbb_sistema.tbl_entidade where st_entidade = 1') ?>
                </h3>
            </div>
        </div>
    </div>

    <div class="col-xl-4 col-md-6">
        <div class="card">
            <div class="card-body">
                <i class="bx bx-layer float-right m-0 h2 text-muted"></i>
                <h6 class="text-muted text-uppercase mt-0">Cisternas</h6>
                <h3 class="mb-3"><span data-plugin="counterup">
 <?php echo $db->pegaUm('SELECT COUNT(*) from fbb_sistema.tbl_cisterna where st_cisterna = 1') ?>
                    </span></h3>
            </div>
        </div>
    </div>

    <div class="col-xl-4 col-md-6">
        <div class="card">
            <div class="card-body">
                <i class="bx bx-bx bx-layer float-right m-0 h2 text-muted"></i>
                <h6 class="text-muted text-uppercase mt-0">Países</h6>
                <h3 class="mb-3"><span data-plugin="counterup">
                        <?php
                        echo $db->pegaUm('SELECT
                                                COUNT(*)
                                            FROM
                                                (
                                                    SELECT
                                                        fk_id_pais AS total
                                                    FROM
                                                        fbb_sistema.tbl_cisterna
                                                    WHERE
                                                        st_cisterna = 1
                                                    GROUP BY
                                                        fk_id_pais ) AS foo')
                        ?>
                    </span></h3>
            </div>
        </div>
    </div>

</div>
<!-- end row -->

<div class="row">

    <div class="col-lg-12">
        <div class="card">
            <div class="card-body">
                <h4 class="card-title d-inline-block">Total de Cisternas cadastradas por data</h4>
                <div id="morris-line-example" class="morris-chart" style="height: 260px;"></div>
            </div>
        </div>
    </div> <!-- end col -->
</div>
<!-- end row-->

<?php include APPRAIZ . '/view/template/footer.inc'; ?>

</body>
</html>
