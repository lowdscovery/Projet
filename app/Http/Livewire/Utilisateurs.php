<?php

namespace App\Http\Livewire;

use Livewire\Component;
use App\Models\User;
use Livewire\WithPagination;

class Utilisateurs extends Component
{
    use WithPagination;
    //variable
    protected $paginationTheme = "bootstrap";
    public $isBtnAddClicked = false;
    public $newUser = [];
    protected $rules = [
    'newUser.nom' => 'required',
    'newUser.prenom' => 'required',
    'newUser.email' => 'required|email|unique:users,email',
    'newUser.telephone1' => 'required|numeric|unique:users,telephone1',
    'newUser.pieceIdentite' => 'required',
    'newUser.sexe' => 'required',
    'newUser.numeroPieceIdentite' => 'required|unique:users,numeroPieceIdentite',
    ];

   /* protected $messages =[
       'newUser.nom.required' => "Le nom de l'utilisateur est requis.",
    ];

    protected $validationAttributes =[
        'newUser.telephone1' => "numero de telephone 1",
     ];*/

    public function render()
    {
        return view('livewire.utilisateurs.index',[
            "users"=> User::latest()->paginate(3)
        ])
       
        ->extends("layouts.master") 
        ->section("contenu");
    }

    public function goToAddUser(){
     $this->isBtnAddClicked = true;
    }

    public function goToListUser(){
    $this->isBtnAddClicked = false;
    }

    public function addUser(){
       
        //verifier que les informations envoyer par les formulaire sont correct
        $validationAttributes=$this->validate();

        $validationAttributes["newUser"]["password"] = "password";
        //ajouter un nouvelle utilisateur
       User::create($validationAttributes["newUser"]);
       //vider le champ
       $this->newUser=[];
       //message affiche pour l'insertion
       $this->dispatchBrowserEvent("showSuccessMessage", ["message"=>"Utilisateur créé avec succès!"]);
    }

    //delete function
    public function confirmDelete($name, $id){
        $this->dispatchBrowserEvent("showConfirmMessage", ["message"=> [
            "text"=> "Vous êtes sur le point de supprimer $name de la liste des utilisateurs.Voulez-vous continuer?",
            "title"=> "Êtes-vous sûr de continuer?",
            "type" => "warning",
            "data"=>[
                "user_id"=>$id
            ]
        ]]);
    }
    //delete id
    public function deleteUser($id){
       User::destroy($id); 

       $this->dispatchBrowserEvent("showSuccessMessage", ["message"=>"Utilisateur supprimer avec succès!"]);
    }
}
