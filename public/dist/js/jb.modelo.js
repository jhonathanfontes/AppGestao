// var base_url = "http://app.gestao/";

var url = window.location.hostname; // obter o dominio
var base_url = "http://" + url ;

// CARREGA DADOS DA TABLE
$(document).ready(function () {

    jQuery.extend(jQuery.fn.dataTableExt.oSort, {

        "date-br-pre": function (a) {
            if (a == null || a == "") {
                return 0;
            }
            var brDatea = a.split('/');
            return (brDatea[2] + brDatea[1] + brDatea[0]) * 1;
        },
        "date-br-asc": function (a, b) {
            return ((a < b) ? -1 : ((a > b) ? 1 : 0));
        },
        "date-br-desc": function (a, b) {
            return ((a < b) ? 1 : ((a > b) ? -1 : 0));
        }
    });
    // CARREGA PARAMENTRO POR DEFAULT DATATABLE
    $.extend(true, $.fn.dataTable.defaults, {
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
        "paging": true,
        "searching": true,
        "ordering": true,
        "info": true,
        "autoWidth": false,
        "iDisplayLength": 25,
        "responsive": true,
        "lengthChange": true,
    });
    // CARREGA DADOS DA TELA DE PESSOAS
    $("#tablePessoas").DataTable({
        "ajax": {
            "url": base_url + "api/cadastro/tabela/pessoa",
            "type": "POST",
            "dataType": "json",
            async: "true"
        },
        columnDefs: [
            { className: "dt-body-center", targets: 2 },
            { className: "dt-body-center", targets: 3 },
            { className: "dt-body-center", targets: 4 },
            { className: "dt-body-center", targets: 5 },
            { className: "dt-body-center", targets: 6 },
            { className: "dt-body-center", targets: 7 },
        ],
    });
    // CARREGA DADOS DA TELA DE PRODUTOS
    $("#tableProdutos").DataTable({
        "ajax": {
            "url": base_url + "api/cadastro/tabela/produto",
            "type": "POST",
            "dataType": "json",
            async: "true"
        },
        columnDefs: [
            { className: "dt-body-center", targets: 0 },
            { className: "dt-body-center", targets: 3 },
            { className: "dt-body-center", targets: 4 },
            { className: "dt-body-center", targets: 5 },
            { className: "dt-body-center", targets: 6 },
            { className: "dt-body-center", targets: 7 },
        ],
    });
    // CARREGA DADOS DA TELA DOS CATEGORIA
    $("#tableCategorias").DataTable({
        "ajax": {
            "url": base_url + "api/cadastro/tabela/categoria",
            "type": "POST",
            "dataType": "json",
            async: "true"
        },
        columnDefs: [
            { className: "dt-body-center", targets: 1 },
            { className: "dt-body-center", targets: 2 },
        ],
    });
    // CARREGA DADOS DA TELA DOS CATEGORIA
    $("#tableSubCategorias").DataTable({
        "ajax": {
            "url": base_url + "api/cadastro/tabela/subcategoria",
            "type": "POST",
            "dataType": "json",
            async: "true"
        },
        columnDefs: [
            { className: "dt-body-center", targets: 2 },
            { className: "dt-body-center", targets: 3 },
        ],
    });
    // CARREGA DADOS DA TELA DOS FABRICANTES
    $("#tableFabricantes").DataTable({
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
        "paging": true,
        "searching": true,
        "ordering": true,
        "info": true,
        "autoWidth": false,
        "iDisplayLength": 25,
        "responsive": true,
        "lengthChange": true,
        "ajax": {
            "url": base_url + "api/cadastro/tabela/fabricante",
            "type": "POST",
            "dataType": "json",
            async: "true"
        },
        columnDefs: [
            { className: "dt-body-center", targets: 1 },
            { className: "dt-body-center", targets: 2 }
        ],
    });
    // CARREGA DADOS DA TELA DOS TAMANHOS
    $("#tableTamanhos").DataTable({
        "ajax": {
            "url": base_url + "api/cadastro/tabela/tamanho",
            "type": "POST",
            "dataType": "json",
            async: "true"
        },
        columnDefs: [
            { className: "dt-body-center", targets: 0 },
            { className: "dt-body-center", targets: 1 },
            { className: "dt-body-center", targets: 2 },
            { className: "dt-body-center", targets: 3 }
        ],
    });
    function limpa_formulário_cep() {
        // Limpa valores do formulário de cep.
        $("#cad_cep").val("");
    }
    //Quando o campo cep perde o foco.
    $('#cad_cep').change(function () {

        //Nova variável "cep" somente com dígitos.
        var cad_cep = $(this).val().replace(/\D/g, '');

        //Verifica se campo cep possui valor informado.
        if (cad_cep != "") {

            //Expressão regular para validar o CEP.
            var validacep = /^[0-9]{8}$/;

            //Valida o formato do CEP.
            if (validacep.test(cad_cep)) {

                //Desabilita os campos enquanto consulta webservice.
                document.getElementById("cad_endereco").disabled = true;
                document.getElementById("cad_setor").disabled = true;
                document.getElementById("cad_cidade").disabled = true;
                document.getElementById("cad_estado").disabled = true;

                //Consulta o webservice viacep.com.br/
                $.getJSON("https://viacep.com.br/ws/" + cad_cep + "/json/?callback=?", function (dados) {

                    if (!("erro" in dados)) {
                        //Atualiza os campos com os valores da consulta.
                        $("#cad_endereco").val(dados.logradouro);
                        $("#cad_setor").val(dados.bairro);
                        $("#cad_cidade").val(dados.localidade);
                        $("#cad_estado").val(dados.uf);

                    } //end if.
                    else {
                        //CEP pesquisado não foi encontrado.
                        $(function () {
                            const Toast = Swal.mixin({
                                toast: true,
                                position: 'top-end',
                                showConfirmButton: false,
                                timer: 3000
                            });
                            $(function () {
                                toastr.error('CEP não encontrado.');
                                campoTexto.value = '';
                            });
                        });
                    }
                    // Habilita após a consulta
                    document.getElementById("cad_endereco").disabled = false;
                    document.getElementById("cad_setor").disabled = false;
                    document.getElementById("cad_cidade").disabled = false;
                    document.getElementById("cad_estado").disabled = false;
                });
            } //end if.
            else {
                //cep é inválido.
                limpa_formulário_cep();
                $(function () {
                    const Toast = Swal.mixin({
                        toast: true,
                        position: 'top-end',
                        showConfirmButton: false,
                        timer: 3000
                    });
                    $(function () {
                        toastr.error('Formato de CEP inválido.');
                        campoTexto.value = '';
                    });
                });
            }
        } //end if.
        else {
            //cep sem valor, limpa formulário.
            limpa_formulário_cep();
        }
    });
});

// MODULO DE CADASTRO
// GERENCIA AS PESSOAS
$('#cad_natureza').change(function () {
    var natureza = document.getElementById('cad_natureza').value
    if (natureza == "F") {
        $('#nameDocumento').text('CPF');
        document.getElementById("container-nascimento").hidden = false;
        document.getElementById("container-rg").hidden = false;
    } else if (natureza == "J") {
        $('#nameDocumento').text('CNPJ');
        document.getElementById("container-nascimento").hidden = true;
        document.getElementById("container-rg").hidden = true;
    }
});
function formatarCampo(campoTexto) {
    var cad_codigo = document.getElementById('cad_codigo').value;
    if (campoTexto.value != '') {
        $.post(base_url + 'api/cadastro/consulta/documento/pessoa', { cad_documento: campoTexto.value })
            .done(function (data) {
                if (cad_codigo == '' || cad_codigo != data.cad_codigo) {
                    if (data) {
                        $menssagem = "Documento já cadastrado - COD: " + data.cad_codigo + " Pessoa: " + data.cad_nome;
                        $(function () {
                            const Toast = Swal.mixin({
                                toast: true,
                                position: 'top-end',
                                showConfirmButton: false,
                                timer: 3000
                            });
                            $(function () {
                                toastr.error($menssagem);
                                document.getElementById('cad_documento').value = '';
                            });
                        });
                    }
                }
            });

        if (campoTexto.value.length == 11) {
            campoTexto.value = mascaraCpf(campoTexto.value);
            $('#cad_natureza').val('F').trigger("change");
        } else if (campoTexto.value.length == 14) {
            consultaCNPJ(campoTexto.value);
            campoTexto.value = mascaraCnpj(campoTexto.value);
            $('#cad_natureza').val('J').trigger("change");

        } else {
            $(function () {
                const Toast = Swal.mixin({
                    toast: true,
                    position: 'top-end',
                    showConfirmButton: false,
                    timer: 3000
                });
                $(function () {
                    toastr.error('Documento informador não é valido');
                    campoTexto.value = '';
                });
            });
        }
    }
}
function consultaCNPJ(cnpj) {
    $.ajax({
        'url': "https://www.receitaws.com.br/v1/cnpj/" + cnpj,
        'type': "GET",
        'dataType': 'jsonp',
        'success': function (dado) {
            if (dado.nome == undefined) {
                $(function () {
                    const Toast = Swal.mixin({
                        toast: true,
                        position: 'top-end',
                        showConfirmButton: false,
                        timer: 3000
                    });
                    $(function () {
                        toastr.error('CNPJ Não encontrado, Preencha Manualmente');
                        // campoTexto.value = '';
                    });
                });
            } else {

                document.getElementById("cad_nome").value = dado.nome;
                document.getElementById("cad_apelido").value = dado.fantasia;
                document.getElementById("cad_cep").value = dado.cep;
                document.getElementById("cad_endereco").value = dado.logradouro;
                document.getElementById("cad_numero").value = dado.numero;
                document.getElementById("cad_setor").value = dado.bairro;
                document.getElementById("cad_cidade").value = dado.municipio;
                document.getElementById("cad_estado").value = dado.uf;
                document.getElementById("cad_complemento").value = dado.complemento;
                document.getElementById("cad_telefone").value = dado.telefone;
                document.getElementById("cad_email").value = dado.email;
            }
        }
    });
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
function getEditPessoa(Paramentro) {
    $.ajax({
        url: base_url + "api/cadastro/pessoa/" + Paramentro,
        success: function (dado) {

            document.getElementById("cad_codigo").value = dado.cad_codigo;
            $('#cad_tipopessoa').val(dado.cad_tipopessoa).trigger("change");
            $('#cad_natureza').val(dado.cad_natureza).trigger("change");
            if (dado.cad_natureza == 'F') {
                document.getElementById("cad_documento").value = dado.cad_cpf;
            }
            if (dado.cad_natureza == 'J') {
                document.getElementById("cad_documento").value = dado.cad_cnpj;
            }
            document.getElementById("cad_nascimeto").value = dado.cad_nascimeto;
            document.getElementById("cad_rg").value = dado.cad_rg;
            document.getElementById("cad_nome").value = dado.cad_nome;
            document.getElementById("cad_apelido").value = dado.cad_apelido;
            document.getElementById("cad_cep").value = dado.cad_cep;
            document.getElementById("cad_endereco").value = dado.cad_endereco;
            document.getElementById("cad_numero").value = dado.cad_numero;
            document.getElementById("cad_setor").value = dado.cad_setor;
            document.getElementById("cad_cidade").value = dado.cad_cidade;
            document.getElementById("cad_estado").value = dado.cad_estado;
            document.getElementById("cad_complemento").value = dado.cad_complemento;
            document.getElementById("cad_telefone").value = dado.cad_telefone;
            document.getElementById("cad_celular").value = dado.cad_celular;
            document.getElementById("cad_email").value = dado.cad_email;
            document.getElementById("container-status").hidden = false;
            if (dado.status == '1') {
                document.getElementById("Ativo").checked = true;
            }
            if (dado.status == '2') {
                document.getElementById("Inativo").checked = true;
            }
        }
    });
}
function newPessoa() {
    var cad_codigo = document.getElementById('cad_codigo').value;
    if (cad_codigo != '') {
        document.getElementById("cad_codigo").value = '';
        $('#cad_tipopessoa').val(1).trigger("change");
        $('#cad_natureza').val('F').trigger("change");
        document.getElementById("cad_documento").value = '';
        document.getElementById("cad_nascimeto").value = '';
        document.getElementById("cad_rg").value = '';
        document.getElementById("cad_nome").value = '';
        document.getElementById("cad_apelido").value = '';
        document.getElementById("cad_cep").value = '';
        document.getElementById("cad_endereco").value = '';
        document.getElementById("cad_numero").value = '';
        document.getElementById("cad_setor").value = '';
        document.getElementById("cad_cidade").value = '';
        document.getElementById("cad_estado").value = '';
        document.getElementById("cad_complemento").value = '';
        document.getElementById("cad_telefone").value = '';
        document.getElementById("cad_celular").value = '';
        document.getElementById("cad_email").value = '';
        document.getElementById("container-status").hidden = true;
    }
}
// GERENCIAR AUXULIARES - CATEGORIA
function newCategoria() {
    $('#title_categoria').text('CADASTRO DE NOVA CATEGORIA');
    var cad_codigo = document.getElementById('cad_codigo').value;
    if (cad_codigo != '') {
        document.getElementById("cad_codigo").value = '';
        document.getElementById("cad_descricao").value = '';
        document.getElementById("container-status").hidden = true;
    }
}
function getEditCategoria(Paramentro) {
    $('#title_categoria').text('ATUALIZAR CATEGORIA');
    $.ajax({
        type: "GET",
        url: base_url + "api/cadastro/categoria/" + Paramentro,
        success: function (dado) {
            document.getElementById("cad_codigo").value = dado.cad_codigo;
            document.getElementById("cad_descricao").value = dado.cad_descricao;
            document.getElementById("container-status").hidden = false;
            if (dado.status == '1') {
                document.getElementById("Ativo").checked = true;
            }
            if (dado.status == '2') {
                document.getElementById("Inativo").checked = true;
            }
        }
    });
}
function getCategoriaOption() {
    $.get(base_url + 'api/cadastro/categoria', {
    }, function (resp) {
        var result = resp.data.data;
        options = '<option value="">SELECIONE UMA CATEGORIA</option>';
        for (var i = 0; i < result.length; i++) {
            options += '<option value="' + result[i].cad_codigo + '">' + result[i].cad_descricao + '</option>';
        }
        $('#cod_categoria').html(options);
    });
}
// GERENCIAR AUXULIARES - SUBCATEGORIA
function newSubCategoria() {
    getCategoriaOption();
    $('#modal_title').text('CADASTRO DE NOVA SUBCATEGORIA');
    var cad_codigo = document.getElementById('cad_codigo').value;
    if (cad_codigo != '') {
        document.getElementById("cad_codigo").value = '';
        $('#cod_categoria').val('').trigger("change");
        document.getElementById("cad_descricao").value = '';
        document.getElementById("container-status").hidden = true;
    }
}
function getEditSubCategoria(Paramentro) {
    getCategoriaOption();
    $('#modal_title').text('ATUALIZAR SUBCATEGORIA');
    $.ajax({
        type: "GET",
        url: base_url + "api/cadastro/subcategoria/" + Paramentro,
        success: function (dado) {
            document.getElementById("cad_codigo").value = dado.cad_codigo;
            $('#cod_categoria').val(dado.cod_categoria).trigger("change");
            document.getElementById("cad_descricao").value = dado.cad_descricao;
            document.getElementById("container-status").hidden = false;
            if (dado.status == '1') {
                document.getElementById("Ativo").checked = true;
            }
            if (dado.status == '2') {
                document.getElementById("Inativo").checked = true;
            }
        }
    });
}
function getSubCategoriaOption(Paramentro) {
    $.get(base_url + 'api/cadastro/subcategoria/categoria/' + Paramentro, {
    }, function (resp) {
        var result = resp.data.data;
        options = '<option value="">SELECIONE UMA SUBCATEGORIA</option>';
        for (var i = 0; i < result.length; i++) {
            options += '<option value="' + result[i].cad_codigo + '">' + result[i].cad_descricao + '</option>';
        }
        $('#cod_subcategoria').html(options);
    });
}
// GERENCIAR AUXULIARES - FABRICANTE
function newFabricante() {
    $('#title_fabricante').text('CADASTRO DE NOVO FABRICANTE');
    var cad_codigo = document.getElementById('cad_codigo').value;
    if (cad_codigo != '') {
        document.getElementById("cad_codigo").value = '';
        document.getElementById("cad_descricao").value = '';
        document.getElementById("container-status").hidden = true;
    }
}
function getEditFabricante(Paramentro) {
    $('#title_fabricante').text('ATUALIZAR CADASTRO DE FABRICANTE');
    $.ajax({
        type: "GET",
        url: base_url + "api/cadastro/fabricante/" + Paramentro,
        success: function (dado) {
            document.getElementById("cad_codigo").value = dado.cad_codigo;
            document.getElementById("cad_descricao").value = dado.cad_descricao;
            document.getElementById("container-status").hidden = false;
            if (dado.status == '1') {
                document.getElementById("Ativo").checked = true;
            }
            if (dado.status == '2') {
                document.getElementById("Inativo").checked = true;
            }
        }
    });
}
function getFabricanteOption() {
    $.get(base_url + 'api/cadastro/fabricante', {
    }, function (resp) {
        var result = resp.data.data;
        options = '<option value="">SELECIONE UM FABRICANTE</option>';
        for (var i = 0; i < result.length; i++) {
            options += '<option value="' + result[i].cad_codigo + '">' + result[i].cad_descricao + '</option>';
        }
        $('#cod_frabricante').html(options);
    });
}
// GERENCIAR AUXULIARES - TAMANHO
function newTamanho() {
    $('#modal_title').text('CADASTRO DE NOVO TAMANHO');
    var cad_codigo = document.getElementById('cad_codigo').value;
    if (cad_codigo != '') {
        document.getElementById("cad_codigo").value = '';
        document.getElementById("cad_descricao").value = '';
        document.getElementById("cad_abreviacao").value = '';
        document.getElementById("container-status").hidden = true;
    }
}
function getEditTamanho(Paramentro) {
    $('#modal_title').text('ATUALIZAR CADASTRO DE TAMANHO');
    $.ajax({
        type: "GET",
        url: base_url + "api/cadastro/tamanho/" + Paramentro,
        success: function (dado) {
            document.getElementById("cad_codigo").value = dado.cad_codigo;
            document.getElementById("cad_descricao").value = dado.cad_descricao;
            document.getElementById("cad_abreviacao").value = dado.cad_abreviacao;
            document.getElementById("container-status").hidden = false;
            if (dado.status == '1') {
                document.getElementById("Ativo").checked = true;
            }
            if (dado.status == '2') {
                document.getElementById("Inativo").checked = true;
            }
        }
    });
}
// GERENCIA OS PRODUTOS
function getCategoriaChangeProduto() {
    var cod_categoria = $('#cod_categoria').val();
    if (cod_categoria) {
        getSubCategoriaOption(cod_categoria);
    }
}
function selectedSubCategoriaProduto() {
    var cad_codigo = $('#cad_codigo').val();
    if (cad_codigo) {
        $.ajax({
            type: "GET",
            url: base_url + "api/cadastro/produto/" + cad_codigo,
            success: function (dado) {
                $('#cod_subcategoria').val(dado.cod_subcategoria).trigger("change");
            }
        });
    }
}
function getNewProduto() {
    getFabricanteOption();
    $('#modal_title').text('CADASTRO DE NOVO TAMANHO');
    var cad_codigo = document.getElementById('cad_codigo').value;
    if (cad_codigo != '') {
        options = '<option value="">SELECIONE UMA CATEGORIA</option>';
        document.getElementById("cad_codigo").value = '';
        document.getElementById("cad_descricao").value = '';
        document.getElementById("cad_descricaopdv").value = '';
        $('#cod_categoria').val('').trigger("change");
        $('#cod_subcategoria').html(options);
        document.getElementById("cad_codfabricante").value = '';
        document.getElementById("cad_descricaopdv").value = '';
        document.getElementById("cad_codbarras").value = '';
        $('#cod_frabricante').val('').trigger("change");
        document.getElementById("container-status").hidden = true;
    }
}
function getEditProduto(Paramentro) {
    getFabricanteOption();
    $('#modal_title').text('ATUALIZAR CADASTRO DO PRODUTO');
    $.ajax({
        type: "GET",
        url: base_url + "api/cadastro/produto/" + Paramentro,
        success: function (dado) {
            getSubCategoriaOption(dado.cod_categoria);
            document.getElementById("cad_codigo").value = dado.cad_codigo;
            document.getElementById("cad_descricao").value = dado.cad_descricao;
            document.getElementById("cad_descricaopdv").value = dado.cad_descricaopdv;
            $('#cod_categoria').val(dado.cod_categoria).trigger("change");
            document.getElementById("cad_codfabricante").value = dado.cad_codfabricante;
            document.getElementById("cad_codbarras").value = dado.cad_codbarras;
            $('#cod_frabricante').val(dado.cod_frabricante).trigger("change");
            document.getElementById("container-status").hidden = false;
            if (dado.status == '1') {
                document.getElementById("Ativo").checked = true;
            }
            if (dado.status == '2') {
                document.getElementById("Inativo").checked = true;
            }
            selectedSubCategoriaProduto();
        }
    });
}
function getEditProdutoGrade(Paramentro) {
    $.ajax({
        type: "POST",
        url: base_url + "ajax/getprodutograde/" + Paramentro,
        success: function (r) {
            dado = JSON.parse(r);
            //console.log(2);
            document.getElementById("cad_codigo").value = dado.cad_codigo;
            document.getElementById("cad_descricao").value = dado.cad_descricao;
            document.getElementById("cad_custo").value = formatMoneyBR(dado.cad_custo);
            document.getElementById("cad_venda").value = formatMoneyBR(dado.cad_venda);
            document.getElementById("cad_prazo").value = formatMoneyBR(dado.cad_prazo);
            if (dado.status == '1') {
                document.getElementById("produtoGrandeAtivo").checked = true;
            }
            if (dado.status == '2') {
                document.getElementById("produtoGrandeInativo").checked = true;
            }
        }
    });
}
// GERENCIA USUARIOS
function showUsuariosDados() {
    $.ajax({
        url: base_url + "api/configuracao/usuario",
        type: "get",
        dataType: "json",
        success: function (data) {
            var tbody = "";
            for (var key in data) {
                tbody += "<tr style='text-align: center;'>";
                tbody += "<td>" + data[key]['cad_name'] + "</td>";
                tbody += "<td>" + data[key]['cad_apelido'] + "</td>";
                tbody += "<td>" + data[key]['cad_user'] + "</td>";
                tbody += "<td>" + data[key]['cad_email'] + "</td>";
                tbody += "<td>" + data[key]['cad_telefone'] + "</td>";
                tbody += "<td><img src='../../../dist/img/avatar/" + data[key]['cad_avatar'] + "' class='img-circle list-inline table-avatar' alt='User Image'></td>";
                if (data[key]['status'] == '1') {
                    tbody += "<td><label class='badge badge-success'>Habilitado</label></td>";
                } else {
                    tbody += "<td><label class='badge badge-danger'>Desabilitado</label></td>";
                }
                tbody += ` <td>
                            <div class="btn-group">
                                <button class="btn btn-xs btn-warning" id="edit" value="${data[key]['cad_codigo']}"><samp class="far fa-edit"> Editar</samp></button>
                            </div>
                        </td>`;
                tbody += "</tr>";
            }
            $("#tbodyUsuario").html(tbody);
        }
    });
}
function returnGrupoAcesso(codigo) {
    $.ajax({
        url: base_url + "api/configuracao/grupoacesso/permissao",
        type: "post",
        data: ({ cod_permisao: codigo }),
        dataType: "json",
        success: function (data) {
            returnDadosPermissao(codigo);
            var tbody = "";
            for (var key in data) {
                tbody += "<tr style='text-align: center;'>";
                tbody += "<td>" + data[key]['cod_modulo'] + "</td>";
                tbody += "<td>" + data[key]['cad_descricao'] + "</td>";
                tbody += "<td>" + checkPermissao(data[key]['cad_permissao']['per_acesso']) + "</td>";
                tbody += "<td>" + checkPermissao(data[key]['cad_permissao']['per_editar']) + "</td>";
                tbody += "<td>" + checkPermissao(data[key]['cad_permissao']['per_deletar']) + "</td>";
                tbody += "</tr>";
            }
            $("#tbodyGrupoAcesso").html(tbody);
        }
    });
}
function checkPermissao(params) {
    if (params == 'S') {
        return '<span class="badge bg-success">Permitido</span>';
    } else {
        return '<span class="badge bg-danger">Negado</span>';
    }
}
function returnDadosPermissao(codigo) {
    $.ajax({
        url: base_url + "api/configuracao/grupoacesso/permissao/" + codigo,
        type: "get",
        dataType: "json",
        success: function (data) {
            document.getElementById("grupoSelecionado").value = data.cod_permisao;
            document.getElementById('titleModulo').innerHTML = data.cad_descricao;
            document.getElementById('titleEditPermissao').innerHTML = 'Gerenciar ' + data.cad_descricao;
            document.getElementById('menuEditPermissao').hidden = false;
        }
    });
}
// GERENCIA AS PERMISSÕES
$(function () {
    //Initialize Select2 Elements
    $('.select2').select2()

    //Initialize Select2 Elements
    $('.select2bs4').select2({
        theme: 'bootstrap4'
    })

    //  MODULO CADASTRO - PESSOA
    $("#formPessoa").submit(function (e) {
        document.getElementById("submit").disabled = true;
        e.preventDefault();
    });
    $.validator.setDefaults({
        submitHandler: function () {
            var form = $('#formPessoa');
            var url = form.attr('action');
            // console.log(form);
            $.ajax({
                url: url,
                type: "POST",
                data: $('#formPessoa').serialize(),
                dataType: "json",
                success: function (response) {
                    console.log(response);
                    if (response.status == true) {
                        $.toast({
                            heading: response.menssagem.heading,
                            text: response.menssagem.description,
                            icon: response.menssagem.status,
                            loader: true,        // Change it to false to disable loader
                            position: 'top-right',
                            showHideTransition: 'plain', // fade, slide or plain
                            allowToastClose: true, // Boolean value true or false
                            hideAfter: 4000, // false to make it sticky or number representing the miliseconds as time after which toast needs to be hidden
                            stack: 6, // false if there should be only one toast at a time or a number representing the maximum number of toasts to be shown at a time                          
                            textAlign: 'left',  // Text alignment i.e. left, right or center
                            loader: true,  // Whether to show loader or not. True by default
                            loaderBg: '#9EC600',  // Background color of the toast loader
                            beforeShow: function () { }, // will be triggered before the toast is shown
                            afterShown: function () {
                                setTimeout(function () {
                                    window.location.reload(1);
                                }, 900);
                            }, // will be triggered after the toat has been shown
                            beforeHide: function () { }, // will be triggered before the toast gets hidden
                            afterHidden: function () { }  // will be triggered after the toast has been hidden
                        });

                    } else {
                        if (response.menssagem != null) {
                            $.toast({
                                heading: response.menssagem.heading,
                                text: response.menssagem.description,
                                icon: response.menssagem.status,
                                loader: true,        // Change it to false to disable loader
                                position: 'top-right',
                                showHideTransition: 'plain', // fade, slide or plain
                                allowToastClose: true, // Boolean value true or false
                                hideAfter: 4000, // false to make it sticky or number representing the miliseconds as time after which toast needs to be hidden
                                stack: 6, // false if there should be only one toast at a time or a number representing the maximum number of toasts to be shown at a time                          
                                textAlign: 'left',  // Text alignment i.e. left, right or center
                                loader: true,  // Whether to show loader or not. True by default
                                loaderBg: '#9EC600',  // Background color of the toast loader
                                beforeShow: function () { }, // will be triggered before the toast is shown
                                afterShown: function () { }, // will be triggered after the toat has been shown
                                beforeHide: function () { }, // will be triggered before the toast gets hidden
                                afterHidden: function () { }  // will be triggered after the toast has been hidden
                            });
                        }
                        if (response.error != null) {
                            $.toast({
                                heading: response.error.heading,
                                text: response.error.description,
                                icon: response.error.status,
                                loader: true,        // Change it to false to disable loader
                                position: 'top-right',
                                showHideTransition: 'plain', // fade, slide or plain
                                allowToastClose: true, // Boolean value true or false
                                hideAfter: 4000, // false to make it sticky or number representing the miliseconds as time after which toast needs to be hidden
                                stack: 6, // false if there should be only one toast at a time or a number representing the maximum number of toasts to be shown at a time                          
                                textAlign: 'left',  // Text alignment i.e. left, right or center
                                loader: true,  // Whether to show loader or not. True by default
                                loaderBg: '#9EC600',  // Background color of the toast loader
                                beforeShow: function () { }, // will be triggered before the toast is shown
                                afterShown: function () { }, // will be triggered after the toat has been shown
                                beforeHide: function () { }, // will be triggered before the toast gets hidden
                                afterHidden: function () { }  // will be triggered after the toast has been hidden
                            });
                        }
                    }
                }
            });
        }
    });
    $('#formPessoa').validate({
        rules: {
            cad_nome: {
                required: true,
                minlength: 2
            }
        },
        messages: {
            cad_nome: {
                required: "Por favor insira o nome da pessoa",
                minlength: "O nome deve conter no minimo 2 caracteres"
            }
        },
        errorElement: 'span',
        errorPlacement: function (error, element) {
            error.addClass('invalid-feedback');
            element.closest('.form-group').append(error);
            document.getElementById("submit").disabled = false;
        },
        highlight: function (element, errorClass, validClass) {
            $(element).addClass('is-invalid');
            document.getElementById("submit").disabled = true;
        },
        unhighlight: function (element, errorClass, validClass) {
            $(element).removeClass('is-invalid');
            document.getElementById("submit").disabled = false;
        }
    });
    //  MODULO CADASTRO - AUXILIA - CATEGORIA
    $("#formProdutoCategoria").submit(function (e) {
        document.getElementById("submit").disabled = true;
        e.preventDefault();
    });
    $.validator.setDefaults({
        submitHandler: function () {
            var form = $('#formProdutoCategoria');
            var url = form.attr('action');
            var origen_form = document.getElementById('form').value;
            $.ajax({
                url: url,
                type: "POST",
                data: $('#formProdutoCategoria').serialize(),
                dataType: "json",
                success: function (response) {
                    if (response.status == true) {
                        $.toast({
                            heading: response.menssagem.heading,
                            text: response.menssagem.description,
                            icon: response.menssagem.status,
                            loader: true,        // Change it to false to disable loader
                            position: 'top-right',
                            showHideTransition: 'plain', // fade, slide or plain
                            allowToastClose: true, // Boolean value true or false
                            hideAfter: 4000, // false to make it sticky or number representing the miliseconds as time after which toast needs to be hidden
                            stack: 6, // false if there should be only one toast at a time or a number representing the maximum number of toasts to be shown at a time                          
                            textAlign: 'left',  // Text alignment i.e. left, right or center
                            loader: true,  // Whether to show loader or not. True by default
                            loaderBg: '#9EC600',  // Background color of the toast loader
                            beforeShow: function () { }, // will be triggered before the toast is shown
                            afterShown: function () {
                                if (origen_form == 'categoria') {
                                    setTimeout(function () {
                                        window.location.reload(1);
                                    }, 900);
                                }
                            }, // will be triggered after the toat has been shown
                            beforeHide: function () { }, // will be triggered before the toast gets hidden
                            afterHidden: function () { }  // will be triggered after the toast has been hidden
                        });
                    } else {
                        if (response.menssagem != null) {
                            $.toast({
                                heading: response.menssagem.heading,
                                text: response.menssagem.description,
                                icon: response.menssagem.status,
                                loader: true,        // Change it to false to disable loader
                                position: 'top-right',
                                showHideTransition: 'plain', // fade, slide or plain
                                allowToastClose: true, // Boolean value true or false
                                hideAfter: 4000, // false to make it sticky or number representing the miliseconds as time after which toast needs to be hidden
                                stack: 6, // false if there should be only one toast at a time or a number representing the maximum number of toasts to be shown at a time                          
                                textAlign: 'left',  // Text alignment i.e. left, right or center
                                loader: true,  // Whether to show loader or not. True by default
                                loaderBg: '#9EC600',  // Background color of the toast loader
                                beforeShow: function () { }, // will be triggered before the toast is shown
                                afterShown: function () { }, // will be triggered after the toat has been shown
                                beforeHide: function () { }, // will be triggered before the toast gets hidden
                                afterHidden: function () { }  // will be triggered after the toast has been hidden
                            });
                        }
                        if (response.error != null) {
                            $.toast({
                                heading: response.error.heading,
                                text: response.error.description,
                                icon: response.error.status,
                                loader: true,        // Change it to false to disable loader
                                position: 'top-right',
                                showHideTransition: 'plain', // fade, slide or plain
                                allowToastClose: true, // Boolean value true or false
                                hideAfter: 4000, // false to make it sticky or number representing the miliseconds as time after which toast needs to be hidden
                                stack: 6, // false if there should be only one toast at a time or a number representing the maximum number of toasts to be shown at a time                          
                                textAlign: 'left',  // Text alignment i.e. left, right or center
                                loader: true,  // Whether to show loader or not. True by default
                                loaderBg: '#9EC600',  // Background color of the toast loader
                                beforeShow: function () { }, // will be triggered before the toast is shown
                                afterShown: function () { }, // will be triggered after the toat has been shown
                                beforeHide: function () { }, // will be triggered before the toast gets hidden
                                afterHidden: function () { }  // will be triggered after the toast has been hidden
                            });
                        }
                    }
                }
            });
        }
    });
    $('#formProdutoCategoria').validate({
        rules: {
            cad_descricao: {
                required: true,
                minlength: 4
            }
        },
        messages: {
            cad_descricao: {
                required: "A descriçao deve ser informado",
                minlength: "A descriçao deve conter no minimo 4 caracteres"
            },
        },
        errorElement: 'span',
        errorPlacement: function (error, element) {
            error.addClass('invalid-feedback');
            element.closest('.form-group').append(error);
            document.getElementById("submit").disabled = false;
        },
        highlight: function (element, errorClass, validClass) {
            $(element).addClass('is-invalid');
            document.getElementById("submit").disabled = true;
        },
        unhighlight: function (element, errorClass, validClass) {
            $(element).removeClass('is-invalid');
            document.getElementById("submit").disabled = false;
        }
    });
    //  MODULO CADASTRO - AUXILIA - SUBCATEGORIA
    $("#formProdutoSubCategoria").submit(function (e) {
        e.preventDefault();
        document.getElementById("submit").disabled = true;
    });
    $.validator.setDefaults({
        submitHandler: function () {
            var form = $('#formProdutoSubCategoria');
            var url = form.attr('action');
            var origen_form = document.getElementById('form').value;
            $.ajax({
                url: url,
                type: "POST",
                data: $('#formProdutoSubCategoria').serialize(),
                dataType: "json",
                success: function (response) {
                    if (response.status == true) {
                        $.toast({
                            heading: response.menssagem.heading,
                            text: response.menssagem.description,
                            icon: response.menssagem.status,
                            loader: true,        // Change it to false to disable loader
                            position: 'top-right',
                            showHideTransition: 'plain', // fade, slide or plain
                            allowToastClose: true, // Boolean value true or false
                            hideAfter: 4000, // false to make it sticky or number representing the miliseconds as time after which toast needs to be hidden
                            stack: 6, // false if there should be only one toast at a time or a number representing the maximum number of toasts to be shown at a time                          
                            textAlign: 'left',  // Text alignment i.e. left, right or center
                            loader: true,  // Whether to show loader or not. True by default
                            loaderBg: '#9EC600',  // Background color of the toast loader
                            beforeShow: function () { }, // will be triggered before the toast is shown
                            afterShown: function () {
                                if (origen_form == 'subcategoria') {
                                    setTimeout(function () {
                                        window.location.reload(1);
                                    }, 900);
                                }
                            }, // will be triggered after the toat has been shown
                            beforeHide: function () { }, // will be triggered before the toast gets hidden
                            afterHidden: function () { }  // will be triggered after the toast has been hidden
                        });
                    } else {
                        if (response.menssagem != null) {
                            $.toast({
                                heading: response.menssagem.heading,
                                text: response.menssagem.description,
                                icon: response.menssagem.status,
                                loader: true,        // Change it to false to disable loader
                                position: 'top-right',
                                showHideTransition: 'plain', // fade, slide or plain
                                allowToastClose: true, // Boolean value true or false
                                hideAfter: 4000, // false to make it sticky or number representing the miliseconds as time after which toast needs to be hidden
                                stack: 6, // false if there should be only one toast at a time or a number representing the maximum number of toasts to be shown at a time                          
                                textAlign: 'left',  // Text alignment i.e. left, right or center
                                loader: true,  // Whether to show loader or not. True by default
                                loaderBg: '#9EC600',  // Background color of the toast loader
                                beforeShow: function () { }, // will be triggered before the toast is shown
                                afterShown: function () { }, // will be triggered after the toat has been shown
                                beforeHide: function () { }, // will be triggered before the toast gets hidden
                                afterHidden: function () { }  // will be triggered after the toast has been hidden
                            });
                        }
                        if (response.error != null) {
                            $.toast({
                                heading: response.error.heading,
                                text: response.error.description,
                                icon: response.error.status,
                                loader: true,        // Change it to false to disable loader
                                position: 'top-right',
                                showHideTransition: 'plain', // fade, slide or plain
                                allowToastClose: true, // Boolean value true or false
                                hideAfter: 4000, // false to make it sticky or number representing the miliseconds as time after which toast needs to be hidden
                                stack: 6, // false if there should be only one toast at a time or a number representing the maximum number of toasts to be shown at a time                          
                                textAlign: 'left',  // Text alignment i.e. left, right or center
                                loader: true,  // Whether to show loader or not. True by default
                                loaderBg: '#9EC600',  // Background color of the toast loader
                                beforeShow: function () { }, // will be triggered before the toast is shown
                                afterShown: function () { }, // will be triggered after the toat has been shown
                                beforeHide: function () { }, // will be triggered before the toast gets hidden
                                afterHidden: function () { }  // will be triggered after the toast has been hidden
                            });
                        }
                    }
                }
            });
        }
    });
    $('#formProdutoSubCategoria').validate({
        rules: {
            cod_categoria: {
                required: true
            },
            cad_descricao: {
                required: true,
                minlength: 4
            }
        },
        messages: {
            cod_categoria: {
                required: "A Categoria deve ser selecionada!"
            },
            cad_descricao: {
                required: "A descriçao deve ser informado!",
                minlength: "A descriçao deve conter no minimo 4 caracteres!"
            }
        },
        errorElement: 'span',
        errorPlacement: function (error, element) {
            error.addClass('invalid-feedback');
            element.closest('.form-group').append(error);
            document.getElementById("submit").disabled = false;
        },
        highlight: function (element, errorClass, validClass) {
            $(element).addClass('is-invalid');
            document.getElementById("submit").disabled = true;
        },
        unhighlight: function (element, errorClass, validClass) {
            $(element).removeClass('is-invalid');
            document.getElementById("submit").disabled = false;
        }
    });
    //  MODULO CADASTRO - AUXILIA - FABRICANTE
    $("#formProdutoFabricante").submit(function (e) {
        e.preventDefault();
        document.getElementById("submit").disabled = true;
    });
    $.validator.setDefaults({
        submitHandler: function () {
            var form = $('#formProdutoFabricante');
            var url = form.attr('action');
            var origen_form = document.getElementById('form').value;
            $.ajax({
                url: url,
                type: "POST",
                data: $('#formProdutoFabricante').serialize(),
                dataType: "json",
                success: function (response) {
                    if (response.status == true) {
                        $.toast({
                            heading: response.menssagem.heading,
                            text: response.menssagem.description,
                            icon: response.menssagem.status,
                            loader: true,        // Change it to false to disable loader
                            position: 'top-right',
                            showHideTransition: 'plain', // fade, slide or plain
                            allowToastClose: true, // Boolean value true or false
                            hideAfter: 4000, // false to make it sticky or number representing the miliseconds as time after which toast needs to be hidden
                            stack: 6, // false if there should be only one toast at a time or a number representing the maximum number of toasts to be shown at a time                          
                            textAlign: 'left',  // Text alignment i.e. left, right or center
                            loader: true,  // Whether to show loader or not. True by default
                            loaderBg: '#9EC600',  // Background color of the toast loader
                            beforeShow: function () { }, // will be triggered before the toast is shown
                            afterShown: function () {
                                if (origen_form == 'fabricante') {
                                    setTimeout(function () {
                                        window.location.reload(1);
                                    }, 900);
                                }
                            }, // will be triggered after the toat has been shown
                            beforeHide: function () { }, // will be triggered before the toast gets hidden
                            afterHidden: function () { }  // will be triggered after the toast has been hidden
                        });
                    } else {
                        if (response.menssagem != null) {
                            $.toast({
                                heading: response.menssagem.heading,
                                text: response.menssagem.description,
                                icon: response.menssagem.status,
                                loader: true,        // Change it to false to disable loader
                                position: 'top-right',
                                showHideTransition: 'plain', // fade, slide or plain
                                allowToastClose: true, // Boolean value true or false
                                hideAfter: 4000, // false to make it sticky or number representing the miliseconds as time after which toast needs to be hidden
                                stack: 6, // false if there should be only one toast at a time or a number representing the maximum number of toasts to be shown at a time                          
                                textAlign: 'left',  // Text alignment i.e. left, right or center
                                loader: true,  // Whether to show loader or not. True by default
                                loaderBg: '#9EC600',  // Background color of the toast loader
                                beforeShow: function () { }, // will be triggered before the toast is shown
                                afterShown: function () { }, // will be triggered after the toat has been shown
                                beforeHide: function () { }, // will be triggered before the toast gets hidden
                                afterHidden: function () { }  // will be triggered after the toast has been hidden
                            });
                        }
                        if (response.error != null) {
                            $.toast({
                                heading: response.error.heading,
                                text: response.error.description,
                                icon: response.error.status,
                                loader: true,        // Change it to false to disable loader
                                position: 'top-right',
                                showHideTransition: 'plain', // fade, slide or plain
                                allowToastClose: true, // Boolean value true or false
                                hideAfter: 4000, // false to make it sticky or number representing the miliseconds as time after which toast needs to be hidden
                                stack: 6, // false if there should be only one toast at a time or a number representing the maximum number of toasts to be shown at a time                          
                                textAlign: 'left',  // Text alignment i.e. left, right or center
                                loader: true,  // Whether to show loader or not. True by default
                                loaderBg: '#9EC600',  // Background color of the toast loader
                                beforeShow: function () { }, // will be triggered before the toast is shown
                                afterShown: function () { }, // will be triggered after the toat has been shown
                                beforeHide: function () { }, // will be triggered before the toast gets hidden
                                afterHidden: function () { }  // will be triggered after the toast has been hidden
                            });
                        }
                    }
                }
            });
        }
    });
    $('#formProdutoFabricante').validate({
        rules: {
            cad_descricao: {
                required: true,
                minlength: 4
            }
        },
        messages: {
            cad_descricao: {
                required: "A descriçao deve ser informado!",
                minlength: "A descriçao deve conter no minimo 4 caracteres!"
            }
        },
        errorElement: 'span',
        errorPlacement: function (error, element) {
            error.addClass('invalid-feedback');
            element.closest('.form-group').append(error);
            document.getElementById("submit").disabled = false;
        },
        highlight: function (element, errorClass, validClass) {
            $(element).addClass('is-invalid');
            document.getElementById("submit").disabled = true;
        },
        unhighlight: function (element, errorClass, validClass) {
            $(element).removeClass('is-invalid');
            document.getElementById("submit").disabled = false;
        }
    });
    //  MODULO CADASTRO - AUXILIA - TAMANHO
    $("#formProdutoTamanho").submit(function (e) {
        e.preventDefault();
        document.getElementById("submit").disabled = true;
    });
    $.validator.setDefaults({
        submitHandler: function () {
            var form = $('#formProdutoTamanho');
            var url = form.attr('action');
            var origen_form = document.getElementById('form').value;
            $.ajax({
                url: url,
                type: "POST",
                data: $('#formProdutoTamanho').serialize(),
                dataType: "json",
                success: function (response) {
                    if (response.status == true) {
                        $.toast({
                            heading: response.menssagem.heading,
                            text: response.menssagem.description,
                            icon: response.menssagem.status,
                            loader: true,        // Change it to false to disable loader
                            position: 'top-right',
                            showHideTransition: 'plain', // fade, slide or plain
                            allowToastClose: true, // Boolean value true or false
                            hideAfter: 4000, // false to make it sticky or number representing the miliseconds as time after which toast needs to be hidden
                            stack: 6, // false if there should be only one toast at a time or a number representing the maximum number of toasts to be shown at a time                          
                            textAlign: 'left',  // Text alignment i.e. left, right or center
                            loader: true,  // Whether to show loader or not. True by default
                            loaderBg: '#9EC600',  // Background color of the toast loader
                            beforeShow: function () { }, // will be triggered before the toast is shown
                            afterShown: function () {
                                if (origen_form == 'tamanho') {
                                    setTimeout(function () {
                                        window.location.reload(1);
                                    }, 900);
                                }
                            }, // will be triggered after the toat has been shown
                            beforeHide: function () { }, // will be triggered before the toast gets hidden
                            afterHidden: function () { }  // will be triggered after the toast has been hidden
                        });
                    } else {
                        if (response.menssagem != null) {
                            $.toast({
                                heading: response.menssagem.heading,
                                text: response.menssagem.description,
                                icon: response.menssagem.status,
                                loader: true,        // Change it to false to disable loader
                                position: 'top-right',
                                showHideTransition: 'plain', // fade, slide or plain
                                allowToastClose: true, // Boolean value true or false
                                hideAfter: 4000, // false to make it sticky or number representing the miliseconds as time after which toast needs to be hidden
                                stack: 6, // false if there should be only one toast at a time or a number representing the maximum number of toasts to be shown at a time                          
                                textAlign: 'left',  // Text alignment i.e. left, right or center
                                loader: true,  // Whether to show loader or not. True by default
                                loaderBg: '#9EC600',  // Background color of the toast loader
                                beforeShow: function () { }, // will be triggered before the toast is shown
                                afterShown: function () { }, // will be triggered after the toat has been shown
                                beforeHide: function () { }, // will be triggered before the toast gets hidden
                                afterHidden: function () { }  // will be triggered after the toast has been hidden
                            });
                        }
                        if (response.error != null) {
                            $.toast({
                                heading: response.error.heading,
                                text: response.error.description,
                                icon: response.error.status,
                                loader: true,        // Change it to false to disable loader
                                position: 'top-right',
                                showHideTransition: 'plain', // fade, slide or plain
                                allowToastClose: true, // Boolean value true or false
                                hideAfter: 4000, // false to make it sticky or number representing the miliseconds as time after which toast needs to be hidden
                                stack: 6, // false if there should be only one toast at a time or a number representing the maximum number of toasts to be shown at a time                          
                                textAlign: 'left',  // Text alignment i.e. left, right or center
                                loader: true,  // Whether to show loader or not. True by default
                                loaderBg: '#9EC600',  // Background color of the toast loader
                                beforeShow: function () { }, // will be triggered before the toast is shown
                                afterShown: function () { }, // will be triggered after the toat has been shown
                                beforeHide: function () { }, // will be triggered before the toast gets hidden
                                afterHidden: function () { }  // will be triggered after the toast has been hidden
                            });
                        }
                    }
                }
            });
        }
    });
    $('#formProdutoTamanho').validate({
        rules: {
            cad_descricao: {
                required: true,
                minlength: 4
            },
            cad_abreviacao: {
                required: true,
                minlength: 1
            }
        },
        messages: {
            cad_descricao: {
                required: "A descriçao deve ser informado!",
                minlength: "A descriçao deve conter no minimo 4 caracteres!"
            },
            cad_abreviacao: {
                required: "A abreviação deve ser informado!",
                minlength: "A abreviação deve conter no minimo 1 caracteres!"
            }
        },
        errorElement: 'span',
        errorPlacement: function (error, element) {
            error.addClass('invalid-feedback');
            element.closest('.form-group').append(error);
            document.getElementById("submit").disabled = false;
        },
        highlight: function (element, errorClass, validClass) {
            $(element).addClass('is-invalid');
            document.getElementById("submit").disabled = true;
        },
        unhighlight: function (element, errorClass, validClass) {
            $(element).removeClass('is-invalid');
            document.getElementById("submit").disabled = false;
        }
    });
    //  MODULO CADASTRO - AUXILIA - PRODUTO
    $("#formProdutoCadastro").submit(function (e) {
        e.preventDefault();
        document.getElementById("submit").disabled = true;
    });
    $.validator.setDefaults({
        submitHandler: function () {
            var form = $('#formProdutoCadastro');
            var url = form.attr('action');
            var origen_form = document.getElementById('form').value;
            $.ajax({
                url: url,
                type: "POST",
                data: $('#formProdutoCadastro').serialize(),
                dataType: "json",
                success: function (response) {
                    console.log(response);
                    if (response.status == true) {
                        $.toast({
                            heading: response.menssagem.heading,
                            text: response.menssagem.description,
                            icon: response.menssagem.status,
                            loader: true,        // Change it to false to disable loader
                            position: 'top-right',
                            showHideTransition: 'plain', // fade, slide or plain
                            allowToastClose: true, // Boolean value true or false
                            hideAfter: 4000, // false to make it sticky or number representing the miliseconds as time after which toast needs to be hidden
                            stack: 6, // false if there should be only one toast at a time or a number representing the maximum number of toasts to be shown at a time                          
                            textAlign: 'left',  // Text alignment i.e. left, right or center
                            loader: true,  // Whether to show loader or not. True by default
                            loaderBg: '#9EC600',  // Background color of the toast loader
                            beforeShow: function () { }, // will be triggered before the toast is shown
                            afterShown: function () {
                                if (origen_form == 'produto') {
                                    setTimeout(function () {
                                        window.location.reload(1);
                                    }, 900);
                                }
                            }, // will be triggered after the toat has been shown
                            beforeHide: function () { }, // will be triggered before the toast gets hidden
                            afterHidden: function () { }  // will be triggered after the toast has been hidden
                        });
                    } else {
                        if (response.menssagem != null) {
                            $.toast({
                                heading: response.menssagem.heading,
                                text: response.menssagem.description,
                                icon: response.menssagem.status,
                                loader: true,        // Change it to false to disable loader
                                position: 'top-right',
                                showHideTransition: 'plain', // fade, slide or plain
                                allowToastClose: true, // Boolean value true or false
                                hideAfter: 4000, // false to make it sticky or number representing the miliseconds as time after which toast needs to be hidden
                                stack: 6, // false if there should be only one toast at a time or a number representing the maximum number of toasts to be shown at a time                          
                                textAlign: 'left',  // Text alignment i.e. left, right or center
                                loader: true,  // Whether to show loader or not. True by default
                                loaderBg: '#9EC600',  // Background color of the toast loader
                                beforeShow: function () { }, // will be triggered before the toast is shown
                                afterShown: function () { }, // will be triggered after the toat has been shown
                                beforeHide: function () { }, // will be triggered before the toast gets hidden
                                afterHidden: function () { }  // will be triggered after the toast has been hidden
                            });
                        }
                        if (response.error != null) {
                            $.toast({
                                heading: response.error.heading,
                                text: response.error.description,
                                icon: response.error.status,
                                loader: true,        // Change it to false to disable loader
                                position: 'top-right',
                                showHideTransition: 'plain', // fade, slide or plain
                                allowToastClose: true, // Boolean value true or false
                                hideAfter: 4000, // false to make it sticky or number representing the miliseconds as time after which toast needs to be hidden
                                stack: 6, // false if there should be only one toast at a time or a number representing the maximum number of toasts to be shown at a time                          
                                textAlign: 'left',  // Text alignment i.e. left, right or center
                                loader: true,  // Whether to show loader or not. True by default
                                loaderBg: '#9EC600',  // Background color of the toast loader
                                beforeShow: function () { }, // will be triggered before the toast is shown
                                afterShown: function () { }, // will be triggered after the toat has been shown
                                beforeHide: function () { }, // will be triggered before the toast gets hidden
                                afterHidden: function () { }  // will be triggered after the toast has been hidden
                            });
                        }
                    }
                }
            });
        }
    });
    $('#formProdutoCadastro').validate({
        rules: {
            cad_descricao: {
                required: true,
                minlength: 4
            },
            "cod_categoria[]": {
                required: true,
            },
            "cod_subcategoria[]": {
                required: true,
            },
            "cod_frabricante[]": {
                required: true,
            }
        },
        messages: {
            cad_descricao: {
                required: "A descriçao deve ser informado!",
                minlength: "A descriçao deve conter no minimo 4 caracteres!"
            },
            cod_categoria: {
                required: "A categoria deve ser informado!",
            },
            cod_subcategoria: {
                required: "A subcategoria deve ser informado!",
            },
            cod_frabricante: {
                required: "O frabricante deve ser informado!",
            }
        },
        errorElement: 'span',
        errorPlacement: function (error, element) {
            error.addClass('invalid-feedback');
            element.closest('.form-group').append(error);
            document.getElementById("submit").disabled = false;
        },
        highlight: function (element, errorClass, validClass) {
            $(element).addClass('is-invalid');
            document.getElementById("submit").disabled = true;
        },
        unhighlight: function (element, errorClass, validClass) {
            $(element).removeClass('is-invalid');
            document.getElementById("submit").disabled = false;
        }
    });

    // MODULO CONFIGURACAO - GRUPO DE ACESSO
    $("#formGrupoAcesso").submit(function (e) {
        e.preventDefault();
    });
    $.validator.setDefaults({
        submitHandler: function () {
            var form = $('#formGrupoAcesso');
            var url = form.attr('action');
            $.ajax({
                url: url,
                type: "POST",
                data: $('#formGrupoAcesso').serialize(),
                dataType: "json",
                success: function (response) {
                    if (response.status == true) {
                        $.toast({
                            heading: response.menssagem.heading,
                            text: response.menssagem.description,
                            icon: response.menssagem.status,
                            loader: true,        // Change it to false to disable loader
                            position: 'top-right',
                            showHideTransition: 'plain', // fade, slide or plain
                            allowToastClose: true, // Boolean value true or false
                            hideAfter: 4000, // false to make it sticky or number representing the miliseconds as time after which toast needs to be hidden
                            stack: 6, // false if there should be only one toast at a time or a number representing the maximum number of toasts to be shown at a time                          
                            textAlign: 'left',  // Text alignment i.e. left, right or center
                            loader: true,  // Whether to show loader or not. True by default
                            loaderBg: '#9EC600',  // Background color of the toast loader
                            beforeShow: function () { }, // will be triggered before the toast is shown
                            afterShown: function () {
                                setTimeout(function () {
                                    window.location.reload(1);
                                }, 900);
                            }, // will be triggered after the toat has been shown
                            beforeHide: function () { }, // will be triggered before the toast gets hidden
                            afterHidden: function () { }  // will be triggered after the toast has been hidden
                        });

                    } else {
                        if (response.menssagem != null) {
                            $.toast({
                                heading: response.menssagem.heading,
                                text: response.menssagem.description,
                                icon: response.menssagem.status,
                                loader: true,        // Change it to false to disable loader
                                position: 'top-right',
                                showHideTransition: 'plain', // fade, slide or plain
                                allowToastClose: true, // Boolean value true or false
                                hideAfter: 4000, // false to make it sticky or number representing the miliseconds as time after which toast needs to be hidden
                                stack: 6, // false if there should be only one toast at a time or a number representing the maximum number of toasts to be shown at a time                          
                                textAlign: 'left',  // Text alignment i.e. left, right or center
                                loader: true,  // Whether to show loader or not. True by default
                                loaderBg: '#9EC600',  // Background color of the toast loader
                                beforeShow: function () { }, // will be triggered before the toast is shown
                                afterShown: function () { }, // will be triggered after the toat has been shown
                                beforeHide: function () { }, // will be triggered before the toast gets hidden
                                afterHidden: function () { }  // will be triggered after the toast has been hidden
                            });
                        }
                        if (response.error != null) {
                            $.toast({
                                heading: response.error.heading,
                                text: response.error.description,
                                icon: response.error.status,
                                loader: true,        // Change it to false to disable loader
                                position: 'top-right',
                                showHideTransition: 'plain', // fade, slide or plain
                                allowToastClose: true, // Boolean value true or false
                                hideAfter: 4000, // false to make it sticky or number representing the miliseconds as time after which toast needs to be hidden
                                stack: 6, // false if there should be only one toast at a time or a number representing the maximum number of toasts to be shown at a time                          
                                textAlign: 'left',  // Text alignment i.e. left, right or center
                                loader: true,  // Whether to show loader or not. True by default
                                loaderBg: '#9EC600',  // Background color of the toast loader
                                beforeShow: function () { }, // will be triggered before the toast is shown
                                afterShown: function () { }, // will be triggered after the toat has been shown
                                beforeHide: function () { }, // will be triggered before the toast gets hidden
                                afterHidden: function () { }  // will be triggered after the toast has been hidden
                            });
                        }
                    }
                }
            });
        }
    });
    $('#formGrupoAcesso').validate({
        rules: {
            cad_descricao: {
                required: true,
                minlength: 4
            }
        },
        messages: {
            cad_descricao: {
                required: "A descriçao deve ser informado",
                minlength: "A descriçao deve conter no minimo 4 caracteres"
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
    // FORMULARIO DE PERMISSÕES
    $("#formPermissoes").submit(function (e) {
        e.preventDefault();
        setTimeout(function () {
            window.location.reload(1);
        });
    });

});

function editFormPermissoes() {
    var permissao = document.getElementById('grupoSelecionado').value;
    $.ajax({
        url: base_url + "api/configuracao/grupoacesso/permissaoacesso/" + permissao,
        type: "get",
        dataType: "json",
        success: function (data) {
            for (var i = 0; i < data.length; i++) {
                var obj = data[i];
                for (var key in obj) {

                    if (obj.per_acesso == 'S') {
                        document.getElementById("per_acesso" + obj.cod_modulo).checked = true;
                    } else {
                        document.getElementById("neg_acesso" + obj.cod_modulo).checked = true;
                    }
                    if (obj.per_editar == 'S') {
                        document.getElementById("per_editar" + obj.cod_modulo).checked = true;
                    } else {
                        document.getElementById("neg_editar" + obj.cod_modulo).checked = true;
                    }
                    if (obj.per_deletar == 'S') {
                        document.getElementById("per_deletar" + obj.cod_modulo).checked = true;
                    } else {
                        document.getElementById("neg_deletar" + obj.cod_modulo).checked = true;
                    }

                }
            }

        }
    });
}

function updateFormPermissoes(modulo, metodo, valor) {
    var permissao = $('#grupoSelecionado').val();
    $.ajax({
        url: base_url + "api/configuracao/grupoacesso/save/permissao",
        type: "post",
        data: ({
            cod_permissao: permissao,
            cod_modulo: modulo,
            cad_metodo: metodo,
            cad_valor: valor,
        }),
        dataType: "json",
        success: function (data) {
            respostaToast(data);

        }
    });
}

function resetFormGrupoAcesso() {
    document.getElementById('titleModalGrupoAcesso').innerHTML = 'Cadastro de Grupo de Acesso ';
    var permissao = document.getElementById('cod_permissao').value;
    if (permissao != null || permissao != '') {
        document.getElementById('formGrupoAcesso').reset();
    }
}

function editFormGrupoAcesso() {
    document.getElementById('titleModalGrupoAcesso').innerHTML = 'Atualizar de Grupo de Acesso ';
    var permissao = document.getElementById('grupoSelecionado').value;
    $.ajax({
        url: base_url + "api/configuracao/grupoacesso/permissao/" + permissao,
        type: "get",
        dataType: "json",
        success: function (data) {
            document.getElementById("cod_permissao").value = data.cod_permisao;
            document.getElementById("cad_descricao").value = data.cad_descricao;
        }
    });
}

function respostaToast(response) {
    if (response.status == true) {
        $.toast({
            heading: response.menssagem.heading,
            text: response.menssagem.description,
            icon: response.menssagem.status,
            loader: true,        // Change it to false to disable loader
            position: 'top-right',
            showHideTransition: 'plain', // fade, slide or plain
            allowToastClose: true, // Boolean value true or false
            hideAfter: 4000, // false to make it sticky or number representing the miliseconds as time after which toast needs to be hidden
            stack: 6, // false if there should be only one toast at a time or a number representing the maximum number of toasts to be shown at a time                          
            textAlign: 'left',  // Text alignment i.e. left, right or center
            loader: true,  // Whether to show loader or not. True by default
            loaderBg: '#9EC600',  // Background color of the toast loader
            beforeShow: function () { }, // will be triggered before the toast is shown
            afterShown: function () { }, // will be triggered after the toat has been shown
            beforeHide: function () { }, // will be triggered before the toast gets hidden
            afterHidden: function () { }  // will be triggered after the toast has been hidden
        });

    } else {
        if (response.menssagem != null) {
            $.toast({
                heading: response.menssagem.heading,
                text: response.menssagem.description,
                icon: response.menssagem.status,
                loader: true,        // Change it to false to disable loader
                position: 'top-right',
                showHideTransition: 'plain', // fade, slide or plain
                allowToastClose: true, // Boolean value true or false
                hideAfter: 4000, // false to make it sticky or number representing the miliseconds as time after which toast needs to be hidden
                stack: 6, // false if there should be only one toast at a time or a number representing the maximum number of toasts to be shown at a time                          
                textAlign: 'left',  // Text alignment i.e. left, right or center
                loader: true,  // Whether to show loader or not. True by default
                loaderBg: '#9EC600',  // Background color of the toast loader
                beforeShow: function () { }, // will be triggered before the toast is shown
                afterShown: function () {
                    setTimeout(function () {
                        window.location.reload(1);
                    }, 3000);
                }, // will be triggered after the toat has been shown
                beforeHide: function () { }, // will be triggered before the toast gets hidden
                afterHidden: function () { }  // will be triggered after the toast has been hidden
            });
        }
        if (response.error != null) {
            $.toast({
                heading: response.error.heading,
                text: response.error.description,
                icon: response.error.status,
                loader: true,        // Change it to false to disable loader
                position: 'top-right',
                showHideTransition: 'plain', // fade, slide or plain
                allowToastClose: true, // Boolean value true or false
                hideAfter: 4000, // false to make it sticky or number representing the miliseconds as time after which toast needs to be hidden
                stack: 6, // false if there should be only one toast at a time or a number representing the maximum number of toasts to be shown at a time                          
                textAlign: 'left',  // Text alignment i.e. left, right or center
                loader: true,  // Whether to show loader or not. True by default
                loaderBg: '#9EC600',  // Background color of the toast loader
                beforeShow: function () { }, // will be triggered before the toast is shown
                afterShown: function () { }, // will be triggered after the toat has been shown
                beforeHide: function () { }, // will be triggered before the toast gets hidden
                afterHidden: function () { }  // will be triggered after the toast has been hidden
            });
        }
    }
}