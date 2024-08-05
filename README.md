## Sobre o Projeto

Aplicação de teste que descreve uma clinica na qual temos médicos, recepcionistas e pacientes.
Os requisitos sao, O rececionista da clínica pode:

- ver as marcações por datas e por tipo de animal
- atribuir as marcações a médicos
- criar, editar e apagar todas as marcações

O médico pode:

- Ver as marcações que lhe estão atribuídas, por dias e por tipo de animal
- Poder editar somente as marcações que lhe estão atribuídas
- Não pode apagar nenhuma marcação

Laravel is accessible, powerful, and provides tools required for large, robust applications.

## Insatalando o projeto

Clonado o repositório, basta rodar os comandos de instalção.
No terminal, indo até a pasta do projeto, rodar:

- composer install
- npm install

## Preparando o ambiente

Pra facilitar o projeto, coloquei um banco MySql e Redis, em um docker.Para rodar o docker dos databases, execute:

- docker-compose up -d

## Migrations

Execute as migrations:

- php artisan migrate

Criei Seeds para criar alguns usuarios e agendamentos. 
Essas Seeds tambem criam dois usuarios default.

email: jeff@recepcionista.com senha: 12345678
email: jeff@doctor.com senha: 12345678

Cada um é de um tipo de usuario e pode ser usado para acessar o sistema.
A seed tb cria um primeiro agendamento, todavia é possivel criar e logar no sistema via tela

Se quiser rodar os seeds execute:

- php artisan db:seed


### Executando o projeto

Com o docker rodando, abra um terminal e execute

- php artisan serve

Abre um segundo terminal e execute

- npm run dev

## Acessando o projeto

Acesse via navegador o link http://localhost:8000/


