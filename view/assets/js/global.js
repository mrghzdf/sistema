function somenteNumeros( string ) {
    var numsStr = string.replace(/[^0-9]/g,'');
    return parseInt(numsStr);
}

/**
 * @param strCPF string
 * @returns {boolean}
 */
function validaCpf(strCPF) {
    var Soma;
    var Resto;
    Soma = 0

    if (strCPF == "00000000000") return false;

    for (i=1; i<=9; i++) Soma = Soma + parseInt(strCPF.substring(i-1, i)) * (11 - i);
    Resto = (Soma * 10) % 11;

    if ((Resto == 10) || (Resto == 11))  Resto = 0;
    if (Resto != parseInt(strCPF.substring(9, 10)) ) return false;

    Soma = 0;
    for (i = 1; i <= 10; i++) Soma = Soma + parseInt(strCPF.substring(i-1, i)) * (12 - i);
    Resto = (Soma * 10) % 11;

    if ((Resto == 10) || (Resto == 11))  Resto = 0;
    if (Resto != parseInt(strCPF.substring(10, 11) ) ) return false;
    return true;
}

function pad (n, val) {
    val = val.toString()
    for (var i=val.length; i<=n;i++)
        val = "0" + val
    return val
}

function replaceAll(str, de, para){
    var pos = str.indexOf(de);
    while (pos > -1){
        str = str.replace(de, para);
        pos = str.indexOf(de);
    }
    return (str);
}

function validarcnpj(e){

    var CNPJ = e;
    var erro = new String;
    if (CNPJ.length < 18) {
        return false;
    }
    else {

        if ((CNPJ.charAt(2) != ".") || (CNPJ.charAt(6) != ".") || (CNPJ.charAt(10) != "/") || (CNPJ.charAt(15) != "-")){
            return false;
        }
        else {

            //substituir os caracteres que nÃ£o sÃ£o nÃºmeros
            if(document.layers && parseInt(navigator.appVersion) == 4){
                x = CNPJ.substring(0,2);
                x += CNPJ. substring (3,6);
                x += CNPJ. substring (7,10);
                x += CNPJ. substring (11,15);
                x += CNPJ. substring (16,18);
                CNPJ = x;
            } else {
                CNPJ = CNPJ. replace (".","");
                CNPJ = CNPJ. replace (".","");
                CNPJ = CNPJ. replace ("-","");
                CNPJ = CNPJ. replace ("/","");
            }


            var a = [];
            var b = new Number;
            var c = [6,5,4,3,2,9,8,7,6,5,4,3,2];
            for (i=0; i<12; i++){
                a[i] = CNPJ.charAt(i);
                b += a[i] * c[i+1];
            }

            if ((x = b % 11) < 2) {
                a[12] = 0
            }
            else {
                a[12] = 11-x
            }

            b = 0;
            for (y=0; y<13; y++) {
                b += (a[y] * c[y]);
            }

            if ((x = b % 11) < 2) {
                a[13] = 0;
            }
            else {
                a[13] = 11-x;
            }

            if ((CNPJ.charAt(12) != a[12]) || (CNPJ.charAt(13) != a[13])){

                return false;
            }
            else {
                return true;
            }

        }
    }
}

function validarData(Data) {
    Data = Data.substring(0,10);

    var dma = -1;
    var data = Array(3);
    var ch = Data.charAt(0);
    for(i=0; i < Data.length && (( ch >= '0' && ch <= '9' ) || ( ch == '/' && i != 0 ) ); ){
        data[++dma] = '';
        if(ch!='/' && i != 0) return false;
        if(i != 0 ) ch = Data.charAt(++i);
        if(ch=='0') ch = Data.charAt(++i);
        while( ch >= '0' && ch <= '9' ){
            data[dma] += ch;
            ch = Data.charAt(++i);
        }
    }
    if(ch!='') return false;
    if(data[0] == '' || isNaN(data[0]) || parseInt(data[0]) < 1) return false;
    if(data[1] == '' || isNaN(data[1]) || parseInt(data[1]) < 1 || parseInt(data[1]) > 12) return false;
    if(data[2] == '' || isNaN(data[2]) || ((parseInt(data[2]) < 0 || parseInt(data[2]) > 99 ) && (parseInt(data[2]) < 1900 || parseInt(data[2]) > 9999))) return false;
    if(data[2] < 50) data[2] = parseInt(data[2]) + 2000;
    else if(data[2] < 100) data[2] = parseInt(data[2]) + 1900;
    switch(parseInt(data[1])){
        case 2: { if(((parseInt(data[2])%4!=0 || (parseInt(data[2])%100==0 && parseInt(data[2])%400!=0)) && parseInt(data[0]) > 28) || parseInt(data[0]) > 29 ) return false; break; }
        case 4: case 6: case 9: case 11: { if(parseInt(data[0]) > 30) return false; break;}
        default: { if(parseInt(data[0]) > 31) return false;}
    }
    return true;
}


function bs_input_file() {
    $(".input-file").before(
        function() {
            if ( ! $(this).prev().hasClass('input-ghost') ) {
                var element = $("<input type='file' class='input-ghost' style='visibility:hidden; height:0'>");
                element.attr("name",$(this).attr("name"));
                element.change(function(){
                    element.next(element).find('input').val((element.val()).split('\\').pop());
                });
                $(this).find("button.btn-choose").click(function(){
                    element.click();
                });
                $(this).find("button.btn-reset").click(function(){
                    element.val(null);
                    $(this).parents(".input-file").find('input').val('');
                });
                $(this).find('input').css("cursor","pointer");
                $(this).find('input').mousedown(function() {
                    $(this).parents('.input-file').prev().click();
                    return false;
                });
                return element;
            }
        }
    );
}
$(function() {
    bs_input_file();
});


/*
 * funcao que inclui zeros a esquerda
 */
function ZerosEsquerda(objeto)
{
    objeto.maxLength = 8;
    var numero = objeto.value;
    var tamanho_numero = numero.length
    var retorno = '';
    var zeros = '';

    for (var i=0; i <= 7; i++)
    {
        if(numero.charAt(7-i) == '')
        {
            zeros = zeros + '0';
        }
    }
    var j=0;
    while (numero.charAt(j) == '0')
    {
        j++;
    }

    if(j==0 && zeros=='')
    {
        numero = numero.substr(0,numero.length-1);
        objeto.value = numero;
    }
    else
    {
        numero = zeros+numero;
        numero = numero.substr(1,numero.length);
        objeto.value = numero;
    }

}
function formataCampo(pCaracteres,event) {

    // identifica se o browser é o internet explorer ou outro
    if (navigator.appName.indexOf("Microsoft") > -1)
    {
        codigo = event.keyCode;
    }
    else
    {
        codigo = event.which;
    }

    var retorno = false;

    for (var i = 0; i < pCaracteres.length ; i++)
    {
        if (pCaracteres.charCodeAt(i) == codigo || codigo == 8 || codigo == 13 || codigo == 0)
        {
            retorno = true;
        }

    }
    return retorno;
}

// Ativa o chosen quando indicado
$('.chosen-toggle').each(function(index) {
    $(this).on('click', function(){
        $(this).parent().find('option').prop('selected', $(this).hasClass('select')).parent().trigger('chosen:updated');
    });
});
$(".chosen-select").chosen({width: "100%"});