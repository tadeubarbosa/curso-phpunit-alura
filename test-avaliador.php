<?php

use Alura\Leilao\Model\Lance;
use Alura\Leilao\Model\Leilao;
use Alura\Leilao\Model\Usuario;
use Alura\Leilao\Service\Avaliador;

require_once './vendor/autoload.php';

// arrange - given
// arruma a casa para o teste
$leilao = new Leilao('Fiat 147');

$maria = new Usuario('Maria');
$joao = new Usuario('João');

$leilao->recebeLance(new Lance($joao, 2000));
$leilao->recebeLance(new Lance($maria, 2500));

// act - when
// executa o teste a ser testada
$leiloeiro = new Avaliador();
$leiloeiro->avalia($leilao);

$maiorValor = $leiloeiro->getMaiorValor();

// assert - then
// verifica se a saída é a esperada
$valorEsperado = 2500;

if ($maiorValor == $valorEsperado) {
  echo "Teste OK";
} else {
  echo "Teste falhou!";
}
