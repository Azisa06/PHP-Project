@extends('layout')

@section('principal')
<div class="row justify-content-center mt-5">
    <div class="col-md-10">
        <div class="card shadow">
            <div class="card-body">
                <h1 class="card-title text-center mb-4">
                    <i class="bi bi-cart-plus"></i> Registrar Compra
                </h1>

                <form method="POST" action="/compras">
                    @csrf

                    <div class="mb-3">
                        <label for="data" class="form-label">Data da Compra</label>
                        <input type="date" name="data" class="form-control" required>
                    </div>

                    <div class="produto-item row g-2 mb-2 d-flex align-items-end"> 
                        <h5 class="mt-4">Produtos</h5>
                        <div id="produtos-lista">
                            <div class="produto-item row g-2 mb-2">
                                <div class="col-md-4">
                                    <select name="produtos[0][produto_id]" class="form-select produto-select select-busca" required>
                                        <option value="">Selecione ou busque um produto</option>
                                        <!-- Itens serão carregados via AJAX pelo Tom Select -->
                                    </select>
                                </div>
                                <div class="col-md-2">
                                    <!-- Aplica a classe para igualar a altura do campo de busca -->
                                    <input type="number" name="produtos[0][quantidade]" class="form-control quantidade input-grande" min="1" placeholder="Qtd" required>
                                </div>
                                <div class="col-md-2">
                                    <!-- Aplica a classe para igualar a altura do campo de busca -->
                                    <input type="text" name="produtos[0][preco_compra]" class="form-control preco input-grande" placeholder="Preço de Compra" required>
                                </div>
                                <div class="col-md-2">
                                    <!-- Aplica a classe para igualar a altura do campo de busca -->
                                    <input type="text" class="form-control subtotal input-grande" placeholder="Subtotal" readonly>
                                </div>
                                <div class="col-md-2">
                                    <button type="button" class="btn btn-danger btn-remover">
                                        <i class="bi bi-trash"></i>
                                    </button>
                                </div>
                            </div>
                        </div>
                    </div>

                    <button type="button" id="adicionar-produto" class="btn btn-secondary mt-2">
                        <i class="bi bi-plus-circle"></i> Adicionar Produto
                    </button>

                    <div class="mt-4 text-end">
                        <h5>Total: R$ <span id="total">0,00</span></h5>
                    </div>

                    <div class="d-flex justify-content-center mt-4">
                        <button type="submit" class="btn btn-primary me-2">
                            <i class="bi bi-check-circle"></i> Cadastrar
                        </button>
                        <a href="{{ route('compras.index') }}" class="btn btn-danger">
                            <i class="bi bi-x-circle"></i> Cancelar
                        </a>
                    </div>

                    @if (session('sucesso'))
                        <div class="alert alert-success mt-3">
                            {{ session('sucesso') }}
                        </div>
                    @endif

                    @if (session('erro'))
                        <div class="alert alert-danger mt-3">
                            {{ session('erro') }}
                        </div>
                    @endif
                </form>
            </div>
        </div>
    </div>
</div>

<style>
.input-grande {
    /* Padding observado no campo de busca para igualar a altura */
    padding: 0.5rem 0.75rem !important; 
    height: auto !important; 
}

/* 2. Tom Select: Estilos para garantir que a FONTE e a COR estejam corretas. */
.ts-wrapper.form-select .ts-control {
    /* Remove a borda padrão do Tom Select que estava causando a 'linha em volta' */
    border: none !important; 
    
    /* Define explicitamente a fonte/tamanho para ser consistente com o Bootstrap padrão (1rem) */
    font-size: 1rem;
    line-height: 1.5;
}

/* 3. Tom Select: Alinha a cor e o tamanho do placeholder */
.ts-wrapper.form-select .ts-placeholder {
    color: #6c757d; 
    opacity: 0.65; 
    font-size: 1rem;
    line-height: 1.5;
}

/* 4. Tom Select: Remove o foco indesejado (a borda interna) */
.ts-wrapper.form-select.focus .ts-control,
.ts-wrapper.form-select .ts-control:focus,
.ts-wrapper.form-select .ts-control:focus-within,
.ts-wrapper.form-select .ts-control input:focus {
    outline: 0 !important;
    box-shadow: none !important;
}
</style>

<script>
    let contador = 1;

    // Função para inicializar o campo de busca (Tom Select)
    function inicializarBusca(elemento) {
        new TomSelect(elemento, {
            valueField: 'id',
            labelField: 'text',
            searchField: 'text',
            placeholder: 'Selecione ou busque um produto...',
            preload: true, 
            load: function(query, callback) {
                if (!query.length) {
                    query = '';
                }
                
                // Chamada da rota Laravel correta
                const url = '{{ route("api.produtos.search") }}?q=' + encodeURIComponent(query);

                fetch(url)
                    .then(response => response.json())
                    .then(data => {
                        if(data.results) {
                            callback(data.results);
                        } else {
                            callback();
                        }
                    })
                    .catch((error) => {
                        console.error("Erro na busca de produtos:", error);
                        callback();
                    });
            },
            maxItems: 1, 
            persist: false,
        });
    }

    document.addEventListener('DOMContentLoaded', function() {
        // Inicializa o primeiro campo de busca ao carregar a página
        document.querySelectorAll('.produto-select').forEach(inicializarBusca);
        atualizarTotais();
    });


    function atualizarTotais() {
        let total = 0;

        document.querySelectorAll('.produto-item').forEach(item => {
            const precoInput = item.querySelector('.preco');
            const qtdInput = item.querySelector('.quantidade');
            const subtotalInput = item.querySelector('.subtotal');

            const precoStr = precoInput.value.replace(/[^\d,]/g, '').replace(',', '.');
            const preco = parseFloat(precoStr) || 0; 
            const qtd = parseInt(qtdInput.value) || 0;
            const subtotal = preco * qtd;

            if (!isNaN(subtotal)) {
                subtotalInput.value = subtotal.toFixed(2).replace('.', ',');
                total += subtotal;
            }
        });

        document.getElementById('total').innerText = total.toFixed(2).replace('.', ',');
    }

    document.getElementById('adicionar-produto').addEventListener('click', function() {
        const modelo = document.querySelector('.produto-item');
        
        // 1. Clonar o elemento pai
        const novo = modelo.cloneNode(true);

        // 2. Limpar inputs (quantidade, preço, subtotal)
        novo.querySelector('.quantidade').value = '';
        novo.querySelector('.preco').value = '';
        novo.querySelector('.subtotal').value = '';
        
        // 3. RECONSTRUÇÃO DO SELECT: Limpar e Recriar o elemento <select>
        const selectContainer = novo.querySelector('.col-md-4');
        selectContainer.innerHTML = ''; 

        const newSelect = document.createElement('select');
        newSelect.setAttribute('name', `produtos[${contador}][produto_id]`);
        newSelect.setAttribute('class', 'form-select produto-select select-busca'); 
        newSelect.setAttribute('required', 'required');
        newSelect.innerHTML = '<option value="">Selecione/Busque um produto</option>';
        
        selectContainer.appendChild(newSelect);
        // FIM DA RECONSTRUÇÃO

        // 4. Renomeia os inputs para o novo índice
        novo.querySelectorAll('input, select').forEach(el => {
            const name = el.getAttribute('name');
            if (name) {
                el.setAttribute('name', name.replace(/\[\d+\]/, `[${contador}]`));
            }
            // Garante que os inputs clonados tenham a classe de tamanho
            if (el.tagName === 'INPUT' && !el.classList.contains('input-grande')) {
                el.classList.add('input-grande');
            }
        });

        document.getElementById('produtos-lista').appendChild(novo);

        // 5. Inicializa o campo de busca com o novo elemento criado
        inicializarBusca(newSelect);

        contador++;
        atualizarTotais();
    });

    document.addEventListener('input', function(e) {
        if (
            e.target.classList.contains('quantidade') ||
            e.target.classList.contains('preco')
        ) {
            atualizarTotais();
        }
    });

    document.addEventListener('click', function(e) {
        if (e.target.closest('.btn-remover')) {
            var item = e.target.closest('.produto-item') || e.target.closest('.btn-remover').closest('.produto-item');
           
            if (document.querySelectorAll('.produto-item').length > 1) {
                item.remove();
                atualizarTotais();
            } else {
                console.warn("É necessário ter pelo menos um produto na compra.");
            }
        }
    });
</script>
@endsection
