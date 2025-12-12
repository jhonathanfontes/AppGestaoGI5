<?php

namespace App\Commands;

use CodeIgniter\CLI\BaseCommand;
use CodeIgniter\CLI\CLI;

class AssetsWatch extends BaseCommand
{
    protected $group = 'assets';
    protected $name = 'assets:watch';
    protected $description = 'Observa a pasta "development/assets" e compila os assets automaticamente.';

    public function run(array $params = [])
    {
        CLI::write('----------------------------------------------------------------', 'blue');
        CLI::write('O comando "assets:watch" não pode ser executado diretamente pelo servidor.', 'blue');
        CLI::write('----------------------------------------------------------------', 'blue');
        CLI::write('Esta funcionalidade requer um processo contínuo de observação de arquivos, o que não é suportado neste ambiente de execução.');
        CLI::write('');
        CLI::write('Para implementar o "watch mode", você pode usar ferramentas externas como:', 'yellow');
        CLI::write('');
        CLI::write('1. chokidar-cli (Node.js):', 'green');
        CLI::write('   Instale com: npm install -g chokidar-cli');
        CLI::write('   Use no terminal: chokidar "app/development/assets/**/*.css" "app/development/assets/**/*.js" -c "php spark assets:build" --initial');
        CLI::write('');
        CLI::write('2. entr (Linux/macOS):', 'green');
        CLI::write('   Instale com: sudo apt-get install entr (ou brew install entr)');
        CLI::write('   Use no terminal: ls app/development/assets/**/* | entr -c php spark assets:build');
        CLI::write('');
        CLI::write('Essas ferramentas irão monitorar as alterações nos seus arquivos de desenvolvimento e executar o comando "php spark assets:build" automaticamente.');
    }
}
