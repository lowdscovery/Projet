<?php

namespace App\Http\Livewire;

use App\Models\Permission;
use App\Models\Role;
use Livewire\Component;
use App\Models\User;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Bus;
use Illuminate\Support\Facades\DB;
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
    public $rolePermissions=[];


   /* protected $messages =[
       'newUser.nom.required' => "Le nom de l'utilisateur est requis.",
    ];

    protected $validationAttributes =[
        'newUser.telephone1' => "numero de telephone 1",
     ];*/

    public function render()
    {
        Carbon::setLocale("fr");
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

        $this->populateRolePermissions();
    }

    public function populateRolePermissions(){
        $this->rolePermissions["roles"]=[];
        $this->rolePermissions["permissions"]=[];

        $mapForCB=function($value){
            return $value["id"];
        };
        $roleIds = array_map($mapForCB,User::find($this->editUser["id"])->roles->toArray());
        $permissionIds = array_map($mapForCB,User::find($this->editUser["id"])->permissions->toArray());
        //la logique pour changer les roles et les permissions
        foreach(Role::all() as $role){
            if(in_array($role->id, $roleIds)){
                array_push($this->rolePermissions["roles"], ["role_id"=>$role->id, "role_nom"=>$role->nom, "active"=>true]);
            }else{
                array_push($this->rolePermissions["roles"], ["role_id"=>$role->id, "role_nom"=>$role->nom, "active"=>false]);
            }
        }

        foreach(Permission::all() as $permission){
            if(in_array($permission->id, $permissionIds)){
                array_push($this->rolePermissions["permissions"], ["permission_id"=>$permission->id, "permission_nom"=>$permission->nom, "active"=>true]);
            }else{
                array_push($this->rolePermissions["permissions"], ["permission_id"=>$permission->id, "permission_nom"=>$permission->nom, "active"=>false]);
            }
        }
    }

    public function updateRoleAndPermissions(){
        DB::table("user_role")->where("user_id", $this->editUser["id"])->delete();
        DB::table("user_permission")->where("user_id", $this->editUser["id"])->delete();
        
        foreach($this->rolePermissions["roles"] as $role){
            if($role["active"]){
                User::find($this->editUser["id"])->roles()->attach($role["role_id"]);
                  }   
        }
        foreach($this->rolePermissions["permissions"] as $permission){
            if($permission["active"]){
                User::find($this->editUser["id"])->permissions()->attach($permission["permission_id"]);
            }
        }
        $this->dispatchBrowserEvent("showSuccessMessage", ["message"=>"Role et permissions mis à jour avec succès!"]);
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
