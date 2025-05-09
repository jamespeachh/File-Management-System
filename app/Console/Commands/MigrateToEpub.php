<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;
use ZipArchive;

class MigrateToEpub extends Command
{
    protected $signature = 'books:migrate-to-epub {book_id?}';
    protected $description = 'Migrate books from SQL storage to EPUB format';

    public function handle()
    {
        $bookId = $this->argument('book_id');
        
        if ($bookId) {
            $this->migrateBook($bookId);
        } else {
            $this->migrateAllBooks();
        }
    }

    private function migrateAllBooks()
    {
        $books = DB::table('books')->get();
        $bar = $this->output->createProgressBar(count($books));
        
        foreach ($books as $book) {
            $this->migrateBook($book->id);
            $bar->advance();
        }
        
        $bar->finish();
        $this->info("\nAll books have been migrated!");
    }

    private function migrateBook($bookId)
    {
        try {
            // Update migration status
            DB::table('epub_migrations')->updateOrInsert(
                ['old_book_id' => $bookId],
                ['status' => 'in_progress', 'updated_at' => now()]
            );

            // Get book metadata
            $book = DB::table('books')->where('id', $bookId)->first();
            if (!$book) {
                throw new \Exception("Book not found");
            }

            // Create EPUB file
            $epub = new ZipArchive();
            $epubFilename = $bookId . '.epub';
            $epubPath = storage_path('app/epub_books/' . $epubFilename);
            
            if ($epub->open($epubPath, ZipArchive::CREATE | ZipArchive::OVERWRITE) !== true) {
                throw new \Exception("Cannot create EPUB file");
            }

            // Add mimetype file
            $epub->addFromString('mimetype', 'application/epub+zip');

            // Add container.xml
            $epub->addFromString('META-INF/container.xml', $this->getContainerXml());

            // Add content.opf
            $epub->addFromString('OEBPS/content.opf', $this->getContentOpf($book));

            // Add chapters
            $chapters = DB::table('book_contents')
                ->where('book_id', $bookId)
                ->orderBy('page_number')
                ->get();

            foreach ($chapters as $index => $chapter) {
                $chapterFilename = sprintf('chapter_%03d.xhtml', $index + 1);
                $epub->addFromString(
                    'OEBPS/' . $chapterFilename,
                    $this->getChapterXhtml($chapter->content, $index + 1)
                );
            }

            $epub->close();

            // Update migration status
            DB::table('epub_migrations')->where('old_book_id', $bookId)->update([
                'status' => 'completed',
                'epub_filename' => $epubFilename,
                'updated_at' => now()
            ]);

        } catch (\Exception $e) {
            DB::table('epub_migrations')->where('old_book_id', $bookId)->update([
                'status' => 'failed',
                'error_message' => $e->getMessage(),
                'updated_at' => now()
            ]);
            
            $this->error("Failed to migrate book {$bookId}: " . $e->getMessage());
        }
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

    private function getContentOpf($book)
    {
        $uuid = 'urn:uuid:' . \Illuminate\Support\Str::uuid();
        return '<?xml version="1.0" encoding="UTF-8"?>
<package xmlns="http://www.idpf.org/2007/opf" version="3.0" unique-identifier="uuid_id">
    <metadata xmlns:dc="http://purl.org/dc/elements/1.1/">
        <dc:identifier id="uuid_id">' . $uuid . '</dc:identifier>
        <dc:title>' . htmlspecialchars($book->title) . '</dc:title>
        <dc:language>en</dc:language>
        <meta property="dcterms:modified">' . now()->format('Y-m-d\TH:i:s\Z') . '</meta>
    </metadata>
    <manifest>
        <!-- Add chapter items here -->
    </manifest>
    <spine>
        <!-- Add chapter references here -->
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
} 