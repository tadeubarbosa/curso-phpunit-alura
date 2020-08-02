<?php

namespace Alura\Leilao\Service;

use Alura\Leilao\Model\Lance;
use Alura\Leilao\Model\Leilao;
use DomainException;

class Avaliador
{
  private $menorValor = INF;
  private $maiorValor = -INF;
  private $maioresLances;
  
  public function avalia(Leilao $leilao): void
  {
    if ($leilao->estaFinalizado($leilao)) {
      throw new DomainException("Leilão já está finalizado!");
    }

    if (empty($leilao->getLances())) {
      throw new \DomainException("Não é possível avaliar um leilão vazio!", 1);
    }

    foreach ($leilao->getLances() as $lance) {
      if ($lance->getValor() > $this->maiorValor) {
        $this->maiorValor = $lance->getValor();
      }
      if ($lance->getValor() < $this->menorValor) {
        $this->menorValor = $lance->getValor();
      }
    }

    $lances = $leilao->getLances();

    usort($lances, function (Lance $primeiroLance, Lance $segundoLance) {
      return $segundoLance->getValor() - $primeiroLance->getValor();
    });

    $this->maioresLances = array_slice($lances, 0, 3);
  }

  public function getMenorValor(): float
  {
    return $this->menorValor; 
  }

  public function getMaiorValor(): float
  {
    return $this->maiorValor; 
  }

  /**
   * Retorna os três maiores lances
   *
   * @return Lance[]
   */
  public function getMaioresLances(): array
  {
    return $this->maioresLances;
  }
}