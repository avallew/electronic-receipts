<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
</head>

<body>
    {{-- HEADER --}}
    <table class="w-100">
        <td class="w-50">
            <img src="{{ env('URL_IMAGE') }}" alt="" class="logo" />
        </td>
        <td class="w-50">
            <h1 class="text-right">NOTA DE DÉBITO</h1>
            <div class="text-right">
                <div class="w-100">
                    <p class="inline">No.</p>
                    <h2 class="inline text-brow ml-3">
                        {{ $data->infoTributaria->estab }}-{{ $data->infoTributaria->ptoEmi }}-{{ $data->infoTributaria->secuencial }}
                    </h2>
                </div>
                <div class="w-100">
                    <p class="inline semi-bold">Fecha y hora de emisión:</p>
                    <p class="inline ml-3">{{ $data->infoFactura->fechaEmision }}</p>
                </div>
            </div>
        </td>
    </table>
    <table class="w-100">
        <td class="w-50 td-align-top text-base">
            <h2 class="semi-bold">{{ $data->infoTributaria->razonSocial }}</h2>
            <h3 class="text-normal">{{ $data->infoTributaria->nombreComercial }}</h3>
            <h3 class="text-normal mb-2">{{ $data->infoTributaria->ruc }}</h3>
            <p class="semi-bold left-bold-text text-base mb-2">Direc. Matriz:</p>
            <p class="mb-2">
                {{ $data->infoTributaria->dirMatriz }}
            </p>
            <p class="semi-bold left-bold-text text-base mb-2">Direc. Sucursal:</p>
            <p class="mb-2">
                {{ $data->infoFactura->dirEstablecimiento }}
            </p>
            <p class="semi-bold left-bold-text text-base">Contactos:</p>
            <div class="text-base">
                <?php if ($data->phone): ?>
                <p class="text-base inline">{{ $data->phone }}</p>
                <?php endif;?>
                <br>
                <?php if ($data->email): ?>
                <p class="text-base inline">{{ $data->email }}</p>
                <?php endif;?>
            </div>
            <?php if ($data->slogan): ?>
            <div class="text-base w-100 text-left">
                <p class="text-base semi-bold left-bold-text inline m-0">Eslogan:</p>
                {{ $data->slogan }}
            </div>
            <?php endif;?>
            <p class="text-base semi-bold">Obligado a llevar contabilidad:
                {{ $data->infoFactura->obligadoContabilidad }}</p>
            <?php if (isset($data->infoTributaria->agenteRetencion)): ?>
            <p class="text-base semi-bold">Agente de Retención No. {{ $data->infoTributaria->agenteRetencion }}
            </p>
            <?php endif;?>
            <?php if (isset($data->infoTributaria->contribuyenteRimpe)): ?>
            <div class="text-base w-100 text-left">
                <p class="text-base left-bold-text m-0">{{ $data->infoTributaria->contribuyenteRimpe }}</p>
            </div>
            <?php endif;?>

        </td>
        <td class="w-50 td-align-top text-base">
            <div class="divider"></div>
            <h3 class="mt-3 ml-3">NÚMERO DE AUTORIZACIÓN</h3>
            <p class="ml-3">{{ $data->infoTributaria->claveAcceso }}</p>
            <table class="ml-3 p-0 mt-3 w-100">
                <tbody>
                    <tr class="mb-3">
                        <td class="w-50">
                            <p class="semi-bold text-left">AMBIENTE:</p>
                        </td>
                        <td class="w-50 text-left">
                            <?php if ($data->infoTributaria->ambiente == "1"): ?>
                            <p class="text-left text-left">PRUEBAS</p>
                            <?php else:?>
                            <p class="text-left text-left">PRODUCCIÓN</p>
                            <?php endif;?>
                        </td>
                    </tr>
                    <tr>
                        <td class="text-left">
                            <p class="semi-bold">EMISIÓN:</p>
                        </td>
                        <td class="">
                            <p class="semi-bold text-left">NORMAL</p>
                        </td>
                    </tr>
                </tbody>
            </table>
            <div class="mt-3 barra">
                {!! DNS1D::getBarcodeHTML($data->infoTributaria->claveAcceso, 'C128', 1.5, 90) !!}
            </div>
            <div class="ml-3">
                <p class="text-center mb-1">
                    {{ $data->infoTributaria->claveAcceso }}
                </p>
            </div>
            <?php if (isset($data->urlWeb)):?>
            <div class="divider"></div>
            <p class="text-center">
                **Visita nuestra tienda web:
                <span class="semi-bold">{{ $data->urlWeb }}</span> **
            </p>
            <?php endif;?>
        </td>
    </table>
    <div class="divider"></div>
    {{-- BODY --}}

    <table>
        <tr>
            <td class="w-70 text-base td-align-top">
                <p>
                <table>
                    <tr>
                        <td class="w-70 text-base td-align-top">
                            <p>
                                <span class="semi-bold">Razón Social / Nombres y Apellidos:</span>
                                {{ $data->infoNotaDebito->razonSocialComprador }}
                            </p>
                            <p>
                                <span
                                    class="semi-bold">Dirección:</span>{{ $data->infoNotaDebito->dirEstablecimiento }}
                            </p>
                            <p><span
                                    class="semi-bold">Identificación:</span>{{ $data->infoNotaDebito->identificacionComprador }}
                            </p>
                            <p><span class="semi-bold">Fecha
                                    Emisión:</span>{{ $data->infoNotaDebito->fechaEmisionDocSustento }}</p>
                            <p>
                                <span class="semi-bold">Comprobante que se modifica:</span>
                                {{ $data->infoNotaDebito->numDocModificado }}
                            </p>
                            <p>
                                <span class="semi-bold">Fecha de Emisión (Comprobante a
                                    modificar):</span>{{ $data->infoNotaDebito->fechaEmisionDocSustento }}
                            </p>
                        </td>
                    </tr>
                </table>
            </td>
        </tr>
    </table>

    <table class="table-details">
        <thead>
            <tr>
                <th>RAZÓN DE LA MODIFICACIÓN</th>
                <th>VALOR DE LA MODIFICACIÓN</th>
            </tr>
            <tr>
                <td colspan="6">
                    <div class="divider"></div>
                </td>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($data->motivos as $motivo): ?>
            <tr>
                <td class="semi-bold">{{ $motivo->razon }}</td>
                <td class="semi-bold">{{ $motivo->valor }}</td>
            </tr>
            <?php endforeach; ?>
        </tbody>
    </table>

    <table class="w-100">
        <td class="w-50">
            <table class="table-subdetails">
                <thead>
                    <tr>
                        <th class="text-base text-normal">Forma de pago</th>
                        <th class="text-base text-normal">Valor</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($data->infoNotaDebito->pagos as $pago): ?>
                    <tr>
                        <td class="semi-bold">{{ $pago->formaPago }}</td>
                        <td class="semi-bold">{{ $pago->total }}</td>
                    </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
            <?php foreach ($data->infoAdicional as $adicional): ?>
            <p class="text-base mt-3">{{ $adicional->nombre }}:</p>
            <p class="semi-bold">{{ $adicional->value }}</p>
            <?php endforeach; ?>
        </td>
        <td class="w-50 td-align-top text-right">
            <table class="w-100">

                <?php foreach ($data->infoNotaDebito->impuestos as $impuesto) {
                    
                }: ?>
                <?php endforeach; ?>
//TODO:DESDE AQUI
                <tr>
                    <td class="semi-bold">SUBTOTAL NO OBJETO DE IVA</td>

                    <?php foreach ($data->infoNotaDebito->impuestos as $impuesto):?>
                    <?php if ($impuesto->codigoPorcentaje=="6"):?>
                    <td>{{ $impuesto->baseImponible }}</td>
                    <?php else:?>
                    <td>0</td>
                    <?php endif;?>
                    <?php endforeach; ?>

                </tr>
                <tr>
                    <td class="semi-bold">SUBTOTAL 0%</td>
                    <td>{{ $data->infoNotaDebito->impuestos[0]->baseImponible }}</td>
                </tr>
                <tr>
                    <td class="semi-bold">IVA 12%</td>
                    <td>
                        <?php foreach ($data->infoNotaDebito->impuestos as $impuesto):{
                            if ($impuesto == "1")
                            $data->infoNotaDebito->impuestos[0]->valor;
                        }?>
                        <?php endforeach; ?>
                    </td>
                </tr>
                <tr>
                    <td class="semi-bold">Subtotal sin impuestos</td>
                    <td>{{ $data->infoNotaDebito->totalSinImpuestos }}</td>
                </tr>
                <tr>
                    <td class="semi-bold">Descuento</td>
                    <td>{{ $data->infoNotaDebito->totalDescuento }}</td>
                </tr>
                <tr>
                    <td class="semi-bold">Valor Total</td>
                    <td>{{ $data->infoNotaDebito->importeTotal }}</td>
                </tr>
            </table>
        </td>
    </table>




    {{-- END BODY --}}
    <table class="w-100 mb-1 mt-1">
        <tr>
            <td class="w-70 text-base">
                <p>
                    <span class="semi-bold">Nombre: </span> {{ $data->infoFactura->razonSocialComprador }}
                </p>
                <p><span class="semi-bold">Identificación: </span>{{ $data->infoFactura->identificacionComprador }}</p>
                <p>
                    <span class="semi-bold">Dirección: </span>{{ $data->infoFactura->direccionComprador }}
                </p>
                <p><span class="semi-bold">Email: </span>{{ $data->email }}</p>
                <p><span class="semi-bold">Teléfono: </span>{{ $data->phone }}</p>
            </td>
            <td class="w-30">
                <table class="w-100">
                    <tbody>
                        <?php if ($data->infoFactura->totalDescuento>0):?>
                        <tr>
                            <td>
                                <p class="inline btn-success">Descuento</p>
                            </td>
                            <td>
                                <h1 class="text-xl text-right">${{ $data->infoFactura->totalDescuento }}</h1>
                            </td>
                        </tr>
                        <?php endif;?>
                        <tr>
                            <td></td>
                            <td>
                                <p class="text-right text-md">Valor a Cancelar</p>
                            </td>
                        </tr>
                        <tr>
                            <td></td>
                            <td>
                                <h1 class="text-right">${{ $data->infoFactura->importeTotal }}</h1>
                            </td>
                        </tr>
                    </tbody>
                </table>
            </td>
        </tr>
    </table>
    <table class="table-details">
        <thead>
            <tr>
                <th style="text-align:center;">Cant.</th>
                <th>Cod. Principal</th>
                <th>Descripción</th>
                <th style="text-align:center;">Precio Unitario</th>
                <th style="text-align:center;">Desc.</th>
                <th style="text-align:center;">Total</th>
            </tr>
            <tr>
                <td colspan="6">
                    <div class="divider"></div>
                </td>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($data->detalles as $detalle): ?>
            <tr>
                <td class="text-center text-base">{{ $detalle->cantidad }}</td>
                <td class="text-base">{{ $detalle->codigoPrincipal }}</td>
                <td class="text-base">{{ $detalle->descripcion }}</td>
                <td class="text-center text-base">{{ $detalle->precioUnitario }}</td>
                <td class="text-center text-base">{{ $detalle->descuento }}</td>
                <td class="text-center text-base">{{ $detalle->precioTotalSinImpuesto }}</td>
            </tr>
            <?php endforeach; ?>
        </tbody>
    </table>
    <table class="w-100">
        <td class="w-50">
            <p class="text-base">Observacion:</p><br>
            <table class="table-subdetails">
                <thead>
                    <tr>
                        <th class="text-base text-normal">Forma de pago</th>
                        <th class="text-base text-normal">Valor</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($data->infoFactura->pagos as $pago): ?>
                    <tr>
                        <td class="semi-bold">{{ $pago->formaPago }}</td>
                        <td class="semi-bold">{{ $pago->total }}</td>
                    </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
            <?php foreach ($data->infoAdicional as $adicional): ?>
            <p class="text-base mt-3">{{ $adicional->nombre }}:</p>
            <p class="semi-bold">{{ $adicional->value }}</p>
            <?php endforeach; ?>
        </td>
        <td class="w-50 td-align-top text-right">
            <table class="w-100">
                <tr>
                    <td class="semi-bold">SUBTOTAL 12%</td>
                    <td>{{ $data->infoFactura->totalConImpuestos[0]->baseImponible }}</td>
                </tr>
                <tr>
                    <td class="semi-bold">IVA 12%</td>
                    <td>{{ $data->infoFactura->totalConImpuestos[0]->valor }}</td>
                </tr>
                <tr>
                    <td class="semi-bold">Subtotal sin impuestos</td>
                    <td>{{ $data->infoFactura->totalSinImpuestos }}</td>
                </tr>
                <tr>
                    <td class="semi-bold">Descuento</td>
                    <td>{{ $data->infoFactura->totalDescuento }}</td>
                </tr>
                <tr>
                    <td class="semi-bold">Valor Total</td>
                    <td>{{ $data->infoFactura->importeTotal }}</td>
                </tr>
            </table>
        </td>
    </table>
    <br>
    <table class="w-100">
        <td class="w-40">
            <div class="greatings">
                <h1 class="text-normal">
                    Gracias por tu compra.
                    <span class="semi-bold"> Wanqara </span>
                    tu aliado estratégico.
                </h1>
            </div>
            <img src="{{ env('URL_IMAGE') }}" alt="" class="logo" />
        </td>
        <td class="w-60">
            <h1 class="text-brow">Términos y Condiciones</h1>
            <ul>
                <li class="text-base text-justify">
                    Garantía es de 12 meses e inicia a partir de la fecha de
                    facturación.
                </li>
                <li class="text-base text-justify semi-bold">
                    Para aplicar la garantía el cliente tiene que presentar factura
                    original, equipo completo, accesorios, cajas, plásticos, pilas,
                    cables, etc.
                </li>
                <li class="text-base text-justify">
                    Se cubre garantía solo cuando se presenten defectos de fabricación
                    más no por golpes, quemaduras, variaciones de voltaje o muestras de
                    mala manipulación.
                </li>
                <li class="text-base text-justify">
                    La validación de garantía inicia con el ingreso del producto a
                    nuestras instalaciones en el siguiente horario: lunes a viernes de
                    09:00am a 16:00pm. Puede enviar el producto por Servientrega a
                    nuestra dirección, no cubrimos este gasto.
                </li>
                <li class="text-base text-justify">
                    Solamente el departamento del servicio técnico podrá determinar si
                    el equipo está dentro o fuera de garantía.
                </li>
            </ul>
        </td>
    </table>

</body>

<style>
    * {
        margin: 0;
        padding: 0;
        /* padding-left: 4px;
        padding-right: 4px; */
        overflow-x: hidden;
    }

    td,
    tr,
    th,
    thead,
    tbody,
    table {
        padding: 0;
        margin: 0;
    }

    p,
    h1,
    span,
    h2,
    h3 {
        margin: 0;
        padding: 0;
    }

    .inline {
        display: inline;
    }

    .w-50 {
        width: 50%;
    }

    .w-30 {
        width: 30%;
    }

    .w-40 {
        width: 40%;
    }

    .w-60 {
        width: 60%;
    }

    .w-70 {
        width: 70%;
    }

    .w-100 {
        width: 100%;
    }

    .text-right {
        text-align: right;
    }

    .text-left {
        text-align: left;
    }

    .text-center {
        text-align: center;
    }

    .text-base {
        font-size: 15px;
    }

    .text-md {
        font-size: 10px;
    }

    .text-sm {
        font-size: 8px;
    }

    .text-xl {
        font-size: 38px;
    }

    .divider {
        height: 1px;
        border-bottom: 1px solid rgb(97, 97, 97);
    }

    .semi-bold {
        font-weight: 800;
    }

    .text-normal {
        font-weight: 500;
    }

    .table-details {
        width: 100%;
    }

    .table-details th {
        text-align: left;
    }

    .table-details thead {
        border-top: 1px solid rgb(97, 97, 97);
    }

    .table-details tbody tr:nth-child(even) {
        background-color: rgb(236, 235, 235);
    }

    .table-details {
        border-collapse: collapse;
    }

    .table-details tbody tr {
        border-bottom: 1pt solid rgb(179, 179, 179);
        font-size: 13px;
        height: 40px;
    }

    .table-subdetails thead th {
        text-align: left;
    }

    .table-subdetails thead th:nth-child(even) {
        padding-left: 10px;
    }

    .table-subdetails tbody td:nth-child(even) {
        padding-left: 10px;
    }

    .mb-3 {
        margin-bottom: 10px;
    }

    .mb-2 {
        margin-bottom: 7px;
    }

    .mb-1 {
        margin-bottom: 5px;
    }

    .ml-3 {
        margin-left: 10px;
    }

    .mt-3 {
        margin-top: 10px;
    }

    .mt-2 {
        margin-top: 7px;
    }

    .mt-1 {
        margin-top: 5px;
    }

    .px-3 {
        padding-left: 10px;
        padding-right: 10px;
    }

    .p-0 {
        padding: 0;
    }

    .m-0 {
        margin: 0;
    }

    .btn-success {
        padding-left: 4px;
        padding-right: 4px;
        padding-bottom: 8px;
        padding-top: 8px;
        border-radius: 3px;
        border: 1px solid green;
        color: green;
    }

    .text-brow {
        color: brown;
    }

    .logo {
        height: 70px;
    }

    .td-align-top {
        vertical-align: top !important;
    }

    ul {
        list-style: inside;
    }

    ul li {
        padding-top: 5px;
        padding-bottom: 5px;
    }

    .greatings {
        margin-left: 4px;
        border-left: 1px solid brown;
        padding-left: 4px;
    }

    .footer {
        width: 100%;
        text-align: center;
        position: absolute;
        bottom: 0;
        padding-bottom: 10px;
    }

    .barra {
        height: 95px;
    }

    .barra div {
        margin: auto;
    }

    body {
        padding-bottom: 35px;
        position: relative;
        height: 1140px;
        padding-left: 12px;
        padding-right: 12px;
    }

    .text-justify {
        text-align: justify;
    }
</style>

</html>
