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
            <input type="date" name="data" class="form-control" value="{{ old('data', date('Y-m-d')) }}" required>
          </div>

          <h5 class="mt-4">Produtos para Venda</h5>
          <div id="produtos-lista">
            <div class="produto-item row g-2 mb-3 border p-2 rounded">
              <div class="col-md-4">
                <label class="form-label">Produto</label>
                <select name="produtos[0][produto_id]" class="form-select produto-select" required>
                  <option value="">Selecione um produto</option>
                  @foreach($produtos as $p)
                    <option 
                      value="{{ $p->id }}" 
                      data-estoque="{{ $p->quantidade_estoque }}"
                      data-preco-venda="{{ number_format($p->preco_venda, 2, ',', '.') }}"
                      {{ old('produtos.0.produto_id') == $p->id ? 'selected' : '' }}
                    >
                      {{ $p->nome }} (Estoque: {{ $p->quantidade_estoque }})
                    </option>
                  @endforeach
                </select>
                <small class="text-info estoque-info"></small>
              </div>
              <div class="col-md-2">
                <label class="form-label">Qtd</label>
                <input type="number" name="produtos[0][quantidade]" class="form-control quantidade" min="1" placeholder="Qtd" required value="{{ old('produtos.0.quantidade') }}">
              </div>
              <div class="col-md-3">
                <label class="form-label">Preço de Venda</label>
                <input type="text" name="produtos[0][preco_venda]" class="form-control preco" placeholder="Preço de Venda" required value="{{ old('produtos.0.preco_venda') }}">
              </div>
              <div class="col-md-2">
                <label class="form-label">Subtotal</label>
                <input type="text" class="form-control subtotal" placeholder="Subtotal" readonly>
              </div>
              <div class="col-md-1 d-flex align-items-end">
                <button type="button" class="btn btn-danger btn-remover w-100">
                  <i class="bi bi-trash"></i>
                </button>
              </div>
            </div>
          </div>

          <button type="button" id="adicionar-produto" class="btn btn-secondary mt-2">
            <i class="bi bi-plus-circle"></i> Adicionar Produto
          </button>

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

<script>
  let contador = 1;

  function formatarReal(valor) {
    return valor.toFixed(2).replace('.', ',');
  }

  function atualizarTotais(item) {
    const precoInput = item.querySelector('.preco');
    const qtdInput = item.querySelector('.quantidade');
    const subtotalInput = item.querySelector('.subtotal');
    const select = item.querySelector('.produto-select');
    const selectedOption = select.options[select.selectedIndex];
    const estoqueInfo = item.querySelector('.estoque-info');

    const preco = parseFloat(precoInput.value.replace(/[^\d,]/g, '').replace(',', '.')) || 0;
    const qtd = parseInt(qtdInput.value) || 0;
    const estoque = parseInt(selectedOption?.getAttribute('data-estoque')) || 0;
    
    const subtotal = preco * qtd;

    // Validação de estoque no Frontend (preventiva)
    if (qtd > estoque && estoque > 0) {
      qtdInput.classList.add('is-invalid');
      estoqueInfo.textContent = `Atenção: A quantidade excede o estoque (${estoque}).`;
      estoqueInfo.classList.remove('text-info');
      estoqueInfo.classList.add('text-danger');
    } else {
      qtdInput.classList.remove('is-invalid');
      if (selectedOption.value) {
        estoqueInfo.textContent = `Em estoque: ${estoque}`;
        estoqueInfo.classList.add('text-info');
        estoqueInfo.classList.remove('text-danger');
      } else {
        estoqueInfo.textContent = '';
      }
    }

    if (!isNaN(subtotal)) {
      subtotalInput.value = formatarReal(subtotal);
    } else {
      subtotalInput.value = '0,00';
    }

    // Calcula o total geral
    let totalGeral = 0;
    document.querySelectorAll('.produto-item').forEach(i => {
      const subtotalValue = parseFloat(i.querySelector('.subtotal').value.replace(/[^\d,]/g, '').replace(',', '.')) || 0;
      totalGeral += subtotalValue;
    });
    document.getElementById('total').innerText = formatarReal(totalGeral);
  }

  function inicializarListeners(item) {
    const select = item.querySelector('.produto-select');
    const qtdInput = item.querySelector('.quantidade');
    const precoInput = item.querySelector('.preco');

    select.addEventListener('change', function() {
      const selectedOption = this.options[this.selectedIndex];
      const precoVenda = selectedOption.getAttribute('data-preco-venda') || '';
      
      // Preenche o preço de venda e atualiza o info de estoque
      precoInput.value = precoVenda;
      
      atualizarTotais(item);
    });

    item.querySelector('.btn-remover').addEventListener('click', function() {
      if (document.querySelectorAll('.produto-item').length > 1) {
        item.remove();
        // Recalcula o total geral após remover
        if (document.querySelectorAll('.produto-item').length > 0) {
            atualizarTotais(document.querySelector('.produto-item')); // Atualiza com base em qualquer item restante
        } else {
             document.getElementById('total').innerText = '0,00';
        }
      }
    });

    qtdInput.addEventListener('input', () => atualizarTotais(item));
    precoInput.addEventListener('input', () => atualizarTotais(item));
    
    // Inicializa valores e totais para o item
    atualizarTotais(item);
  }
 

  document.getElementById('adicionar-produto').addEventListener('click', function() {
    const modelo = document.querySelector('.produto-item');
    const novo = modelo.cloneNode(true);
    const lista = document.getElementById('produtos-lista');

    // Limpa valores e classes de feedback
    novo.querySelectorAll('input').forEach(input => input.value = '');
    novo.querySelectorAll('select').forEach(select => select.selectedIndex = 0);
    novo.querySelector('.estoque-info').textContent = '';
    novo.querySelector('.estoque-info').classList.remove('text-danger', 'text-info');
    novo.querySelector('.quantidade').classList.remove('is-invalid');


    novo.querySelectorAll('select, input').forEach(el => {
      const name = el.getAttribute('name');
      if (name) {
        el.setAttribute('name', name.replace(/\[\d+\]/, `[${contador}]`));
      }
    });

    lista.appendChild(novo);
    inicializarListeners(novo); 
    contador++;
  });

  // Inicializa listeners para os itens existentes (se houver old() data ou o item inicial)
  document.querySelectorAll('.produto-item').forEach(inicializarListeners);
  
</script>
@endsection