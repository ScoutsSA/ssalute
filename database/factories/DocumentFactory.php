<?php

namespace Database\Factories;

use App\Models\AmsDocumentType;
use App\Models\Document;
use App\Models\SystemUser;
use Illuminate\Database\Eloquent\Factories\Factory;

/** @extends Factory<Document> */
class DocumentFactory extends Factory
{
    protected $model = Document::class;

    public function definition(): array
    {
        return [
            'userID' => SystemUser::factory(),
            'countryID' => 196,
            'assocToRegion' => 0,
            'assocToDistrict' => 0,
            'assocToGroup' => 0,
            'documentTypeID' => AmsDocumentType::factory(),
            'description' => fake()->sentence(3),
            'PDFLocation' => 'ssalute/documents/' . fake()->uuid() . '.pdf',
            'active' => 1,
            'created' => now(),
            'createdby' => 1,
        ];
    }

    public function inactive(): static
    {
        return $this->state(['active' => 0]);
    }
}
