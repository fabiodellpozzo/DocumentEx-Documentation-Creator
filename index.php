<?php
include 'conexao.php';

$qtdModulos = $pdo->query("SELECT COUNT(*) FROM modulos")->fetchColumn();
$qtdCategorias = $pdo->query("SELECT COUNT(*) FROM categorias")->fetchColumn();
$qtdSubcategorias = $pdo->query("SELECT COUNT(*) FROM subcategorias")->fetchColumn();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>DocumentEx - Documentation Creator · v0.1</title>
    <link href="bootstrap.min.css" rel="stylesheet">
</head>

<body class="bg-body-tertiary">
 
<!-- container --> 
    <div class="container-fluid">
       <!-- main --> 
        <main class="p-4">
            <!-- logo -->
            <div class="py-5 text-center">
                <img class="d-block mx-auto mb-4" src="logo.svg" alt="" width="95" height="80">
                <h1 class="h2">DocumentEx - Documentation Creator</h1>
                <p class="lead">Create modules, categories, subcategories, and export to HTML.</p>
            </div>
            <!-- end logo -->

            <!-- aviso -->
            <div class="container mt-3">
                <div id="aviso" class="mb-3"></div>
            </div>
            <!-- end aviso -->

            <!-- cart -->
            <div class="row g-5">
                <div class="col-md-5 col-lg-4 order-md-last">
                    <h6 class="d-flex justify-content-between align-items-center mb-3">


<!-- contagem modulos -->
                <span class="badge bg-primary rounded-pill">Módulos <?= $qtdModulos ?></span>
                <span class="badge bg-primary rounded-pill">Categorias <?= $qtdCategorias ?></span>
                <span class="badge bg-primary rounded-pill">Subcategorias <?= $qtdSubcategorias ?></span>
<!-- end contagem modulos -->
             
</h6>
                    <span class="text-primary">Tree</span>
                                <!-- arvore modulos -->
                                <div id="sidebar" class="list-group">
                                    Carregando módulos...
                                </div>
                                <!-- end arvore modulos -->

                </div>
            <!-- end cart -->
            <!-- form -->
            <div class="col-lg-8">
                <h4 class="mb-3">Form create model</h4>

         
             
                    <!-- container criar -->
                    <div class="container-fluid">

<!-- input criar modulo -->


                <div class="input-group input-group-sm mb-1">
                    <input type="text" class="form-control" id="inputModulo" placeholder="Novo módulo">
                    <button id="btnCriarModulo" class="btn btn-primary btn-sm">Criar Módulo</button>
                </div>
<!-- end input criar modulo -->

<!-- select criar categoria -->
                        <div class="input-group input-group-sm mb-1">
                            <select id="moduloParaCategoria" class="form-select"></select>
                            <input type="text" id="inputCategoria" class="form-control" placeholder="Nova categoria">
                            
                        </div>
        <div class="d-grid gap-2 col-6 mx-auto">
            <button id="btnCriarCategoria" class="btn btn-secondary btn-sm mb-1">Criar Categoria</button>
        </div>
<!-- end select criar categoria -->
<!-- criar categoria subcategoria -->
                        <div class="input-group input-group-sm mb-1">
                            <select id="moduloParaSubcategoria" class="form-select"></select>
                            <select id="categoriaParaSubcategoria" class="form-select"></select>
                            <input type="text" id="inputSubcategoria" class="form-control" placeholder="Nova subcategoria">
                            
                        </div>
    <div class="d-grid gap-2 col-6 mx-auto">
        <button id="btnCriarSubcategoria" class="btn btn-secondary btn-sm">Criar Subcategoria</button>
    </div>
<!-- end criar categoria subcategoria -->
               
                    </div>
                    <!-- end container criar -->

                 <div class="col-md-8 col-lg-12">
                    <h4 class="mb-3">Registrar</h4>
                    <form id="formRegistro">

                        <div class="row g-3 mb-3">
                            <div class="col-md-4">
                                <label for="moduloSelect" class="form-label">Módulo</label>
                                <select class="form-select" name="modulo" id="moduloSelect"></select>
                            </div>
                            <div class="col-md-4">
                                <label for="categoriaSelect" class="form-label">Categoria</label>
                                <select class="form-select" name="categoria" id="categoriaSelect"></select>
                            </div>
                            <div class="col-md-4">
                                <label for="subcategoriaSelect" class="form-label">Subcategoria</label>
                                <select class="form-select" name="subcategoria" id="subcategoriaSelect">
                                    <option value="">Sem subcategoria</option>
                                </select>
                            </div>
                        </div>

                        <div class="mb-3">
                            <label for="titulo" class="form-label">Título</label>
                            <input type="text" class="form-control" id="titulo" name="titulo" placeholder="Título" required>
                        </div>

                        <div class="mb-3">
                            <label for="conteudo" class="form-label">Conteúdo</label>
                            <textarea name="conteudo" id="conteudo" class="form-control" placeholder="Conteúdo"></textarea>
                        </div>
                        
<!-- cadastrar e ver -->
<div class="d-grid gap-2 d-md-flex justify-content-md-end">
  <button class="btn btn-primary me-md-2" type="submit">Cadastrar</button>
  <a class="btn btn-primary" href="listar_registros.php" target="_blank">Ver Documento</a>
</div>
  <!-- end cadastrar e ver -->                   

                    </form>

                </div>

                </div>
            </div>
        </main>
        <!-- end main -->
    </div>
<!-- end container -->

    <div class="container">
        <main>
            <div id="conteudoRegistro"></div>
        </main>
        <footer class="my-5 pt-5 text-body-secondary text-center text-small">
            <p class="mb-1">2025 DocumentEx</p>
            <ul class="list-inline">
                <li class="list-inline-item"><a href="#">Privacy</a></li>
                <li class="list-inline-item"><a href="#">Terms</a></li>
                <li class="list-inline-item"><a href="#">Support</a></li>
            </ul>
        </footer>
    </div>
    <script src="bootstrap.bundle.min.js"></script>
    <script src="app.js"></script>
    <!-- Modal de confirmação de registro -->
    <div class="modal fade" id="modalConfirmarRegistro" tabindex="-1" aria-labelledby="modalConfirmarRegistroLabel" aria-hidden="true">
      <div class="modal-dialog modal-lg">
        <div class="modal-content">
          <div class="modal-header">
            <h5 class="modal-title" id="modalConfirmarRegistroLabel">Revisar Registro</h5>
            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Fechar"></button>
          </div>
          <div class="modal-body">
            <div id="resumoRegistro"></div>
          </div>
          <div class="modal-footer">
            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Editar</button>
            <button type="button" class="btn btn-success" id="btnSalvarRegistro">Concluir e Salvar</button>
          </div>
        </div>
      </div>
    </div>

    <!-- Modal fullscreen para listagem de registros -->
    <div class="modal fade" id="modalListarRegistros" tabindex="-1" aria-labelledby="modalListarRegistrosLabel" aria-hidden="true">
      <div class="modal-dialog modal-fullscreen">
        <div class="modal-content">
          <div class="modal-header">
            <h5 class="modal-title" id="modalListarRegistrosLabel">Registros</h5>
            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Fechar"></button>
          </div>
          <div class="modal-body" id="conteudoModalRegistros">
            Carregando registros...
          </div>
        </div>
      </div>
    </div>

    
</body>
</html>