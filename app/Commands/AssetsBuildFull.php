<?php

namespace App\Commands;

use CodeIgniter\CLI\BaseCommand;
use CodeIgniter\CLI\CLI;

class AssetsBuildFull extends BaseCommand
{
    protected $group = 'assets';
    protected $name  = 'assets:build-full';
    protected $description = 'Gera bundles globais e modulares.';

    public function run(array $params)
    {
        $devBase  = ROOTPATH . 'development/assets/';
        $prodBase = FCPATH . 'assets/';

        // --------------------
        // 1) BUNDLE GLOBAL
        // --------------------
        CLI::write("🔧 Gerando bundle GLOBAL...", 'yellow');

        $this->bundle($devBase . "css",  $prodBase . "css/app.min.css", "css");
        $this->bundle($devBase . "js",   $prodBase . "js/app.min.js",  "js");

        // --------------------
        // 2) BUNDLES MODULARES
        // --------------------
        CLI::write("🔧 Gerando bundles MODULARES...", 'yellow');

        foreach (glob($devBase . "*", GLOB_ONLYDIR) as $moduleDir) {

            $module = basename($moduleDir);

            if ($module === "css" || $module === "js") {
                continue; // já tratado como global
            }

            $this->bundle("$module/css",  "{$prodBase}{$module}/css/{$module}.min.css", "css", $devBase);
            $this->bundle("$module/js",   "{$prodBase}{$module}/js/{$module}.min.js",  "js",  $devBase);
        }

        CLI::write("✔ Build completo finalizado!", 'green');
    }

    private function bundle(string $devPath, string $output, string $type, string $base = "")
    {
        if ($base) $devPath = $base . $devPath;

        if (!is_dir($devPath)) return;

        $content = '';

        foreach (glob($devPath . "/*.{$type}") as $file) {
            $content .= "\n/* FILE: " . basename($file) . " */\n" . file_get_contents($file);
        }

        // minify
        if ($type === 'css') {
            $content = preg_replace('!/\*.*?\*/!s', '', $content);
        } else {
            $content = preg_replace('#/\*.*?\*/#s', '', $content);
            $content = preg_replace('#//.*#', '', $content);
        }

        $content = trim(preg_replace('/\s+/', ' ', $content));

        // garantir diretório de saída
        $dir = dirname($output);
        if (!is_dir($dir)) mkdir($dir, 0775, true);

        file_put_contents($output, $content);

        CLI::write("    → Criado: $output", 'green');
    }
}
