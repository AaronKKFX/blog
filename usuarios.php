<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Usuários | Projeto para Web com PHP</title>
    <link rel="stylesheet" href="lib\bootstrap-4.2.1-dist\bootstrap-4.2.1-dist\css\bootstrap.min.css">

</head>
<body>
    <div class="container">
        <div class="row">
            <div class="col-md-12">
                <?php 
                    include 'includes/topo.php';
                    include 'includes/valida_login.php';
                    if($_SESSION['login']['usuario']['adm'] !==1){ //VERIFICA SE O USUÁRIO È ADMINISTRADOR
                        header('Location: index.php'); //CASO ELE NÃO SEJA É REDIRECIONADO PARA O INDEX
                    }
                ?>
            </div>
        </div>
        <div class="row" style="min-height: 500px;">
            <div class="col-md-12">
                <?php include 'includes/menu.php'; ?>
            </div>
            <div class="col-md-10" style="padding-top: 50px;">
                <h2>Usuário</h2>
                <?php include 'includes/busca.php' ?>
                <?php
                    require_once 'includes/funcoes.php';
                    require_once 'core/conexao_mysql.php';
                    require_once 'core/sql.php';
                    require_once 'core/mysql.php';

                    foreach($_GET as $indice => $dado){
                        $$indice = limparDados($dado);
                    }

                    $data_atual = date('Y-m-d H:i:s'); //CRIA DATA ATUAL NO FORMATO DESEJADO

                    $criterio = [];

                    if(!empty($busca)){
                        $criterio[] = ['nome', 'like', "%{$busca}%"]; //CRITERIO PARA BUSCA DO NOME
                    }
                    $result = buscar( //FUNÇÃO BUSCAR
                        'usuario',
                        [
                            'id',
                            'nome',
                            'email',
                            'data_criacao',
                            'ativo',
                            'adm'
                        ],
                        $criterio,
                        'data_criacao DESC, nome ASC'
                    );
                ?>
                <table class=" mt-3 table table-bordered table-hover table-striped table-responsive{-sm|-md|-lg|-xl}">
                    <thead>
                        <tr>
                            <td>Nome</td>
                            <td>E-mail</td>
                            <td>Data cadastro</td>
                            <td>Ativo</td>
                            <td>Administrador</td>
                        </tr>
                    </thead>
                    <tbody>
                        <?php 
                            foreach($result as $entidade):
                                $data = date_create($entidade['data_criacao']);
                                $data = date_format($data, 'd/m/Y H:i:s');
                        ?>
                        <tr>
                            <td><?php echo $entidade['nome'] ?></td> <!--PUXA O NOME DA PESSOA PARA TABELA-->
                            <td><?php echo $entidade['email'] ?></td> <!--PUXA O EMAIL DA PESSOA-->
                            <td><?php echo $data ?></td>
                            <td><a href='core/usuario_repositorio.php?acao=status&id=<?php echo $entidade['id']?>&valor=<?php echo !$entidade['ativo']?>'><?php echo($entidade['ativo']==1) ? 'Desativar' : 'Ativar'; ?></a></td> <!--VERIFICA SE O USUÁRIO FOI ATIVADO CASO NÃO ELE APARECE PARA ATIVAR E O CONTRARIO TMB-->
                            <td><a href='core/usuario_repositorio.php?acao=adm&id=<?php echo $entidade['id']?>&valor=<?php echo !$entidade['adm']?>'><?php echo ($entidade['adm']==1) ? 'Rebaixar' : 'Promover'; ?></a></td> <!--MESMA COISA DO DE CIMA MAS PARA ADM-->
                        </tr>
                        <?php endforeach; ?>
                    </tbody>
                </table>
            </div>
        </div>
        <div class="row">
            <div class="col-md-12">
                <?php 
                    include 'includes/rodape.php';
                ?>
            </div>
        </div>
    </div>
    <script src="lib\bootstrap-4.2.1-dist\bootstrap-4.2.1-dist\js\bootstrap.min.js"></script>
</body>
</html>