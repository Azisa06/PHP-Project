<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Eletrônica Schock</title>
    <link rel="icon" href="{{ asset('img/logoshock.png') }}" type="image/png">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-icons/1.11.3/font/bootstrap-icons.min.css" rel="stylesheet">
    <link href="{{ asset('/css/welcome.css') }}" rel="stylesheet">
</head>
<body data-bs-spy="scroll" data-bs-target="#navbar" data-bs-offset="70" tabindex="0">

    <!-- NAVBAR -->
    <nav id="navbar" class="navbar navbar-expand-lg navbar-dark shadow-sm fixed-top bg-dark">
        <div class="container">
            <a class="navbar-brand d-flex align-items-center gap-2" href="#">
                <span>Eletrônica Schock</span>
            </a>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarNav">
                <ul class="navbar-nav me-auto mb-2 mb-lg-0">
                    <li class="nav-item"><a class="nav-link" href="#quem-somos">Quem Somos</a></li>
                    <li class="nav-item"><a class="nav-link" href="#servicos">Serviços</a></li>
                    <li class="nav-item"><a class="nav-link" href="#contato">Contato</a></li>
                </ul>
                <a href="{{ route('login') }}" class="btn btn-outline-light me-2 shadow-sm">Acessar o Sistema</a>
                <a href="https://wa.me/5518981986794" target="_blank" class="btn btn-success shadow-sm"><i class="bi bi-whatsapp"></i> Contato</a>
            </div>
        </div>
    </nav>

    <!-- BANNER -->
    <header class="banner d-flex align-items-center justify-content-center">
        <div class="banner-content text-center">
            <h1 class="display-5 fw-bold mb-3">Eletrônica Schock</h1>
            <p class="lead mb-4">Especialistas em vendas e consertos de eletrônicos desde 1978</p>
            <a href="#servicos" class="btn btn-success btn-lg shadow">Conheça nossos serviços</a>
        </div>
    </header>

    <!-- QUEM SOMOS -->
    <section id="quem-somos" class="container py-5">
        <div class="row justify-content-center">
            <div class="col-md-8 text-center">
                <h2 class="section-title"><i class="bi bi-people-fill"></i> Quem Somos</h2>
                <p class="fs-5 quem-somos-justificado">
                    Fundada em Junho de 1978, a Eletrônica Schock atua há mais de 40 anos no mercado de eletrônicos em Presidente Epitácio – SP. Trabalhamos com o comércio de eletrodomésticos, equipamentos de áudio e vídeo, além de oferecer assistência técnica especializada em consertos de televisores, rádios, micro-ondas e outros aparelhos eletrônicos.
                </p>
                <p class="fs-5 quem-somos-justificado">
                    Nosso compromisso sempre foi oferecer um atendimento transparente, ágil e de confiança. Prezamos pela qualidade dos produtos e serviços, buscando constantemente soluções que facilitem o dia a dia dos nossos clientes. A Eletrônica Schock é feita de tradição, responsabilidade e dedicação. Seguimos firmes com a missão de atender com excelência, sempre com foco no cliente.
                </p>
            </div>
        </div>
    </section>

    <!-- SERVIÇOS -->
    <section id="servicos" class="bg-light py-5">
        <div class="container">
            <h2 class="section-title text-center mb-5"><i class="bi bi-tools"></i> Nossos Serviços</h2>
            <div class="row g-4">
                <div class="col-md-3">
                    <div class="card h-100 shadow-sm service-card text-center">
                        <div class="card-body">
                            <i class="bi bi-cart4 fs-1 text-success"></i>
                            <h5 class="card-title mt-3">Venda de Eletrônicos</h5>
                            <p class="card-text">Eletrônicos e acessórios de qualidade das melhores marcas</p>
                        </div>
                    </div>
                </div>
                <div class="col-md-3">
                    <div class="card h-100 shadow-sm service-card text-center">
                        <div class="card-body">
                            <i class="bi bi-tv fs-1 text-success"></i>
                            <h5 class="card-title mt-3">Conserto de Aparelhos</h5>
                            <p class="card-text">Reparo de TVs, micro-ondas, rádios e outros eletrônicos</p>
                        </div>
                    </div>
                </div>
                <div class="col-md-3">
                    <div class="card h-100 shadow-sm service-card text-center">
                        <div class="card-body">
                            <i class="bi bi-clipboard-check fs-1 text-success"></i>
                            <h5 class="card-title mt-3">Orçamentos Rápidos</h5>
                            <p class="card-text">Aprovação de orçamentos online ou presencial com mais praticidade</p>
                        </div>
                    </div>
                </div>
                <div class="col-md-3">
                    <div class="card h-100 shadow-sm service-card text-center">
                        <div class="card-body">
                            <i class="bi bi-truck fs-1 text-success"></i>
                            <h5 class="card-title mt-3">Entrega de Produtos</h5>
                            <p class="card-text">Serviço de entrega com excelência e rápidez</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- CONTATO -->
    <section id="contato" class="bg-light py-5">
        <div class="container">
            <div class="row justify-content-center align-items-center">
                <div class="col-lg-5 mb-4 mb-lg-0">
                    <h2 class="section-title"><i class="bi bi-envelope-fill"></i> Fale Conosco</h2>
                    <ul class="list-unstyled fs-5">
                        <li><i class="bi bi-geo-alt-fill text-dark"></i> Rua Fortaleza, 924/928 - Centro - Presidente Epitácio - SP</li>
                        <li><i class="bi bi-telephone-fill text-dark"></i> (18) 98198-6794</li>
                        <li><i class="bi bi-envelope-at-fill text-dark"></i> <a href="mailto:contato.eletronicashock@gmail.com">contato.eletronicashock@gmail.com</a></li>
                    </ul>
                    <a href="https://wa.me/5518981986794" target="_blank" class="btn btn-success mt-2 shadow">
                        <i class="bi bi-whatsapp"></i> WhatsApp
                    </a>
                </div>
                <div class="col-lg-7">
                    <div class="ratio ratio-16x9 rounded-4 shadow overflow-hidden">
                        <iframe 
                            src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d3706.6151623569934!2d-52.1151863!3d-21.771736699999997!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x9493f24dbf14ec0b%3A0x916348508c69e4a2!2sR.%20Fortaleza%2C%20924%20-%20Centro%2C%20Pres.%20Epit%C3%A1cio%20-%20SP%2C%2019470-000!5e0!3m2!1spt-BR!2sbr!4v1716748467450!5m2!1spt-BR!2sbr" 
                            style="border:0;" allowfullscreen="" loading="lazy" 
                            referrerpolicy="no-referrer-when-downgrade">
                        </iframe>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- RODAPÉ -->
    <footer class="footer-dark text-center py-4">
        <div class="container">
            <small class="text-light">© 2025 Eletrônica Schock - Todos os direitos reservados.</small>
        </div>
    </footer>

    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.6/dist/umd/popper.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.min.js"></script>
</body>
</html>