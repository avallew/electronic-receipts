<html>
<meta http-equiv="content-type" content="text/html; charset=UTF-8">

<head>
    <script>
        function subst() {
            var vars = {};
            var x = document.location.search.substring(1).split('&');
            for (var i in x) {
                var z = x[i].split('=', 2);
                vars[z[0]] = unescape(z[1]);
            }
            var x = ['frompage', 'topage', 'page', 'webpage', 'section', 'subsection', 'subsubsection'];
            for (var i in x) {
                var y = document.getElementsByClassName(x[i]);
                for (var j = 0; j < y.length; ++j) y[j].textContent = vars[x[i]];
            }
        }
    </script>
</head>

<body style="border:0; padding-left: 10px; padding-right: 10px;" onload="subst()">
    <div
        style="border-bottom: 1px solid black; border-top: 1px solid black; padding-left: 10px; padding-right: 10px; width: 98%; text-align:center; font-size: 13px;">
        Comprobante electrónico generado por Illarli Software - Wanqara © 2022
    </div>
    <div style="text-align:right; font-size: 12px;">
        Pag. <span class="page"></span> de
        <span class="topage"></span>
    </div>
</body>

</html>
