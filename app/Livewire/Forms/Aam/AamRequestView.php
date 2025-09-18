<?php

namespace App\Livewire\Forms\Aam;

use App\Models\Forms\ApplicationAdultMembershipRequest;
use App\Settings\FormSettings;
use Filament\Schemas\Concerns\InteractsWithSchemas;
use Filament\Schemas\Contracts\HasSchemas;
use Filament\Schemas\Schema;
use Illuminate\Http\Request;
use Livewire\Attributes\Layout;
use Livewire\Component;

#[Layout('components.layouts.app')]
class AamRequestView extends Component implements HasSchemas
{
    use InteractsWithSchemas;

    public ApplicationAdultMembershipRequest $aamRequest;

    public function mount(Request $request, ApplicationAdultMembershipRequest $aamRequest)
    {
        if (! resolve(FormSettings::class)->aam_enabled) {
            abort(404);
        }
        $this->aamRequest = $aamRequest;
    }

    public function render()
    {
        return view('forms.aam.aam_request_view')
            ->layoutData([
                'title' => 'AAM - Ssalute',
            ]);
    }

    public function aamInfolist(Schema $schema): Schema
    {
        return $schema
            ->record($this->aamRequest)
            ->schema(AamRequestAction::getAamRequestSchema());
    }
}
