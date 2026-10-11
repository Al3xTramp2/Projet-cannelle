<?php

namespace Supalta\Cannelle\utils;

use Exception;

/**
 * Compiles the views of app/view into cached PHP files and renders them
 */
class Renderer
{
    /**
     * @param string $file
     * @param array<string, mixed>|null $data
     * @return string|false
     */
    public static function render(string $file, array $data = null)
    {
        $path = __DIR__ . "/../view/" . $file . ".php";
        $pathCache = __DIR__ . "/../../storage/cache/";

        if (!file_exists($path)) {
            throw new Exception("'$file' n'existe pas dans le dossier view !");
        }
        $content = file_get_contents($path);

        $fingerprint = md5($content);
        $outputPath = $pathCache . $fingerprint . ".php";

        if (!file_exists($outputPath)) {
            $content = preg_replace('/{{\s*(.+?)\s*}}/', "<?php echo htmlspecialchars($1); ?>", $content);
            $content = preg_replace('/@foreach\s*\((.+)\)/', "<?php foreach ($1) { ?>", $content);
            $content = preg_replace('/@if\s*\((.+)\)/', "<?php if ($1) { ?>", $content);
            $content = str_replace('@else', "<?php } else { ?>", $content);
            $content = preg_replace('/@while\s*\((.+)\)/', "<?php while ($1) { ?>", $content);
            $content = preg_replace('/@end(foreach|if|while)/', "<?php } ?>", $content);
            file_put_contents($outputPath, $content);
        }

        ob_start();
        if ($data !== null) {
            extract($data);
        }

        include $outputPath;

        return ob_get_clean();
    }
}
