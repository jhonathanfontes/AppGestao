# AppGestao - Sistema de Gestão Empresarial

Sistema de gestão empresarial desenvolvido em CodeIgniter 4 para gerenciamento de colaboradores, vales e folha de pagamento.

## Requisitos

- PHP 7.4 ou superior
- MySQL 5.7 ou superior
- Composer
- Servidor web (Apache/Nginx)

## Instalação

1. Clone o repositório:
```bash
git clone https://github.com/seu-usuario/AppGestao.git
cd AppGestao
```

2. Instale as dependências via Composer:
```bash
composer install
```

3. Copie o arquivo de ambiente:
```bash
cp env .env
```

4. Configure o arquivo `.env` com suas credenciais de banco de dados:
```env
database.default.hostname = localhost
database.default.database = appgestao
database.default.username = seu_usuario
database.default.password = sua_senha
database.default.DBDriver = MySQLi
```

5. Execute as migrações do banco de dados:
```bash
php spark migrate
```

## Estrutura do Projeto

### Tabelas do Banco de Dados

1. `cad_usuario`
   - Gerenciamento de usuários do sistema
   - Campos: id, nome, email, senha, status, etc.

2. `cad_empresa`
   - Cadastro de empresas
   - Campos: razao_social, nome_fantasia, cnpj, endereco, etc.

3. `cad_usuario_empresa`
   - Relacionamento entre usuários e empresas
   - Campos: usuario_id, empresa_id, status, etc.

4. `cad_colaborador`
   - Cadastro de colaboradores
   - Campos: nome, cpf, rg, data_nascimento, cargo, etc.

5. `cad_vale`
   - Gerenciamento de vales (alimentação, transporte)
   - Campos: tipo, valor, data_solicitacao, status, etc.

6. `cad_salario`
   - Folha de pagamento
   - Campos: salario_base, adicionais, descontos, etc.

### Controllers

- `AutenticacaoController`: Gerenciamento de login/logout
- `EmpresasController`: Gestão de empresas e seleção
- `ColaboradoresController`: CRUD de colaboradores
- `ValesController`: Gestão de vales
- `SalariosController`: Gestão da folha de pagamento
- `DashboardController`: Página inicial do sistema

### Models

- `UsuarioModel`: Modelo para usuários
- `EmpresaModel`: Modelo para empresas
- `UsuarioEmpresaModel`: Modelo para relacionamento usuário-empresa
- `ColaboradorModel`: Modelo para colaboradores
- `ValeModel`: Modelo para vales
- `SalarioModel`: Modelo para salários

## Funcionalidades

### Gestão de Usuários
- Cadastro de usuários
- Autenticação
- Controle de acesso por empresa

### Gestão de Empresas
- Cadastro de empresas
- Seleção de empresa ativa
- Controle de acesso multi-empresa

### Gestão de Colaboradores
- Cadastro completo de colaboradores
- Histórico de colaboradores
- Controle de status

### Gestão de Vales
- Solicitação de vales
- Aprovação/rejeição
- Controle de pagamento
- Tipos: alimentação, transporte, outros

### Folha de Pagamento
- Cálculo de salários
- Controle de adicionais
- Descontos automáticos
- Geração de contracheque

## Segurança

- Senhas criptografadas com password_hash
- Proteção contra CSRF
- Validação de dados
- Controle de acesso por empresa
- Soft delete em todas as tabelas

## Contribuição

1. Faça um fork do projeto
2. Crie uma branch para sua feature (`git checkout -b feature/AmazingFeature`)
3. Commit suas mudanças (`git commit -m 'Add some AmazingFeature'`)
4. Push para a branch (`git push origin feature/AmazingFeature`)
5. Abra um Pull Request

## Licença

Este projeto está sob a licença MIT. Veja o arquivo [LICENSE](LICENSE) para mais detalhes.

## Suporte

Para suporte, envie um email para seu-email@exemplo.com ou abra uma issue no repositório.