<?php

namespace App\Models;

use App\Models\Concerns\BaseModel;
use App\Providers\AppServiceProvider;
use Illuminate\Database\Eloquent\Casts\Attribute;

class SystemFaqCat extends BaseModel
{
    public const array AUDIENCE_FLAGS = [
        'forNational' => 'National',
        'forRegion' => 'Region',
        'forDistrict' => 'District',
        'forGroupAdults' => 'Group Adults',
        'forGroupParents' => 'Group Parents',
        'forGroupScouts' => 'Group Scouts',
        'forGroupRovers' => 'Group Rovers',
        'forAlumni' => 'Alumni',
    ];

    protected $connection = AppServiceProvider::DB_SD_CORE;
    protected $table = 'system_faq_cats';

    protected $guarded = [];

    protected $casts = [
        'id' => 'int',
        'faqGroup' => 'int',
        'position' => 'int',
        'name' => 'string',
        'description' => 'string',
        'forNational' => 'int',
        'forRegion' => 'int',
        'forDistrict' => 'int',
        'forGroupAdults' => 'int',
        'forGroupParents' => 'int',
        'forGroupScouts' => 'int',
        'forGroupRovers' => 'int',
        'forAlumni' => 'int',
        'active' => 'int',
    ];

    /**
     * Human readable label for where the legacy FAQ pages display this category.
     * The live legacy pages only show rows with faqGroup 0 and an audience flag;
     * rows without any flag belong to the retired faqGroup mechanism.
     */
    protected function audience(): Attribute
    {
        return Attribute::get(function (): string {
            $labels = [];

            foreach (self::AUDIENCE_FLAGS as $column => $label) {
                if ((int) $this->getAttribute($column) === 1) {
                    $labels[] = $label;
                }
            }

            return $labels === [] ? 'Not Displayed' : implode(', ', $labels);
        });
    }
}
