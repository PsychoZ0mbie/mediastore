<?php headerAdmin($data)?>

<div class="body flex-grow-1 px-3" id="<?=$data['page_name']?>">
    <div id="modalItem">
        <div class="modal fade d-none" id="modalElement">
            <div class="modal-dialog modal-dialog-centered modal-xl">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="staticBackdropLabel">Nuevo producto</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <form id="formFile" name="formFile">
                            <div class="row scrolly" id="upload-multiple">
                                <div class="col-md-3">
                                    <div class="mb-3 upload-images">
                                        <label for="txtImg" class="text-primary text-center d-flex justify-content-center align-items-center">
                                            <div>
                                                <i class="far fa-images fs-1"></i>
                                                <p class="m-0">Subir imágen</p>
                                            </div>
                                        </label>
                                        <input class="d-none" type="file" id="txtImg" name="txtImg[]" multiple accept="image/*"> 
                                    </div>
                                </div>
                            </div>
                        </form>
                        <form id="formItem" name="formItem" class="mb-4">  
                            <input type="hidden" id="idProduct" name="idProduct" value="">
                            <div class="row">
                                <div class="col-md-6">
                                    <div class="mb-3">
                                        <label for="txtReference" class="form-label">Referencia</label>
                                        <input type="text" class="form-control" id="txtReference" name="txtReference" placeholder="SKU">
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="mb-3">
                                        <label for="txtName" class="form-label">Nombre <span class="text-danger">*</span></label>
                                        <input type="text" class="form-control" id="txtName" name="txtName" required>
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-6">
                                    <div class="mb-3">
                                        <label for="categoryList" class="form-label">Categoría <span class="text-danger">*</span></label>
                                        <select class="form-control" aria-label="Default select example" id="categoryList" name="categoryList" required></select>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="mb-3">
                                        <label for="subcategoryList" class="form-label">SubCategoría <span class="text-danger">*</span></label>
                                        <select class="form-control" aria-label="Default select example" id="subcategoryList" name="subcategoryList" required></select>
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-6">
                                    <div class="mb-3">
                                        <label for="txtDiscount" class="form-label">Descuento</label>
                                        <input type="number" class="form-control"  max="99" id="txtDiscount" name="txtDiscount">
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="mb-3">
                                        <label for="txtPrice" class="form-label">Precio <span class="text-danger">*</span></label>
                                        <input type="number" class="form-control" min ="1" id="txtPrice" name="txtPrice">
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-6">
                                    <div class="mb-3">
                                        <label for="txtStock" class="form-label">Cantidad <span class="text-danger">*</span></label>
                                        <input type="number" value="1" min="0" class="form-control" id="txtStock" name="txtStock">
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="mb-3">
                                        <label for="statusList" class="form-label">Estado <span class="text-danger">*</span></label>
                                        <select class="form-control" aria-label="Default select example" id="statusList" name="statusList" required>
                                            <option value="1">Activo</option>
                                            <option value="2">Inactivo</option>
                                        </select>
                                    </div>
                                </div>
                            </div>
                            <div class="mb-3">
                                <label for="txtDescription" class="form-label">Descripción</label>
                                <textarea class="form-control" id="txtDescription" name="txtDescription" rows="5"></textarea>
                            </div>
                            <div class="modal-footer">
                                <button type="submit" class="btn btn-primary" id="btnAdd"><i class="fas fa-plus-circle"></i> Agregar</button>
                                <button type="button" class="btn btn-secondary text-white" data-bs-dismiss="modal">Cerrar</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="container-lg">
        <div class="card">
            <div class="card-body">
                <div class="row">
                    <div class="col-md-12 mt-3">
                        <input class="form-control" type="search" placeholder="buscar" aria-label="Search" id="search" name="search">
                    </div>
                </div>
                <div class="scroll-y">
                    <table class="table text-center items align-middle">
                        <thead>
                            <tr>
                                <th>Portada</th>
                                <th>Referencia</th>
                                <th>Nombre</th>
                                <th>Precio</th>
                                <th>Descuento</th>
                                <th>Fecha de registro</th>
                                <th>Estado</th>
                                <th>Acciones</th>
                            </tr>
                        </thead>
                        <tbody id="listItem">
                            
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>
<?php footerAdmin($data)?>        