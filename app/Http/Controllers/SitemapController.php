<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Artisan;

class SitemapController extends Controller
{
    public function index()
    {
        $sitemapPath = public_path('sitemap.xml');
        $exists = File::exists($sitemapPath);
        $fileSize = $exists ? $this->formatBytes(File::size($sitemapPath)) : 'N/A';
        $lastGenerated = $exists ? date('d/m/Y H:i', File::lastModified($sitemapPath)) : null;

        $totalUrls = 0;
        if ($exists) {
            $content = File::get($sitemapPath);
            $totalUrls = substr_count($content, '<url>');
        }

        return view('sitemap.index', compact('exists', 'fileSize', 'lastGenerated', 'totalUrls'));
    }

    public function generate()
    {
        try {
            Artisan::call('sitemap:generate');
            return back()->with('success', 'Sitemap đã được tạo thành công!');
        } catch (\Exception $e) {
            return back()->with('error', 'Lỗi khi tạo sitemap: ' . $e->getMessage());
        }
    }

    public function download()
    {
        $sitemapPath = public_path('sitemap.xml');

        if (!File::exists($sitemapPath)) {
            return back()->with('error', 'File sitemap.xml không tồn tại!');
        }

        return response()->download($sitemapPath);
    }

    public function view()
    {
        return response()
            ->view('sitemap')
            ->header('Content-Type', 'application/xml');
    }

    private function formatBytes($size, $precision = 2)
    {
        $units = array('B', 'KB', 'MB', 'GB');

        for ($i = 0; $size > 1024 && $i < count($units) - 1; $i++) {
            $size /= 1024;
        }

        return round($size, $precision) . ' ' . $units[$i];
    }
}