<?php
include 'conexao.php';

$action = $_GET['action'] ?? '';

switch ($action) {
  case 'modulos':
  $stmt = $pdo->query("SELECT id, nome FROM modulos ORDER BY id ASC");
  echo json_encode($stmt->fetchAll());
  break;

case 'categorias':
  $modulo = $_GET['modulo'] ?? 0;
  $stmt = $pdo->prepare("SELECT id, nome FROM categorias WHERE id_modulo = ? ORDER BY id ASC");
  $stmt->execute([$modulo]);
  echo json_encode($stmt->fetchAll());
  break;

case 'subcategorias':
  $categoria = $_GET['categoria'] ?? 0;
  $stmt = $pdo->prepare("SELECT id, nome FROM subcategorias WHERE id_categoria = ? ORDER BY id ASC");
  $stmt->execute([$categoria]);
  echo json_encode($stmt->fetchAll());
  break;

case 'registros':
  $modulo = $_GET['modulo'] ?? null;
  $categoria = $_GET['categoria'] ?? null;
  $subcategoria = $_GET['subcategoria'] ?? null;

  $query = "SELECT titulo, conteudo FROM registros WHERE 1=1 ";
  $params = [];

  if ($subcategoria) {
    $query .= " AND id_subcategoria = ?";
    $params[] = $subcategoria;
  } elseif ($categoria) {
    $query .= " AND id_categoria = ?";
    $params[] = $categoria;
  } elseif ($modulo) {
    $query .= " AND id_modulo = ?";
    $params[] = $modulo;
  }

  $query .= " ORDER BY id ASC"; // <-- Adiciona ordenação por id

  $stmt = $pdo->prepare($query);
  $stmt->execute($params);

  $registros = $stmt->fetchAll();

  if (count($registros) === 0) {
    echo "<p>Nenhum registro encontrado.</p>";
  } else {
    foreach ($registros as $r) {
      echo "<h4>{$r['titulo']}</h4><p>{$r['conteudo']}</p><hr>";
    }
  }
  break;

case 'sidebar':
  $modulos = $pdo->query("SELECT id, nome FROM modulos ORDER BY id ASC")->fetchAll();

  foreach ($modulos as $modulo) {
    echo "
    <ul>
    
      {$modulo['nome']}
    
      <div class='d-grid gap-2 d-md-flex justify-content-md-end'>
        <button class='btn btn-primary me-md-2 btn-sm' onclick=\"excluir('modulo', {$modulo['id']})\">X</button>
      </div>

          
          <ul>";

    $categorias = $pdo->prepare("SELECT id, nome FROM categorias WHERE id_modulo = ? ORDER BY id ASC");
    $categorias->execute([$modulo['id']]);

    foreach ($categorias->fetchAll() as $categoria) {
      echo "
      
      <li>{$categoria['nome']} 
              <button onclick=\"excluir('categoria', {$categoria['id']})\">X</button>
              <ul>";

      $subcategorias = $pdo->prepare("SELECT id, nome FROM subcategorias WHERE id_categoria = ? ORDER BY id ASC");
      $subcategorias->execute([$categoria['id']]);

      foreach ($subcategorias->fetchAll() as $sub) {
        echo "<li>{$sub['nome']} 
                <button onclick=\"excluir('subcategoria', {$sub['id']})\">X</button>
              </li>";
      }

      echo "</ul></li>";
    }

    echo "</ul>";
  }
  break;


  case 'excluir':
  $tipo = $_GET['tipo'] ?? '';
  $id = $_GET['id'] ?? 0;

  switch ($tipo) {
    case 'modulo':
      $stmt = $pdo->prepare("DELETE FROM modulos WHERE id = ?");
      break;
    case 'categoria':
      $stmt = $pdo->prepare("DELETE FROM categorias WHERE id = ?");
      break;
    case 'subcategoria':
      $stmt = $pdo->prepare("DELETE FROM subcategorias WHERE id = ?");
      break;
    default:
      echo json_encode(['erro' => 'Tipo inválido']);
      exit;
  }

  $stmt->execute([$id]);
  echo json_encode(['sucesso' => true]);
  break;



case 'sidebar':
  $modulos = $pdo->query("SELECT id, nome FROM modulos ORDER BY nome ASC")->fetchAll();

  foreach ($modulos as $modulo) {
    echo "<strong>{$modulo['nome']}</strong><ul>";

    $categorias = $pdo->prepare("SELECT id, nome FROM categorias WHERE id_modulo = ? ORDER BY nome ASC");
    $categorias->execute([$modulo['id']]);

    foreach ($categorias->fetchAll() as $categoria) {
      echo "<li>{$categoria['nome']}<ul>";

      $subcategorias = $pdo->prepare("SELECT nome FROM subcategorias WHERE id_categoria = ? ORDER BY nome ASC");
      $subcategorias->execute([$categoria['id']]);

      foreach ($subcategorias->fetchAll() as $sub) {
        echo "<li>{$sub['nome']}</li>";
      }

      echo "</ul></li>";
    }

    echo "</ul>";
  }
  break;

  default:
    echo json_encode(['erro' => 'Ação inválida']);
}
?>