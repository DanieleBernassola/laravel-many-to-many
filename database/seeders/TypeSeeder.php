<?php

namespace Database\Seeders;

use App\Models\Type;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Schema;

class TypeSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Schema::disableForeignKeyConstraints();

        //SVUOTO LA TABELLA PRIMA DI POPOLARLA PER NON ACCUMULARE TROPPI ELEMENTI
        Type::truncate();

        //ARRAY DI PARTENZA
        $types = ['Frontend', 'Backend', 'AI', 'Data Analytics', 'Fullstack'];

        foreach ($types as $type) {
            $new_type = new Type();
            $new_type->title = $type;
            $new_type->slug = Str::of($type)->slug();

            $new_type->save();
        }

        Schema::enableForeignKeyConstraints();
    }
}
