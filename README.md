# Desafio estágio back-end
## Api que consome as noticias do site [https://www.correio24horas.com.br/rss/]

# Inicialização do projeto
Após realizar o download do projeto é necessário realizar o update do composer para que o mesmo possa baixar todas as depêndecias necessárias.
Feito a instalação do composer, iniciliaze o servidor web com o próprio PHP utilizando o comando **php -S localhost:3000**.

#### Códigos de erros
Código | Descrição
-------|----------
404    | Rota ou recurso inválido
405| Método não encontrado

#### Ambiente
Substituir a porta 3000 pela porta definida ao subir o servidor

Ambiente | URL
-------|----------
Teste| http://localhost:3000/noticia

#### /noticia

Retorna todas as notícias do site [https://www.correio24horas.com.br/].

Nome | Descrição
-------|----------
Endpoint| /noticia
Method| GET

#### Campos|Parâmetros

Nome | valor| Descrição| Tipo | Exemplo
-----|-------------|----------|-----|---
order| title:asc| Ordena as notícias através do titulo de forma ascendente| string|http://localhost:3000/noticia?order=title:asc
order| title:desc| Ordena as notícias através do titulo de forma descendente| string|http://localhost:3000/noticia?order=title:desc
order| title:asc| Ordena as notícias através da data de forma ascendente| string|http://localhost:3000/noticia?order=date:asc
order| title:asc| Ordena as notícias através da data de forma descendente| string|http://localhost:3000/noticia?order=date:desc
category| categorias disponiveis no feed| Lista dados da categoria selecionada| string|http://localhost:3000/noticia?category=categoriaaqui
limit| 1-20 | Limita a quantidade de noticias entregues de acordo ao que for parametrizado| int |http://localhost:3000/noticia?limit=5
filter| basic | Limita os campos que serão entregues| string |http://localhost:3000/noticia?filter=basic
