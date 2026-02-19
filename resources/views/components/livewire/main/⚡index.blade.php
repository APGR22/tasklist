<?php

use Livewire\Component;
use App\Http\Controllers\GroupController;

new class extends Component
{
    #[Locked]
    public $groups_uuid = [];

    #[Locked]
    public $__table_content = "";

    public $formName;
    public $formNameError;
    
    public function mount($groups)
    {
        foreach ($groups as $group_id)
        {
            $group = \App\Models\Group::find($group_id);

            $this->addToTable($group->uuid, $group->name);

            array_push($this->groups_uuid, $group->uuid);
        }
    }

    public function addToTable($uuid, $name)
    {
        $url = url('/group/'.$uuid);

        $content = "
        <tr>
            <td>{$name}</td>
            <td>
                <a href=\"{$url}\">
                    <button class=\"btn btn-primary\">Enter</button>
                </a>
            </td>
        </tr>
        ";

        $this->__table_content .= $content;
    }

    public function save()
    {
        if ($this->formName == "")
        {
            $this->formNameError = "This name is empty";
            return;
        }

        $group = GroupController::create($this->formName);
        
        $this->addToTable($group->uuid, $group->name);
        array_push($this->groups_uuid, $group->uuid);

        $this->js('closeModal');
        return;
    }
};
?>

{{-- https://stackoverflow.com/questions/13002626/how-to-set-variables-in-a-laravel-blade-template/25618878#25618878 --}}

<div>
    {{-- Breathing in, I calm body and mind. Breathing out, I smile. - Thich Nhat Hanh --}}
    {{-- It is not the man who has too little, but the man who craves more, that is poor. - Seneca --}}

    <button class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#modal-create-group">+</button>
    <table class="table table-primary">
        <thead>
            <tr>
                <th>Group</th>
                <th>Action</th>
            </tr>
        </thead>
        <tbody id="table-groups-body">
            {!! $__table_content !!}
        </tbody>
    </table>

    {{-- Must use `wire:ignore` to prevent automatically close modal in refresh html by Livewire --}}
    <div class="modal" id="modal-create-group" tabindex="-1" data-bs-backdrop="static" wire:ignore.self>
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h2 class="h2 modal-title">Create</h2>
                    <button class="btn-close" data-bs-dismiss="modal" aria-label="close" id="modal-close"></button>
                </div>
                <div class="modal-body">
                    <form class="d-flex container-fluid flex-column align-items-center" wire:submit="save">
                        <input type="text" class="form-control w-100" wire:model="formName" id="wire-formName">
                        <span wire:text="formNameError"></span><br>
                        <button type="submit" class="btn btn-primary">Add</button>
                    </form>
                </div>
                <div class="modal-footer"></div>
            </div>
        </div>
    </div>
</div>


<script>
    this.$js.closeModal = () =>
    {
        let modalCloser = document.getElementById("modal-close");
        modalCloser.click();
    }
</script>