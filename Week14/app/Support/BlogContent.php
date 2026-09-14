<?php

namespace App\Support;

use Illuminate\Support\Facades\File;
use Illuminate\Validation\ValidationException;

class BlogContent
{
    public static function storeImages(string $content): string
    {
        $document = new \DOMDocument();
        $previous = libxml_use_internal_errors(true);
        try {
            $document->loadHTML('<?xml encoding="UTF-8"><html><body>'.$content.'</body></html>', LIBXML_NONET | LIBXML_PARSEHUGE);
        } finally {
            libxml_clear_errors();
            libxml_use_internal_errors($previous);
        }
        foreach ($document->getElementsByTagName('img') as $img) {
            $src = $img->getAttribute('src');
            if (!str_starts_with(strtolower($src), 'data:')) continue;
            $parts = explode(',', $src, 2);
            if (count($parts) !== 2 || !in_array(strtolower($parts[0]), ['data:image/jpeg;base64', 'data:image/png;base64', 'data:image/gif;base64', 'data:image/webp;base64'], true)) {
                throw ValidationException::withMessages(['content' => 'รองรับรูป JPG, PNG, GIF และ WebP เท่านั้น']);
            }
            $bytes = base64_decode($parts[1], true);
            $info = $bytes === false ? false : @getimagesizefromstring($bytes);
            $types = ['image/jpeg' => 'jpg', 'image/png' => 'png', 'image/gif' => 'gif', 'image/webp' => 'webp'];
            if (!$info || !isset($types[$info['mime']])) {
                throw ValidationException::withMessages(['content' => 'ไฟล์รูปภาพไม่ถูกต้อง กรุณาเลือกรูปใหม่']);
            }
            $name = hash('sha256', $bytes).'.'.$types[$info['mime']];
            $directory = public_path('uploads/blogs');
            File::ensureDirectoryExists($directory);
            if (!File::exists($directory.'/'.$name)) {
                File::put($directory.'/'.$name, $bytes);
            }

            $img->setAttribute('src', asset('uploads/blogs/'.$name));
        }
        $content = '';
        foreach ($document->getElementsByTagName('body')->item(0)->childNodes as $node) {
            $content .= $document->saveHTML($node);
        }

        if (strlen($content) > 900000) {
            throw ValidationException::withMessages(['content' => 'เนื้อหาบทความยาวเกินไป กรุณาลดข้อความหรือแบ่งเป็นหลายบทความ']);
        }

        return $content;
    }
}
