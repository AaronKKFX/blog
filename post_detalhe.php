<!DOCTYPE html>
<html lang="pt-br">
<?php
require_once 'includes/funcoes.php';
require_once 'core/conexao_mysql.php';
require_once 'core/sql.php';
require_once 'core/mysql.php';
foreach ($_GET as $indice => $dado) {
    $$indice = limparDados($dado);
}
$posts = buscar( //FUNÇÃO DE BUSCA NO BANCO
    'post',
    [
        'titulo',
        'data_postagem',
        'texto',
        '(select nome 
        from usuario 
        where usuario.id = post.usuario_id) as nome'
    ],
    [
        ['id', '=', $post] // PEGA O ID CORRESPONDENTE DO POST//
    ]
);
$post = $posts[0];
$data_post = date_create($post['data_postagem']); //CRIA A DATA DA POSTAGEM PRA PODER USAR NA PARTE DO HTML
$data_post = date_format($data_post, 'd/m/Y H:i:s'); //FORMATA A DATA 12/12/12 12:30:02
?>

<head>
    <title><?php echo $post['titulo'] ?></title>
    <link rel="stylesheet" href="lib\bootstrap-4.2.1-dist\bootstrap-4.2.1-dist\css\bootstrap.min.css">
</head>

<body>
    <div class="container">
        <div class="row">
            <div class="col-md-12">
                <?php include 'includes/topo.php'; ?>
            </div>
        </div>
        <div class="row" style="min-height: 500px;">
            <div class="col-md-12">
                <?php include 'includes/menu.php'; ?>
            </div>
            <!--CARD DO DETALHES DO POST-->
            <div class="col-md-10 mb-5" style="padding-top: 50px;">
                <div class="card">
                    <div class="card-header">
                        <h5 class="card-title"><?php echo $post['titulo'] ?></h5> <!--TÍTULO DO POST-->
                    </div>
                    <div class="card-body">
                        
                        <h5 class="card-subtitle mb-2 text-muted">
                            <?php echo $data_post ?> Por <?php echo $post['nome'] ?> <!--PUXA DATA DO POST E O NOME DO ÚSUARIO-->
                        </h5>
                        <div class="card-text">
                            <?php echo html_entity_decode($post['texto']) ?> <!--PUXA O TEXTO DO POST-->
                        </div>
                    </div>
                </div>
                
            </div>
        </div>
        <div class="row">
            <div class="col-md-12">
                <?php include 'includes/rodape.php'; ?>
            </div>
        </div>
    </div>
    <script src="lib\bootstrap-4.2.1-dist\bootstrap-4.2.1-dist\js\bootstrap.min.js"></script>
</body>

</html>