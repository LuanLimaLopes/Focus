# FocusFOCUS/
├── .gitignore              ✅ Já existe
├── README.md               ✅ Já existe
├── index.php               ✅ Entry point
├── composer.json           ❌ FALTA - gerenciamento de dependências
│
├── config/                 ✅
│   ├── .gitkeep
│   ├── database.php        ❌ Configurações do banco
│   └── app.php             ❌ Configurações gerais
│
├── public/                 ✅ Pasta acessível via web
│   ├── index.php           ❌ Mover o index.php raiz para cá
│   ├── .htaccess           ❌ Reescrita de URLs
│   ├── assets/
│   │   ├── css/
│   │   │   └── style.css
│   │   ├── js/
│   │   │   └── app.js
│   │   └── images/
│
├── src/                    ✅ Lógica da aplicação
│   ├── Controllers/        ❌ Controlar requisições
│   │   └── TaskController.php
│   ├── Models/             ❌ Interação com banco
│   │   └── Task.php
│   ├── Views/              ❌ Templates HTML
│   │   ├── layouts/
│   │   │   └── main.php
│   │   └── tasks/
│   │       ├── index.php
│   │       └── form.php
│   ├── Database/           ❌ Conexão e migrations
│   │   └── Connection.php
│   └── Helpers/            ❌ Funções auxiliares
│       └── functions.php
│
├── storage/                ✅
│   ├── database/
│   │   └── tasks.db        ❌ SQLite database
│   └── logs/               ❌ Logs de erro
│       └── .gitkeep
│
├── scripts/                ✅ Scripts utilitários
│   └── setup.php           ❌ Script de instalação/migração
│
└── tests/                  ❌ CRIAR - Testes (opcional)
    └── TaskTest.php