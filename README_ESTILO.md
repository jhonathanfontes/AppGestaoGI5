# CI4 + Twig — Render System & Asset Versioning

Projeto base para CodeIgniter 4 integrado com Twig:
- Renderização multi-nível (ex: `modulo/home` → busca `modulo/home.html.twig` e `modulo/home/home.html.twig`)
- Carregamento automático de CSS/JS por nível
- Asset versioning automático via hash (gera `app.min.css?v=...` ou fallback)
- Cache Twig em `writable/cache/twig` (ativado em produção)
- Função Twig `asset()` para incluir assets corretamente (ENV dev/prod)

## Conteúdo entregue
- `app/Libraries/Twig/TwigFactory.php` — Singleton Twig, globals e cache
- `app/Libraries/Twig/TwigRenderer.php` — render multi-nível (HTML/CSS/JS)
- `app/Libraries/Twig/TwigFunctionLib.php` — funções Twig (inclui `asset()`)
- `app/Libraries/Twig/TwigExtensionLib.php` — filtros Twig
- `app/Libraries/Twig/AssetVersion.php` — resolve e versiona assets
- `app/Commands/TwigClearCache.php` — comando Spark para limpar cache twig
- `app/Commands/AssetsBuild.php` — comando Spark para gerar `.min.css`/`.min.js` simples
- Exemplo de templates em `app/Templates/` e assets em `public/assets/`

## Como usar
### Instalação
1. Copie os arquivos em `app/Libraries/Twig/` e `app/Commands/`.
2. Garanta `APPPATH . 'Templates'` com seus templates `.html.twig`.
3. Assets em `public/assets/css` e `public/assets/js`.

### Comandos úteis
- Limpar cache Twig:
```bash
php spark twig:clear
