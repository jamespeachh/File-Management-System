<?php

namespace App\Services;

use DOMDocument;
use ZipArchive;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\DB;

class EPUBService
{
    private $epubPath;
    
    public function __construct()
    {
        $this->epubPath = storage_path('app/epub_books');
    }

    public function addNewBook($title, $author, $chapters, $coverImage = 'default.jpg')
    {
        // Create database entry for the book
        $book = new \App\Models\book();
        $book->title = $title;
        $book->formatted_title = $title;
        $book->pages = count($chapters);
        $book->cover_pic = $coverImage;
        $book->save();

        // Insert each chapter into book_body table
        foreach ($chapters as $index => $chapter) {
            DB::table('book_body')->insert([
                'book_id' => $book->id,
                'page_number' => $index + 1,
                'body_text' => $chapter
            ]);
        }

        // Clear the book list cache to ensure the new book appears in the directory
        \Illuminate\Support\Facades\Cache::forget('bookList');

        return [
            'id' => $book->id,
            'title' => $title,
            'author' => $author,
            'chapters' => count($chapters),
            'cover_image' => $coverImage
        ];
    }

    public function getBookContent($bookID, $pageNumber)
    {
        $cacheKey = "book_content_{$bookID}_page_{$pageNumber}";
        
        if (Cache::has($cacheKey)) {
            return Cache::get($cacheKey);
        }

        // Get the content directly from book_body table
        $content = DB::table('book_body')
            ->where('book_id', $bookID)
            ->where('page_number', $pageNumber)
            ->value('body_text');

        if (!$content) {
            throw new \Exception("Content not found for book ID {$bookID}, page {$pageNumber}");
        }

        // Cache the content
        Cache::put($cacheKey, $content, now()->addHours(24));
        
        return $content;
    }

    public function getBookMetadata($bookID)
    {
        $cacheKey = "book_metadata_{$bookID}";
        
        if (Cache::has($cacheKey)) {
            return Cache::get($cacheKey);
        }

        // Get the book metadata from the book table
        $book = \App\Models\book::find($bookID);
        if (!$book) {
            throw new \Exception("Book not found with ID: {$bookID}");
        }

        // Get the total number of pages from book_body
        $totalPages = DB::table('book_body')
            ->where('book_id', $bookID)
            ->count();

        $metadata = [
            'id' => $book->id,
            'title' => $book->formatted_title,
            'pages' => $totalPages
        ];

        Cache::put($cacheKey, $metadata, now()->addDays(7));
        
        return $metadata;
    }

    private function getContainerXml()
    {
        return '<?xml version="1.0" encoding="UTF-8"?>
<container version="1.0" xmlns="urn:oasis:names:tc:opendocument:xmlns:container">
    <rootfiles>
        <rootfile full-path="OEBPS/content.opf" media-type="application/oebps-package+xml"/>
    </rootfiles>
</container>';
    }

    private function getContentOpf($title, $author, $chapters)
    {
        $uuid = 'urn:uuid:' . Str::uuid();
        $manifestItems = [];
        $spineItems = [];

        // Generate manifest and spine items for each chapter
        foreach ($chapters as $index => $chapter) {
            $chapterId = "chapter_" . ($index + 1);
            $chapterFilename = sprintf('chapter_%03d.xhtml', $index + 1);
            
            $manifestItems[] = sprintf(
                '<item id="%s" href="%s" media-type="application/xhtml+xml"/>',
                $chapterId,
                $chapterFilename
            );
            
            $spineItems[] = sprintf('<itemref idref="%s"/>', $chapterId);
        }

        return '<?xml version="1.0" encoding="UTF-8"?>
<package xmlns="http://www.idpf.org/2007/opf" version="3.0" unique-identifier="uuid_id">
    <metadata xmlns:dc="http://purl.org/dc/elements/1.1/">
        <dc:identifier id="uuid_id">' . $uuid . '</dc:identifier>
        <dc:title>' . htmlspecialchars($title) . '</dc:title>
        <dc:creator>' . htmlspecialchars($author) . '</dc:creator>
        <dc:language>en</dc:language>
        <meta property="dcterms:modified">' . now()->format('Y-m-d\TH:i:s\Z') . '</meta>
    </metadata>
    <manifest>
        ' . implode("\n        ", $manifestItems) . '
    </manifest>
    <spine>
        ' . implode("\n        ", $spineItems) . '
    </spine>
</package>';
    }

    private function getChapterXhtml($content, $chapterNumber)
    {
        return '<?xml version="1.0" encoding="UTF-8"?>
<!DOCTYPE html>
<html xmlns="http://www.w3.org/1999/xhtml" xmlns:epub="http://www.idpf.org/2007/ops">
<head>
    <title>Chapter ' . $chapterNumber . '</title>
    <meta charset="UTF-8"/>
</head>
<body>
    <div epub:type="chapter">
        ' . htmlspecialchars($content) . '
    </div>
</body>
</html>';
    }

    public function extractChaptersFromEpub($epubPath)
    {
        if (!file_exists($epubPath)) {
            throw new \Exception("EPUB file not found at: " . $epubPath);
        }

        $zip = new ZipArchive();
        $result = $zip->open($epubPath);
        
        if ($result !== true) {
            $errorMessage = match($result) {
                ZipArchive::ER_NOZIP => "File is not a zip archive",
                ZipArchive::ER_INCONS => "Zip archive is inconsistent",
                ZipArchive::ER_CRC => "CRC error",
                ZipArchive::ER_OPEN => "Cannot open file",
                ZipArchive::ER_READ => "Read error",
                ZipArchive::ER_WRITE => "Write error",
                ZipArchive::ER_ZIPCLOSED => "Containing zip archive was closed",
                ZipArchive::ER_NOENT => "No such file",
                ZipArchive::ER_EXISTS => "File already exists",
                ZipArchive::ER_INVAL => "Invalid argument",
                ZipArchive::ER_MEMORY => "Malloc failure",
                ZipArchive::ER_CHANGED => "Entry has been changed",
                ZipArchive::ER_COMPNOTSUPP => "Compression method not supported",
                ZipArchive::ER_EOF => "Premature EOF",
                ZipArchive::ER_INTERNAL => "Internal error",
                ZipArchive::ER_INCONS => "Zip archive is inconsistent",
                ZipArchive::ER_REMOVE => "Cannot remove file",
                ZipArchive::ER_DELETED => "Entry has been deleted",
                default => "Unknown error (code: $result)"
            };
            throw new \Exception("Failed to open EPUB file: " . $errorMessage);
        }

        try {
            // Read the OPF file to get the reading order
            $container = $zip->getFromName('META-INF/container.xml');
            if (!$container) {
                throw new \Exception("container.xml not found in EPUB file");
            }

            $containerXml = new DOMDocument();
            if (!$containerXml->loadXML($container)) {
                throw new \Exception("Failed to parse container.xml");
            }
            
            // Get the content file path
            $rootfile = $containerXml->getElementsByTagName('rootfile')->item(0);
            if (!$rootfile) {
                throw new \Exception("No rootfile found in container.xml");
            }

            $opfPath = $rootfile->getAttribute('full-path');
            if (!$opfPath) {
                throw new \Exception("No full-path attribute found in rootfile");
            }

            $opfContent = $zip->getFromName($opfPath);
            if (!$opfContent) {
                throw new \Exception("OPF file not found at: " . $opfPath);
            }
            
            $opfXml = new DOMDocument();
            if (!$opfXml->loadXML($opfContent)) {
                throw new \Exception("Failed to parse OPF file");
            }
            
            // Get the spine items (reading order)
            $spine = $opfXml->getElementsByTagName('spine')->item(0);
            if (!$spine) {
                throw new \Exception("No spine found in OPF file");
            }

            $items = $spine->getElementsByTagName('itemref');
            if ($items->length === 0) {
                throw new \Exception("No items found in spine");
            }
            
            $chapters = [];
            $manifest = $opfXml->getElementsByTagName('manifest')->item(0);
            if (!$manifest) {
                throw new \Exception("No manifest found in OPF file");
            }
            
            foreach ($items as $item) {
                $itemId = $item->getAttribute('idref');
                if (!$itemId) {
                    continue;
                }

                $contentPath = null;
                foreach ($manifest->getElementsByTagName('item') as $manifestItem) {
                    if ($manifestItem->getAttribute('id') === $itemId) {
                        $contentPath = $manifestItem->getAttribute('href');
                        break;
                    }
                }
                
                if ($contentPath) {
                    // Get the content
                    $content = $zip->getFromName($contentPath);
                    if (!$content) {
                        \Log::warning("Content not found for path: " . $contentPath);
                        continue;
                    }
                    
                    // Convert to plain text
                    $contentDoc = new DOMDocument();
                    $contentDoc->loadHTML($content, LIBXML_HTML_NOIMPLIED | LIBXML_HTML_NODEFDTD);
                    
                    // Extract just the body content
                    $body = $contentDoc->getElementsByTagName('body')->item(0);
                    if ($body) {
                        $chapters[] = $body->nodeValue;
                    }
                }
            }
            
            if (empty($chapters)) {
                throw new \Exception("No readable content found in EPUB file");
            }
            
            return $chapters;
        } finally {
            $zip->close();
        }
    }
} 