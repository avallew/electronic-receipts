<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Registro exitoso en ILLARLI</title>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Chivo+Mono:ital,wght@0,100;1,100&family=Montserrat&display=swap"
        rel="stylesheet">
</head>

<body>
    <table style="width: 100%;font-family: 'Montserrat', sans-serif;">
        <tbody>
            <tr>
                <td style="width: 800px;">
                    <table style="max-width: 800px;width: 100%;">
                        <tbody>
                            <tr style="background-color: #f9f9f9;">
                                <td style="width: 100%;text-align: center;">
                                    <a href="https://www.illarli.com.ec/" target="_blank">
                                        <img src="https://facturacion-electronica-gratuita.illarli.com.ec/wp-content/uploads/2023/07/Logo-illarli.png"
                                            alt="logo-illarli" style="width: 50%;padding: 5% 25%;">
                                    </a>
                                    <h1
                                        style="color: #222222;font-size: 30px;letter-spacing: 1px;line-height: 45px;text-align: center; font-weight: 400;">
                                        Bienvenido, <span style="font-weight: bold;"><b>{{ $comercialName }}</b></span>
                                    </h1>
                                    <p
                                        style="color: 222222;/*! padding: 16px 8% 32px 8%; */text-align: center;font-size: 20px;">
                                        Gracias por elegir <b><span
                                                style="font-family: 'Chivo';font-weight: bold;">ILLARLI</span>
                                        </b>.<br>Esperamos que disfrute la experiencia de trabajar con <br>
                                        nuestro sistema de facturación.
                                    </p>
                                </td>
                            </tr>
                            <tr>
                                <td style="padding: 1% 0%;background-color: {{ $color }};text-align: center;">
                                    <img src="https://facturacion-electronica-gratuita.illarli.com.ec/wp-content/uploads/2023/07/illarlicomercios-vertical.png"
                                        alt="illarli-comercios" style="width: auto;height: 219px;">
                                </td>
                            </tr>
                            <tr>
                                <td style="padding: 0% 0% 0% 0%;text-align: center;">
                                    <div
                                        style="width: auto;background-color: #F9F9F9;border-radius: 15px;margin: 30px 0px;text-align: center;padding: 15px 0px;color: #222222">
                                        <div style="font-size: 20px;font-weight: bold;">
                                            <span><b></b>Datos para ingresar al sistema:</b></span><br>
                                        </div>
                                        <div
                                            style="padding:31px 16px;border-radius: 0px 0px 15px 15px;font-size: 20px;color: #222222;font-weight: bold;text-align: left;width: fit-content;margin: 0 auto;font-weight: bold;">
                                            <b>Usuario: <span
                                                    style="color: {{ $color }};font-weight: 400;">{{ $username }}</span></b><br><br>
                                            <?php if($password===null):?>
                                            <a href="https://{{ $url }}/reset-password/{{ $token }}"
                                                target="_blank">
                                                <button
                                                    style="background-color: {{ $color }};color: white;padding: 2.5% 8%;border-radius: 15px;font-size: 15px;cursor: pointer;margin-bottom: 15px;">Clic
                                                    aquí para generar tu contraseña</button>
                                            </a>
                                            <?php endif;?>
                                        </div>
                                        <?php if($password!==null):?>
                                        <a href="https://{{ $url }}" target="_blank">
                                            <button
                                                style="background-color: {{ $color }};color: white;padding: 2.5% 8%;border-radius: 15px;font-size: 15px;cursor: pointer;margin-bottom: 15px;">Clic
                                                aquí para ingresar</button>
                                        </a>
                                        <br>
                                        <small style="color: #505050;font-size: 14px;">*Nota: Por favor, guarde esta
                                            información importante</small>
                                        <?php endif;?>
                                    </div>
                                </td>
                            </tr>
                            <tr>
                                <td>
                                    <div
                                        style="background-color: {{ $color }};color: white;text-align: center;padding: 10px 0px;">
                                        <img src="https://facturacion-electronica-gratuita.illarli.com.ec/wp-content/uploads/2023/07/illarlicomercios-academy.png"
                                            alt="illarli-academy" style="width: auto;height: 30px;">
                                    </div>
                                    <img src="https://facturacion-electronica-gratuita.illarli.com.ec/wp-content/uploads/2023/07/academy.jpg"
                                        alt="illarli-academy" style="width: 100%;height: auto;overflow: hidden;">
                                </td>
                            </tr>
                            <tr>
                                <td style="padding: 0% 0% 0% 0%;text-align: center;">
                                    <div
                                        style="width: auto;background-color: #F9F9F9;border-radius: 15px;margin: 30px 0px;text-align: center;padding: 15px 0px;color: #222222">
                                        <p style="font-size: 16px;">En <b><span
                                                    style="font-family: 'Chivo';font-weight: bold;">ILLARLI</span>
                                                Academy</b>, encontrarás cursos a través de <br>video tutoriales que te
                                            ayudarán a mejorar tus <br>habilidades en el manejo del sistema de
                                            facturación.</p>
                                        <a href="https://illarli.com.ec/illarli-academy" target="_blank">
                                            <button
                                                style="background-color: {{ $color }};color: white;padding: 2.5% 8%;border-radius: 15px;font-size: 15px;cursor: pointer;margin-bottom: 15px;">Ver
                                                cursos</button>
                                        </a>
                                    </div>
                                </td>
                            </tr>
                            <tr>
                                <td>
                                    <div
                                        style="background-color: {{ $color }};color: white;padding: 1.5% 8%;text-align: center;">
                                        <h3 style="margin: 0px;font-size: 20px;">CAPACITACIONES <span
                                                style="font-weight: normal;">VIRTUALES</span></h3>
                                    </div>
                                    <img src="https://facturacion-electronica-gratuita.illarli.com.ec/wp-content/uploads/2023/07/capacitacionesvirtuales.jpg"
                                        style="width: 100%;height: auto;overflow: hidden;">
                                </td>
                            </tr>
                            <tr>
                                <td style="padding: 0% 0% 0% 0%;text-align: center;">
                                    <div
                                        style="width: auto;background-color: #F9F9F9;border-radius: 15px;margin: 30px 0px;text-align: center;padding: 15px 0px;color: #222222;">
                                        <p>Le invitamos a unirse a las capacitaciones gratuitas a través de nuestro
                                            distribuidor autorizado <b>Wanqara</b> por medio de la plataforma Zoom:</p>
                                        <ul style="list-style: none;">
                                            <li><b>Horario: <span
                                                        style="color: {{ $color }};font-weight: 400">Miércoles
                                                        09:00 -12:00</span></b></li>
                                            <li><b>Código de acceso: <span
                                                        style="color: {{ $color }};font-weight: 400">1234</span></b>
                                            </li>
                                        </ul>
                                        <a href="https://illarli.com/capacitacionCOMERCIOS" target="_blank">
                                            <button
                                                style="background-color: {{ $color }};color: white;padding: 2% 8%;border-radius: 15px;font-size: 15px;cursor: pointer;margin-bottom: 15px;">Ir
                                                a la capacitación</span></button>
                                        </a>
                                    </div>
                                </td>
                            </tr>
                            <tr>
                                <td
                                    style="text-align: center;background-color: {{ $color }};color: white;padding-top: 10px;">
                                    <img src="https://facturacion-electronica-gratuita.illarli.com.ec/wp-content/uploads/2023/07/logoillarli-comercios.png"
                                        style="width: auto;height: 26px;"><br>
                                    <p
                                        style="display: inline-block;padding-top: 0px;margin-top: 3px;margin-bottom: 10px;">
                                        2023 - Todos los derechos reservados.</p>
                                </td>
                            </tr>
                        </tbody>
                    </table>
                </td>
            </tr>
        </tbody>
    </table>
</body>

</html>
