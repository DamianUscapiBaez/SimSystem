<?php 
  headerAdmin($data); 
?>
<div class="container-fluid">
    <div class="row mt-3">
        <div class="col-md-3 col-lg-3 col-xl-3">
            <div class="card mb-3 border-0">
                <div class="card-body text-blue d-flex justify-content-between">
                    <div class="box-icon box-blue">
                        <i class="fa fa-truck"></i>
                    </div>
                    <div class="box-text">
                        <h5 class="card-title">PROVEEDORES</h5>
                        <p class="card-text"><?= $data['proveedores']['total']?></p>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-md-3 col-lg-3 col-xl-3">
            <div class="card border-0 mb-3">
                <div class="card-body text-purple d-flex justify-content-between">
                    <div class="box-icon box-purple">
                        <i class="fa fa-users"></i>
                    </div>
                   <div class="box-text">
                        <h5 class="card-title">CLIENTES</h5>
                        <p class="card-text"><?= $data['clientes']['total']?></p>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-md-3 col-lg-3 col-xl-3"> 
            <div class="card border-0 mb-3">
                <div class="card-body text-green d-flex justify-content-between">
                    <div class="box-icon box-green">
                        <i class="fas fa-shapes"></i>
                    </div>
                    <div class="box-text">
                        <h5 class="card-title">CATEGORIAS</h5>
                        <p class="card-text"><?= $data['categorias']['total']?></p>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-md-3 col-lg-3 col-xl-3">
            <div class="card border-0 mb-3">
                <div class="card-body text-red d-flex justify-content-between">
                    <div class="box-icon box-red">
                        <i class="fas fa-box"></i>
                    </div>
                    <div class="box-text">
                        <h5 class="card-title">PRODUCTOS</h5>
                        <p class="card-text"><?= $data['productos']['total']?></p>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="row mt-3">
        <div class="col-md-6">
            <div class="card text-bg-white mb-3">
                <div class="card-header text-center">Productos con minimo stock</div>
                <div class="card-body">
                    <!-- <div class="table-responsive">
                        <table class="table text-center">
                            <thead>
                                <tr>
                                    <th scope="col">#</th>
                                    <th scope="col">Productos</th>
                                    <th scope="col">Cantidad</th>
                                </tr>
                            </thead>
                            <tbody id="productos">
                            </tbody>
                        </table>
                    </div> -->
                    <canvas id="stockMinimo" style="min-height: 250px; height: 250px; max-height: 250px; max-width: 100%;"></canvas>
                </div>
            </div>
        </div>
        <div class="col-md-6">
            <div class="card text-bg-white mb-3">
                <div class="card-header text-center">Productos con mas salidas</div>
                <div class="card-body">
                    <!-- <div class="table-responsive">
                        <table class="table text-center">
                            <thead>
                                <tr>
                                    <th scope="col">#</th>
                                    <th scope="col">Productos</th>
                                    <th scope="col">Cantidad</th>
                                </tr>
                            </thead>
                            <tbody id="productosSalidas">
                            </tbody>
                        </table>
                    </div> -->
                    <canvas id="productoSalidas" style="min-height: 250px; height: 250px; max-height: 250px; max-width: 100%; display: block; width: 488px;"></canvas>
                </div>
            </div>
        </div>
    </div>
</div>
<?php footerAdmin($data); ?>