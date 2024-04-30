
$(function () {
    setTimeout("atualiza()", 2000); // Aqui eu chamo a função após 2s quando a página for carregada
});

function atualiza() { // Função com Ajax
    $.ajax({
        url: "teste.php", // substitua por qualquer URL real
        async: true
    }).done(function (data) { // "data" é o que retorna do Ajax
        a = true;
        $("#atualizar-assincrona").html(data); // Aqui eu jogo o retorno do Ajax dentro da div
        setTimeout("atualiza()", 2000); // Novamente chamo a função após 2s quando o Ajax for completado
    });
}

$(document).ready(function () {

    $("#tableCaixas").DataTable({
        "language": {
            "lengthMenu": "Mostrar _MENU_ por pagina",
            "zeroRecords": "Não foi encontrado resultado",
            "searchPlaceholder": "Digite sua busca",
            "info": "Mostrando de _START_ a _END_ de um total de _TOTAL_ registros",
            "infoFiltered": "(Filtrado de um total de _MAX_ registros)",
            "search": "Buscar:",
            "paginate": {
                "first": "Primeiro",
                "last": "Último",
                "next": "Seguinte",
                "previous": "Anterior"
            }
        },
        "order": [
            [0, "desc"]
        ],
        "paging": true,
        "lengthChange": true,
        "searching": true,
        "ordering": true,
        "info": true,
        "autoWidth": true,
        "iDisplayLength": '25',
    });



});


function getEditContaBancaria(parametro) {
    $.ajax({
        url: `${base_url}api/configuracao/exibir/contabancaria/${parametro}`,
        type: "GET",
        dataType: "json",
        success: function (dado) {
            document.getElementById('modalTitleContaBancaria').innerHTML = `ATUALIZANDO A CONTA ${dado.cad_contabancaria}`;

            const elements = [
                { id: "cod_contabancaria", value: dado.cod_contabancaria },
                { id: "cad_agencia", value: dado.cad_agencia },
                { id: "cad_conta", value: dado.cad_conta },
                { id: "cad_contabancaria", value: dado.cad_contabancaria },
                { id: "cad_titular", value: dado.cad_titular },
                { id: "cad_documento", value: dado.cad_documento }
            ];

            elements.forEach(element => {
                document.getElementById(element.id).value = element.value;
            });

            const selectElements = [
                { id: "cad_banco", value: dado.cad_banco },
                { id: "cad_tipo", value: dado.cad_tipo },
                { id: "cad_empresa", value: dado.cad_empresa },
                { id: "cad_pagamento", value: dado.cad_pagamento },
                { id: "cad_recebimento", value: dado.cad_recebimento },
                { id: "cad_natureza", value: dado.cad_natureza }
            ];

            selectElements.forEach(selectElement => {
                $(`#${selectElement.id}`).val(selectElement.value).trigger('change');
            });

            document.getElementById("contabancariaAtivo").checked = dado.status === '1';
            document.getElementById("contabancariaInativo").checked = dado.status === '2';
        }
    });
}

function setNewContaBancaria() {
    document.getElementById('modalTitleContaBancaria').innerHTML = 'CADASTRO DE NOVA CONTA BANCARIA';
    const elements = [
        "cod_contabancaria",
        "cad_agencia",
        "cad_conta",
        "cad_contabancaria",
        "cad_titular",
        "cad_documento"
    ];

    elements.forEach(element => {
        document.getElementById(element).value = '';
    });

    const selectElements = [
        { id: "cad_banco", value: '' },
        { id: "cad_tipo", value: 'C' },
        { id: "cad_empresa", value: '' },
        { id: "cad_pagamento", value: 'S' },
        { id: "cad_recebimento", value: 'S' },
        { id: "cad_natureza", value: 'F' }
    ];

    selectElements.forEach(selectElement => {
        $(`#${selectElement.id}`).val(selectElement.value).trigger('change');
    });

    document.getElementById("contabancariaAtivo").checked = true;
}

function salvarContaBancaria() {
    $("#formContaBancaria").submit(function (e) {
        e.preventDefault();
    });

    $.validator.setDefaults({
        submitHandler: function () {
            var form = $('#formContaBancaria');
            var url = form.attr('action');
            $.ajax({
                url: url,
                type: "POST",
                data: form.serialize(),
                dataType: "json",
                beforeSend: function () {
                    document.getElementById("SalvarContaBancaria").disabled = true;
                },
                success: function (response) {
                    respostaSwalFire(response);
                },
                error: function () {
                    document.getElementById("SalvarContaBancaria").disabled = false;
                }
            });
        }
    });

    $('#formContaBancaria').validate({
        rules: {
            cad_contabancaria: {
                required: true,
            },
        },
        messages: {
            cad_contabancaria: {
                required: "O nome da maquininha deve ser informada!",
            },
        },
        errorElement: 'span',
        errorPlacement: function (error, element) {
            error.addClass('invalid-feedback');
            element.closest('.form-group').append(error);
        },
        highlight: function (element, errorClass, validClass) {
            $(element).addClass('is-invalid');
        },
        unhighlight: function (element, errorClass, validClass) {
            $(element).removeClass('is-invalid');
        }
    });
}


$('#valor_creditofinan').change(function () {
    var apagar = parseFloat($("#valor_apagar").val().replace(/[.,]/g, '').replace(/(\d)(?=(\d{3})+(?!\d))/g, '$1.')) || 0;
    var creditofinan = parseFloat($("#valor_creditofinan").val().replace(/[.,]/g, '').replace(/(\d)(?=(\d{3})+(?!\d))/g, '$1.')) || 0;
    var creditosaldo = parseFloat($("#valor_creditosaldo").val().replace(/[.,]/g, '').replace(/(\d)(?=(\d{3})+(?!\d))/g, '$1.')) || 0;
    var verifica_saldo = creditosaldo - creditofinan;
    var verifica_pagamento = apagar - creditofinan;
    
    if (verifica_saldo < 0) {
        toastr.error('O VALOR INFORMADO É SUPERIOR AO CRÉDITO!');
        $("#valor_creditofinan").val('');
    } else {
        if (verifica_pagamento < 0) {
            toastr.error('O VALOR INFORMADO É SUPERIOR AO PAGAMENTO!');
            $("#valor_creditofinan").val(formatMoneyBR(apagar));
        }
    }
});


$('#valor_creditofinan').change(function () {
    var apagar = $("#valor_apagar").val() != "" ? $("#valor_apagar").val().replace('.', '').replace(',', '.') : 0;
    var creditofinan = $("#valor_creditofinan").val() != "" ? $("#valor_creditofinan").val().replace('.', '').replace(',', '.') : 0;
    var creditosaldo = $("#valor_creditosaldo").val() != "" ? $("#valor_creditosaldo").val().replace('.', '').replace(',', '.') : 0;
    var verifica_saldo = creditosaldo - creditofinan;
    var verifica_pagamento = apagar - creditofinan;
    if (verifica_saldo < 0) {
        toastr.error('O VALOR INDORMADO É SUPERIOR AO CREDITO!')
        document.getElementById('valor_creditofinan').value = '';
    } else {
        if (verifica_pagamento < 0) {
            toastr.error('O VALOR INDORMADO É SUPERIOR AO PAGAMENTO!')
            document.getElementById('valor_creditofinan').value = formatMoneyBR(apagar);
        }
    }
});