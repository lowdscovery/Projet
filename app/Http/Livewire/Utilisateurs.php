<?php

namespace App\Http\Livewire;

use Livewire\Component;
use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rule;
use Livewire\WithPagination;

class Utilisateurs extends Component
{
    use WithPagination;
    //variable
    protected $paginationTheme = "bootstrap";
  //  public $isBtnAddClicked = false;

    //modification
    public $currentPage = PAGELIST;

    public $newUser = [];
    public $editUser = [];


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

    public function rules(){
        if($this->currentPage == PAGEEDITFORM){
            //'required|email|unique:users,email'  
            return [
                'editUser.nom' => 'required',
                'editUser.prenom' => 'required',
                'editUser.email' => ['required', 'email', Rule::unique("users", "email")->ignore($this->editUser['id'])],
                'editUser.telephone1' => ['required', 'numeric', Rule::unique("users", "telephone1")->ignore($this->editUser['id'])],
                'editUser.pieceIdentite' => ['required'],
                'editUser.sexe' => 'required',
                'editUser.numeroPieceIdentite' => ['required', Rule::unique("users", "numeroPieceIdentite")->ignore($this->editUser['id'])],
                ];
            
        }
         return [
            'newUser.nom' => 'required',
            'newUser.prenom' => 'required',
            'newUser.email' => 'required|email|unique:users,email',
            'newUser.telephone1' => 'required|numeric|unique:users,telephone1',
            'newUser.pieceIdentite' => 'required',
            'newUser.sexe' => 'required',
            'newUser.numeroPieceIdentite' => 'required|unique:users,numeroPieceIdentite',
            ];
        
        
    }

    public function goToAddUser(){
        //modification
        $this->currentPage = PAGECREATEFORM;
       
     //$this->isBtnAddClicked = true;
    }

    public function goToEditUser($id){
        //afficher une valeur dans une champ
        $this->editUser = User::find($id)->toArray();
        $this->currentPage = PAGEEDITFORM;
    }

    public function goToListUser(){
        //modification
        $this->currentPage = PAGELIST;
       //vider le champ
        $this->editUser = [];
    //$this->isBtnAddClicked = false;
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


    //modification
    public function updateUser(){
       //verifier que les informations envoyer par les formulaire sont correct
       $validationAttributes=$this->validate();

       User::find($this->editUser["id"])->update($validationAttributes["editUser"]);

       $this->dispatchBrowserEvent("showSuccessMessage", ["message"=>"Utilisateur mis à jour avec succès!"]);
    }

    //reiniliser le mot de passe
    public function confirmPwdReset(){
        $this->dispatchBrowserEvent("showConfirmMessage", ["message"=> [
            "text"=> "Vous êtes sur le point de réinitialiser le mot de passe de cet utilisateur.Voulez-vous continuer?",
            "title"=> "Êtes-vous sûr de continuer?",
            "type" => "warning"
        ]]);
    }

    public function resetPassword(){
      User::find($this->editUser["id"])->update(["password" => Hash::make(DEFAULTPASSWORD)]);  
      $this->dispatchBrowserEvent("showSuccessMessage", ["message"=>"Mot de passe utilisateur réinitialisé avec succès!"]);
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
