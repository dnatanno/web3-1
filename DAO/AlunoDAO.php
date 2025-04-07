<?php

namespace App\DAO;

use App\Model\Aluno;

/**
 * As classes DAO (Data Access Object) são responsáveis por executar os
 * SQL junto ao banco de dados.
 */
final class AlunoDAO extends DAO
{
     /**
     * Método construtor, sempre chamado na classe quando a classe é instanciada.
     * Exemplo de instanciar classe (criar objeto da classe):
     * $dao = new AlunoDAO();
     */
    public function __construct()
    {
        /**
         * Chamando o construtor da classe DAO, isto é, toda vez que chamos o consturo da classe DAO
         * estamos fazendo a conexão com o banco de dados.
         */
        parent::__construct();
    }

    public function save(Aluno $model) : Aluno
    {
        /**
         * Uso do operador ternário para verificar se trata-se de uma inserção
         * ou de uma exclusão. Tem o mesmo efeito de um if...else, porém mais compacto.
         */
        return ($model->Id == null) ? $this->insert($model) : $this->update($model);
    }


    /**
     * Método que recebe um model e extrai os dados do model para realizar o insert
     * na tabela correspondente ao model. Note o tipo do parâmetro declarado.
     */
    public function insert(Aluno $model) : Aluno
    {
        // Trecho de código SQL com marcadores ? para substituição posterior, no prepare
        $sql = "INSERT INTO aluno (nome, ra, curso) VALUES (?, ?, ?) ";

        // Declaração da variável stmt que conterá a montagem da consulta. Observe que
        // estamos acessando o método prepare dentro da propriedade que guarda a conexão
        // com o MySQL, via operador seta "->". Isso significa que o prepare "está dentro"
        // da propriedade $conexao e recebe nossa string sql com os devidor marcadores.
        // Para saber mais sobre Preparated Statements, leia: https://www.codigofonte.com.br/artigos/evite-sql-injection-usando-prepared-statements-no-php
        $stmt = parent::$conexao->prepare($sql);
        
        // Nesta etapa os bindValue são responsáveis por receber um valor e trocar em uma 
        // determinada posição, ou seja, o valor que está em 3, será trocado pelo terceiro ?
        // No que o bindValue está recebendo o model que veio via parâmetro e acessamos
        // via seta qual dado do model queremos pegar para a posição em questão.
        $stmt->bindValue(1, $model->Nome);
        $stmt->bindValue(2, $model->RA);
        $stmt->bindValue(3, $model->Curso);

        // Ao fim, onde todo SQL está montando, executamos a consulta.
        $stmt->execute();

        $model->Id = parent::$conexao->lastInsertId();
        
        return $model;
    }


    /**
     * Método que recebe o Model preenchido e atualiza no banco de dados.
     * Note que neste model é necessário ter a propriedade id preenchida.
     */
    public function update(Aluno $model) : Aluno
    {
        $sql = "UPDATE aluno SET nome=?, ra=?, curso=? WHERE id=? ";

        $stmt = parent::$conexao->prepare($sql);
        $stmt->bindValue(1, $model->Nome);
        $stmt->bindValue(2, $model->RA);
        $stmt->bindValue(3, $model->Curso);
        $stmt->bindValue(4, $model->Id);
        $stmt->execute();
        
        return $model;
    }


    /**
     * Retorna um registro específico da tabela pessoa do banco de dados.
     * Note que o método exige um parâmetro $id do tipo inteiro.
     */
    public function selectById(int $id) : ?Aluno
    {
        $sql = "SELECT * FROM aluno WHERE id=? ";

        $stmt = parent::$conexao->prepare($sql);  
        $stmt->bindValue(1, $id);
        $stmt->execute();

        return $stmt->fetchObject("App\Model\Aluno");
    }


    /**
     * Método que retorna todas os registros da tabela pessoa no banco de dados.
     */
    public function select() : array
    {
        $sql = "SELECT * FROM aluno ";

        $stmt = parent::$conexao->prepare($sql);  
        $stmt->execute();

        // Retorna um array com as linhas retornadas da consulta. Observe que
        // o array é um array de objetos. Os objetos são do tipo stdClass e 
        // foram criados automaticamente pelo método fetchAll do PDO.
        return $stmt->fetchAll(DAO::FETCH_CLASS, "App\Model\Aluno");
    }

    /**
     * Remove um registro da tabela pessoa do banco de dados.
     * Note que o método exige um parâmetro $id do tipo inteiro.
     */
    public function delete(int $id) : bool
    {
        $sql = "DELETE FROM aluno WHERE id=? ";

        $stmt = parent::$conexao->prepare($sql);  
        $stmt->bindValue(1, $id);
        return $stmt->execute();
    }
}