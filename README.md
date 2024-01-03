# Password Verify
Backend para um validador de senhas.

O objetivo desse projeto é criar um validador de string por api, conforme algumas regras que podem ser informadas junto com a string.

Quer ver online? a url da api é: https://password-verify.jhon.dev.br/verify

## *Como iniciar o projeto*
Para iniciar asse projeto, basta executar os seguintes passos:
- Rodar o comando **docker-compose up -d** pelo terminal dentro da pasta desse projeto.
- Rodar o comando **composer-update** dentro do container **password_verify_app**.
---
## *Documentação*
### Endpoint
- O endpoint principal para esse projeto é o ***verify*** que deve ser do tipo ***POST***. 
- Exemplo de ***json*** para enviar no post:
  ````
  {
    "password": "TesteSenhaForte!123&",
    "rules": [
        {
            "rule": "minSize",
            "value": 8
        },
        {
            "rule": "minUppercase",
            "value": 2
        },
        {
            "rule": "minLowercase",
            "value": 2
        },
        {
            "rule": "minDigit",
            "value": 1
        },
        {
            "rule": "minSpecialChars",
            "value": 2
        },
        {
            "rule": "noRepeated",
            "value": 0
        }
    ]
  }
  ````
### Atributos
- **password**: obrigatório, deve ser do tipo string.
- **rules**: obrigatório, deve ser do tipo array de objetos.
  - **rule**: regra escolhida no formato string.
  - **value**: valor para a regra no tipo int.
- **Obs.**: no mínimo uma regra deve ser informada.
### Tipos de regras aceitas
- ***minSize***: quantidade minima de carácteres contidos na string informada.
- ***minUppercase***: quantidade minima de carácteres maiúsculos na string informada.
- ***minLowercase***: quantidade minima de carácteres minúsculo na string informada.
- ***minDigit***: quantidade minima de carácteres numéricos na string informada.
- ***minSpecialChars***: quantidade minima de carácteres especiais (!@#$%^&*()-+\/{}[]) na string informada.
- ***noRepeated***: valida para que não tenha nenhum caractere repetido em sequência, ou seja, "aab" viola esta condição, mas "aba" não.
### Retorno
- O retorno será no formato ***json*** de acordo com o seguinte exemplo:
  ````
  {
    "verify": false,
    "noMatch": ["minDigit"]
  }
  ````
- No retorno teremos dois parâmetros:
  - ***verify***: é do tipo **boolean** retornando se a determinada string violou ou não nas regras.
  - ***noMatch***: é do tipo **array** retornando as regras que essa string violou, caso não tenha violado nenhuma, será retornado um **array** vazio.
---
## *Como rodar os testes*
- ***Unitários***: composer run php-unit
- ***Coverage***: composer run php-coverage - Após rodar irá ficar em **tests/coverage**
---
## *Bibliotecas Utilizadas*
- ***Kint***: utilizado para debug no php.
- ***Php Unit***: utilizado para testes unitários, testes de integração e relatório de coverage.
- ***Composer***: utilizado para instalar as bibliotecas mencionadas aqui.
- ***Mockery***: utilizado para mock em testes unitários.
---
