<?php

namespace App\Http\Livewire;

use Livewire\Component;
use App\Models\User;
use Livewire\WithPagination;

class Utilisateurs extends Component
{
    use WithPagination;

    protected $paginationTheme = "bootstrap";
    public $isBtnAddClicked = false;
    public function render()
    {
        return view('livewire.utilisateurs.index',[
            "users"=> User::paginate(3)
        ])
       
        ->extends("layouts.master") 
        ->section("contenu");
    }

    public function goToAddUser(){
     $this->isBtnAddClicked = true;
    }
}
