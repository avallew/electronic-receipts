<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
</head>

<body>
    <div class="">
        <table class="w-100">
            <tbody>
                <tr>
                    <td class="text-center">
                        <div class="left">
                            <div class="text-left logo">
                                <img src="{{ env('URL_IMAGE') }}" alt="" class="box1" />
                            </div>
                            <div class="company px-3">
                                <h2 class="m-0 text-left">{{ $data->infoTributaria->razonSocial }}</h2>
                                <h3 class="m-0 text-left">{{ $data->infoTributaria->nombreComercial }}</h3>
                                <h3 class="m-0 text-left">{{ $data->infoTributaria->ruc }}</h3>
                                <br>
                                <div class="w-100 text-left">
                                    <p class="left-bold-text m-0">Direc. Matriz:</p>
                                    <p class="m-0">{{ $data->infoTributaria->dirMatriz }}</p>
                                </div>
                                <div class="w-100 text-left">
                                    <p class="left-bold-text m-0">Direc. Sucursal:</p>
                                    <p class="m-0">{{ $data->infoFactura->dirEstablecimiento }}</p>
                                </div>
                                <div class="w-100 text-left">
                                    <p class="left-bold-text inline m-0">Conctactos:</p>
                                    <div class="m-0">
                                        <?php if ($data->phone): ?>
                                        <p class="m-0 inline">{{ $data->phone }}</p>
                                        <?php endif;?>
                                        <br>
                                        <?php if ($data->email): ?>
                                        <p class="m-0 inline">{{ $data->email }}</p>
                                        <?php endif;?>
                                    </div>
                                </div>

                                <?php if ($data->slogan): ?>
                                <div class="w-100 text-left">
                                    <p class="left-bold-text inline m-0">Eslogan:</p>
                                    <div class="m-0">
                                        <p class="m-0 inline">{{ $data->slogan }}</p>
                                    </div>
                                </div>
                                <?php endif;?>

                                <div class="w-100 text-left">
                                    <p class="left-bold-text m-0">
                                        Obligado a llevar contabilidad:
                                        {{ $data->infoFactura->obligadoContabilidad }}
                                    </p>
                                </div>
                                <?php if (isset($data->infoTributaria->agenteRetencion)): ?>
                                <div class="w-100 text-left">
                                    <p class="left-bold-text m-0">
                                        Agente de Retención No.
                                        {{ $data->infoTributaria->agenteRetencion }}
                                    </p>

                                </div>
                                <?php endif;?>

                                <?php if (isset($data->infoTributaria->contribuyenteRimpe)): ?>
                                <div class="w-100 text-left">
                                    <p class="left-bold-text m-0">{{ $data->infoTributaria->contribuyenteRimpe }}</p>
                                </div>
                                <?php endif;?>
                            </div>
                        </div>
                    </td>
                    <td>
                        <div class="rigth text-right">
                            <h1 class="m-0">FACTURA</h1>
                            <div class="text-right w-100">
                                <p class="m-0 inline mr-3">No.</p>
                                <h3 class="m-0 text-red-bold inline">
                                    {{ $data->infoTributaria->estab }}-{{ $data->infoTributaria->ptoEmi }}-{{ $data->infoTributaria->secuencial }}
                                </h3>
                            </div>
                            <div class="text-right w-100">
                                <p class="m-0 inline mr-3">Fecha y hora de emisión:</p>
                                <p class="m-0 inline">{{ $data->infoFactura->fechaEmision }}</p>
                            </div>
                            <div class="divider"></div>
                            <div class="right-detail text-left px-3">
                                <h4 class="m-0 semi-bold">NÚMERO DE AUTORIZACIÓN</h4>
                                <p class="m-0">
                                    {{ $data->infoTributaria->claveAcceso }}
                                </p>
                                <div class="w-100 text-left">
                                    <h4 class="m-0 semi-bold inline">AMBIENTE</h4>
                                    <?php if ($data->infoTributaria->ambiente == "1"): ?>
                                    <p class="ml-3 inline">PRUEBAS</p>
                                    <?php else:?>
                                    <p class="ml-3 inline">PRODUCCIÓN</p>
                                    <?php endif;?>
                                </div>
                                <div class="w-100 text-left">
                                    <h4 class="m-0 semi-bold inline">EMISIÓN</h4>
                                    <p class="ml-3 semi-bold inline">NORMAL</p>
                                </div>
                                <div class="mt-3">
                                    {!! DNS1D::getBarcodeHTML($data->infoTributaria->claveAcceso, 'C128', 2, 100) !!}
                                </div>
                                <div class="text-center">
                                    <p>{{ $data->infoTributaria->claveAcceso }}</p>
                                </div>
                            </div>
                            <?php if (isset($data->urlWeb)):?>
                            <div class="divider"></div>
                            <div class="w-100 text-center">
                                <p class="m-0">**Visitanos en: <span
                                        class="m-0 semi-bold">{{ $data->urlWeb }}</span>**</p>
                            </div>
                            <?php endif;?>
                        </div>
                    </td>
                </tr>
            </tbody>
        </table>
        <table class="w-100 border">
            <tbody>
                <tr>
                    <td class="w-min">
                        <p class="m-0 inline">Razon social/Nombre y Apellidos</p>
                    </td>
                    <td class="w-80">
                        <p class="ml-3 inline">{{ $data->infoFactura->razonSocialComprador }}</p>
                    </td>
                </tr>
                <tr>
                    <td class="w-min">
                        <p class="m-0 inline">Identificacion:</p>
                    </td>
                    <td class="w-80">
                        <p class="ml-3 inline">{{ $data->infoFactura->identificacionComprador }}</p>
                    </td>
                </tr>
                <tr>
                    <td class="w-min">
                        <p class="m-0 inline">Fecha Emision:</p>
                    </td>
                    <td class="w-80">
                        <p class="ml-3 inline">{{ $data->infoFactura->fechaEmision }}</p>
                    </td>
                </tr>
                <tr>
                    <td class="w-min">
                        <p class="m-0 inline">Direccion:</p>
                    </td>
                    <td class="w-80">
                        <p class="ml-3 inline">{{ $data->infoFactura->direccionComprador }}</p>
                    </td>
                </tr>
            </tbody>
        </table>
        <div class="product-description w-100">
            <table class="w-100">
                <thead>
                    <tr>
                        <th class="semi-bold border-square">Codigo Principal</th>
                        <th class="semi-bold border-square">Cantidad</th>
                        <th class="semi-bold w-50 border-square">Descripción</th>
                        <th class="semi-bold border-square">Precio unitario</th>
                        <th class="semi-bold border-square">Descuento</th>
                        <th class="semi-bold border-square">Precio tota</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($data->detalles as $detalle): ?>
                    <tr>
                        <td>{{ $detalle->codigoPrincipal }}</td>
                        <td>{{ $detalle->cantidad }}</td>
                        <td>{{ $detalle->descripcion }}</td>
                        <td>{{ $detalle->precioUnitario }}</td>
                        <td>{{ $detalle->descuento }}</td>
                        <td>{{ $detalle->precioTotalSinImpuesto }}</td>
                    </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
        </div>
        <table class="w-100 mt-3">
            <tr>
                <td class="extra-info border w-80">
                    <table class="w-100">
                        <tr>
                            <td>
                                <p class="m-0 semi-bold underline">Informacion adicional</p>
                            </td>
                        </tr>
                        <?php foreach ($data->infoAdicional as $adicional): ?>
                        <tr>
                            <td>{{ $adicional->nombre }}</td>
                            <td>{{ $adicional->value }}</td>
                        </tr>
                        <?php endforeach; ?>
                    </table>
                </td>
                <td class="price">
                    <table class="w-100 m-0">
                        <tbody>
                            <tr>
                                <td>SUBTOTAL 12%</td>
                                <td>{{ $data->infoFactura->totalConImpuestos[0]->baseImponible }}</td>
                            </tr>
                            <tr>
                                <td>IVA 12%</td>
                                <td>{{ $data->infoFactura->totalConImpuestos[0]->valor }}</td>
                            </tr>
                            <tr>
                                <td>Subtotal sin impuestos</td>
                                <td>{{ $data->infoFactura->totalSinImpuestos }}</td>
                            </tr>
                            <tr>
                                <td>Descuento</td>
                                <td>{{ $data->infoFactura->totalDescuento }}</td>
                            </tr>
                            <tr>
                                <td>Valor Total</td>
                                <td>{{ $data->infoFactura->importeTotal }}</td>
                            </tr>
                        </tbody>
                    </table>
                </td>
            </tr>
        </table>
        <table class="payment-method w-50">
            <tr>
                <td class="w-80 text-center semi-bold">Forma de pago</td>
                <td class="text-center semi-bold">Valor</td>
            </tr>
            <?php foreach ($data->infoFactura->pagos as $pago): ?>
            <tr>
                <td class="w-80">{{ $pago->formaPago }}</td>
                <td class="text-right">{{ $pago->total }}</td>
            </tr>
            <?php endforeach; ?>

        </table>
    </div>
    <style>
        .border {
            border-radius: 5px;
            border: 1px solid black;
        }

        .w-min {
            width: min-content;
        }

        .w-80 {
            width: 80%;
        }

        .w-20 {
            width: 20%;
        }

        .w-50 {
            width: 50%;
        }

        .border-square {
            border: 1px solid black;
        }

        .w-100 {
            width: 100%;
        }

        .inline {
            display: inline;
        }

        .text-red-bold {
            color: red;
            font-weight: 600;
        }

        .text-left {
            text-align: left;
        }

        .product-description table {
            border-collapse: collapse;
            margin-top: 15px;
        }

        .product-description tr td {
            white-space: nowrap;
            border: 1px solid black;
        }

        .price table {
            border-collapse: collapse;
            margin-top: 15px;
        }

        .price tr td {
            white-space: nowrap;
            border: 1px solid black;
        }

        .payment-method {
            border-collapse: collapse;
            margin-top: 15px;
        }

        .payment-method tr td {
            white-space: nowrap;
            border: 1px solid black;
        }

        .text-right {
            text-align: right;
        }

        .text-center {
            text-align: center;
        }

        .divider {
            height: 1px;
            border-bottom: 1px solid black;
        }

        .semi-bold {
            font-weight: 600;
        }

        .underline {
            text-decoration: underline;
        }

        .ml-3 {
            margin-left: 16px;
        }

        .mt-3 {
            margin-top: 16px;
        }

        .mr-3 {
            margin-right: 16px !important;
        }

        .px-3 {
            padding-left: 10px;
            padding-right: 10px;
        }

        .left-bold-text {
            text-align: left;
            font-weight: 600;
        }

        .company {
            text-align: center;
        }

        .company-detail .left {
            text-align: center;
            width: 50%;
        }

        .company-detail .rigth {
            width: 50%;
        }

        .m-0 {
            margin: 0 !important;
        }

        .p-0 {
            padding: 0;
        }

        .box1 {
            width: 400px;
            height: 200px;
        }

        .price {
            vertical-align: top !important;
        }

        .h-bar-code {
            height: 70px;
        }
    </style>
</body>

</html>
