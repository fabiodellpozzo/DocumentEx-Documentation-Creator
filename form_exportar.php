<?php
include 'conexao.php';
$modulos = $pdo->query("SELECT id, nome FROM modulos ORDER BY nome")->fetchAll();
?>

<form action="exportar_html.php" method="post">
  <label for="modulo">Escolha o módulo:</label>
  <select name="modulo" id="modulo">
    <option value="todos">Todos os módulos</option>
    <?php foreach ($modulos as $m): ?>
      <option value="<?= $m['id'] ?>"><?= htmlspecialchars($m['nome']) ?></option>
    <?php endforeach; ?>
  </select>
  <button type="submit">Exportar HTML</button>
</form>