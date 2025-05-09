<?php

namespace App\Services;

use DOMDocument;
use ZipArchive;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Str;

class EPUBService
{
    private $epubPath;
    
    public function __construct()
    {
        $this->epubPath = storage_path('app/epub_books');
    }

    public function addNewBook($title, $author, $chapters)
    {
        $bookId = Str::uuid();
        $epubFilename = $bookId . '.epub';
        $epubPath = "{$this->epubPath}/{$epubFilename}";

        // Create EPUB file
        $epub = new ZipArchive();
        if ($epub->open($epubPath, ZipArchive::CREATE | ZipArchive::OVERWRITE) !== true) {
            throw new \Exception("Cannot create EPUB file");
        }

        // Add mimetype file
        $epub->addFromString('mimetype', 'application/epub+zip');

        // Add container.xml
        $epub->addFromString('META-INF/container.xml', $this->getContainerXml());

        // Add content.opf with chapters
        $epub->addFromString('OEBPS/content.opf', $this->getContentOpf($title, $author, $chapters));

        // Add chapters
        foreach ($chapters as $index => $chapter) {
            $chapterFilename = sprintf('chapter_%03d.xhtml', $index + 1);
            $epub->addFromString(
                'OEBPS/' . $chapterFilename,
                $this->getChapterXhtml($chapter, $index + 1)
            );
        }

        $epub->close();

        return [
            'id' => $bookId,
            'filename' => $epubFilename,
            'title' => $title,
            'author' => $author,
            'chapters' => count($chapters)
        ];
    }

    public function getBookContent($bookID, $pageNumber)
    {
        $cacheKey = "epub_book_{$bookID}_page_{$pageNumber}";
        
        if (Cache::has($cacheKey)) {
            return Cache::get($cacheKey);
        }

        $epubFile = $this->getEpubPath($bookID);
        $content = $this->extractPageContent($epubFile, $pageNumber);
        
        Cache::put($cacheKey, $content, now()->addHours(24));
        
        return $content;
    }

    public function getBookMetadata($bookID)
    {
        $cacheKey = "epub_metadata_{$bookID}";
        
        if (Cache::has($cacheKey)) {
            return Cache::get($cacheKey);
        }

        $epubFile = $this->getEpubPath($bookID);
        $metadata = $this->extractMetadata($epubFile);
        
        Cache::put($cacheKey, $metadata, now()->addDays(7));
        
        return $metadata;
    }

    private function getEpubPath($bookID)
    {
        return "{$this->epubPath}/{$bookID}.epub";
    }

    private function extractPageContent($epubFile, $pageNumber)
    {
        $zip = new ZipArchive();
        
        if ($zip->open($epubFile) !== true) {
            throw new \Exception("Failed to open EPUB file");
        }

        // Read the OPF file to get the reading order
        $container = $zip->getFromName('META-INF/container.xml');
        $containerXml = new DOMDocument();
        $containerXml->loadXML($container);
        
        // Get the content file path
        $opfPath = $containerXml->getElementsByTagName('rootfile')->item(0)->getAttribute('full-path');
        $opfContent = $zip->getFromName($opfPath);
        
        $opfXml = new DOMDocument();
        $opfXml->loadXML($opfContent);
        
        // Get the spine items (reading order)
        $spine = $opfXml->getElementsByTagName('spine')->item(0);
        $items = $spine->getElementsByTagName('itemref');
        
        if ($pageNumber > $items->length) {
            $zip->close();
            return null;
        }

        // Get the content document for the requested page
        $itemId = $items->item($pageNumber - 1)->getAttribute('idref');
        $manifest = $opfXml->getElementsByTagName('manifest')->item(0);
        $contentPath = null;
        
        foreach ($manifest->getElementsByTagName('item') as $item) {
            if ($item->getAttribute('id') === $itemId) {
                $contentPath = $item->getAttribute('href');
                break;
            }
        }

        if (!$contentPath) {
            $zip->close();
            return null;
        }

        // Read the content
        $content = $zip->getFromName($contentPath);
        $zip->close();

        // Convert to plain text and basic HTML
        $contentDoc = new DOMDocument();
        $contentDoc->loadHTML($content, LIBXML_HTML_NOIMPLIED | LIBXML_HTML_NODEFDTD);
        
        // Extract just the body content
        $body = $contentDoc->getElementsByTagName('body')->item(0);
        return $body ? $body->nodeValue : '';
    }

    private function extractMetadata($epubFile)
    {
        $zip = new ZipArchive();
        
        if ($zip->open($epubFile) !== true) {
            throw new \Exception("Failed to open EPUB file");
        }

        // Read the OPF file
        $container = $zip->getFromName('META-INF/container.xml');
        $containerXml = new DOMDocument();
        $containerXml->loadXML($container);
        
        $opfPath = $containerXml->getElementsByTagName('rootfile')->item(0)->getAttribute('full-path');
        $opfContent = $zip->getFromName($opfPath);
        
        $opfXml = new DOMDocument();
        $opfXml->loadXML($opfContent);
        
        // Extract metadata
        $metadata = [];
        $metadataNode = $opfXml->getElementsByTagName('metadata')->item(0);
        
        $metadata['title'] = $this->getMetadataValue($metadataNode, 'title');
        $metadata['creator'] = $this->getMetadataValue($metadataNode, 'creator');
        $metadata['language'] = $this->getMetadataValue($metadataNode, 'language');
        $metadata['pages'] = $opfXml->getElementsByTagName('spine')->item(0)->getElementsByTagName('itemref')->length;

        $zip->close();
        return $metadata;
    }

    private function getMetadataValue($metadataNode, $elementName)
    {
        $elements = $metadataNode->getElementsByTagName($elementName);
        return $elements->length > 0 ? $elements->item(0)->nodeValue : null;
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