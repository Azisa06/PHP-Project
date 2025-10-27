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
            <div class="produto-item row g-2 mb-3 border p-2 rounded align-items-end">
              <div class="col-12 col-md-5">
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
              </div>

              <div class="col-6 col-md-2">
                <label class="form-label">Quantidade</label>
                <input type="number" name="produtos[0][quantidade]" class="form-control quantidade" min="1" required value="{{ old('produtos.0.quantidade') }}">
              </div>

              <div class="col-6 col-md-3">
                <label class="form-label">Preço Unitário</label>
                <input type="text" name="produtos[0][preco_venda]" class="form-control preco" required value="{{ old('produtos.0.preco_venda') }}">
              </div>

              <div class="col-6 col-md-1">
                <label class="form-label">Subtotal</label>
                <input type="text" class="form-control subtotal text-end" readonly>
              </div>

              <div class="col-6 col-md-1 d-flex align-items-center justify-content-center">
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

<script>
  let contador = 1;

  function formatarReal(valor) {
    return valor.toFixed(2).replace('.', ',');
  }

  function parseNumberBr(text) {
    // Recebe "1.234,56" ou "1234,56" ou "R$ 1.234,56" e retorna Number
    if (!text && text !== 0) return 0;
    const s = String(text);
    // remove tudo exceto dígitos e vírgula e ponto, depois remove pontos de milhar
    const cleaned = s.replace(/[^\d.,-]/g, '').replace(/\.(?=\d{3})/g, '');
    // agora substitui vírgula decimal por ponto
    const normalized = cleaned.replace(',', '.');
    const n = parseFloat(normalized);
    return isFinite(n) ? n : 0;
  }

  function atualizarTotais(item) {
    const precoInput = item.querySelector('.preco');
    const qtdInput = item.querySelector('.quantidade');
    const subtotalInput = item.querySelector('.subtotal');
    const select = item.querySelector('.produto-select');
    const selectedOption = select ? select.options[select.selectedIndex] : null;
    const estoqueInfo = item.querySelector('.estoque-info');

    if (!subtotalInput) return; // protege caso o elemento esteja ausente

    // Parse seguro do preço e quantidade
    const preco = parseNumberBr(precoInput?.value || '');
    const qtd = parseInt(qtdInput?.value) || 0;
    const estoque = parseInt(selectedOption?.getAttribute('data-estoque')) || 0;

    const subtotal = preco * qtd;

    // DEBUG (remova depois): ajuda a ver se valores chegam corretos
    // console.log('atualizarTotais -> preco:', preco, 'qtd:', qtd, 'subtotal:', subtotal);

    // Validação de estoque no Frontend (preventiva) — sem mensagem se estoqueInfo não existir
    if (qtd > estoque && estoque > 0) {
      qtdInput.classList.add('is-invalid');
      if (estoqueInfo) {
        estoqueInfo.textContent = `Atenção: A quantidade excede o estoque (${estoque}).`;
        estoqueInfo.classList.remove('text-info');
        estoqueInfo.classList.add('text-danger');
      }
    } else {
      qtdInput.classList.remove('is-invalid');
      if (estoqueInfo) {
        if (selectedOption && selectedOption.value) {
          estoqueInfo.textContent = `Em estoque: ${estoque}`;
          estoqueInfo.classList.add('text-info');
          estoqueInfo.classList.remove('text-danger');
        } else {
          estoqueInfo.textContent = '';
        }
      }
    }

    // atualiza o campo subtotal (formato "0,00")
    subtotalInput.value = formatarReal(isNaN(subtotal) ? 0 : subtotal);

    // Calcula o total geral
    let totalGeral = 0;
    document.querySelectorAll('.produto-item').forEach(i => {
      const subEl = i.querySelector('.subtotal');
      const subtotalValue = parseNumberBr(subEl?.value || '0');
      totalGeral += subtotalValue;
    });
    document.getElementById('total').innerText = formatarReal(totalGeral);
  }

  function inicializarListeners(item) {
    const select = item.querySelector('.produto-select');
    const qtdInput = item.querySelector('.quantidade');
    const precoInput = item.querySelector('.preco');

    if (select) {
      select.addEventListener('change', function() {
        const selectedOption = this.options[this.selectedIndex];
        const precoVenda = selectedOption ? selectedOption.getAttribute('data-preco-venda') || '' : '';
        // Preenche o preço de venda (formato "1.234,56" vindo do atributo)
        if (precoInput) precoInput.value = precoVenda;
        atualizarTotais(item);
      });
    }

    const btnRemover = item.querySelector('.btn-remover');
    if (btnRemover) {
      btnRemover.addEventListener('click', function() {
        if (document.querySelectorAll('.produto-item').length > 1) {
          item.remove();
          // Recalcula o total geral após remover
          const anyItem = document.querySelector('.produto-item');
          if (anyItem) {
            atualizarTotais(anyItem);
          } else {
            document.getElementById('total').innerText = '0,00';
          }
        }
      });
    }

    if (qtdInput) qtdInput.addEventListener('input', () => atualizarTotais(item));
    if (precoInput) precoInput.addEventListener('input', () => atualizarTotais(item));

    // Inicializa valores e totais para o item
    atualizarTotais(item);
  }

  document.getElementById('adicionar-produto').addEventListener('click', function() {
    const modelo = document.querySelector('.produto-item');
    const novo = modelo.cloneNode(true);
    const lista = document.getElementById('produtos-lista');

    // Limpa valores e classes de feedback
    novo.querySelectorAll('input').forEach(input => {
      if (input.classList.contains('subtotal')) {
        input.value = '0,00';
      } else {
        input.value = '';
      }
      input.classList.remove('is-invalid');
    });
    novo.querySelectorAll('select').forEach(select => select.selectedIndex = 0);

    const estoqueInfoEl = novo.querySelector('.estoque-info');
    if (estoqueInfoEl) {
      estoqueInfoEl.textContent = '';
      estoqueInfoEl.classList.remove('text-danger', 'text-info');
    }

    // Ajusta os nomes para o novo índice
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