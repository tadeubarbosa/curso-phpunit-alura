<?php

namespace Alura\Leilao\Model;

use DomainException;

class Leilao
{
    /** @var Lance[] */
    private $lances;
    /** @var string */
    private $descricao;
    private $finalizado;

    public function __construct(string $descricao)
    {
        $this->descricao = $descricao;
        $this->lances = [];
        $this->finalizado = false;
    }

    public function recebeLance(Lance $lance)
    {
        if (!empty($this->lances) && $this->ehDoUltimoUsuario($lance)) {
          throw new DomainException("Usuário não pode propor dois lances consecutivos!");
        }

        $totalDeLancesPorUsuario = $this->qtdDeLancesPorUsuario($lance->getUsuario());

        if ($totalDeLancesPorUsuario >= 5) {
          throw new DomainException("Usuário não pode propor mais de cinco lances por sessão!");
        }

        $this->lances[] = $lance;
    }

    /**
     * @return Lance[]
     */
    public function getLances(): array
    {
        return $this->lances;
    }

    public function estaFinalizado(Leilao $leilao): bool
    {
      return $leilao->finalizado;
    }

    public function finaliza()
    {
        $this->finalizado = true;
    }

    protected function qtdDeLancesPorUsuario(Usuario $usuario)
    {
      return array_reduce(
        $this->lances,
        function (int $totalAcumulado, Lance $lanceAtual) use ($usuario) {
          if ($lanceAtual->getUsuario() == $usuario) {
            return $totalAcumulado + 1;
          }
          return $totalAcumulado;
        },
        0
      );
    }

    protected function ehDoUltimoUsuario(Lance $lance)
    {
      $lastLance = count($this->lances) - 1;
      return $lance->getUsuario() == $this->lances[$lastLance]->getUsuario();
    }
}
