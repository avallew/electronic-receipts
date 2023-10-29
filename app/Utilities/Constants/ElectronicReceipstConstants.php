<?php

namespace App\Utilities\Constants;

class ElectronicReceipstConstants
{

    //TABLA 2
    const EMISSION_TYPE_NORMAL = '1';
    
    //TABLA 4
    const ENVIRONMENT_TEST = '1';
    const ENVIRONMENT_PRODUCTION = '2';

    //TABLA 6
    const BUYER_IDENTIFICATION_TYPE_RUC = '04';
    const BUYER_IDENTIFICATION_TYPE_CEDULA = '05';
    const BUYER_IDENTIFICATION_TYPE_PASAPORTE = '06';
    const BUYER_IDENTIFICATION_TYPE_CONSUMIDOR_FINAL = '07';
    const BUYER_IDENTIFICATION_TYPE_EXTERIOR = '08';

    //QUANTITY CHARS
    const MINMAX_CHARS_04_RUC = '13|13';
    const MINMAX_CHARS_05_CEDULA = '10|10';
    const MINMAX_CHARS_06_PASAPORTE = '13|16';
    const MINMAX_CHARS_07_CONSUMIDOR_FINAL = '10|10';
    const MINMAX_CHARS_08_EXTERIOR = '9|16';

    //TABLA 3
    const RECEIPT_TYPE_INVOICE = '01';
    const RECEIPT_TYPE_PURCHASE_LIQUIDATION = '03';
    const RECEIPT_TYPE_CREDIT_NOTE = '04';
    const RECEIPT_TYPE_DEBIT_NOTE = '05';
    const RECEIPT_TYPE_REMISSION_GUIDE = '06';
    const RECEIPT_TYPE_RETENTION_RECEIPT = '07';

    const INVOICE_SPANISH = 'Factura Electrónica';
    const DEBIT_NOTE_SPANISH = 'Nota de Débito';
    const CREDIT_NOTE_SPANISH = 'Nota de Crédito';
    const REMISSION_GUIDE_SPANISH = 'Guía de Remisión';
    const PURCHASE_LIQUIDATION_SPANISH = 'Liquidación de Compra';
    const RETENTION_RECEIPT_SPANISH = 'Comprobante de Retención';

    const INVOICE = 'INVOICE';
    const DEBIT_NOTE = 'DEBIT NOTE';
    const CREDIT_NOTE = 'CREDIT NOTE';
    const REMISSION_GUIDE = 'REMISSION GUIDE';
    const PURCHASE_LIQUIDATION = 'PURCHASE LIQUIDATION';
    const RETENTION_RECEIPT = 'RETENTION RECEIPT';

    const INVOICE_VERSION_110 = '1.1.0';
    const DEBIT_NOTE_VERSION_100 = '1.0.0';
    const CREDIT_NOTE_VERSION_110 = '1.1.0';
    const REMISSION_GUIDE_VERSION_110 = '1.1.0';
    const PURCHASE_LIQUIDATION_VERSION_110 = '1.1.0';
    const RETENTION_RECEIPT_VERSION_200 = '2.0.0';

    // const VALIDATION_CODE_AUTHORIZATION_2 = '2';
    // const VALIDATION_CODE_AUTHORIZATION_10 = '10';
    // const VALIDATION_CODE_RECEPTION_26 = '26';
    // const VALIDATION_CODE_AUTHORIZATION_27 = '27';
    // const VALIDATION_CODE_RECEPTION_28 = '28';
    // const VALIDATION_CODE_EMISOR_34 = '34';
    // const VALIDATION_CODE_RECEPTION_35 = '35';
    // const VALIDATION_CODE_RECEPTION_36 = '36';
    // const VALIDATION_CODE_AUTHORIZATION_37 = '37';
    // const VALIDATION_CODE_AUTHORIZATION_39 = '39';
    // const VALIDATION_CODE_AUTHORIZATION_40 = '40';
    // const VALIDATION_CODE_EMISOR_42 = '42';
    // const VALIDATION_CODE_RECEPTION_43 = '43';
    // const VALIDATION_CODE_AUTHORIZATION_45 = '45';
    // const VALIDATION_CODE_RECEPTION_45 = '45';
    // const VALIDATION_CODE_AUTHORIZATION_46 = '46';
    // const VALIDATION_CODE_RECEPTION_47 = '47';
    // const VALIDATION_CODE_RECEPTION_48 = '48';
    // const VALIDATION_CODE_RECEPTION_49 = '49';
    // const VALIDATION_CODE_RECEPTION_50 = '50';
    // const VALIDATION_CODE_EMISOR_AUTHORIZATION_52 = '52';
    // const VALIDATION_CODE_AUTHORIZATION_56 = '56';
    // const VALIDATION_CODE_AUTHORIZATION_57 = '57';
    // const VALIDATION_CODE_AUTHORIZATION_58 = '58';
    // const VALIDATION_CODE_AUTHORIZATION_63 = '63';
    // const VALIDATION_CODE_EMISOR_64 = '64';
    // const VALIDATION_CODE_EMISOR_RECEPTION_65 = '65';
    // const VALIDATION_CODE_RECEPTION_67 = '67';
    // const VALIDATION_CODE_EMISOR_69 = '69';
    // const VALIDATION_CODE_RECEPTION_70 = '70';
    // const VALIDATION_CODE_AUTHORIZATION_80 = '80';
    // const VALIDATION_CODE_RECEPTION_82 = '82';
    // const VALIDATION_CODE_RECEPTION_92 = '92';


    //TABLA 16
    const TAX_RATE_TYPE_IVA = '2';
    const TAX_RATE_TYPE_ICE = '3';
    const TAX_RATE_TYPE_IRBPNR = '5';

    //TABLA 17
    const VAT_TYPE_CODE_0 = '0';
    const VAT_TYPE_CODE_12 = '2';
    const VAT_TYPE_CODE_14 = '3';
    const VAT_TYPE_CODE_NOT_TAXABLE = '6';
    const VAT_TYPE_CODE_TAX_FREE    = '7';
    const VAT_TYPE_CODE_DIFFERENTIATED = '8';

    //TABLA 18
    const RATE_ICE_Cigarrillos_Rubios = '3011';
    const RATE_ICE_Cigarrillos_Negros = '3021';
    const RATE_ICE_Productos_del_Tabaco_y_Sucedáneos_del_Tabaco_excepto_Cigarrillos = '3023';
    const RATE_ICE_Bebidas_Alcohólicas = '3031';
    const RATE_ICE_Cerveza_Industrial_Gran_Escala = '3041';
    const RATE_ICE_Cerveza_Industrial_Mediana_Escala = '3041';
    const RATE_ICE_Cerveza_Industrial_Pequeña_Escala = '3041';
    const RATE_ICE_Vehículos_Motorizados_cuyo_PVP_sea_hasta_de_20000_USD = '3073';
    const RATE_ICE_Vehículos_Motorizados_PVP_entre_30000_y_40000 = '3075';
    const RATE_ICE_Vehículos_Motorizados_cuyo_PVP_superior_USD_40000_hasta_50000 = '3077';
    const RATE_ICE_Vehículos_Motorizados_cuyo_PVP_superior_USD_50000_hasta_60000 = '3078';
    const RATE_ICE_Vehículos_Motorizados_cuyo_PVP_superior_USD_60000_hasta_70000 = '3079';
    const RATE_ICE_Vehículos_Motorizados_cuyo_PVP_superior_USD_70000 = '3080';
    const RATE_ICE_Aviones_Tricares_yates_Barcos_de_Recreo = '3081';
    const RATE_ICE_Servicios_de_Televisión_Prepagada = '3092';
    const RATE_ICE_Perfumes_y_Aguas_de_Tocador = '3610';
    const RATE_ICE_Videojuegos = '3620';
    const RATE_ICE_Armas_de_Fuego_Armas_deportivas_y_Municiones = '3630';
    const RATE_ICE_Focos_Incandescentes = '3640';
    const RATE_ICE_Cuotas_Membresías_Afiliaciones_Acciones = '3660';
    const RATE_ICE_Servicios_Telefonía_Sociedades = '3093';
    const RATE_ICE_Bebidas_Energizantes = '3101';

    const RATE_ICE_Bebidas_Gaseosas_con_Alto_Contenido_de_Azúcar = '3053';
    const RATE_ICE_Bebidas_Gaseosas_con_Bajo_Contenido_de_Azúcar = '3054';
    const RATE_ICE_Bebidas_No_Alcohólicas = '3111';
    const RATE_ICE_Cerveza_Artesanal = '3043';
    const RATE_ICE_Alcohol = '3033';
    const RATE_ICE_CALEFONES_Y_SISTEMAS_DE_CALENTAMIENTO_DE_AGUA_A_GAS_SRI = '3671';
    const RATE_ICE_VEHÍCULOS_MOTORIZADOS_CAMIONETAS_Y_DE_RESCATE_CUYO_PVP_SEA_HASTA_DE_30000_USD = '3684';
    const RATE_ICE_VEHÍCULOS_MOTORIZADOS_EXCEPTO_CAMIONETAS_Y_DE_RESCATE_CUYO_PVP_SEA_SUPERIOR_USD_20000_HASTA_DE_30000 = '3686';
    const RATE_ICE_VEHÍCULOS_HÍBRIDOS_CUYO_PVP_SEA_DE_HASTA_USD_35000 = '3688';
    const RATE_ICE_VEHÍCULOS_HÍBRIDOS_CUYO_PVP_SUPERIOR_USD_35000_HASTA_40000 = '3691';
    const RATE_ICE_VEHÍCULOS_HÍBRIDOS_CUYO_PVP_SUPERIOR_USD_40000_HASTA_50000 = '3692';
    const RATE_ICE_VEHÍCULOS_HÍBRIDOS_CUYO_PVP_SUPERIOR_USD_50000_HASTA_60000 = '3695';
    const RATE_ICE_VEHÍCULOS_HÍBRIDOS_CUYO_PVP_SUPERIOR_USD_60000_HASTA_70000 = '3696';
    const RATE_ICE_VEHÍCULOS_HÍBRIDOS_CUYO_PVP_SUPERIOR_A_USD_70000 = '3698';
    const RATE_ICE_CONSUMIBLES_TABACO_CALENTADO_Y_LIQUIDOS_CON_NICOTINA_SRI = '3682';
    const RATE_ICE_SERVICIOS_DE_TELEFONÍA_MÓVIL_PERSONAS_NATURALES = '3681';
    const RATE_ICE_FUNDAS_PLÁSTICAS = '3680';
    const RATE_ICE_Import_Bebidas_Alcohólicas = '3533';
    const RATE_ICE_Cerveza_Gran_Escala_Cae = '3541';
    const RATE_ICE_Cerveza_Industrial_de_Mediana_Escala_Cae = '3541';
    const RATE_ICE_Cerveza_Industrial_de_Pequeña_Escala_Cae = '3541';
    const RATE_ICE_Cigarrillos_Rubios_Cae = '3542';
    const RATE_ICE_Cigarrillos_Negros_Cae = '3543';
    const RATE_ICE_Productos_del_Tabaco_y_Sucedáneos_del_Tabaco_Excepto_Cigarrillos_Cae = '3544';
    const RATE_ICE_Aeronaves_Cae = '3581';
    const RATE_ICE_Aviones_Avionetas_y_Helicópteros_Exct_Aquellos_destinados_Al_Trans_Cae = '3582';
    const RATE_ICE_Perfumes_Aguas_de_Tocador_Cae = '3710';
    const RATE_ICE_Video_Juegos_Cae = '3720';
    const RATE_ICE_Importaciones_Armas_de_Fuego_Armas_deportivas_y_Municiones_Cae = '3730';
    const RATE_ICE_Focos_Incandecentes_Cae = '3740';
    const RATE_ICE_VEHÍCULOS_MOTORIZADOS_CUYO_PVP_SEA_HASTA_DE_20000_USD_SENAE = '3871';
    const RATE_ICE_VEHÍCULOS_MOTORIZADOS_PVP_ENTRE_30000_Y_40000_SENAE = '3873';
    const RATE_ICE_VEHÍCULOS_MOTORIZADOS_CUYO_PVP_SUPERIOR_USD_40000_HASTA_50000_SENAE = '3874';

    const RATE_ICE_VEHÍCULOS_MOTORIZADOS_CUYO_PVP_SUPERIOR_USD_50000_HASTA_60000_SENAE = '3875';
    const RATE_ICE_VEHÍCULOS_MOTORIZADOS_CUYO_PVP_SUPERIOR_USD_60000_HASTA_70000_SENAE = '3876';
    const RATE_ICE_VEHÍCULOS_MOTORIZADOS_CUYO_PVP_SUPERIOR_USD_70000_SENAE = '3877';
    const RATE_ICE_Aviones_Tricares_Yates_Barcos_De_Rec_SENAE = '3878';
    const RATE_ICE_Bebidas_Energizantes_SENAE = '3601';
    const RATE_ICE_BEBIDAS_GASEOSAS_CON_ALTO_CONTENIDO_DE_AZUCAR_SENAE = '3552';
    const RATE_ICE_BEBIDAS_GASEOSAS_CON_BAJO_CONTENIDO_DE_AZÚCAR_SENAE = '3553';
    const RATE_ICE_BEBIDAS_NO_ALCOHOLICAS_SENAE = '3602';
    const RATE_ICE_CERVEZA_ARTESANAL_SENAE = '3545';
    const RATE_ICE_IMPORT_ALCOHOL_SENAE = '3532';
    const RATE_ICE_CALEFONES_Y_SISTEMAS_DE_CALENTAMIENTO_DE_AGUA_A_GAS_SENAE = '3771';
    const RATE_ICE_VEHÍCULOS_MOTORIZADOS_CAMIONETAS_Y_DE_RESCATE_PVP_SEA_HASTA_DE_30000_USD_SENAE = '3685';
    const RATE_ICE_VEHÍCULOS_MOTORIZADOS_EXCEPTO_CAMIONETAS_Y_DE_RESCATE_CUYO_PVP_SEA_SUPERIOR_USD_20000_HASTA_DE_30000_SENAE = '3687';
    const RATE_ICE_VEHÍCULOS_HÍBRIDOS_CUYO_PVP_SEA_DE_HASTA_USD_35000_SENAE = '3689';
    const RATE_ICE_VEHÍCULOS_HÍBRIDOS_CUYO_PVP_SUPERIOR_USD_35000_HASTA_40000_SENAE = '3690';
    const RATE_ICE_VEHÍCULOS_HÍBRIDOS_CUYO_PVP_SUPERIOR_USD_40000_HASTA_50000_SENAE = '3693';
    const RATE_ICE_VEHÍCULOS_HÍBRIDOS_CUYO_PVP_SUPERIOR_USD_50000_HASTA_60000_SENAE = '3694';
    const RATE_ICE_VEHÍCULOS_HÍBRIDOS_CUYO_PVP_SUPERIOR_USD_60000_HASTA_70000_SENAE = '3697';
    const RATE_ICE_VEHÍCULOS_HÍBRIDOS_CUYO_PVP_SUPERIOR_A_USD_70000_SENAE = '3699';
    const RATE_ICE_CONSUMIBLES_TABACO_CALENTADO_Y_LIQUIDOS_CON_NICOTINA_SENAE = '3683';

    //TABLA 19
    const TAX_TO_WITHHOLD_TYPE_RENT = '1';
    const TAX_TO_WITHHOLD_TYPE_VAT = '2';
    const TAX_TO_WITHHOLD_TYPE_ISD = '6';

    //TABLA 20
    const VAT_PORCENTAGE_10 = '9';
    const VAT_PORCENTAGE_20 = '10';
    const VAT_PORCENTAGE_30 = '1';
    const VAT_PORCENTAGE_50 = '11';
    const VAT_PORCENTAGE_70 = '2';
    const VAT_PORCENTAGE_100 = '3';

    //TABLA 22
    const TAX_TO_WITHHOLD = '4';

    //TABLA 23
    const WITHHOLD_TYPE_3 = '3';
    const WITHHOLD_TYPE_4 = '4';
    const WITHHOLD_TYPE_5 = '5';
    const WITHHOLD_TYPE_6 = '6';

    //TABLA 24
    const PAYMENT_SIN_UTILIZACION_DEL_SISTEMA_FINANCIERO = '01';
    const PAYMENT_COMPENSACION_DE_DEUDAS = '15';
    const PAYMENT_TARJETA_DE_DEBITO = '16';
    const PAYMENT_DINERO_ELECTRONICO = '17';
    const PAYMENT_TARJETA_PREPAGO = '18';
    const PAYMENT_TARJETA_DE_CREDITO = '19';
    const PAYMENT_OTROS_CON_UTILIZACION_DEL_SISTEMA_FINANCIERO = '20';
    const PAYMENT_ENDOSO_DE_TITULOS = '21';
    //SPANISH PAYMENTS
    const SPANISH_PAYMENT_01 = "SIN UTILIZACIÓN DEL SISTEMA FINANCIERO";
    const SPANISH_PAYMENT_15 = 'COMPENSACIÓN DE DEUDAS';
    const SPANISH_PAYMENT_16 = 'TARJETA DE DÉBITO';
    const SPANISH_PAYMENT_17 = 'DINERO ELECTRONICO';
    const SPANISH_PAYMENT_18 = 'TARJETA PREPAGO';
    const SPANISH_PAYMENT_19 = 'TARJETA DE CRÉDITO';
    const SPANISH_PAYMENT_20 = 'OTROS CON UTILIZACIÓN DEL SISTEMA FINANCIERO';
    const SPANISH_PAYMENT_21 = 'ENDOSO DE TÍTULOS';

    //TABLA 26
    const RETAINED_SUBJECT_TYPE_NATURAL = '01';
    const RETAINED_SUBJECT_TYPE_SOCIETY = '02';

    //TABLA 4 - CATALOGO ATS
    const AUTHORIZED_VOUCHER_TYPE_1 = '1';
    const AUTHORIZED_VOUCHER_TYPE_2 = '2';
    const AUTHORIZED_VOUCHER_TYPE_3 = '3';
    const AUTHORIZED_VOUCHER_TYPE_4 = '4';
    const AUTHORIZED_VOUCHER_TYPE_6 = '6';
    const AUTHORIZED_VOUCHER_TYPE_7 = '7';
    const AUTHORIZED_VOUCHER_TYPE_8 = '8';
    const AUTHORIZED_VOUCHER_TYPE_9 = '9';
    const AUTHORIZED_VOUCHER_TYPE_10 = '10';
    const AUTHORIZED_VOUCHER_TYPE_11 = '11';
    const AUTHORIZED_VOUCHER_TYPE_12 = '12';
    const AUTHORIZED_VOUCHER_TYPE_13 = '13';
    const AUTHORIZED_VOUCHER_TYPE_14 = '14';
    const AUTHORIZED_VOUCHER_TYPE_15 = '15';
    const AUTHORIZED_VOUCHER_TYPE_16 = '16';
    const AUTHORIZED_VOUCHER_TYPE_18 = '18';
    const AUTHORIZED_VOUCHER_TYPE_19 = '19';
    const AUTHORIZED_VOUCHER_TYPE_20 = '20';
    const AUTHORIZED_VOUCHER_TYPE_21 = '21';
    const AUTHORIZED_VOUCHER_TYPE_22 = '22';
    const AUTHORIZED_VOUCHER_TYPE_23 = '23';
    const AUTHORIZED_VOUCHER_TYPE_24 = '24';
    const AUTHORIZED_VOUCHER_TYPE_41 = '41';
    const AUTHORIZED_VOUCHER_TYPE_42 = '42';
    const AUTHORIZED_VOUCHER_TYPE_43 = '43';
    const AUTHORIZED_VOUCHER_TYPE_44 = '44';
    const AUTHORIZED_VOUCHER_TYPE_45 = '45';
    const AUTHORIZED_VOUCHER_TYPE_47 = '47';
    const AUTHORIZED_VOUCHER_TYPE_48 = '48';
    const AUTHORIZED_VOUCHER_TYPE_49 = '49';
    const AUTHORIZED_VOUCHER_TYPE_50 = '50';
    const AUTHORIZED_VOUCHER_TYPE_51 = '51';
    const AUTHORIZED_VOUCHER_TYPE_52 = '52';
    const AUTHORIZED_VOUCHER_TYPE_294 = '294';
    const AUTHORIZED_VOUCHER_TYPE_344 = '344';
    const AUTHORIZED_VOUCHER_TYPE_364 = '364';
    const AUTHORIZED_VOUCHER_TYPE_370 = '370';
    const AUTHORIZED_VOUCHER_TYPE_371 = '371';
    const AUTHORIZED_VOUCHER_TYPE_372 = '372';
    const AUTHORIZED_VOUCHER_TYPE_373 = '373';
    const AUTHORIZED_VOUCHER_TYPE_374 = '374';
    const AUTHORIZED_VOUCHER_TYPE_375 = '375';

    //TABLA 5 - CATALOGO ATS
    const RECEIPT_SUPPORT_CODE_00 = '00';
    const RECEIPT_SUPPORT_CODE_01 = '01';
    const RECEIPT_SUPPORT_CODE_02 = '02';
    const RECEIPT_SUPPORT_CODE_03 = '03';
    const RECEIPT_SUPPORT_CODE_04 = '04';
    const RECEIPT_SUPPORT_CODE_05 = '05';
    const RECEIPT_SUPPORT_CODE_06 = '06';
    const RECEIPT_SUPPORT_CODE_07 = '07';
    const RECEIPT_SUPPORT_CODE_08 = '08';
    const RECEIPT_SUPPORT_CODE_09 = '09';
    const RECEIPT_SUPPORT_CODE_10 = '10';
    const RECEIPT_SUPPORT_CODE_11 = '11';
    const RECEIPT_SUPPORT_CODE_12 = '12';
    const RECEIPT_SUPPORT_CODE_13 = '13';
    const RECEIPT_SUPPORT_CODE_14 = '14';
    const RECEIPT_SUPPORT_CODE_15 = '15';

    //TABLA 13 - CATALOGO ATS
    const PAYMENT_ATS_SIN_UTILIZACION_DEL_SISTEMA_FINANCIERO = '01';
    const PAYMENT_ATS_CHEQUE_PROPIO = '02';
    const PAYMENT_ATS_CHEQUE_CERTIFICADO = '03';
    const PAYMENT_ATS_CHEQUE_DE_GERENCIA = '04';
    const PAYMENT_ATS_CHEQUE_DEL_EXTERIOR = '05';
    const PAYMENT_ATS_DÉBITO_DE_CUENTA = '06';
    const PAYMENT_ATS_TRANSFERENCIA_PROPIO_BANCO = '07';
    const PAYMENT_ATS_TRANSFERENCIA_OTRO_BANCO_NACIONAL = '08';
    const PAYMENT_ATS_TRANSFERENCIA_BANCO_EXTERIOR = '09';
    const PAYMENT_ATS_TARJETA_DE_CRÉDITO_NACIONAL = '10';
    const PAYMENT_ATS_TARJETA_DE_CRÉDITO_INTERNACIONAL = '11';
    const PAYMENT_ATS_GIRO = '12';
    const PAYMENT_ATS_DEPOSITO_EN_CUENTA_CORRIENTE_AHORROS = '13';
    const PAYMENT_ATS_ENDOSO_DE_INVERSIÒN = '14';
    const PAYMENT_ATS_COMPENSACIÓN_DE_DEUDAS = '15';
    const PAYMENT_ATS_TARJETA_DE_DÉBITO = '16';
    const PAYMENT_ATS_DINERO_ELECTRÓNICO = '17';
    const PAYMENT_ATS_TARJETA_PREPAGO = '18';
    const PAYMENT_ATS_TARJETA_DE_CRÉDITO = '19';
    const PAYMENT_ATS_OTROS_CON_UTILIZACION_DEL_SISTEMA_FINANCIERO = '20';
    const PAYMENT_ATS_ENDOSO_DE_TÍTULOS = '21';

    //TABLA 15 - CATALOGO ATS
    const RESIDENT_PAYMENT_TYPE = '01';
    const NO_RESIDENT_PAYMENT_TYPE = '02';

    //TABLA 19 - CATALOGO ATS
    const REGIME_TAX_FOREIGN_TYPE = '01';
    const REGIME_TAX_FOREIGN_TYPE_TAX_HAVEN = '02';
    const REGIME_TAX_FOREIGN_TYPE_TAX_REGIME = '03';


    public static function getValidationEnvironmentType(): array
    {
        $reflector = new \ReflectionClass(static::class);
        $constants = $reflector->getConstants();
        $formattedConstants = [];
        foreach ($constants as $name => $value) {
            if (stristr($name, 'ENVIRONMENT_'))
                $formattedConstants[$name] = $value;
        }
        return $formattedConstants;
    }

    public static function getValidationTaxToWithHoldType(): array
    {
        $reflector = new \ReflectionClass(static::class);
        $constants = $reflector->getConstants();
        $formattedConstants = [];
        foreach ($constants as $name => $value) {
            if (stristr($name, 'TAX_TO_WITHHOLD_TYPE'))
                $formattedConstants[$name] = $value;
        }
        return $formattedConstants;
    }

    public static function getValidationVatPorcentaje(): array
    {
        $reflector = new \ReflectionClass(static::class);
        $constants = $reflector->getConstants();
        $formattedConstants = [];
        foreach ($constants as $name => $value) {
            if (stristr($name, 'VAT_PORCENTAGE'))
                $formattedConstants[$name] = $value;
        }
        return $formattedConstants;
    }

    public static function getValidationWithHoldType(): array
    {
        $reflector = new \ReflectionClass(static::class);
        $constants = $reflector->getConstants();
        $formattedConstants = [];
        foreach ($constants as $name => $value) {
            if (stristr($name, 'WITHHOLD_TYPE_'))
                $formattedConstants[$name] = $value;
        }
        return $formattedConstants;
    }

    public static function getValidationRatesIce(): array
    {
        $reflector = new \ReflectionClass(static::class);
        $constants = $reflector->getConstants();
        $formattedConstants = [];
        foreach ($constants as $name => $value) {
            if (stristr($name, 'RATE_ICE_'))
                $formattedConstants[$name] = $value;
        }
        return $formattedConstants;
    }

    public static function getValidationElectronicReceiptTypes(): array
    {
        $reflector = new \ReflectionClass(static::class);
        $constants = $reflector->getConstants();
        $formattedConstants = [];
        foreach ($constants as $name => $value) {
            if (stristr($name, 'RECEIPT_TYPE_'))
                $formattedConstants[$name] = $value;
        }
        return $formattedConstants;
    }

    public static function getVersionElectronicReceipts(): array
    {
        $reflector = new \ReflectionClass(static::class);
        $constants = $reflector->getConstants();
        $formattedConstants = [];
        foreach ($constants as $name => $value) {
            $formattedConstants[$name] = $value;
        }
        return $formattedConstants;
    }

    public static function getValidationCodesSri(): array
    {
        $reflector = new \ReflectionClass(static::class);
        $constants = $reflector->getConstants();
        $formattedConstants = [];
        foreach ($constants as $name => $value) {
            if (strpos($name, 'CODE'))
                $formattedConstants[$name] = $value;
        }
        return $formattedConstants;
    }

    public static function getTypesReceiptElectronic(): array
    {
        $reflector = new \ReflectionClass(static::class);
        $constants = $reflector->getConstants();
        $formattedConstants = [];
        foreach ($constants as $name => $value) {
            if (strpos($name, 'TYPE'))
                $formattedConstants[$name] = $value;
        }
        return $formattedConstants;
    }

    public static function getValidationIdentificationBuyer(): array
    {
        $reflector = new \ReflectionClass(static::class);
        $constants = $reflector->getConstants();
        $formattedConstants = [];
        foreach ($constants as $name => $value) {
            if (stristr($name, 'BUYER'))
                $formattedConstants[$name] = $value;
        }
        return $formattedConstants;
    }

    public static function getValidationIdentificationBuyerMinMax($minMaxCharsType)
    {

        $reflector = new \ReflectionClass(static::class);
        $constants = $reflector->getConstants();
        $minMax = null;
        foreach ($constants as $name => $value) {
            if (stristr($name, $minMaxCharsType))
                $minMax = $value;
        }
        return $minMax;
    }

    public static function getValidationVatType(): array
    {
        $reflector = new \ReflectionClass(static::class);
        $constants = $reflector->getConstants();
        $formattedConstants = [];
        foreach ($constants as $name => $value) {
            if (stristr($name, 'VAT_TYPE_CODE'))
                $formattedConstants[$name] = $value;
        }
        return $formattedConstants;
    }

    public static function getValidationTaxRateType(): array
    {
        $reflector = new \ReflectionClass(static::class);
        $constants = $reflector->getConstants();
        $formattedConstants = [];
        foreach ($constants as $name => $value) {
            if (stristr($name, 'TAX_RATE_TYPE_'))
                $formattedConstants[$name] = $value;
        }
        return $formattedConstants;
    }

    public static function getValidationPaymentMethodsAts(): array
    {
        $reflector = new \ReflectionClass(static::class);
        $constants = $reflector->getConstants();
        $formattedConstants = [];
        foreach ($constants as $name => $value) {
            if (stristr($name, 'PAYMENT_ATS'))
                $formattedConstants[$name] = $value;
        }
        return $formattedConstants;
    }

    public static function getValidationPaymentMethods(): array
    {
        $reflector = new \ReflectionClass(static::class);
        $constants = $reflector->getConstants();
        $formattedConstants = [];
        foreach ($constants as $name => $value) {
            if (stristr($name, 'PAYMENT'))
                $formattedConstants[$name] = $value;
        }
        return $formattedConstants;
    }

    public static function getValidationRetainedSubjectType(): array
    {
        $reflector = new \ReflectionClass(static::class);
        $constants = $reflector->getConstants();
        $formattedConstants = [];
        foreach ($constants as $name => $value) {
            if (stristr($name, 'RETAINED_SUBJECT_TYPE'))
                $formattedConstants[$name] = $value;
        }
        return $formattedConstants;
    }

    public static function getValidationReceiptSupportCode(): array
    {
        $reflector = new \ReflectionClass(static::class);
        $constants = $reflector->getConstants();
        $formattedConstants = [];
        foreach ($constants as $name => $value) {
            if (stristr($name, 'RECEIPT_SUPPORT_CODE'))
                $formattedConstants[$name] = $value;
        }
        return $formattedConstants;
    }

    public static function getValidationAuthorizedVoucherType(): array
    {
        $reflector = new \ReflectionClass(static::class);
        $constants = $reflector->getConstants();
        $formattedConstants = [];
        foreach ($constants as $name => $value) {
            if (stristr($name, 'AUTHORIZED_VOUCHER_TYPE'))
                $formattedConstants[$name] = $value;
        }
        return $formattedConstants;
    }

    public static function getValidationResidentPaymentType(): array
    {
        $reflector = new \ReflectionClass(static::class);
        $constants = $reflector->getConstants();
        $formattedConstants = [];
        foreach ($constants as $name => $value) {
            if (stristr($name, 'RESIDENT_PAYMENT_TYPE'))
                $formattedConstants[$name] = $value;
        }
        return $formattedConstants;
    }

    public static function getValidationRegimeTaxForeignType(): array
    {
        $reflector = new \ReflectionClass(static::class);
        $constants = $reflector->getConstants();
        $formattedConstants = [];
        foreach ($constants as $name => $value) {
            if (stristr($name, 'REGIME_TAX_FOREIGN_TYPE'))
                $formattedConstants[$name] = $value;
        }
        return $formattedConstants;
    }

    public static function getSpanishPaymentMethods($paymentCode)
    {
        $reflector = new \ReflectionClass(static::class);
        $constants = $reflector->getConstants();
        $spanishName = null;
        foreach ($constants as $name => $value) {
            if (stristr($name, 'SPANISH_PAYMENT_' . $paymentCode))
                $spanishName = $value;
        }
        return $spanishName;
    }
}
