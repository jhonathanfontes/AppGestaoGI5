<?php

namespace App\Commands;

use CodeIgniter\CLI\BaseCommand;
use CodeIgniter\CLI\CLI;

class AssetsBuild extends BaseCommand
{
    protected $group = 'assets';
    protected $name = 'assets:build';
    protected $description = 'Gera app.min.css e app.min.js (bundle global) a partir de development/assets. Use --esbuild para usar esbuild.';
    protected $options = [
        '--esbuild' => 'Usa esbuild para minificar e agrupar os assets.',
    ];

    public function run(array $params = [])
    {
        if (CLI::getOption('esbuild')) {
            if (!$this->isEsbuildAvailable()) {
                CLI::error('esbuild não foi encontrado. Instale-o globalmente com "npm install -g esbuild" e tente novamente.');
                return;
            }
            $this->buildWithEsbuild();
        } else {
            $this->buildWithPhp();
        }

        CLI::write("Build de assets concluído.", 'green');
    }

    private function isEsbuildAvailable(): bool
    {
        exec('esbuild --version', $output, $returnCode);
        return $returnCode === 0;
    }

    private function buildWithEsbuild()
    {
        CLI::write('Construindo assets com esbuild...', 'yellow');
        $development = FCPATH . 'development/assets/';
        $public = FCPATH . 'assets/';

        // Global CSS
        $cssSrc = $development . 'css/';
        $cssDist = $public . 'css/';
        if (!is_dir($cssDist)) mkdir($cssDist, 0775, true);
        if (is_dir($cssSrc)) {
            $files = glob($cssSrc . '*.css');
            $nonCritical = array_filter($files, fn($f) => !str_contains($f, 'critical.css'));
            $critical = array_filter($files, fn($f) => str_contains($f, 'critical.css'));
            
            $this->runEsbuild($nonCritical, $cssDist . 'app.min.css');
            if($critical) $this->runEsbuild($critical, $cssDist . 'critical.min.css');
        }

        // Global JS
        $jsSrc = $development . 'js/';
        $jsDist = $public . 'js/';
        if (!is_dir($jsDist)) mkdir($jsDist, 0775, true);
        if (is_dir($jsSrc)) {
            $this->runEsbuild(glob($jsSrc . '*.js'), $jsDist . 'app.min.js');
        }
        
        // Module and Company assets
        $entityDirs = glob($development . '*', GLOB_ONLYDIR);
        foreach ($entityDirs as $entityDir) {
            $entityName = basename($entityDir);
            if($entityName === 'css' || $entityName === 'js') continue;

            // CSS
            $cssSrc = $entityDir . '/css/';
            $cssDist = $public . $entityName . '/css/';
            if (!is_dir($cssDist)) mkdir($cssDist, 0775, true);
            if (is_dir($cssSrc)) {
                $files = glob($cssSrc . '*.css');
                $nonCritical = array_filter($files, fn($f) => !str_contains($f, 'critical.css'));
                $critical = array_filter($files, fn($f) => str_contains($f, 'critical.css'));

                // For modules
                $this->runEsbuild($nonCritical, $cssDist . $entityName . '.min.css');
                // For company themes
                $this->runEsbuild($nonCritical, $cssDist . 'theme.min.css');
                // For critical
                if($critical) $this->runEsbuild($critical, $cssDist . 'critical.min.css');
            }

            // JS
            $jsSrc = $entityDir . '/js/';
            $jsDist = $public . $entityName . '/js/';
            if (!is_dir($jsDist)) mkdir($jsDist, 0775, true);
            if (is_dir($jsSrc)) {
                $this->runEsbuild(glob($jsSrc . '*.js'), $jsDist . $entityName . '.min.js');
            }
        }
    }

    private function runEsbuild(array $entryPoints, string $outfile)
    {
        if (empty($entryPoints)) return;
        $command = sprintf(
            'esbuild %s --bundle --minify --sourcemap --outfile=%s',
            implode(' ', array_map('escapeshellarg', $entryPoints)),
            escapeshellarg($outfile)
        );

        exec($command, $output, $returnCode);

        if ($returnCode === 0) {
            CLI::write("ESBUILD -> {$outfile}", 'green');
        } else {
            CLI::error("Falha ao compilar {$outfile} com esbuild.");
            CLI::error(implode("\n", $output));
        }
    }

    private function buildWithPhp()
    {
        $development = FCPATH . 'development/assets/';
        $public      = FCPATH . 'assets/';

        // -----------------------------
        // CSS GLOBAL
        // -----------------------------
        $cssSrc = $development . 'css/';
        $cssDist = $public . 'css/';
        if (!is_dir($cssDist)) mkdir($cssDist, 0775, true);

        $bundleCss = '';

        if (is_dir($cssSrc)) {
            $files = glob($cssSrc . '*.css');

            foreach ($files as $file) {
                $content = file_get_contents($file);
                $min     = $this->minifyCss($content);
                $bundleCss .= $min;
            }

            file_put_contents($cssDist . 'app.min.css', $bundleCss);
            CLI::write("CSS -> {$cssDist}app.min.css", 'green');
        }

        // -----------------------------
        // JS GLOBAL
        // -----------------------------
        $jsSrc = $development . 'js/';
        $jsDist = $public . 'js/';
        if (!is_dir($jsDist)) mkdir($jsDist, 0775, true);

        $bundleJs = '';

        if (is_dir($jsSrc)) {
            $files = glob($jsSrc . '*.js');

            foreach ($files as $file) {
                $content = file_get_contents($file);
                $min     = $this->minifyJs($content);
                $bundleJs .= $min . ";";
            }

            file_put_contents($jsDist . 'app.min.js', $bundleJs);
            CLI::write("JS  -> {$jsDist}app.min.js", 'green');
        }
    }

    private function minifyCss(string $content): string
    {
        $min = preg_replace('!/\*.*?\*/!s', '', $content);
        $min = preg_replace('/\s+/', ' ', $min);
        return trim(str_replace(["\r", "\n", "\t"], '', $min));
    }

    private function minifyJs(string $content): string
    {
        $min = preg_replace('#/\*.*?\*/#s', '', $content);
        $min = preg_replace('#//.*#', '', $min);
        $min = preg_replace('/\s+/', ' ', $min);
        return trim(str_replace(["\r", "\n", "\t"], '', $min));
    }
}
