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
                        <input type="date" name="data" class="form-control" required value="{{ old('data', date('Y-m-d')) }}">
                    </div>

                    <h5 class="mt-4">Produtos</h5>
                    
                    {{-- O ID da lista é o container de todos os itens --}}
                    <div id="produtos-lista">
                        
                        {{-- Estrutura modelo (Produto 1) --}}
                        <div class="produto-item row g-2 mb-3 p-3 border rounded align-items-end">
                            
                            {{-- Índice do Produto --}}
                            <h6 class="produto-indice mb-2">Produto 1</h6>

                            <div class="col-md-4">
                                <label for="produtos[0][produto_id]" class="form-label">Nome:</label>
                                <select name="produtos[0][produto_id]" class="form-select produto-select select-busca" required>
                                    <option value="">Selecione ou busque um produto</option>
                                </select>
                            </div>
                            <div class="col-md-2">
                                <label for="produtos[0][quantidade]" class="form-label">Quantidade:</label>
                                <input type="number" name="produtos[0][quantidade]" class="form-control quantidade input-grande" min="1" required>
                            </div>
                            <div class="col-md-2">
                                <label for="produtos[0][preco_compra]" class="form-label">Preço de compra:</label>
                                <input type="text" name="produtos[0][preco_compra]" class="form-control preco input-grande" placeholder="0,00" required>
                            </div>
                            <div class="col-md-2">
                                <label for="subtotal" class="form-label">Subtotal:</label>
                                <input type="text" name="subtotal" class="form-control subtotal input-grande text-end" placeholder="0,00" readonly>
                            </div>
                            <div class="col-md-2 d-flex justify-content-center">
                                <button type="button" class="btn btn-danger btn-remover">
                                    <i class="bi bi-trash"></i>
                                </button>
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
/* Seus estilos CSS */
.input-grande {
    padding: 0.5rem 0.75rem !important; 
    height: auto !important; 
}
.ts-wrapper.form-select .ts-control {
    border: none !important; 
    font-size: 1rem;
    line-height: 1.5;
}
.ts-wrapper.form-select .ts-placeholder {
    color: #6c757d; 
    opacity: 0.65; 
    font-size: 1rem;
    line-height: 1.5;
}
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

    // Função para cálculo de totais (corrigida na iteração anterior)
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

    // Função para re-indexar os nomes, títulos e re-inicializar o Tom Select em todos os itens
    function reindexarProdutos() {
        const lista = document.getElementById('produtos-lista');
        let index = 1; // Começa a contagem visual em 1

        lista.querySelectorAll('.produto-item').forEach(item => {
            // 1. Atualiza o título e os names dos inputs/selects
            const indiceElement = item.querySelector('.produto-indice');
            if (indiceElement) {
                indiceElement.textContent = `Produto ${index}`;
            }
            
            item.querySelectorAll('input, select').forEach(el => {
                const name = el.getAttribute('name');
                if (name) {
                    // Usa o índice de array (index - 1)
                    el.setAttribute('name', name.replace(/\[\d+\]/, `[${index - 1}]`)); 
                }
            });
            
            // 2. AJUSTE CRÍTICO: Re-inicialização do Tom Select
            const select = item.querySelector('.produto-select');
            
            // Destrói a instância Tom Select existente
            if (select && select.tomselect) {
                 select.tomselect.destroy();
            }
            
            // Re-inicializa o Tom Select no elemento
            inicializarBusca(select);
            
            index++;
        });
        
        // Atualiza o contador para o próximo item
        contador = index; 
        atualizarTotais(); 
    }

    document.addEventListener('DOMContentLoaded', function() {
        // Inicializa o primeiro campo de busca ao carregar a página
        document.querySelectorAll('.produto-select').forEach(inicializarBusca);
        atualizarTotais();
        // Garante que o contador inicial está correto
        contador = document.querySelectorAll('.produto-item').length + 1;
    });


    // Listener para adicionar produto
    document.getElementById('adicionar-produto').addEventListener('click', function() {
        const modelo = document.querySelector('.produto-item');
        
        // 1. Clonar o elemento modelo
        const novo = modelo.cloneNode(true);
        const lista = document.getElementById('produtos-lista');
        
        // 2. Limpar inputs
        novo.querySelector('.quantidade').value = '';
        novo.querySelector('.preco').value = '';
        novo.querySelector('.subtotal').value = '0,00';
        
        // 3. LIMPEZA CRÍTICA E RECONSTRUÇÃO DO SELECT
        const selectContainer = novo.querySelector('.col-md-4');

        // Destrói qualquer instância Tom Select ativa no clone (previne erros)
        const selectParaRemover = selectContainer.querySelector('.produto-select');
        if (selectParaRemover && selectParaRemover.tomselect) {
            selectParaRemover.tomselect.destroy();
        }

        // Remove todo o conteúdo, incluindo o wrapper do Tom Select
        selectContainer.innerHTML = ''; 

        // 4. Reconstruir o elemento <select> puro
        const newSelect = document.createElement('select');
        newSelect.setAttribute('name', `produtos[${contador}][produto_id]`);
        newSelect.setAttribute('class', 'form-select produto-select select-busca'); 
        newSelect.setAttribute('required', 'required');
        newSelect.innerHTML = '<option value="">Selecione ou busque um produto</option>';
        selectContainer.appendChild(newSelect);

        // 5. Adicionar o novo item à lista
        lista.appendChild(novo);

        // 6. Re-indexa a lista inteira, o que irá inicializar o Tom Select no novo item.
        reindexarProdutos(); 
    });

    // Listeners de cálculo de totais
    document.addEventListener('input', function(e) {
        if (
            e.target.classList.contains('quantidade') ||
            e.target.classList.contains('preco')
        ) {
            atualizarTotais(); 
        }
    });

    // Listener para remover produto
    document.addEventListener('click', function(e) {
        if (e.target.closest('.btn-remover')) {
            var item = e.target.closest('.produto-item');
            
            if (document.querySelectorAll('.produto-item').length > 1) {
                
                // 1. Destrói a instância do Tom Select do item que será removido
                const selectEl = item.querySelector('.produto-select');
                if (selectEl && selectEl.tomselect) {
                    selectEl.tomselect.destroy();
                }
                
                // 2. Remove o item
                item.remove();
                
                // 3. Reindexa os produtos restantes
                reindexarProdutos(); 
                
            } else {
                alert("É necessário ter pelo menos um produto na compra.");
            }
        }
    });
</script>
@endsection