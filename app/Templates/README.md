Kit Premium de Componentes Twig <x-*>

Para CodeIgniter 4 + performing/twig-components

Este projeto oferece um conjunto completo de componentes Twig no estilo Laravel Blade, usando a sintaxe:

<x-button>
<x-card>
<x-input>
<x-modal>
<x-table>
<x-alert>
<x-badge>
<x-avatar>
<x-select>
<x-form>
<x-layout>


Todos os componentes suportam:

Slots (<x-slot name="footer">)

Props (atributos)

Atributos HTML dinâmicos (attributes.merge())

Variantes, tamanhos e estilos

Modo escuro global

Versionamento automático de assets

📁 Estrutura
app/Views/components/
    button.twig
    card.twig
    input.twig
    modal.twig
    alert.twig
    badge.twig
    avatar.twig
    select.twig
    table.twig
    form.twig
    layout.twig
    ...

🚀 Instalação
1. Instale o performing/twig-components:
composer require performing/twig-components

2. Configure o TwigFactory
use Performing\TwigComponents\Configuration;

Configuration::make($twig)
    ->setTemplatesPath('components')
    ->setTemplatesExtension('twig')
    ->useCustomTags()
    ->setup();

3. Limpe cache:
php spark twig:clear

🧩 Uso dos componentes
Botão
<x-button variant="primary" icon="bi bi-check">Salvar</x-button>

Card
<x-card title="Usuários">
    Lista de usuários...
    <x-slot name="footer">
        <x-button variant="success">Novo</x-button>
    </x-slot>
</x-card>

Tabela
<x-table :headers="['ID','Nome','Ação']" :rows="rows" />

Modal
<x-modal id="modal1" title="Confirmar ação">
    Tem certeza?
    <x-slot name="footer">
        <x-button variant="danger">Excluir</x-button>
    </x-slot>
</x-modal>

🎨 Modo Dark

O layout suporta modo escuro automático com toggle:

<x-button icon="bi bi-moon" onclick="toggleTheme()">Tema</x-button>

📦 Demo

Rota sugerida:

GET /demo → DemoController::index


Arquivo:

app/Views/demo.html.twig