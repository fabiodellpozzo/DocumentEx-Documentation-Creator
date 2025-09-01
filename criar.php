<?php
include 'conexao.php';

$action = $_POST['action'] ?? '';

switch ($action) {
    case 'modulo':
        $nome = trim($_POST['nome'] ?? '');
        if (!$nome) {
            echo "Nome inválido.";
            exit;
        }
        $stmt = $pdo->prepare("SELECT COUNT(*) FROM modulos WHERE nome = ?");
        $stmt->execute([$nome]);
        if ($stmt->fetchColumn() > 0) {
            echo "Módulo já existe.";
            exit;
        }
        $stmt = $pdo->prepare("INSERT INTO modulos (nome) VALUES (?)");
        $stmt->execute([$nome]);
        echo "Módulo criado com sucesso!";
        break;

    case 'categoria':
        $nome = trim($_POST['nome'] ?? '');
        $id_modulo = $_POST['modulo'] ?? '';
        if (!$nome || !$id_modulo) {
            echo "Nome ou módulo inválido.";
            exit;
        }
        $stmt = $pdo->prepare("SELECT COUNT(*) FROM categorias WHERE nome = ? AND id_modulo = ?");
        $stmt->execute([$nome, $id_modulo]);
        if ($stmt->fetchColumn() > 0) {
            echo "Categoria já existe.";
            exit;
        }
        $stmt = $pdo->prepare("INSERT INTO categorias (nome, id_modulo) VALUES (?, ?)");
        $stmt->execute([$nome, $id_modulo]);
        echo "Categoria criada com sucesso!";
        break;

    case 'subcategoria':
        $nome = trim($_POST['nome'] ?? '');
        $id_categoria = $_POST['categoria'] ?? '';
        if (!$nome || !$id_categoria) {
            echo "Nome ou categoria inválidos.";
            exit;
        }
        $stmt = $pdo->prepare("SELECT COUNT(*) FROM subcategorias WHERE nome = ? AND id_categoria = ?");
        $stmt->execute([$nome, $id_categoria]);
        if ($stmt->fetchColumn() > 0) {
            echo "Subcategoria já existe.";
            exit;
        }
        $stmt = $pdo->prepare("INSERT INTO subcategorias (nome, id_categoria) VALUES (?, ?)");
        $stmt->execute([$nome, $id_categoria]);
        echo "Subcategoria criada com sucesso!";
        break;

    default:
        echo "Ação inválida.";
}
?>

<script>
// Criar módulo
fetch('criar.php', {
    method: 'POST',
    headers: { 'Content-Type': 'application/x-www-form-urlencoded' },
    body: 'action=modulo&nome=' + encodeURIComponent(nome)
})

// Criar categoria
fetch('criar.php', {
    method: 'POST',
    headers: { 'Content-Type': 'application/x-www-form-urlencoded' },
    body: 'action=categoria&nome=' + encodeURIComponent(nome) + '&modulo=' + encodeURIComponent(modulo)
})

// Criar subcategoria
fetch('criar.php', {
    method: 'POST',
    headers: { 'Content-Type': 'application/x-www-form-urlencoded' },
    body: 'action=subcategoria&nome=' + encodeURIComponent(nome) + '&categoria=' + encodeURIComponent(categoria)
})
.then(res => res.text())
.then(msg => {
    alert(msg);
    // Atualize selects e sidebar conforme necessário
});
</script>