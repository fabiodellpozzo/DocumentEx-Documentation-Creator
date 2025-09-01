<?php
include 'conexao.php';

$moduloSelecionado = $_POST['modulo'] ?? 'todos';

$html = "<!DOCTYPE html><html lang='pt-br'><head><meta charset='UTF-8'>
<title>Exportação de Registros</title>
<style>
body { margin: 0; font-family: Arial, sans-serif; display: flex; }
aside { width: 280px; background: #f4f4f4; padding: 20px; border-right: 1px solid #ccc; height: 100vh; overflow-y: auto; position: fixed; }
main { margin-left: 300px; padding: 20px; flex: 1; }
a { text-decoration: none; color: #333; display: block; margin: 5px 0; }
a:hover { text-decoration: underline; }
h2, h3, h4, h5 { margin-top: 20px; }
hr { margin: 20px 0; }
input[type='text'] { width: 100%; padding: 8px; margin-bottom: 15px; border: 1px solid #ccc; border-radius: 4px; }
.hidden { display: none; }
</style>
<script>
function filtrarConteudo() {
  const termo = document.getElementById('busca').value.toLowerCase();
  const blocos = document.querySelectorAll('.bloco');

  blocos.forEach(bloco => {
    const texto = bloco.textContent.toLowerCase();
    bloco.style.display = texto.includes(termo) ? '' : 'none';
  });
}
</script>
</head><body>";

$html .= "<aside><h2>Índice</h2>
<input type='text' id='busca' onkeyup='filtrarConteudo()' placeholder='Buscar registros...'>";

if ($moduloSelecionado === 'todos') {
  $modulos = $pdo->query("SELECT id, nome FROM modulos ORDER BY nome")->fetchAll();
} else {
  $stmt = $pdo->prepare("SELECT id, nome FROM modulos WHERE id = ?");
  $stmt->execute([$moduloSelecionado]);
  $modulos = $stmt->fetchAll();
}

// Sidebar com links hierárquicos
foreach ($modulos as $modulo) {
  $html .= "<a href='#modulo{$modulo['id']}'><strong>" . htmlspecialchars($modulo['nome']) . "</strong></a>";

  $categorias = $pdo->prepare("SELECT id, nome FROM categorias WHERE id_modulo = ?");
  $categorias->execute([$modulo['id']]);
  foreach ($categorias->fetchAll() as $categoria) {
    $html .= "<div style='margin-left:10px;'><a href='#categoria{$categoria['id']}'>" . htmlspecialchars($categoria['nome']) . "</a>";

    $subcategorias = $pdo->prepare("SELECT id, nome FROM subcategorias WHERE id_categoria = ?");
    $subcategorias->execute([$categoria['id']]);
    foreach ($subcategorias->fetchAll() as $sub) {
      $html .= "<div style='margin-left:20px;'><a href='#subcategoria{$sub['id']}'>" . htmlspecialchars($sub['nome']) . "</a></div>";
    }

    $html .= "</div>";
  }
}

$html .= "</aside><main>";

foreach ($modulos as $modulo) {
  $html .= "<div class='bloco'><h2 id='modulo{$modulo['id']}'>" . htmlspecialchars($modulo['nome']) . "</h2><hr>";

  $categorias = $pdo->prepare("SELECT id, nome FROM categorias WHERE id_modulo = ?");
  $categorias->execute([$modulo['id']]);
  foreach ($categorias->fetchAll() as $categoria) {
    $html .= "<h3 id='categoria{$categoria['id']}'>" . htmlspecialchars($categoria['nome']) . "</h3>";

    $subcategorias = $pdo->prepare("SELECT id, nome FROM subcategorias WHERE id_categoria = ?");
    $subcategorias->execute([$categoria['id']]);
    foreach ($subcategorias->fetchAll() as $sub) {
      $html .= "<h4 id='subcategoria{$sub['id']}'>" . htmlspecialchars($sub['nome']) . "</h4>";

      $registros = $pdo->prepare("SELECT titulo, conteudo FROM registros WHERE id_subcategoria = ?");
      $registros->execute([$sub['id']]);
      foreach ($registros->fetchAll() as $r) {
        $html .= "<h5>" . htmlspecialchars($r['titulo']) . "</h5>";
        $html .= "<p>" . nl2br(htmlspecialchars($r['conteudo'])) . "</p><hr>";
      }
    }
  }

  $html .= "</div>";
}

$html .= "</main></body></html>";

header("Content-Type: text/html");
header("Content-Disposition: attachment; filename=exportacao_registros.html");
echo $html;
exit;
?>