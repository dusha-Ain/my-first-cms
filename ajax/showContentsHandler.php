<?php
require ('../config.php');

header('Content-Type: application/json; charset=utf-8');

// Обработка GET запроса
if (isset($_GET['articleId'])) {
    $articleId = (int)$_GET['articleId'];
    $article = Article::getById($articleId);
    
    if ($article) {
        echo json_encode([
            'success' => true,
            'content' => $article->content
        ]);
    } else {
        echo json_encode([
            'success' => false,
            'error' => 'Статья не найдена'
        ]);
    }
    exit;
}

// Обработка POST запроса
if (isset($_POST['articleId'])) {
    $articleId = (int)$_POST['articleId'];
    $article = Article::getById($articleId);
    
    if ($article) {
        echo json_encode([
            'success' => true,
            'content' => $article->content
        ]);
    } else {
        echo json_encode([
            'success' => false,
            'error' => 'Статья не найдена'
        ]);
    }
    exit;
}

// Если не передан articleId
echo json_encode([
    'success' => false,
    'error' => 'Не указан ID статьи'
]);