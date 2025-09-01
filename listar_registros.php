<!DOCTYPE html>
<html lang="pt-br">
<head>
  <meta charset="UTF-8">
  <title>Listar Registros</title>
  <style>
    body { font-family: Arial, sans-serif; display: flex; }
    aside.sidebar-esq { width: 250px; background: #f9f9f9; padding: 10px; border-right: 1px solid #ccc; height: 100vh; overflow-y: auto; }
    aside.sidebar-dir { width: 220px; background: #f9f9f9; padding: 10px; border-left: 1px solid #ccc; height: 100vh; overflow-y: auto; }
    main { flex: 1; padding: 20px; min-height: 100vh; }
    a { text-decoration: none; color: #333; display: block; margin: 5px 0; }
    a:hover { text-decoration: underline; }
    h4 { margin-bottom: 5px; }
    p { margin-top: 0; }
    .categoria-link, .subcategoria-link { margin-left: 15px; }
    .active-link { font-weight: bold; color: #007bff; }
    .container-flex { display: flex; width: 100vw; }
  </style>
</head>
<body>
<?php
include 'conexao.php';

// Carrega todos os módulos
$modulos = $pdo->query("SELECT id, nome FROM modulos ORDER BY id ASC")->fetchAll(PDO::FETCH_ASSOC);

// Carrega todas as categorias agrupadas por módulo
$categorias = [];
$stmt = $pdo->query("SELECT id, nome, id_modulo FROM categorias ORDER BY id ASC");
while ($cat = $stmt->fetch(PDO::FETCH_ASSOC)) {
    $categorias[$cat['id_modulo']][] = $cat;
}

// Carrega todas as subcategorias agrupadas por categoria
$subcategorias = [];
$stmt = $pdo->query("SELECT id, nome, id_categoria FROM subcategorias ORDER BY id ASC");
while ($sub = $stmt->fetch(PDO::FETCH_ASSOC)) {
    $subcategorias[$sub['id_categoria']][] = $sub;
}

// Carrega todos os registros agrupados por categoria e subcategoria
$registros = [];
$stmt = $pdo->query("SELECT id, titulo, conteudo, id_categoria, id_subcategoria FROM registros ORDER BY id ASC");
while ($reg = $stmt->fetch(PDO::FETCH_ASSOC)) {
    $registros[$reg['id_categoria']][$reg['id_subcategoria']][] = $reg;
}
?>

<div class="container-flex">
    <!-- Sidebar esquerda: módulos e categorias -->
    <aside class="sidebar-esq">
        <h4>Módulos</h4>
        <ul style="list-style:none; padding-left:0;">
        <?php foreach ($modulos as $mod): ?>
            <li>
                <a href="#modulo<?= $mod['id'] ?>" class="modulo-link" data-id="<?= $mod['id'] ?>"><?= htmlspecialchars($mod['nome']) ?></a>
                <?php if (!empty($categorias[$mod['id']])): ?>
                    <ul style="list-style:none; padding-left:10px;">
                    <?php foreach ($categorias[$mod['id']] as $cat): ?>
                        <li>
                            <a href="#categoria<?= $cat['id'] ?>" class="categoria-link" data-id="<?= $cat['id'] ?>"><?= htmlspecialchars($cat['nome']) ?></a>
                        </li>
                    <?php endforeach; ?>
                    </ul>
                <?php endif; ?>
            </li>
        <?php endforeach; ?>
        </ul>
    </aside>

    <!-- Conteúdo central -->
    <main id="conteudo">
        <?php foreach ($modulos as $mod): ?>
            <h2 id="modulo<?= $mod['id'] ?>"><?= htmlspecialchars($mod['nome']) ?></h2>
            <?php if (!empty($categorias[$mod['id']])): ?>
                <?php foreach ($categorias[$mod['id']] as $cat): ?>
                    <h3 id="categoria<?= $cat['id'] ?>"><?= htmlspecialchars($cat['nome']) ?></h3>
                    <?php
                    // Subcategorias para esta categoria
                    $subs = $subcategorias[$cat['id']] ?? [];
                    if ($subs): ?>
                        <ul>
                        <?php foreach ($subs as $sub): ?>
                            <li>
                                <a href="#subcategoria<?= $sub['id'] ?>" class="subcategoria-link"><?= htmlspecialchars($sub['nome']) ?></a>
                            </li>
                        <?php endforeach; ?>
                        </ul>
                    <?php endif; ?>

                    <?php
                    // Registros sem subcategoria
                    if (!empty($registros[$cat['id']][null])) {
                        foreach ($registros[$cat['id']][null] as $reg) {
                            echo "<div style='margin-bottom:10px;'><strong>{$reg['titulo']}</strong><br><span>{$reg['conteudo']}</span></div>";
                        }
                    }
                    // Registros por subcategoria
                    if (!empty($subs)) {
                        foreach ($subs as $sub) {
                            echo "<h4 id='subcategoria{$sub['id']}'>" . htmlspecialchars($sub['nome']) . "</h4>";
                            if (!empty($registros[$cat['id']][$sub['id']])) {
                                foreach ($registros[$cat['id']][$sub['id']] as $reg) {
                                    echo "<div style='margin-bottom:10px;'><strong>{$reg['titulo']}</strong><br><span>{$reg['conteudo']}</span></div>";
                                }
                            } else {
                                echo "<p><em>Sem registros nesta subcategoria.</em></p>";
                            }
                        }
                    }
                    ?>
                <?php endforeach; ?>
            <?php endif; ?>
        <?php endforeach; ?>
    </main>

    <!-- Sidebar direita: subcategorias da categoria selecionada -->
    <aside class="sidebar-dir" id="sidebarDir">
        <h4>Subcategorias</h4>
        <div id="subcategoriasLinks">
            <p>Selecione uma categoria para ver as subcategorias.</p>
        </div>
    </aside>
</div>

<script>
// Navegação interna suave
document.querySelectorAll('a[href^="#"]').forEach(link => {
    link.addEventListener('click', function(e) {
        const target = document.querySelector(this.getAttribute('href'));
        if (target) {
            e.preventDefault();
            target.scrollIntoView({ behavior: 'smooth', block: 'start' });
        }
    });
});

// Atualiza sidebar direita ao clicar em categoria
document.querySelectorAll('.categoria-link').forEach(link => {
    link.addEventListener('click', function(e) {
        const catId = this.dataset.id;
        const subs = <?php echo json_encode($subcategorias); ?>;
        const subLinksDiv = document.getElementById('subcategoriasLinks');
        subLinksDiv.innerHTML = '';
        if (subs[catId]) {
            subs[catId].forEach(function(sub) {
                const a = document.createElement('a');
                a.href = '#subcategoria' + sub.id;
                a.className = 'subcategoria-link';
                a.textContent = sub.nome;
                subLinksDiv.appendChild(a);
            });
        } else {
            subLinksDiv.innerHTML = '<p><em>Sem subcategorias nesta categoria.</em></p>';
        }
    });
});

// Limpa sidebar direita ao clicar em módulo
document.querySelectorAll('.modulo-link').forEach(link => {
    link.addEventListener('click', function(e) {
        document.getElementById('subcategoriasLinks').innerHTML = '<p>Selecione uma categoria para ver as subcategorias.</p>';
    });
});
</script>
</body>
</html>