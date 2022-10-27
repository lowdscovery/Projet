<?php

namespace App\Http\Livewire;

use App\Models\ProprieteArticle;
use App\Models\TypeArticle;
use Illuminate\Support\Carbon;
use Livewire\Component;
use Livewire\WithPagination;
use Illuminate\Validation\Rule;

class TypeArticleComp extends Component
{

    use WithPagination;
    //variable
    protected $paginationTheme = "bootstrap";
  //  public $isBtnAddClicked = false;
    public $search="";
    public $isAddTypeArticle=false;
    public $newTypeArticleName="";
    public $newValue="";
    public $selectedTypeArticle;
    public $newPropModel = [];
    public $editPropModel=[];


    public function render()
    {
    Carbon::setLocale("fr");
    $searchCriteria = "%".$this->search."%";

      $this->resetPage();
       $data=[     
        //variable articles, proprietestypeArticle et model TypeArticle
        "typearticles"=>TypeArticle::where("nom", "like", $searchCriteria)->latest()->paginate(6,["*"], "art"),
        //propriete article
        "proprietesTypeArticles"=>ProprieteArticle::where("type_article_id",optional( $this->selectedTypeArticle)->id)->paginate(2, ["*"], "pro")
       ];
      

        return view('livewire.typearticles.index', $data)
        ->extends("layouts.master")
        ->section("contenu");
    }

    public function toggleShowAddTypeArticleForm(){
       if( $this->isAddTypeArticle){
        $this->isAddTypeArticle = false;
        $this->newTypeArticleName = "";
        $this->resetErrorBag(["newTypeArticleName"]);
       }else{
        $this->isAddTypeArticle = true;
       }  
    }

    public function addTypeArticle(){
        $validated =$this->validate([
          "newTypeArticleName"=>"required|max:50|unique:type_articles,nom"
        ]);
        TypeArticle::create(["nom"=> $validated["newTypeArticleName"]]);
        $this->toggleShowAddTypeArticleForm();
        $this->dispatchBrowserEvent("showSuccessMessage", ["message"=>"Type d'article ajouté avec succès!"]);
    }

    public function editTypeArticle($id){
        // c'est la mm chose public function editTypeArticle(TypeArticle, $typeArticle)
        //donc n'est pas besoin d'ici $typeArticle = TypeArticle::find($id);
        $typeArticle = TypeArticle::find($id);
        $this->dispatchBrowserEvent("showEditForm", ["typearticle"=> $typeArticle]); 
    }

    public function updateTypeArticle($id, $valueFromJS){
    $this->newValue=$valueFromJS;
    $validated =$this->validate([
            "newValue"=>["required", "max:50", Rule::unique("type_articles", "nom")->ignore($id)]
          ]);
   TypeArticle::find($id)->update(["nom"=>$validated["newValue"]]);
   $this->dispatchBrowserEvent("showSuccessMessage", ["message"=>"Type d'article mis à jour avec succès!"]);
    }

    public function confirmDelete($name, $id){
        $this->dispatchBrowserEvent("showConfirmMessage", ["message"=> [
            "text"=> "Vous êtes sur le point de supprimer $name de la liste des types d'articles.Voulez-vous continuer?",
            "title"=> "Êtes-vous sûr de continuer?",
            "type" => "warning",
            "data"=>[
                "type_article_id"=>$id
            ]
        ]]);
    }

   
    public function deleteTypeArticle(TypeArticle $typeArticle){
     $typeArticle->delete();
     $this->dispatchBrowserEvent("showSuccessMessage", ["message"=>"Type d'article supprimer avec succès!"]);
    }

    public function showProp(TypeArticle $typeArticle){
      $this->selectedTypeArticle=$typeArticle;
      $this->dispatchBrowserEvent("showModal", []);
    }

    public function closeModal(){
        $this->dispatchBrowserEvent("closeModal", []);
    }

    //propriete
    public function addProp(){
      $validated=$this->validate([
        "newPropModel.nom" =>[
          "required",
          Rule::unique("propriete_articles", "nom")->where("type_article_id", $this->selectedTypeArticle->id)
        ],
        "newPropModel.estObligatoire"=>"required"
      ]);

      ProprieteArticle::create([
        "nom"=>$this->newPropModel["nom"],
        "estObligatoire"=>(int) $this->newPropModel["estObligatoire"],
        "type_article_id"=>$this->selectedTypeArticle->id,
      ]);
      $this->newPropModel = [];
      $this->resetErrorBag();
      $this->dispatchBrowserEvent("showSuccessMessage", ["message"=>"Propriétés ajoutée avec succès!"]);
    }

    //delete propriete
    public function showDeletePrompt($name, $id){
      $this->dispatchBrowserEvent("showConfirmMessage", ["message"=> [
        "text"=> "Vous êtes sur le point de supprimer $name de la liste des propriétés d'articles.Voulez-vous continuer?",
        "title"=> "Êtes-vous sûr de continuer?",
        "type" => "warning",
        "data"=>[
            "propriete_id"=>$id
        ]
    ]]);
    }
    public function deleteProp(ProprieteArticle $proprieteArticle){
      $proprieteArticle->delete();
      $this->dispatchBrowserEvent("showSuccessMessage", ["message"=>"Propriétés supprimée avec succès!"]);
    }

     //modifier propriete
     public function editProp(ProprieteArticle $proprieteArticle){
      $this->editPropModel["nom"] = $proprieteArticle->nom;
      $this->editPropModel["estObligatoire"] = $proprieteArticle->estObligatoire;
      $this->editPropModel["id"] = $proprieteArticle->id;
      $this->dispatchBrowserEvent("showEditModal", []);
    }
    public function updateProp(){
      $this->validate([
        "editPropModel.nom" =>[
          "required",
          Rule::unique("propriete_articles", "nom")->ignore($this->editPropModel["id"])
        ],
        "editPropModel.estObligatoire"=>"required"
      ]);

      ProprieteArticle::find($this->editPropModel["id"])->update([
        "nom"=>$this->editPropModel["nom"],
        "estObligatoire"=>(int) $this->editPropModel["estObligatoire"]
       
      ]);
     
      $this->dispatchBrowserEvent("showSuccessMessage", ["message"=>"Propriétés mis à jour avec succès!"]);
      $this->closeEdit();
    }
    public function closeEdit(){
      //reinitialiser le champ
      $this->editPropModel = [];
      $this->resetErrorBag();
      $this->dispatchBrowserEvent("closeEditModal", []);
  }
}
