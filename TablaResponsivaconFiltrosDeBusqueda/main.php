<?php

?>

<div id="frmArea">
    <h2 class="mb-4">Captura</h2>

    <div class="row mb-3">
        <div class="col-12 text-end">
            <button type="button" class="btn" style="background-color: #E74C3C; border-color: #E74C3C; color: white;"
                onclick="location.href='index.php';">
                <i class="fas fa-arrow-circle-left"></i> Regresar
            </button>
            <button type="button" class="btn" style="background-color: #009475; border-color: #009475; color: white;"
                onclick="">
                <i class="fas fa-plus-circle"></i> Agregar Calificación
            </button>
            <button type="button" class="btn btn-primary"
                onclick="">
                <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-table" viewBox="0 0 16 16">
                    <path d="M0 2a2 2 0 0 1 2-2h12a2 2 0 0 1 2 2v12a2 2 0 0 1-2 2H2a2 2 0 0 1-2-2zm15 2h-4v3h4zm0 4h-4v3h4zm0 4h-4v3h3a1 1 0 0 0 1-1zm-5 3v-3H6v3zm-5 0v-3H1v2a1 1 0 0 0 1 1zm-4-4h4V8H1zm0-4h4V4H1zm5-3v3h4V4zm4 4H6v3h4z" />
                </svg> Importar Archivo
            </button>
        </div>
    </div>

    <table class="table table-hover table-responsive table-striped" id="tableCaptura">
        <thead>
            <tr class="table-dark text-center">
                <th>Numero de Control</th>
                <th>Nombre del Alumno</th>
                <th>Parcial</th>
                <th>Semestre</th>
                <th>Clave de Materia</th>
                <th>Nombre de Materia</th>
                <th>Unidad</th>
                <th>Horario</th>
                <th>Calificación</th>
                <th>Estado</th>
                <th>Opciones</th>
            </tr>
            <tr>
                <th><input type="text" placeholder="Buscar..." class="form-control form-control-sm"></th>
                <th><input type="text" placeholder="Buscar..." class="form-control form-control-sm"></th>
                <th><input type="text" placeholder="Buscar..." class="form-control form-control-sm"></th>
                <th><input type="text" placeholder="Buscar..." class="form-control form-control-sm"></th>
                <th><input type="text" placeholder="Buscar..." class="form-control form-control-sm"></th>
                <th><input type="text" placeholder="Buscar..." class="form-control form-control-sm"></th>
                <th><input type="text" placeholder="Buscar..." class="form-control form-control-sm"></th>
                <th><input type="text" placeholder="Buscar..." class="form-control form-control-sm"></th>
                <th><input type="text" placeholder="Buscar..." class="form-control form-control-sm"></th>
                <th><input type="text" placeholder="Buscar..." class="form-control form-control-sm"></th>
                <th></th>
            </tr>
        </thead>
        <tbody class="">

            <tr class="text-center">
                <td>123456789</td>
                <td>Jose Manuel Luigu</td>
                <td>Primero</td>
                <td>6</td>
                <td>KOA-2019</td>
                <td>Taller de VideoJuegos</td>
                <td>5</td>
                <td>3</td>
                <td>90.00</td>
                <td><span class="badge bg-success">Abierto</span></td>

                <td>
                    <div class="d-flex gap-2 justify-content-center">
                        <?php //if ($fila['estado'] === 'Abierto' || $fila['estado'] === 'Cerrado') : 
                        ?>
                        <button class="btn btn-primary btn-sm d-flex align-items-center"
                            onclick="">
                            <i class="fas fa-edit me-1"></i>
                            <span>Editar</span>
                        </button>
                        <?php //else :
                        ?>
                        <!--dsd
                                <button class="btn btn-primary btn-sm d-flex align-items-center" title="No editable"
                                    disabled>
                                    <i class="fas fa-edit me-1"></i>
                                    <span>Editar</span>
                                </button>-->
                        <?php //endif; 
                        ?>
                        <label>
                            <select class="form-select form-select-sm btn-warning"
                                style="width: auto; color: #212529; background-color: #ffc107; border-color: #ffc107;"
                                onchange="changeStatusCaptura('123456789', this.value, 'Abierto')">
                                <option value="" disabled selected>Cambiar estado</option>
                                <option value="Abierto">Abierto</option>
                                <option value="Cerrado">Cerrado</option>

                            </select>
                        </label>
                    </div>
                </td>
            </tr>
            <tr>
                <td>123456789</td>
                <td>Jose Manuel Luigu</td>
                <td>Primero</td>
                <td>3</td>
                <td>AEB-1011</td>
                <td>Algebra Lineal</td>
                <td>3</td>
                <td>12</td>
                <td>92.00</td>
                <td><span class="badge bg-success">Abierto</span></td>
                <td>
                    <div class="d-flex gap-2 justify-content-center">
                        <?php //if ($fila['estado'] === 'Abierto' || $fila['estado'] === 'Cerrado') : 
                        ?>
                        <button class="btn btn-primary btn-sm d-flex align-items-center"
                            onclick="">
                            <i class="fas fa-edit me-1"></i>
                            <span>Editar</span>
                        </button>
                        <?php //else :
                        ?>
                        <!--dsd
                                <button class="btn btn-primary btn-sm d-flex align-items-center" title="No editable"
                                    disabled>
                                    <i class="fas fa-edit me-1"></i>
                                    <span>Editar</span>
                                </button>-->
                        <?php //endif; 
                        ?>
                        <label>
                            <select class="form-select form-select-sm btn-warning"
                                style="width: auto; color: #212529; background-color: #ffc107; border-color: #ffc107;"
                                onchange="changeStatusCaptura('123456789', this.value, 'Abierto')">
                                <option value="" disabled selected>Cambiar estado</option>
                                <option value="Abierto">Abierto</option>
                                <option value="Cerrado">Cerrado</option>

                            </select>
                        </label>
                    </div>
                </td>
            </tr>

            <tr>
                <td>210115087</td>
                <td>Delfina Lopez</td>
                <td>Primero</td>
                <td>5</td>
                <td>OAK-1923</td>
                <td>Progrmacion orientada a objetos</td>
                <td>1</td>
                <td>8</td>
                <td>89.00</td>
                <td><span class="badge bg-danger">Cerrado</span></td>
                <td>
                    <div class="d-flex gap-2 justify-content-center">
                        <?php //if ($fila['estado'] === 'Abierto' || $fila['estado'] === 'Cerrado') : 
                        ?>
                        <!--dsd
                        <button class="btn btn-primary btn-sm d-flex align-items-center"
                            onclick="">
                            <i class="fas fa-edit me-1"></i>
                            <span>Editar</span>
                        </button>-->
                        <?php //else :
                        ?>

                        <button class="btn btn-primary btn-sm d-flex align-items-center" title="No editable"
                            disabled>
                            <i class="fas fa-edit me-1"></i>
                            <span>Editar</span>
                        </button>
                        <?php //endif; 
                        ?>
                        <label>
                            <select class="form-select form-select-sm btn-warning"
                                style="width: auto; color: #212529; background-color: #ffc107; border-color: #ffc107;"
                                onchange="changeStatusCaptura('210115087', this.value, 'Cerrado')">
                                <option value="" disabled selected>Cambiar estado</option>
                                <option value="Abierto">Abierto</option>
                                <option value="Cerrado">Cerrado</option>

                            </select>
                        </label>
                    </div>
                </td>
            </tr>
        </tbody>
    </table>
</div>
