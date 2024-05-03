var url = window.location.hostname; // obter o dominio
var base_url = "http://" + url + ":8080/";

$(document).ready(function () {

    // CARREGA PARAMENTRO POR DEFAULT DATATABLE
    jQuery.extend(jQuery.fn.dataTableExt.oSort, {
        "date-br-pre": function (a) {
            if (!a || a === "") {
                return 0;
            }
            var brDatea = a.split('/');
            return parseInt(brDatea[2] + brDatea[1] + brDatea[0], 10);
        },

        "date-br-asc": function (a, b) {
            return a < b ? -1 : a > b ? 1 : 0;
        },

        "date-br-desc": function (a, b) {
            return a < b ? 1 : a > b ? -1 : 0;
        }
    });

    // CARREGA PARAMENTRO POR DEFAULT DATATABLE
    $.extend(true, $.fn.dataTable.defaults, {
        language: {
            emptyTable: "Nenhum registro encontrado",
            lengthMenu: "Mostrar _MENU_ por página",
            zeroRecords: "Não foram encontrados resultados",
            searchPlaceholder: "Digite sua busca",
            info: "Mostrando de _START_ a _END_ de um total de _TOTAL_ registros",
            infoFiltered: "(Filtrado de um total de _MAX_ registros)",
            search: "Buscar:",
            paginate: {
                first: "Primeiro",
                last: "Último",
                next: "Seguinte",
                previous: "Anterior"
            },
            infoEmpty: "Mostrando 0 até 0 de 0 registro(s)",
            searchPlaceholder: "Buscar registros",
            processing: "<i class='fas fa-2x fa-sync-alt fa-spin'></i> </br> Carregando Informações"
        },
        paging: true,
        searching: true,
        info: true,
        autoWidth: false,
        pageLength: 25,
        lengthChange: true,
        processing: true
    });

    $('.valorbr').mask('###.###.###,00', {
        reverse: true
    });

    $('.taxabr').mask('000.00', {
        reverse: true
    });

    $('.cnpj').mask('00.000.000/0000-00');
});

function formatMoneyBR(n, c = 2, d = ",", t = ".") {
    const s = n < 0 ? "-" : "";
    const i = Math.abs(+n || 0).toFixed(c).toString();
    const parts = i.split(".");
    let formatted = parts[0].replace(/\B(?=(\d{3})+(?!\d))/g, t);

    if (c > 0) {
        const decimalPart = parts[1] ? d + parts[1].slice(0, c) : "";
        formatted += decimalPart.padEnd(c + 1, "0");
    }

    return s + formatted;
}

function formatMoneyUS(value) {
    var clean = parseFloat(value.replace(/[^0-9,]*/g, '').replace(',', '.')).toFixed(2);
    return clean;
}

function retirarFormatacao(campoTexto) {
    campoTexto.value = campoTexto.value.replace(/(\.|\/|\-)/g, "");
}

function mascaraCpf(valor) {
    return valor.replace(/(\d{3})(\d{3})(\d{3})(\d{2})/g, "\$1.\$2.\$3\-\$4");
}

function mascaraCnpj(valor) {
    return valor.replace(/(\d{2})(\d{3})(\d{3})(\d{4})(\d{2})/g, "\$1.\$2.\$3\/\$4\-\$5");
}

function consultaReceitaWsCNPJ(cnpj) {
    $.ajax({
        url: "https://www.receitaws.com.br/v1/cnpj/" + cnpj,
        type: "GET",
        dataType: 'json',
        success: function (data) {
            if (data.nome === undefined) {
                callback(false);
            } else {
                callback(data);
            }
        }
    });
}

function consultaReceitaWsCNPJ(cnpj) {
    return new Promise((resolve, reject) => {
        $.ajax({
            url: "https://www.receitaws.com.br/v1/cnpj/" + cnpj,
            type: "GET",
            dataType: 'json',
            success: function (data) {
                if (data.nome === undefined) {
                    reject("CNPJ not found or invalid.");
                } else {
                    resolve(data);
                }
            },
            error: function (xhr, status, error) {
                reject("Error fetching data: " + status + ", " + error);
            }
        });
    });
}

$('#cad_documento').on('input', function () {
    if ($(this).val().length > 14) {
        $(this).val($(this).val().slice(0, 14));
    }
});

function initializepPagamentoDataTable(tableId, url, serial, codigo) {
    $(tableId).DataTable({
        "ajax": {
            type: "POST",
            url: url,
            data: {
                'serial': serial,
                'codigo': codigo
            },
            dataType: "json",
            async: "true"
        },
        paging: false,
        searching: false,
        ordering: false,
        info: false,
        columnDefs: [
            { targets: 0, type: "date-br" },
            { targets: 5, className: "no-print" },
        ],
        order: [
            [0, 'asc'],
            [5, 'asc']
        ],
    });
}

// GERENCIA AS CONTAS A PAGAR
function getPagamentosContaPagar(serial, codigo) {
    initializepPagamentoDataTable("#tablePagamentosPagar", base_url + "api/financeiro/tabela/pagamentos/contaspagar", serial, codigo);
}

// GERENCIA AS CONTAS A RECEBER
function getPagamentosContaReceber(serial, codigo) {
    initializepPagamentoDataTable("#tablePagamentosReceber", base_url + "api/financeiro/tabela/pagamentos/contasreceber", serial, codigo);
}

// GERENCIA OS RECEBIMENTOS 
function getPagamentosContaReceber(serial, codigo) {
    getPagamentosVendaAReceber("#tablePagamentosVendaAReceber", base_url + "api/venda/tabela/recebimento/vendareceber", serial, codigo);
}

function handlePaymentChange(forma, tipo = null) {

    document.getElementById("ReceberSubmit").disabled = false;
    var consulta = forma === 2 ? 'contabancaria' : 'formaspagamentos';
    $.post(base_url + 'api/configuracao/consulta/' + consulta, {
        forma: forma,
        tipo: tipo
    }, function (data) {
        $('#pag_conta').html(data);
        document.getElementById("pag_conta").disabled = false;
    });
    document.getElementById("pag_bandeira").disabled = true;
    $('#pag_bandeira').html('')
    if (forma === 5) {
        document.getElementById("pag_parcela").disabled = false;
        getParcelaOption()
    } else {
        document.getElementById("pag_parcela").disabled = true;
        $('#pag_parcela').val(1).trigger('change');
    }
    document.getElementById("div_troco").hidden = forma !== 1;
}

$('#radioDinheiro').change(function () {
    handlePaymentChange(1);
});

$('#radioTransferencia').change(function () {
    var tipoTransferencia = document.getElementById("tipoTransferencia").value;

    handlePaymentChange(2, tipoTransferencia);
});

$('#radioDebito').change(function () {
    handlePaymentChange(3);
});

$('#radioCredito').change(function () {
    handlePaymentChange(4);
});

$('#radioBoleto').change(function () {
    handlePaymentChange(5);
});

$('#pag_conta').change(function () {
    var radioCredito = $("#radioCredito").prop("checked");
    var radioDebito = $("#radioDebito").prop("checked");
    if (radioCredito || radioDebito) {
        var pag_conta = $("#pag_conta").val();
        $.ajax({
            type: "GET",
            url: base_url + "api/configuracao/consulta/bandeira/" + pag_conta,
            success: function (response) {
                options = '<option value="">SELECIONE UMA BANDEIRA</option>';
                for (var i = 0; i < response.length; i++) {
                    options += '<option value="' + response[i].cad_bandeira + '">' + response[i].ban_descricao + '</option>';
                }
                $('#pag_bandeira').html(options);
                document.getElementById("pag_bandeira").disabled = false;
                $('#pag_parcela').val(1).trigger('change');
            }
        });
    }
});

$('#pag_bandeira').change(function () {
    var radioCredito = $("#radioCredito").prop("checked");
    var radioDebito = $("#radioDebito").prop("checked");
    if (radioCredito || radioDebito) {
        var pag_conta = $("#pag_conta").val();
        var pag_bandeira = $("#pag_bandeira").val();
        $.ajax({
            type: "GET",
            url: `${base_url}api/configuracao/exibir/formasparcelamentos/${pag_conta}/${pag_bandeira}`,
            success: function (response) {
                options = '';
                for (var i = 0; i < response.length; i++) {
                    options += '<option value="' + response[i].cad_parcela + '">' + response[i].cad_parcela + '</option>';
                }
                $('#pag_parcela').html(options);
                document.getElementById("pag_parcela").disabled = false;
            }
        });
    }
});

function getParcelaOption() {
    $.get(base_url + 'api/configuracao/exibir/parcela', {}, function (response) {
        options = '';
        for (var i = 0; i < response.length; i++) {
            options += '<option value="' + response[i].parcela + '">' + response[i].parcela + '</option>';
        }
        $('#pag_parcela').html(options);
    });
}

function getClientesOption() {
    $.get(base_url + 'api/cadastro/exibir/pessoas/clientes', {}, function (response) {
        options = '<option value="">SELECIONE UMA CLIENTE</option>';
        for (var i = 0; i < response.length; i++) {
            options += '<option value="' + response[i].cod_pessoa + '">' + response[i].cad_nome + '</option>';
        }
        $('#cod_pessoa').html(options);
    });
}

function getFornecedoresOption() {
    $.get(base_url + 'api/cadastro/exibir/pessoas/fornecedores', {}, function (response) {
        options = '<option value="">SELECIONE UMA FORNECEDOR</option>';
        for (var i = 0; i < response.length; i++) {
            options += '<option value="' + response[i].cod_pessoa + '">' + response[i].cad_nome + '</option>';
        }
        $('#cod_pessoa').html(options);
    });
}

//Function to display a toast notification
function respostaToast(response) {
    // Destructure the response object to make it easier to access its properties
    const { heading, description, status } = response.menssagem;

    // Set default values for optional parameters
    const options = {
        icon: status,
        position: 'top-right',
        showHideTransition: 'plain',
        allowToastClose: true,
        hideAfter: 4000,
        stack: 6,
        textAlign: 'left',
        loaderBg: '#9EC600'
    };

    // Display the toast notification
    $.toast({
        heading,
        text: description,
        icon: options.icon,
        loader: options.loader,
        position: options.position,
        showHideTransition: options.showHideTransition,
        allowToastClose: options.allowToastClose,
        hideAfter: options.hideAfter,
        stack: options.stack,
        textAlign: options.textAlign,
        loaderBg: options.loaderBg
    });
}

// Function to display a modal dialog with SweetAlert2
function respostaSwalFire(response, reload = true) {
    // Destructure the response object to make it easier to access its properties
    const { heading, description, status } = response.menssagem;

    // Configure the SweetAlert2 options
    const options = {
        title: heading,
        text: description,
        icon: status,
        showConfirmButton: false,
        timer: 2000,
    };

    // Display the modal dialog
    Swal.fire(options);
    setTimeout(function () {
        if (reload === true) {
            window.location.reload(1);
        }
    }, 1500);
}

function showConfirmationDialog(title, message, confirmButtonText) {
    return new Promise((resolve) => {
        Swal.fire({
            allowOutsideClick: false,
            allowEscapeKey: true,
            title: title,
            text: message,
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#3085d6',
            cancelButtonColor: '#d33',
            confirmButtonText: confirmButtonText,
            cancelButtonText: 'Fechar'
        }).then((result) => {
            resolve(result.isConfirmed);
        });
    });
}

function executeAction(actionUrl, Paramentro, Codigo) {
    $.ajax({
        url: actionUrl + Paramentro + "/" + Codigo,
        type: "get",
        dataType: "json",
        success: function (response) {
            respostaSwalFire(response);
        }
    });
}

function initializeDataTable(tableId, url, columnDefs, order, data) {
    $(tableId).DataTable({
        ajax: {
            url: url,
            data: {
                'codigo': data
            },
            type: "POST",
            dataType: "json",
            async: true
        },
        columnDefs: columnDefs,
        order: order
    });
}