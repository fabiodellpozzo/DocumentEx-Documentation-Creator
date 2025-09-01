document.addEventListener('DOMContentLoaded', function() {

    // Elementos do DOM
    const moduloSelect = document.getElementById('moduloSelect');
    const categoriaSelect = document.getElementById('categoriaSelect');
    const subcategoriaSelect = document.getElementById('subcategoriaSelect');
    const formRegistro = document.getElementById('formRegistro');
    const btnCriarModulo = document.getElementById('btnCriarModulo');
    const inputModulo = document.getElementById('inputModulo');
    const moduloParaCategoria = document.getElementById('moduloParaCategoria');
    const inputCategoria = document.getElementById('inputCategoria');
    const btnCriarCategoria = document.getElementById('btnCriarCategoria');
    const moduloParaSubcategoria = document.getElementById('moduloParaSubcategoria');
    const categoriaParaSubcategoria = document.getElementById('categoriaParaSubcategoria');
    const inputSubcategoria = document.getElementById('inputSubcategoria');
    const btnCriarSubcategoria = document.getElementById('btnCriarSubcategoria');

    // Função para mostrar avisos
    function mostrarAviso(msg, tipo = 'info') {
        const aviso = document.getElementById('aviso');
        aviso.innerHTML = `<div class="alert alert-${tipo}" role="alert">${msg}</div>`;
        setTimeout(() => { aviso.innerHTML = ''; }, 5000);
    }

    // Sidebar
    function atualizarSidebar() {
        fetch('get_functions.php?action=sidebar')
            .then(res => res.text())
            .then(html => {
                document.getElementById('sidebar').innerHTML = html;
            });
    }

    // Carregar módulos para registro
    function carregarModulos() {
        fetch('get_functions.php?action=modulos')
            .then(res => res.json())
            .then(data => {
                if (moduloSelect) {
                    moduloSelect.innerHTML = '';
                    data.forEach(mod => {
                        moduloSelect.innerHTML += `<option value="${mod.id}">${mod.nome}</option>`;
                    });
                    if (data.length > 0) {
                        moduloSelect.dispatchEvent(new Event('change'));
                    }
                }
            });
    }

    // Carregar módulos para categoria
    function carregarModulosParaCategoria() {
        fetch('get_functions.php?action=modulos')
            .then(res => res.json())
            .then(data => {
                if (moduloParaCategoria) {
                    moduloParaCategoria.innerHTML = '';
                    data.forEach(mod => {
                        moduloParaCategoria.innerHTML += `<option value="${mod.id}">${mod.nome}</option>`;
                    });
                }
            });
    }

    // Carregar módulos para subcategoria
    function carregarModulosParaSubcategoria() {
        fetch('get_functions.php?action=modulos')
            .then(res => res.json())
            .then(data => {
                if (moduloParaSubcategoria) {
                    moduloParaSubcategoria.innerHTML = '';
                    data.forEach(mod => {
                        moduloParaSubcategoria.innerHTML += `<option value="${mod.id}">${mod.nome}</option>`;
                    });
                    if (data.length > 0) {
                        carregarCategoriasParaSubcategoria(data[0].id);
                    } else if (categoriaParaSubcategoria) {
                        categoriaParaSubcategoria.innerHTML = '';
                    }
                }
            });
    }

    // Carregar categorias para subcategoria
    function carregarCategoriasParaSubcategoria(moduloId) {
        fetch(`get_functions.php?action=categorias&modulo=${moduloId}`)
            .then(res => res.json())
            .then(data => {
                if (categoriaParaSubcategoria) {
                    categoriaParaSubcategoria.innerHTML = '';
                    data.forEach(cat => {
                        categoriaParaSubcategoria.innerHTML += `<option value="${cat.id}">${cat.nome}</option>`;
                    });
                }
            });
    }

    // Eventos dinâmicos para selects de registro
    if (moduloSelect) {
        moduloSelect.addEventListener('change', () => {
            fetch(`get_functions.php?action=categorias&modulo=${moduloSelect.value}`)
                .then(res => res.json())
                .then(data => {
                    if (categoriaSelect) {
                        categoriaSelect.innerHTML = '';
                        data.forEach(cat => {
                            categoriaSelect.innerHTML += `<option value="${cat.id}">${cat.nome}</option>`;
                        });
                        if (data.length > 0) {
                            categoriaSelect.dispatchEvent(new Event('change'));
                        } else if (subcategoriaSelect) {
                            subcategoriaSelect.innerHTML = '<option value="">Sem subcategoria</option>';
                        }
                    }
                });
        });
    }

    if (categoriaSelect) {
        categoriaSelect.addEventListener('change', () => {
            fetch(`get_functions.php?action=subcategorias&categoria=${categoriaSelect.value}`)
                .then(res => res.json())
                .then(data => {
                    if (subcategoriaSelect) {
                        subcategoriaSelect.innerHTML = '<option value="">Sem subcategoria</option>';
                        data.forEach(sub => {
                            subcategoriaSelect.innerHTML += `<option value="${sub.id}">${sub.nome}</option>`;
                        });
                    }
                });
        });
    }

    if (moduloParaSubcategoria) {
        moduloParaSubcategoria.addEventListener('change', () => {
            carregarCategoriasParaSubcategoria(moduloParaSubcategoria.value);
        });
    }

    // Formulário de registro
    if (formRegistro) {
        formRegistro.addEventListener('submit', function(e) {
            e.preventDefault();

            const titulo = document.getElementById('titulo').value.trim();
            const conteudo = document.getElementById('conteudo').value.trim();
            const modulo = moduloSelect.options[moduloSelect.selectedIndex]?.text || '';
            const categoria = categoriaSelect.options[categoriaSelect.selectedIndex]?.text || '';
            const subcategoria = subcategoriaSelect.options[subcategoriaSelect.selectedIndex]?.text || 'Sem subcategoria';

            document.getElementById('resumoRegistro').innerHTML = `
                <div class="mb-2"><strong>Título:</strong> ${titulo}</div>
                <div class="mb-2"><strong>Módulo:</strong> ${modulo}</div>
                <div class="mb-2"><strong>Categoria:</strong> ${categoria}</div>
                <div class="mb-2"><strong>Subcategoria:</strong> ${subcategoria}</div>
                <div class="mb-2"><strong>Conteúdo:</strong><br><pre class="bg-light p-2">${conteudo}</pre></div>
            `;

            const modal = new bootstrap.Modal(document.getElementById('modalConfirmarRegistro'));
            modal.show();

            document.getElementById('btnSalvarRegistro').onclick = function() {
                const formData = new FormData(formRegistro);
                fetch('cadastrar_registro.php', {
                    method: 'POST',
                    body: formData
                })
                .then(res => res.text())
                .then(msg => {
                    modal.hide();
                    mostrarAviso(msg, msg.toLowerCase().includes('sucesso') ? 'success' : 'danger');
                    document.getElementById('conteudoRegistro').innerText = msg;
                    atualizarSidebar();
                    formRegistro.reset();
                });
            };
        });
    }

    // Criar módulo
    if (btnCriarModulo) {
        btnCriarModulo.addEventListener('click', () => {
            const nome = inputModulo.value.trim();
            if (!nome) {
                mostrarAviso('Digite o nome do módulo.', 'danger');
                return;
            }
            fetch('criar.php', {
                method: 'POST',
                headers: { 'Content-Type': 'application/x-www-form-urlencoded' },
                body: 'action=modulo&nome=' + encodeURIComponent(nome)
            })
            .then(res => res.text())
            .then(msg => {
                mostrarAviso(msg, msg.toLowerCase().includes('sucesso') ? 'success' : 'danger');
                inputModulo.value = '';
                carregarModulos();
                carregarModulosParaCategoria();
                carregarModulosParaSubcategoria();
                atualizarSidebar();
            });
        });
    }

    // Criar categoria
    if (btnCriarCategoria) {
        btnCriarCategoria.addEventListener('click', () => {
            const nome = inputCategoria.value.trim();
            const modulo = moduloParaCategoria.value;
            if (!nome || !modulo) {
                mostrarAviso('Preencha todos os campos para criar a categoria.', 'danger');
                return;
            }
            fetch('criar.php', {
                method: 'POST',
                headers: { 'Content-Type': 'application/x-www-form-urlencoded' },
                body: 'action=categoria&nome=' + encodeURIComponent(nome) + '&modulo=' + encodeURIComponent(modulo)
            })
            .then(res => res.text())
            .then(msg => {
                mostrarAviso(msg, msg.toLowerCase().includes('sucesso') ? 'success' : 'danger');
                inputCategoria.value = '';
                carregarModulos();
                carregarModulosParaCategoria();
                carregarModulosParaSubcategoria();
                atualizarSidebar();
            });
        });
    }

        // Criar subcategoria
    if (btnCriarSubcategoria) {
        btnCriarSubcategoria.addEventListener('click', () => {
            const nome = inputSubcategoria.value.trim();
            const categoria = categoriaParaSubcategoria.value;
            if (!nome || !categoria) {
                mostrarAviso('Preencha todos os campos para criar a subcategoria.', 'danger');
                return;
            }
            fetch('criar.php', {
                method: 'POST',
                headers: { 'Content-Type': 'application/x-www-form-urlencoded' },
                body: 'action=subcategoria&nome=' + encodeURIComponent(nome) + '&categoria=' + encodeURIComponent(categoria)
            })
            .then(res => res.text())
            .then(msg => {
                mostrarAviso(msg, msg.toLowerCase().includes('sucesso') ? 'success' : 'danger');
                inputSubcategoria.value = '';
                carregarModulos();
                carregarModulosParaCategoria();
                carregarModulosParaSubcategoria();
                atualizarSidebar();
            });
        });
    }





    // Inicialização
    carregarModulos();
    carregarModulosParaCategoria();
    carregarModulosParaSubcategoria();
    atualizarSidebar();
    setInterval(atualizarSidebar, 5000);
}); // Fim do DOMContentLoaded

// Função global para exclusão — precisa estar fora do DOMContentLoaded
function excluir(tipo, id) {
    if (confirm("Tem certeza que deseja excluir este item?")) {
        fetch(`get_functions.php?action=excluir&tipo=${tipo}&id=${id}`)
            .then(res => res.json())
            .then(data => {
                if (data.sucesso) {
                    alert("Item excluído com sucesso!");
                    // Atualiza a sidebar sem recarregar a página
                    if (typeof atualizarSidebar === 'function') {
                        atualizarSidebar();
                    } else {
                        location.reload(); // fallback
                    }
                } else {
                    alert("Erro ao excluir.");
                }
            })
            .catch(error => {
                console.error("Erro na requisição:", error);
                alert("Erro na comunicação com o servidor.");
            });
    }
}
