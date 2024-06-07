<?php

use CodeIgniter\Router\RouteCollection;

/**
 * @var RouteCollection $routes
 */
// $routes->get('/', 'Home::index');
$routes->addRedirect('/', 'autenticacao/login');

// service('auth')->routes($routes);

// Modulo APP Relatorio
$routes->group('autenticacao', ['namespace' => 'App\Controllers\App'], function ($routes) {
    // Redirecionamento  para o Login
    $routes->addRedirect('/', 'autenticacao/login');

    $routes->get('login', 'Autenticacao::index', ['filter' => 'autenticado']);
    $routes->get('logout', 'Autenticacao::logout');

    $routes->get('forgot/password', 'Autenticacao::EsqueciSenha', ['filter' => 'autenticado']);
    $routes->get('recover/password', 'Autenticacao::RedefinirSenha', ['filter' => 'autenticado']);
});

// Rota Api
$routes->group('api', function ($routes) {

    $routes->group('valida', ['namespace' => 'App\Controllers\Api'], function ($routes) {
        $routes->get('cep/(:segment)', 'Valida::cep/$1');
        $routes->get('cnpj/(:segment)', 'Valida::cnpj/$1');
    });

    $routes->group('autenticacao', ['namespace' => 'App\Controllers\Api\v1'], function ($routes) {
        $routes->post('login', 'Autenticacao::login');
        $routes->post('forgot/password', 'Autenticacao::esqueciSenha');
        $routes->post('recover/password', 'Autenticacao::RedefinirSenha');
    });

    // Modulo API Cadastro
    $routes->group('cadastro', ['namespace' => 'App\Controllers\Api\v1\Cadastro', 'filter' => 'auth'], function ($routes) {

        // Carrega dados da TableDatta
        $routes->group('tabela', function ($routes) {
            $routes->post('pessoas', 'Pessoas::getCarregaTabela');
            $routes->post('profissoes', 'Profissoes::getCarregaTabela');
            $routes->post('produtos', 'Produtos::getCarregaTabela');
            $routes->post('(:segment)/categorias', 'Categorias::getCarregaTabela/$1');
            $routes->post('(:segment)/tamanhos', 'Tamanhos::getCarregaTabela/$1');
            $routes->group('grade', function ($routes) {
                $routes->get('produto/(:segment)', 'ProdutoGrade::getCarregaTabela/$1');
                $routes->get('tamanho', 'ProdutoGrade::addGradeProduto');
            });
        });

        // Salvar dados Cadastro
        $routes->group('salvar', function ($routes) {
            $routes->post('pessoa', 'Pessoas::save');
            $routes->post('profissao', 'Profissoes::save');
            $routes->post('produto', 'Produtos::save');
            $routes->post('categoria', 'Categorias::save');
            $routes->post('tamanho', 'Tamanhos::save');

            $routes->group('grade', function ($routes) {
                $routes->post('produto', 'ProdutoGrade::save');
            });
        });

        // Exibir dados Cadastro
        $routes->group('exibir', function ($routes) {

            $routes->group('pessoas', function ($routes) {
                $routes->get('/', 'Pessoas::findAll');
                $routes->get('clientes', 'Pessoas::clientes');
                $routes->get('fornecedores', 'Pessoas::fornecedores');
            });

            $routes->get('profissoes', 'Profissoes::findAll');
            $routes->get('produtos', 'Produtos::findAll');
            $routes->get('(:segment)/categorias', 'Categorias::findAll/$1');
            $routes->get('categorias', 'Categorias::findAll');
            $routes->get('(:segment)/tamanhos', 'Tamanhos::findAll/$1');

            $routes->get('pessoa/(:segment)', 'Pessoas::show/$1');
            $routes->get('profissao/(:segment)', 'Profissoes::show/$1');
            $routes->get('produto/(:segment)', 'Produtos::show/$1');
            $routes->get('categoria/(:segment)', 'Categorias::show/$1');
            $routes->get('tamanho/(:segment)', 'Tamanhos::show/$1');

            $routes->group('categoria', function ($routes) {
                $routes->get('subcategorias/(:segment)', 'SubCategorias::getCagetoriaFiltro/$1');
            });

            $routes->group('grade', function ($routes) {
                $routes->get('produto/tamanho/(:segment)', 'ProdutoGrade::addGradeProduto/$1');
            });

            // AUTO COMPLETE E AJAX BUSCAR DE DADOS search
            $routes->group('busca', function ($routes) {
                $routes->get('produto', 'Produtos::selectBuscaProdutos/$1');
                $routes->get('produto/(:segment)', 'Produtos::selectBuscaProdutos/$1');
                $routes->get('produtograde', 'ProdutoGrade::selectBuscaProdutosGrade/$1');
                $routes->get('produtograde/(:segment)', 'ProdutoGrade::selectBuscaProdutosGrade/$1');

                $routes->group('grade', function ($routes) {
                    $routes->post('produto', 'ProdutoGrade::getGradeProduto');
                    $routes->post('produtos', 'ProdutoGrade::getGradesProduto');
                });
            });
        });

        // Criar as Consultas
        $routes->group('consulta', function ($routes) {
            $routes->post('pessoa/documento', 'Pessoas::checkDocumento');
            $routes->post('contabancaria', 'ContaBancaria::optionContaBancaria');
        });

        // Deletar dados Cadastro
        $routes->group('remover', function ($routes) {
            $routes->post('pessoa/(:segment)', 'Pessoas::remove/$1');
            $routes->post('profissao/(:segment)', 'Profissoes::remove/$1');
            $routes->post('produto/(:segment)', 'Produtos::remove/$1');
            $routes->post('categoria/(:segment)', 'Categorias::remove/$1');
            $routes->post('subcategoria/(:segment)', 'SubCategorias::remove/$1');
            $routes->post('fabricante/(:segment)', 'Fabricantes::remove/$1');
            $routes->post('tamanho/(:segment)', 'Tamanhos::remove/$1');
        });

        // Exibir dados Cadastro
        $routes->group('arquivar', function ($routes) {
            $routes->get('pessoa/(:segment)', 'Pessoas::arquivar/$1');
            $routes->get('profissao/(:segment)', 'Profissoes::arquivar/$1');
            $routes->get('produto/(:segment)', 'Produtos::arquivar/$1');
            $routes->get('categoria/(:segment)', 'Categorias::arquivar/$1');
            $routes->get('subcategoria/(:segment)', 'SubCategorias::arquivar/$1');
            $routes->get('fabricante/(:segment)', 'Fabricantes::arquivar/$1');
            $routes->get('tamanho/(:segment)', 'Tamanhos::arquivar/$1');
        });
    });

    // Modulo API Cadastro
    $routes->group('projeto', ['namespace' => 'App\Controllers\Api\v1\Projeto', 'filter' => 'auth'], function ($routes) {

        // Carrega dados da TableDatta
        $routes->group('tabela', function ($routes) {
            $routes->post('obras', 'Obras::getCarregaTabela');
            $routes->post('produtoorcamento', 'Locais::getCarregaTabelaLocalProduto');
            $routes->post('servicoorcamento', 'Locais::getCarregaTabelaLocalServico');
        });

        // Salvar dados Cadastro
        $routes->group('salvar', function ($routes) {
            $routes->post('obra', 'Obras::save');
            $routes->post('local', 'Locais::save');
        });

        // Exibir dados Cadastro
        $routes->group('exibir', function ($routes) {

            $routes->group('pessoas', function ($routes) {
                $routes->get('/', 'Pessoas::findAll');
                $routes->get('clientes', 'Pessoas::clientes');
                $routes->get('fornecedores', 'Pessoas::fornecedores');
            });

            $routes->get('obra', 'Obras::findAll');
            $routes->get('local', 'Locais::findAll');
            $routes->get('categorias', 'Categorias::findAll');
            $routes->get('subcategorias', 'SubCategorias::findAll');
            $routes->get('fabricantes', 'Fabricantes::findAll');
            $routes->get('tamanhos', 'Tamanhos::findAll');

            $routes->get('obra/(:segment)', 'Obras::show/$1');
            $routes->get('local/(:segment)', 'Locais::show/$1');
            $routes->get('produto/(:segment)', 'Produtos::show/$1');
            $routes->get('categoria/(:segment)', 'Categorias::show/$1');
            $routes->get('subcategoria/(:segment)', 'SubCategorias::show/$1');
            $routes->get('fabricante/(:segment)', 'Fabricantes::show/$1');
            $routes->get('tamanho/(:segment)', 'Tamanhos::show/$1');

            $routes->group('categoria', function ($routes) {
                $routes->get('subcategorias/(:segment)', 'SubCategorias::getCagetoriaFiltro/$1');
            });

            $routes->group('detalhe', function ($routes) {
                $routes->get('produto/(:segment)', 'Locais::addGradeProduto/$1');
            });

            // AUTO COMPLETE E AJAX BUSCAR DE DADOS search
            $routes->group('busca', function ($routes) {
                $routes->get('obra', 'Obras::selectBuscaProdutos/$1');
                $routes->get('obra/(:segment)', 'Produtos::selectBuscaProdutos/$1');
                $routes->get('produtograde', 'ProdutoGrade::selectBuscaProdutosGrade/$1');
                $routes->get('produtograde/(:segment)', 'ProdutoGrade::selectBuscaProdutosGrade/$1');

                $routes->group('grade', function ($routes) {
                    $routes->post('produto', 'ProdutoGrade::getGradeProduto');
                    $routes->post('produtos', 'ProdutoGrade::getGradesProduto');
                });
            });
        });

        // Criar as Consultas
        $routes->group('consulta', function ($routes) {
            $routes->post('resumo/projeto', 'Locais::getCarregaResumoLocal');
            $routes->post('contabancaria', 'ContaBancaria::optionContaBancaria');
        });

        // Deletar dados Cadastro
        $routes->group('remover', function ($routes) {
            $routes->post('obra/(:segment)', 'Obras::remove/$1');
            $routes->post('profissao/(:segment)', 'Profissoes::remove/$1');
            $routes->post('produto/(:segment)', 'Produtos::remove/$1');
            $routes->post('categoria/(:segment)', 'Categorias::remove/$1');
            $routes->post('subcategoria/(:segment)', 'SubCategorias::remove/$1');
            $routes->post('fabricante/(:segment)', 'Fabricantes::remove/$1');
            $routes->post('tamanho/(:segment)', 'Tamanhos::remove/$1');
        });

        // Exibir dados Cadastro
        $routes->group('arquivar', function ($routes) {
            $routes->get('obra/(:segment)', 'Obras::arquivar/$1');
            $routes->get('profissao/(:segment)', 'Profissoes::arquivar/$1');
            $routes->get('produto/(:segment)', 'Produtos::arquivar/$1');
            $routes->get('categoria/(:segment)', 'Categorias::arquivar/$1');
            $routes->get('subcategoria/(:segment)', 'SubCategorias::arquivar/$1');
            $routes->get('fabricante/(:segment)', 'Fabricantes::arquivar/$1');
            $routes->get('tamanho/(:segment)', 'Tamanhos::arquivar/$1');
        });

        // ROTA PARA GENRENCIA OS ORÇAMENTOS
        $routes->group('orcamento', function ($routes) {
            $routes->post('novo', 'Vendas::sale');
            $routes->post('finaliza', 'Vendas::finish');

            $routes->group('exibir', function ($routes) {
                $routes->post('produto', 'Vendas::getDetalheOrcamento');
            });

            $routes->group('inclui', function ($routes) {
                $routes->post('produto', 'Locais::addProdutoOrcamento');
            });

            $routes->group('remove', function ($routes) {
                $routes->post('produto', 'Vendas::delProdutoOrcamento');
            });
        });
    });

    // Modulo API Configuracao
    $routes->group('configuracao', ['namespace' => 'App\Controllers\Api\v1\Configuracao', 'filter' => 'auth'], function ($routes) {

        // Carrega dados da TableDatta
        $routes->group('tabela', function ($routes) {

            $routes->post('bancos', 'Bancos::getCarregaTabela');
            $routes->post('bandeiras', 'Bandeiras::getCarregaTabela');
            $routes->post('formaspagamentos', 'FormasPagamentos::getCarregaTabela');
            $routes->post('formasparcelamentos', 'FormaParcelamentos::getCarregaTabela');
            $routes->post('contasbancarias', 'ContasBancarias::getCarregaTabela');
            $routes->post('maquinascartoes', 'MaquinaCartao::getCarregaTabela');
            $routes->post('vendedores', 'Vendedor::getCarregaTabela');

            $routes->post('empresas', 'Empresa::getCarregaTabela');

            $routes->post('usuarios', 'Usuario::getCarregaTabela');
            $routes->post('gruposdeacesso', 'ControleAcesso::getCarregaTabela');
        });

        // Salvar dados Configuracao
        $routes->group('salvar', function ($routes) {
            $routes->post('banco', 'Bancos::save');
            $routes->post('bandeira', 'Bandeiras::save');
            $routes->post('contabancaria', 'ContasBancarias::save');
            $routes->post('maquinacartao', 'MaquinaCartao::save');
            $routes->post('formapagamento', 'FormasPagamentos::save');
            $routes->post('formaparcelamento', 'FormaParcelamentos::save');
            $routes->post('grupodeacesso', 'ControleAcesso::save');

            $routes->post('vendedor', 'Vendedor::save');

            $routes->post('empresa', 'Empresa::save');

            $routes->group('usuario', function ($routes) {
                $routes->post('/', 'Usuario::save');
                $routes->post('senha', 'Usuario::updatePassword');
            });
        });

        // Exibir dados Configuracao
        $routes->group('exibir', function ($routes) {
            $routes->get('bancos', 'Bancos::findAll');
            $routes->get('bandeiras', 'Bandeiras::findAll');
            $routes->get('formapagamento', 'FormasPagamentos::findAll');
            $routes->get('contasbancarias', 'ContasBancarias::findAll');
            $routes->get('maquinacartao', 'MaquinaCartao::findAll');
            $routes->get('gruposdeacesso', 'ControleAcesso::findAll');
            $routes->get('parcela', 'Parcela::findAll');

            $routes->get('empresas', 'Empresa::findAll');

            $routes->get('vendedor', 'Vendedor::findAll');

            $routes->get('banco/(:segment)', 'Bancos::show/$1');
            $routes->get('bandeira/(:segment)', 'Bandeiras::show/$1');
            $routes->get('formapagamento/(:segment)', 'FormasPagamentos::show/$1');
            $routes->get('contabancaria/(:segment)', 'ContasBancarias::show/$1');
            $routes->get('maquinacartao/(:segment)', 'MaquinaCartao::show/$1');
            $routes->get('grupodeacesso/(:segment)', 'ControleAcesso::show/$1');

            $routes->get('empresa/(:segment)', 'Empresa::show/$1');

            $routes->group('formasparcelamentos', function ($routes) {
                $routes->get('(:segment)/(:segment)', 'FormaParcelamentos::findAll/$1/$2');
                $routes->get('bandeira/(:segment)/(:segment)', 'FormaParcelamentos::addParcelaBandeira/$1/$2');
                $routes->get('tamanho', 'ProdutoGrade::addGradeProduto');
            });

            $routes->get('vendedor/(:segment)', 'Vendedor::show/$1');

            $routes->get('usuario/(:segment)', 'Usuario::show/$1');
            $routes->get('grupoacesso/permissao', 'ControleAcesso::getPermissoes');
        });

        // Exibir dados Cadastro
        $routes->group('arquivar', function ($routes) {
            $routes->get('formapagamento/(:segment)', 'FormasPagamentos::arquivar/$1');
            $routes->get('contabancaria/(:segment)', 'ContasBancarias::arquivar/$1');
            $routes->get('maquinacartao/(:segment)', 'MaquinaCartao::arquivar/$1');
        });
        // Criar as Consultas
        $routes->group('consulta', function ($routes) {
            $routes->post('contabancaria', 'ContasBancarias::optionContaBancaria');
            $routes->post('formaspagamentos', 'FormasPagamentos::optionFormaPagamento');
            $routes->get('formaparcelamento/(:segment)', 'FormasPagamentos::showFormaParcelamento/$1');
            $routes->get('bandeira/(:segment)', 'FormasPagamentos::showBandeiraParcelamento/$1');
        });

        //  Modulo para Controle de Acessos
        $routes->get('grupoacesso/show/(:segment)', 'ControleAcesso::show/$1');
        $routes->post('grupoacesso', 'ControleAcesso::create');
        $routes->post('grupoacesso/save/modulo', 'ControleAcesso::grupoSave');
        $routes->post('grupoacesso/save/permissao', 'ControleAcesso::permissaoSave');

        $routes->get('grupoacesso/modulo/(:segment)', 'ControleAcesso::getModulo/$1');
        $routes->get('grupoacesso/permissao', 'ControleAcesso::getPermissao');
        $routes->get('grupoacesso/permissao/(:segment)', 'ControleAcesso::getPermissaoShow/$1');
        $routes->get('grupoacesso/permissaoacesso/(:segment)', 'ControleAcesso::getPermissaoModulos/$1');
        $routes->post('grupoacesso/permissao', 'ControleAcesso::postPermissao');
    });

    // Modulo API Financeiro
    $routes->group('financeiro', ['namespace' => 'App\Controllers\Api\v1\Financeiro', 'filter' => 'auth'], function ($routes) {

        // Carrega dados da TableData
        $routes->group('tabela', function ($routes) {
            $routes->post('contaspagar', 'Contas::getCarregaTabelaByFornecedor');
            $routes->post('contasreceber', 'Contas::getCarregaTabelaByCliente');

            $routes->post('grupos', 'Grupo::getCarregaTabela');
            $routes->post('subgrupos', 'Subgrupo::getCarregaTabela');

            $routes->group('pagamentos', function ($routes) {
                $routes->post('contaspagar', 'ContaPagar::getPagamentosTabela');
                $routes->post('contasreceber', 'ContaReceber::getPagamentosTabela');
            });
        });

        // Salvar dados Cadastro
        $routes->group('salvar', function ($routes) {
            $routes->post('contapagar', 'Contas::save');
            $routes->post('contareceber', 'Contas::save');
            $routes->post('grupo', 'Grupo::save');
            $routes->post('subgrupo', 'Subgrupo::save');
        });

        //Pagamentos 

        $routes->group('contaspagar', function ($routes) {
            $routes->get('/', 'Contas::show');
            $routes->post('/', 'ContaPagar::findAllWhere');

            $routes->post('payment', 'ContaPagar::savePayment');
        });

        $routes->group('contasreceber', function ($routes) {
            $routes->get('/', 'Contas::show');
            $routes->post('/', 'ContaReceber::findAllWhere');

            $routes->post('payment', 'ContaReceber::savePayment');
        });

        // Exibir dados Financeiro
        $routes->group('exibir', function ($routes) {

            $routes->get('grupos', 'Grupo::findAll');

            $routes->group('contaspagar', function ($routes) {
                $routes->get('/(:segment)', 'Contas::show/$1');
                $routes->post('/(:segment)', 'Contas::show/$1');
                // $routes->post('/', 'ContaPagar::findAllWhere');
            });

            $routes->group('contasreceber', function ($routes) {
                $routes->get('/(:segment)', 'Contas::show/$1');
                $routes->post('/(:segment)', 'Contas::show/$1');
                // $routes->post('/', 'ContaReceber::findAllWhere');

                $routes->post('payment', 'ContaReceber::savePayment');
            });


            $routes->group('subgrupos', function ($routes) {
                $routes->get('/', 'Subgrupo::findAll');
                $routes->get('receitas', 'Subgrupo::subgruposReceitas');
                $routes->get('despesas', 'Subgrupo::subgruposDespesas');
            });

            $routes->get('contapagar/(:segment)', 'ContaPagar::show/$1');
            $routes->get('contareceber/(:segment)', 'ContaReceber::show/$1');
            $routes->get('grupo/(:segment)', 'Grupo::show/$1');
            $routes->get('subgrupo/(:segment)', 'Subgrupo::show/$1');

            $routes->group('grupo', function ($routes) {
                $routes->get('subgrupos/(:segment)', 'Subgrupo::getGrupoFiltro/$1');
            });
        });

        // Arquivar dados Cadastro
        $routes->group('arquivar', function ($routes) {
            $routes->get('contaspagar/(:segment)', 'ContaPagar::arquivar/$1');
            $routes->get('contasreceber/(:segment)', 'ContaReceber::arquivar/$1');
            $routes->get('grupo/(:segment)', 'Grupo::arquivar/$1');
            $routes->get('subgrupo/(:segment)', 'Subgrupo::arquivar/$1');
        });
    });

    // Modulo API Relatorio
    $routes->group('relatorio', ['namespace' => 'App\Controllers\Api\v1\Relatorio'], function ($routes) {
        // Contas a Pagar
        $routes->get('contapagar', 'ContaPagar::getAll');
        $routes->get('contapagar/show/(:segment)', 'ContaPagar::show/$1');
        $routes->get('contapagar/(:segment)', 'ContaPagar::show/$1');
        $routes->post('contapagar', 'ContaPagar::create');
        $routes->post('contapagar/update/(:segment)', 'ContaPagar::update/$1');
        $routes->post('contapagar/remove/(:segment)', 'ContaPagar::remove/$1');
        // Contas a Receber
        $routes->get('contareceber', 'ContaReceber::getAll');
        $routes->get('contareceber/show/(:segment)', 'ContaReceber::show/$1');
        $routes->get('contareceber/(:segment)', 'ContaReceber::show/$1');
        $routes->post('contareceber', 'ContaReceber::create');
        $routes->post('contareceber/update/(:segment)', 'ContaReceber::update/$1');
        $routes->post('contareceber/remove/(:segment)', 'ContaReceber::remove/$1');
    });

    // Modulo API Venda
    $routes->group('venda', ['namespace' => 'App\Controllers\Api\v1\Venda'], function ($routes) {

        // Carrega dados da TableDatta
        $routes->group('tabela', function ($routes) {
            $routes->group('orcamento', function ($routes) {
                $routes->post('aberto', 'Vendas::getOrcamentoAbertoTabela');
            });
            $routes->group('caixa', function ($routes) {
                $routes->post('fechado', 'Caixas::getCarregaTabelaFechado');
            });
            $routes->group('recebimento', function ($routes) {
                $routes->post('vendareceber', 'Vendas::getCarregaTabelaRecebimento');
            });
        });

        // ATUALIZA DADOS DA TABELA
        $routes->group('atualiza', function ($routes) {

            // APLICA OS PAGAMENTO NAS VENDAS
            $routes->group('pagamento', function ($routes) {
                $routes->post('venda', 'Caixas::paymentVenda');
            });

            // APLICA O DESCONTO NO ORÇAMENTO
            $routes->group('desconto', function ($routes) {
                $routes->post('orcamento', 'Vendas::updateDesconto');
            });

            // ATUALIZA O DADOS DO ORÇAMENTO
            $routes->group('orcamento', function ($routes) {
                $routes->post('formapagamento', 'Vendas::updateFormaPagamentoOrcamento');
                $routes->post('cliente', 'Vendas::updateClienteOrcamento');
                $routes->post('vendedor', 'Vendas::updateVendedorOrcamento');
                $routes->post('produto', 'Vendas::updateProdutoOrcamento');
            });
        });

        // FINALIZA OPERAÇÃO EM ABERTO
        $routes->group('finaliza', function ($routes) {
            $routes->post('orcamento', 'Vendas::finishOrcamento');
            $routes->post('venda', 'Vendas::finishVenda');
            $routes->post('retirada', 'Vendas::finishRetirada');
        });

        // CANCELA OPERAÇÃO RETORNA PARA EM ABERTO
        $routes->group('retorna', function ($routes) {
            $routes->post('orcamento', 'Vendas::vendaToOrcamento');
            $routes->post('retirada', 'Vendas::vendaToRetirada');
        });

        // CONSULTA OPERAÇÃO EM ABERTO
        $routes->group('consulta', function ($routes) {
            $routes->post('orcamento', 'Vendas::getVendaReceber');
            $routes->post('retirada', 'Vendas::finishRetirada');
        });

        // ROTA PARA GENRENCIA O PONTO DE VENDA - DIRETO
        $routes->group('pdv', function ($routes) {
            $routes->get('novo', 'Vendas::pdvSale');
            $routes->post('finaliza', 'Vendas::finish');

            $routes->group('inclui', function ($routes) {
                $routes->post('produto', 'Vendas::addProdutoOrcamento');
            });
            $routes->group('remove', function ($routes) {
                $routes->post('produto', 'Vendas::delProdutoOrcamento');
            });
        });

        // ROTA PARA GENRENCIA OS ORÇAMENTOS
        $routes->group('orcamento', function ($routes) {
            $routes->post('novo', 'Vendas::sale');
            $routes->post('finaliza', 'Vendas::finish');

            $routes->group('exibir', function ($routes) {
                $routes->post('produto', 'Vendas::getDetalheOrcamento');
            });

            $routes->group('inclui', function ($routes) {
                $routes->post('produto', 'Vendas::addProdutoOrcamento');
            });

            $routes->group('remove', function ($routes) {
                $routes->post('produto', 'Vendas::delProdutoOrcamento');
            });
        });

        // ROTA PARA GENRENCIA AS RETIRADAS
        $routes->group('retirada', function ($routes) {
            $routes->post('novo', 'Retiradas::sale');

            $routes->group('incluir', function ($routes) {
                $routes->post('produto', 'Retiradas::addProdutoOrcamento');
            });
            $routes->group('remover', function ($routes) {
                $routes->post('produto', 'Retiradas::addProdutoOrcamento');
            });
        });
    });

    // Modulo API Caixa \ Venda
    $routes->group('caixa', ['namespace' => 'App\Controllers\Api\v1\Venda'], function ($routes) {
        // ATUALIZA DADOS DA TABELA
        $routes->group('incluir', function ($routes) {
            $routes->post('suplemento', 'Caixas::addSuplementoCaixa');
            $routes->post('sangria', 'Caixas::addSangriaCaixa');
        });
        //REMOVE DADOS DO CAIXA
        $routes->group('remover', function ($routes) {
            $routes->post('suplemento', 'Caixas::delSuplementoCaixa');
            $routes->post('sangria', 'Caixas::delSangriaCaixa');
            $routes->get('movimento/(:segment)', 'Caixas::removerPagamento/$1');
            $routes->get('areceber/(:segment)', 'Caixas::removerBoleto/$1');
        });
        // CONSULTA DOS DADOS DO CAIXA
        $routes->group('consulta', function ($routes) {
            $routes->get('abertura', 'Caixas::ultimoCaixaFechado');
            $routes->get('fechamento', 'Caixas::fecharCaixa');
        });
        // PROCESSAMENTO DOS DADOS DO CAIXA
        $routes->group('processar', function ($routes) {
            $routes->post('abertura', 'Caixas::abrirCaixa');
            $routes->post('fechamento', 'Caixas::fecharCaixa');
        });
    });
});

// Rota app
// $routes->group('app', ['filter' => 'login'], function ($routes) {
$routes->group('app', ['filter' => 'auth'], function ($routes) {

    // Redirecionamento  para o Dashboard
    $routes->addRedirect('/', 'app/dashboard');

    // Modulo APP Dashboard
    $routes->get('dashboard', 'App\Dashboard::index');

    // Modulo APP
    $routes->group('modulo', function ($routes) {
        $routes->get('cadastro', 'App\Modulo::cadastro');
        $routes->get('configuracao', 'App\Modulo::configuracao');
        $routes->get('financeiro', 'App\Modulo::financeiro');
        $routes->get('venda', 'App\Modulo::venda');
        $routes->get('projeto', 'App\Modulo::projeto');
    });

    // Modulo APP Cadastro
    $routes->group('cadastro', ['namespace' => 'App\Controllers\App\Cadastro'], function ($routes) {
        // Redirecionamento  para o modulo Cadastro
        $routes->addRedirect('/', 'app/modulo/cadastro');
        // Rota Cadastro/Pessoa
        $routes->group('pessoas', function ($routes) {
            $routes->get('/', 'Pessoas::index');
            $routes->get('show/(:segment)', 'Pessoas::show/$1');
            $routes->get('/(:segment)', 'Pessoas::show/$1');
            $routes->get('view/(:segment)', 'Pessoas::view/$1');
        });
        // Rota Cadastro/Produto
        $routes->group('produtos', function ($routes) {
            $routes->get('/', 'Produtos::index');
            $routes->get('show/(:segment)', 'Produtos::show/$1');
            $routes->get('(:segment)', 'Produtos::show/$1');
            $routes->get('view/(:segment)', 'Produtos::view/$1');
        });

        // Rota Cadastro/Servico
        $routes->group('servicos', function ($routes) {
            $routes->get('/', 'Servicos::index');
            $routes->get('show/(:segment)', 'Servicos::show/$1');
            $routes->get('(:segment)', 'Servicos::show/$1');
            $routes->get('view/(:segment)', 'Servicos::view/$1');
        });

        // Carrega dados da Auxiliares
        $routes->group('auxiliar', function ($routes) {
            // Carrega dados da TableDatta
            $routes->group('pessoas', function ($routes) {
                // Rota Cadastro/Profissoes
                $routes->get('profissoes', 'Profissoes::index');
            });
            // Carrega dados da TableDatta
            $routes->group('produtos', function ($routes) {
                // Rota Cadastro/Categoria
                $routes->get('categorias', 'Categorias::produto');
                // Rota Cadastro/Tamanho
                $routes->get('tamanhos', 'Tamanhos::produto');
            });

              // Carrega dados da TableDatta
              $routes->group('servicos', function ($routes) {
                // Rota Cadastro/Categoria
                $routes->get('categorias', 'Categorias::servico');
                // Rota Cadastro/Tamanho
                $routes->get('unidade', 'Tamanhos::servico');
            });

            $routes->group('servicos', function ($routes) {
                // Rota Cadastro/Tamanho
                $routes->get('unidade', 'Tamanhos::index');
            });
        });
    });
    // Modulo APP Configuracao
    $routes->group('configuracao', ['namespace' => 'App\Controllers\App\Configuracao'], function ($routes) {
        // Redirecionamento  para o modulo Configuracao
        $routes->addRedirect('/', 'app/modulo/configuracao');

        // Rota Configuracao/Empresas
        $routes->group('empresas', function ($routes) {
            $routes->get('/', 'Empresa::empresa');
            $routes->get('show/(:segment)', 'Empresa::show/$1');
            $routes->get('/(:segment)', 'Empresa::show/$1');
            $routes->get('view/(:segment)', 'Empresa::view/$1');
        });

        // Rota Configuracao/Parametros
        $routes->group('parametro', function ($routes) {
            $routes->get('/', 'Parametro::parametro');
        });

        $routes->get('parametros', 'Usuario::grupo');
        // Carrega dados da Gerenciamento
        $routes->group('gerenciar', function ($routes) {
            // SUB MODULO USUARIOS
            // Rota app/configuracao/financeiro/usuarios
            $routes->get('usuarios', 'Usuarios::usuarios');

            // Rota app/configuracao/financeiro/gruposdeacesso
            $routes->group('gruposdeacesso', function ($routes) {
                $routes->get('/', 'GruposDeAcesso::gruposdeacesso');
                $routes->get('show/(:segment)', 'GruposDeAcesso::show/$1');
                $routes->get('/(:segment)', 'GruposDeAcesso::show/$1');
                $routes->get('view/(:segment)', 'GruposDeAcesso::view/$1');
            });
        });

        // Carrega dados Auxiliares
        $routes->group('auxiliar', function ($routes) {
            // Carrega dados Auxiliares / Financeiro
            $routes->group('financeiro', function ($routes) {

                // Rota app/configuracao/auxiliar/financeiro/bancos
                $routes->get('bancos', 'Banco::bancos');

                // Rota app/configuracao/auxiliar/financeiro/bandeiras
                $routes->get('bandeiras', 'Bandeira::bandeiras');

                // Rota app/configuracao/auxiliar/financeiro/contasbancarias
                $routes->get('contasbancarias', 'ContaBancaria::contasbancarias');

                // Rota app/configuracao/auxiliar/financeiro/formaspagamentos
                $routes->group('formaspagamentos', function ($routes) {
                    $routes->get('/', 'FormaPagamento::formaspagamentos');
                    $routes->get('show/(:segment)', 'FormaPagamento::show/$1');
                    $routes->get('/(:segment)', 'FormaPagamento::show/$1');
                    $routes->get('view/(:segment)', 'FormaPagamento::view/$1');
                });

                // Rota app/configuracao/auxiliar/financeiro/maquinascartoes
                $routes->get('maquinascartoes', 'MaquinaCartao::maquinascartoes');

                // Rota app/configuracao/auxiliar/financeiro/parcela
                $routes->get('parcela', 'Parcela::parcela');
            });
            // Carrega dados Auxiliares / Venda
            $routes->group('venda', function ($routes) {
                // Rota app/configuracao/auxiliar/venda/Fidelidade
                $routes->get('fidelidade', 'Categorias::index');

                // Rota app/configuracao/auxiliar/venda/vendedores
                $routes->get('vendedores', 'Vendedor::vendedores');
                $routes->get('prestadores', 'Prestador::prestadores');
            });
        });
    });
    // Modulo APP Financeiro
    $routes->group('financeiro', ['namespace' => 'App\Controllers\App\Financeiro'], function ($routes) {
        // Redirecionamento  para o modulo Financeiro
        $routes->addRedirect('/', 'app/modulo/financeiro');

        // Rota Financeiro/ContaPagar
        $routes->group('contapagar', function ($routes) {
            $routes->get('/', 'ContaPagar::index');
            $routes->get('/(:segment)', 'ContaPagar::view/$1');
            $routes->get('show/(:segment)', 'ContaPagar::show/$1');
            $routes->get('view/(:segment)', 'ContaPagar::view/$1');
            $routes->get('fornecedor/(:segment)', 'ContaPagar::viewFornecedor/$1');

        });
        // Rota Financeiro/ContaReceber
        $routes->group('contareceber', function ($routes) {
            $routes->get('/', 'ContaReceber::index');
            $routes->get('show/(:segment)', 'ContaReceber::show/$1');
            $routes->get('(:segment)', 'ContaReceber::show/$1');
            $routes->get('view/(:segment)', 'ContaReceber::view/$1');
            $routes->get('cliente/(:segment)', 'ContaReceber::viewCliente/$1');
        });

        // Carrega dados da Auxiliares
        $routes->group('auxiliar', function ($routes) {

            // Rota Financeiro/Grupo
            $routes->get('grupo', 'Grupo::index');
            // Rota Financeiro/SubGrupo
            $routes->get('subgrupo', 'SubGrupo::index');
        });
    });
    // Modulo APP Relatorio
    $routes->group('relatorio', ['namespace' => 'App\Controllers\App\Relatorio'], function ($routes) {

        // Rota Relatorio/Financeiro
        $routes->group('financeiro', function ($routes) {
            $routes->group('pdf', function ($routes) {
                $routes->get('venda', 'Pdf::Venda');
            });
        });
    });
    // Modulo APP Venda
    $routes->group('venda', ['namespace' => 'App\Controllers\App\Venda'], function ($routes) {
        // Redirecionamento  para o modulo Venda
        $routes->addRedirect('/', 'app/modulo/venda');

        $routes->get('cancelamento', 'Orcamento::Cancelamento');
        $routes->get('devolucao', 'Orcamento::Devolucao');

        // Carrega dados da ORÇAMENTO
        $routes->group('orcamento', function ($routes) {
            $routes->get('/', 'Orcamento::Orcamento');
            $routes->get('selling/(:segment)', 'Orcamento::Orcamento_Selling/$1');
            $routes->get('selling', 'Orcamento::Orcamento_Selling');
        });

        // Carrega dados da PDV
        $routes->group('pdv', function ($routes) {
            $routes->get('/', 'Orcamento::Pdv');
            $routes->get('selling/(:segment)', 'Orcamento::Pdv_Selling/$1');
            $routes->get('selling', 'Orcamento::Pdv_Selling');
        });
    });

    // Modulo APP Venda
    $routes->group('projeto', ['namespace' => 'App\Controllers\App\Projeto'], function ($routes) {
        // Redirecionamento  para o modulo Venda
        $routes->addRedirect('/', 'app/modulo/projeto');

        // Carrega dados da OBRA
        $routes->group('obra', function ($routes) {
            $routes->get('/', 'Obra::index');
            $routes->get('view/(:segment)', 'Obra::view/$1');
            $routes->get('view/(:segment)/(:segment)', 'Obra::view_local/$1/$2');
        });

        // Carrega dados da PDV
        $routes->group('pdv', function ($routes) {
            $routes->get('/', 'Orcamento::Pdv');
            $routes->get('selling/(:segment)', 'Orcamento::Pdv_Selling/$1');
            $routes->get('selling', 'Orcamento::Pdv_Selling');
        });
    });

    $routes->group('caixa', ['namespace' => 'App\Controllers\App\Venda'], function ($routes) {

        // CAIXA
        $routes->get('(:segment)', 'Caixa::caixaAbertoTerminal/$1');
        $routes->get('/', 'Caixa::index');

        // VENDAS
        $routes->get('receber/(:segment)', 'Caixa::caixaReceberVenda/$1');
    });
});


