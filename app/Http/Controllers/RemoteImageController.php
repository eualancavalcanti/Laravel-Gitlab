<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\File;
use Intervention\Image\Facades\Image;
use Spatie\ImageOptimizer\OptimizerChainFactory;

class RemoteImageController extends Controller
{
    public function show($filename)
    {
        // Decodificar o nome do arquivo que foi codificado na URL
        $filename = urldecode($filename);
        
        // Criar um hash MD5 do nome do arquivo para usar como nome de cache
        $cacheKey = md5($filename);
        $cachePath = storage_path('app/images-cache/' . $cacheKey);
        
        // Verificar se a imagem já está em cache
        if (File::exists($cachePath)) {
            // Retornar imagem do cache com headers apropriados
            return $this->serveImage($cachePath);
        }
        
        // Buscar imagem do servidor externo
        try {
            // Montar a URL remota (ajuste conforme seu domínio)
            $remoteUrl = "https://server2.hotboys.com.br/arquivos/" . $filename;
            
            // Fazer requisição com timeout
            $imageContent = Http::timeout(5)->get($remoteUrl)->body();
            
            // Se a busca falhou, usar imagem de fallback
            if (empty($imageContent)) {
                return $this->serveFallbackImage();
            }
            
            // Garantir que o diretório de cache existe
            if (!File::exists(dirname($cachePath))) {
                File::makeDirectory(dirname($cachePath), 0755, true);
            }
            
            // Salvar no cache
            File::put($cachePath, $imageContent);
            
            // Otimizar a imagem
            $this->optimizeImage($cachePath);
            
            // Servir a imagem otimizada
            return $this->serveImage($cachePath);
            
        } catch (\Exception $e) {
            // Em caso de erro, servir imagem de fallback
            return $this->serveFallbackImage();
        }
    }
    
    private function serveImage($path)
    {
        // Detectar tipo de imagem
        $mime = File::mimeType($path);
        
        // Definir cabeçalhos de cache
        $headers = [
            'Content-Type' => $mime,
            'Cache-Control' => 'public, max-age=2592000', // 30 dias
            'Expires' => gmdate('D, d M Y H:i:s', time() + 2592000) . ' GMT'
        ];
        
        // Verificar se o navegador suporta WebP
        if (request()->header('Accept') && strpos(request()->header('Accept'), 'image/webp') !== false) {
            // Converter para WebP se o navegador suportar
            $webpPath = $path . '.webp';
            
            if (!File::exists($webpPath)) {
                $this->convertToWebp($path, $webpPath);
            }
            
            if (File::exists($webpPath)) {
                return response()->file($webpPath, array_merge($headers, ['Content-Type' => 'image/webp']));
            }
        }
        
        // Retornar imagem original se WebP não estiver disponível
        return response()->file($path, $headers);
    }
    
    private function optimizeImage($path)
    {
        // Usar pacote Spatie para otimizar a imagem
        try {
            $optimizerChain = OptimizerChainFactory::create();
            $optimizerChain->optimize($path);
        } catch (\Exception $e) {
            // Silenciosamente falhar se a otimização não funcionar
        }
    }
    
    private function convertToWebp($source, $destination)
    {
        try {
            $image = Image::make($source);
            $image->encode('webp', 85)->save($destination);
        } catch (\Exception $e) {
            // Silenciosamente falhar se a conversão WebP não funcionar
        }
    }
    
    private function serveFallbackImage()
    {
        $fallbackPath = public_path('images/placeholder.jpg');
        
        if (!File::exists($fallbackPath)) {
            // Criar uma imagem placeholder se não existir
            $this->createFallbackImage($fallbackPath);
        }
        
        return response()->file($fallbackPath, [
            'Content-Type' => 'image/jpeg',
            'Cache-Control' => 'public, max-age=86400', // 1 dia
        ]);
    }
    
    private function createFallbackImage($path)
    {
        // Garantir que o diretório existe
        if (!File::exists(dirname($path))) {
            File::makeDirectory(dirname($path), 0755, true);
        }
        
        // Criar uma imagem simples como fallback
        $img = Image::canvas(320, 180, '#333333');
        $img->text('Imagem não disponível', 160, 90, function($font) {
            $font->file(public_path('fonts/arial.ttf'));
            $font->size(16);
            $font->color('#FFFFFF');
            $font->align('center');
            $font->valign('middle');
        });
        
        $img->save($path);
    }
}