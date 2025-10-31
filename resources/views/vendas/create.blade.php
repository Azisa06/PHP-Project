@extends('layout')

@section('principal')
<div class="row justify-content-center mt-5">
    <div class="col-md-10">
        <div class="card shadow">
            <div class="card-body">
                <h1 class="card-title text-center mb-4">
                    <i class="bi bi-cart-dash"></i> Registrar Venda
                </h1>

                <form method="POST" action="/vendas">
                    @csrf

                    <div class="mb-3">
                        <label for="data" class="form-label">Data da Venda</label>
                        <input type="date" name="data" class="form-control" required>
                    </div>

                    <h5 class="mt-4">Produtos para Venda</h5>
                    <div id="produtos-lista">
                        <div class="produto-item row g-2 mb-2 d-flex align-items-start"> 
                            
                            <div class="col-md-4">
                                <label class="form-label visually-hidden">Produto</label>
                                <select name="produtos[0][produto_id]" class="form-select produto-select select-busca" required> 
                                    <option value="">Selecione ou busque um produto</option>
                                </select>
                            </div>

                            <div class="col-6 col-md-2">
                                <input type="number" name="produtos[0][quantidade]" class="form-control quantidade" 
                                       min="1" required value="{{ old('produtos.0.quantidade') }}" placeholder="Quantidade">
                            </div>

                            <div class="col-6 col-md-3">
                                <input type="text" name="produtos[0][preco_venda]" class="form-control preco" 
                                       required value="{{ old('produtos.0.preco_venda') }}" placeholder="Preço Unitário">
                            </div>

                            <div class="col-6 col-md-1">
                                <input type="text" class="form-control subtotal text-end" readonly placeholder="Subtotal">
                            </div>

                            <div class="col-6 col-md-1 d-flex justify-content-center"> 
                                <button type="button" class="btn btn-danger btn-remover" title="Remover item">
                                    <i class="bi bi-trash"></i>
                                </button>
                            </div>
                        </div>
                    </div>

                    <div class="d-flex justify-content-start">
                        <button type="button" id="adicionar-produto" class="btn btn-secondary mt-2">
                            <i class="bi bi-plus-circle"></i> Adicionar Produto
                        </button>
                    </div>

                    <div class="mt-4 text-end">
                        <h5>Total da Venda: R$ <span id="total">0,00</span></h5>
                    </div>

                    <div class="d-flex justify-content-center mt-4">
                        <button type="submit" class="btn btn-primary me-2">
                            <i class="bi bi-check-circle"></i> Cadastrar Venda
                        </button>
                        <a href="{{ route('vendas.index') }}" class="btn btn-danger">
                            <i class="bi bi-x-circle"></i> Cancelar
                        </a>
                    </div>

                    @if (session('sucesso'))
                        <div class="alert alert-success mt-3">
                            <p class="mensagem-sucesso mb-0">{{ session('sucesso') }}</p>
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
/* Seu CSS original (Mantenha-o) */
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

    function formatarReal(valor) {
        return valor.toFixed(2).replace('.', ',');
    }

    function parseNumberBr(text) {
        if (!text && text !== 0) return 0;
        const s = String(text);
        const cleaned = s.replace(/[^\d.,-]/g, '').replace(/\.(?=\d{3})/g, '');
        const normalized = cleaned.replace(',', '.');
        const n = parseFloat(normalized);
        return isFinite(n) ? n : 0;
    }

    function atualizarTotais(item) {
        let itemDiv = item || document.querySelector('.produto-item');
        if (!itemDiv) return;

        const precoInput = itemDiv.querySelector('.preco');
        const qtdInput = itemDiv.querySelector('.quantidade');
        const subtotalInput = itemDiv.querySelector('.subtotal');

        const preco = parseNumberBr(precoInput?.value || '0');
        const qtd = parseInt(qtdInput?.value) || 0;
        const subtotal = preco * qtd;

        if (subtotalInput) {
            subtotalInput.value = formatarReal(isNaN(subtotal) ? 0 : subtotal);
        }

        let totalGeral = 0;
        document.querySelectorAll('.produto-item').forEach(i => {
            const subEl = i.querySelector('.subtotal');
            const subtotalValue = parseNumberBr(subEl?.value || '0');
            totalGeral += subtotalValue;
        });
        document.getElementById('total').innerText = formatarReal(totalGeral);
    }

    // Função para inicializar o campo de busca (Tom Select)
    function inicializarBusca(elemento) {
        if (elemento.tomselect) {
            elemento.tomselect.destroy();
        }

        const ts = new TomSelect(elemento, {
            valueField: 'id',
            labelField: 'text',
            searchField: 'text',
            placeholder: 'Selecione ou busque um produto...',
            preload: true, 
            load: function(query, callback) {
                if (!query.length) {
                    query = '';
                }
                
                const url = '{{ route("api.vendas.produtos.search") }}?q=' + encodeURIComponent(query);

                fetch(url)
                    .then(response => response.json())
                    .then(data => {
                        if(data.results) {
                            // CORREÇÃO: Mapeia o resultado para exibir o ESTOQUE no dropdown
                            const formattedResults = data.results.map(item => {
                                // Assume que a chave de estoque é 'quantidade_estoque' (como no seu código antigo)
                                const estoque = item.quantidade_estoque || 0; 

                                return {
                                    id: item.id,
                                    // Concatena o nome do produto (item.text) com o estoque
                                    text: `${item.text} (Estoque: ${estoque})`, 
                                    preco_venda: item.preco_venda, 
                                    // Mantém outras chaves importantes
                                };
                            });
                            callback(formattedResults);
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

        // Evento para preencher o preço de venda quando um item é selecionado
        ts.on('change', function(value) {
            const itemDiv = elemento.closest('.produto-item');
            const precoInput = itemDiv.querySelector('.preco');
            
            const selectedData = ts.options[value];
            
            if (selectedData && precoInput) {
                // Preenche o input de preço com o valor do item selecionado (automaticamente)
                precoInput.value = formatarReal(selectedData.preco_venda || 0); 
            } else if (precoInput) {
                precoInput.value = '0,00';
            }
            
            atualizarTotais(itemDiv);
        });
    }


    document.addEventListener('DOMContentLoaded', function() {
        document.querySelectorAll('.produto-select').forEach(inicializarBusca);
        atualizarTotais();
    });


    document.getElementById('adicionar-produto').addEventListener('click', function() {
        const modelo = document.querySelector('.produto-item');
        const novo = modelo.cloneNode(true);

        // 2. Limpar inputs (quantidade, preço, subtotal)
        novo.querySelector('.quantidade').value = '';
        novo.querySelector('.preco').value = '';
        novo.querySelector('.subtotal').value = '0,00';
        
        // 3. RECONSTRUÇÃO DO SELECT: Limpar e Recriar o elemento <select>
        const selectContainer = novo.querySelector('.col-md-4');
        selectContainer.innerHTML = ''; 

        const newSelect = document.createElement('select');
        newSelect.setAttribute('name', `produtos[${contador}][produto_id]`);
        newSelect.setAttribute('class', 'form-select produto-select select-busca'); 
        newSelect.setAttribute('required', 'required');
        newSelect.innerHTML = '<option value="">Selecione ou busque um produto</option>';
        
        selectContainer.appendChild(newSelect);
        // FIM DA RECONSTRUÇÃO

        // 4. Renomeia os inputs para o novo índice
        novo.querySelectorAll('input, select').forEach(el => {
            const name = el.getAttribute('name');
                if (name) {
                    el.setAttribute('name', name.replace(/\[\d+\]/, `[${contador}]`));
                }
        });

        document.getElementById('produtos-lista').appendChild(novo);

        // 5. Inicializa o campo de busca com o novo elemento criado
        inicializarBusca(newSelect);

        contador++;
        atualizarTotais(novo); 
    });

    // Listener de input genérico para Qtd e Preço
    document.addEventListener('input', function(e) {
        if (
            e.target.classList.contains('quantidade') ||
            e.target.classList.contains('preco')
        ) {
            const itemDiv = e.target.closest('.produto-item');
            if (itemDiv) atualizarTotais(itemDiv);
        }
    });

    // Listener de click para remover item
    document.addEventListener('click', function(e) {
        if (e.target.closest('.btn-remover')) {
            var item = e.target.closest('.produto-item');
            
            if (document.querySelectorAll('.produto-item').length > 1) {
                item.remove();
                atualizarTotais(); 
            } else {
                // Limpar inputs e resetar o Tom Select
                const selectEl = item.querySelector('.produto-select');
                const ts = selectEl.tomselect;
                if (ts) {
                    ts.clear();
                }
                item.querySelector('.quantidade').value = '';
                item.querySelector('.preco').value = '';
                item.querySelector('.subtotal').value = '0,00';
                atualizarTotais(); 
            }
        }
    });
</script>
@endsection