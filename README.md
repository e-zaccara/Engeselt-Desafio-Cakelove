# Engeselt Desafio | Marketplace Confeitaria
## Projeto: Cakelove

Aplicação em execução:
link do vídeo: https://youtu.be/pxB-oj5bZrw
<a href="https://youtu.be/pxB-oj5bZrw">
  <img src="https://img.youtube.com/vi/pxB-oj5bZrw/maxresdefault.jpg" width="400" />
</a>

## Especificações Técnicas
Laravel (v12.0.7)<br>
Laravel/ui (v4.6.1)<br>
PHP (8.2.4)<br>
PostgreSQL (17.4)<br>
Vue.JS (3.5.13)<br>
Leaflet.JS (1.9.4) - Carregado localmente

## Como rodar a aplicação
1° Clone o repositório<br>
    Utilizando xampp cria uma pasta dentro de "htdocs" e clone o repositório<br>
2° Crie um banco de dados no pgAdmin4 com nome "bd_cakelove"<br>
3° Importe o banco de dados que está na pasta "BANCODEDADOS" para "bd_cakelove"<br>
    OBS: Os dois arquivos são o mesmo banco, um como "directory" e o outro como "plain"<br>
4° Abra a aplicação no servidor local (XAMPP->Apache)<br>
    No processo de criação foi utilizado XAMPP->Apache<br>
    http://127.0.0.1:8080/cakelove/public/

## Estrutura da aplicação (DADOS)
Utilização do PostgreSQL para servir como banco de dados. Os dados foram tratados utilizando o Eloquent ORM do laravel para mapear as tabelas do banco em modelos, o que facilitou para criação de controladores permitindo realizar operações, tais como, create, show, update, destroy (CRUD). E a visualização dos dados via renderização dos componentes vue.

## Considerações
Gostaria de me desculpar por não conseguir atender a todos os requisitos solicitados, especialmente em relação ao uso do Inertia.js. Eu não conhecia essa tecnologia anteriormente, mas me esforcei para estudá-la e tentei aplicá-la ao projeto enquanto aprendia. Infelizmente, não consegui implementá-la, mas pretendo continuar estudando e evoluindo nesse ponto.
Também peço desculpas pela falta de commits frequentes. Concentrei meus esforços nas etapas de desenvolvimento e estudo para entregar o melhor resultado possível, o que acabou impactando um pouco a frequência dos registros no repositório.

Agradeço pela compreensão e pela oportunidade de aprendizado!
