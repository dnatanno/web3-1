<?php

/**
 * Para saber mais sobre namespaces:
 * https://www.php.net/manual/pt_BR/language.namespaces.rationale.php
 */
use App\Controller\{
    AlunoController,
    InicialController,
    LoginController,
    AutorController,
    CategoriaController,
    LivroController,
    EmprestimoController
};

/* Para saber mais sobre a função 
 * parse_url: https://www.php.net/manual/pt_BR/function.parse-url.php
 */
$url = parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH);

/**
 * Para saber mais estrutura switch,
 * leia: https://www.php.net/manual/pt_BR/control-structures.switch.php
 */
switch($url)
{
    /**
     * Para saber mais sobre o Operador de Resolução de Escopo (::), 
     * leia: https://www.php.net/manual/pt_BR/language.oop5.paamayim-nekudotayim.php
     */
    case '/':
        InicialController::index();
    break;
    

    /**
     * Rotas para Login
     */
    case '/login':
        LoginController::index();
    break;

    case '/logout':
        LoginController::logout();
    break;


    /**
     * Rotas para alunos
     */
    case '/aluno':        
        AlunoController::index();
    break;

    case '/aluno/cadastro':
        AlunoController::cadastro();
    break;

    case '/aluno/delete':
        AlunoController::delete();
    break;


    /**
     * Rotas para autores
     */
    case '/autor':        
        AutorController::index();
    break;

    case '/autor/cadastro':
        AutorController::cadastro();
    break;

    case '/autor/delete':
        AutorController::delete();
    break;


    /**
     * Rotas para categorias
     */
    case '/categoria':        
        CategoriaController::index();
    break;

    case '/categoria/cadastro':
        CategoriaController::cadastro();
    break;

    case '/categoria/delete':
        CategoriaController::delete();
    break;


    /**
     * Rotas para livros
     */
    case '/livro':        
        LivroController::index();
    break;

    case '/livro/cadastro':
        LivroController::cadastro();
    break;

    case '/livro/delete':
        LivroController::delete();
    break; 
    

    /**
     * Rotas para Emprestimo
     */
    case '/emprestimo':        
        EmprestimoController::index();
    break;

    case '/emprestimo/cadastro':
        EmprestimoController::cadastro();
    break;

    case '/emprestimo/delete':
        EmprestimoController::delete();
    break;  
}