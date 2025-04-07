<?php

namespace App\Model;

use App\DAO\AutorDAO;
use Exception;

/**
 * A camada model é responsável por transportar os dados da Controller até a DAO e vice-versa.
 * Também é atribuído a Model a validação dos dados da View e controle de acesso aos métodos
 * da DAO.
 */
final class Autor extends Model
{
    /**
     * Declaração das propriedades conforme campos da tabela no banco de dados.
     * para saber mais sobre Propriedades de Classe, leia: https://www.php.net/manual/pt_BR/language.oop5.properties.php
     */
    public ?int $Id = null;

    public ?string $Nome
    {
        set
        {
            if(strlen($value) < 3)
                throw new Exception("Nome deve ter no mínimo 3 caracteres.");

            $this->Nome = $value;
        }

        get => $this->Nome ?? null;
    }


    public ?string $Data_Nascimento
    {
        set
        {
            if(empty($value))
                throw new Exception("Preencha a Data de Nascimento");

            $this->Data_Nascimento = $value;
        }

        get => $this->Data_Nascimento ?? null;
    }


    public ?string $CPF
    {
        set
        {
            if(strlen($value) < 11)
                throw new Exception("CPF deve ter no mínimo 11 caracteres.");

            $this->CPF = $value;
        }

        get => $this->CPF ?? null;
    }



    
    /**
     * Declaração do método save que chamará a DAO para gravar no banco de dados
     * o model preenchido.
     */
    function save() : Autor
    {
        /**
         * Note que os objetos da classe AlunoDAO estão sendo criados de forma anônima.
         * Fazemos isso quando podemos descartar o objeto logo apos o uso, ou seja,
         * não sendo necessário armazenar o objeto em uma variável.
         * Leia sobre: https://www.php.net/manual/pt_BR/language.oop5.anonymous.php
         */
        return new AutorDAO()->save($this);
    }


    /**
     * Método que encapsula o acesso ao método selectById da camada DAO
     * O método recebe um parâmetro do tipo inteiro que é o id do registro
     * a ser recuperado do MySQL, via camada DAO.
     */
    function getById(int $id) : ?Autor
    {
        return new AutorDAO()->selectById($id);
    }


    /**
     * Método que encapsula a chamada a DAO e que abastecerá a propriedade rows;
     * Esse método é importante pois como a model é "vista" na View a propriedade
     * $rows será acessada e possibilitará listar os registros vindos do banco de dados
     */
    function getAllRows() : array
    {
        $this->rows = new AutorDAO()->select();

        return $this->rows;
    }


    /**
     * Método que encapsula o acesso a DAO do método delete.
     * O método recebe um parâmetro do tipo inteiro que é o id do registro
     * que será excluido da tabela no MySQL, via camada DAO.
     */
    function delete(int $id) : bool
    {
        return new AutorDAO()->delete($id);
    }
}