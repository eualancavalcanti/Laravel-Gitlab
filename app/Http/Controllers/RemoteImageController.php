<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Intervention\Image\ImageManagerStatic as Image;
use Spatie\ImageOptimizer\OptimizerChainFactory;
use Illuminate\Support\Str;

class RemoteImageController extends Controller
{
    public function show(Request $request, $filename)
    {
        $base     = pathinfo($filename, PATHINFO_FILENAME);
        $ext      = Str::lower(pathinfo($filename, PATHINFO_EXTENSION));
        $cacheDir = storage_path('app/images-cache/');
        $remote   = "https://server2.hotboys.com.br/arquivos/{$filename}";

        // Define extensão de saída (WebP se suportado)
        $wantWebp   = str_contains($request->header('Accept'), 'image/webp');
        $outExt     = $wantWebp ? 'webp' : $ext;
        $cachePath  = "{$cacheDir}{$base}.{$outExt}";

        if (! file_exists($cachePath)) {
            if (! is_dir($cacheDir)) {
                mkdir($cacheDir, 0755, true);
            }
            // Carrega remoto, converte e salva
            $img = Image::make($remote);
            if ($wantWebp) {
                $img->encode('webp', 80);
            }
            $img->save($cachePath);
            // Otimiza (jpegoptim, pngquant…)
            OptimizerChainFactory::create()->optimize($cachePath);
        }

        return response()->file($cachePath, [
            'Content-Type'  => $wantWebp ? 'image/webp' : "image/{$ext}",
            'Cache-Control' => 'public, max-age=2592000, immutable',
        ]);
    }
}
