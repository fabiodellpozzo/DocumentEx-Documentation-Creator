<?php
include 'conexao.php';

$titulo = trim($_POST['titulo']);
$conteudo = $_POST['conteudo'];
$modulo = $_POST['modulo'];
$categoria = $_POST['categoria'];
$subcategoria = $_POST['subcategoria'] ?: null;

if (!$titulo || !$modulo || !$categoria) {
  echo "Preencha todos os campos obrigatórios.";
  exit;
}

$stmt = $pdo->prepare("SELECT COUNT(*) FROM registros WHERE titulo = ?");
$stmt->execute([$titulo]);

if ($stmt->fetchColumn() > 0) {
  echo "Título já existe.";
  exit;
}

$stmt = $pdo->prepare("INSERT INTO registros (titulo, conteudo, id_modulo, id_categoria, id_subcategoria) VALUES (?, ?, ?, ?, ?)");
$stmt->execute([$titulo, $conteudo, $modulo, $categoria, $subcategoria]);

echo "Registro criado com sucesso!";
?>