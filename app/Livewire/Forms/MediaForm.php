<?php

namespace App\Livewire\Forms;

use Livewire\Attributes\Validate;
use Livewire\Form;

class MediaForm extends Form
{
    #[Validate('required|string|max:255')]
    public ?string $title;

    #[Validate('required|in:Manga,Anime,Book,Movie')]
    public ?string $type = 'Anime';

    #[Validate('required|in:Watching,Reading,Completed,On Hold,Dropped,Plan to Watch')]
    public ?string $status = 'Watching';

    #[Validate('required|string')]
    public ?string $overview;
}
