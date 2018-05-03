<?php

use Illuminate\Database\Seeder;

use App\Doc;
use App\DocItem;

class DocSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $docs = factory(Doc::class, 10)->create();

        foreach ($docs as $doc) {
            for ($line = 1; $line <= 3; $line++) {
                factory(DocItem::class)->create([
                    'doc_id' => $doc->id,
                    'doc_uuid' => $doc->uuid,
                    'line_number' => $line,
                ]);
            }
        }
    }
}
