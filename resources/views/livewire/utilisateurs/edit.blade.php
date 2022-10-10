<div class="row p-4 pt-5">
<div class="col-md-6">

<div class="card card-primary">
<div class="card-header">
<h3 class="card-title"><i class="fas fa-user-plus fa-2x"></i>Formulaire d'édition utilisateur</h3>
</div>

<form wire:submit.prevent="updateUser()">
<div class="card-body">
<div class="row">
<div class="col-6">
<div class="form-group">
<label>Nom</label>
<input type="text" class="form-control @error('editUser.nom') is-invalid @enderror" wire:model="editUser.nom">
@error("editUser.nom")
    <span class="text-danger">{{$message}}</span>
@enderror
</div>
</div>
<div class="col-6">
<div class="form-group">
<label>Prenom</label>
<input type="text" class="form-control @error('editUser.prenom') is-invalid @enderror" wire:model="editUser.prenom">
@error("editUser.prenom")
    <span class="text-danger">{{$message}}</span>
@enderror
</div>
</div>
</div>

<div class="form-group">
<label>Sexe</label>
<select class="form-control @error('editUser.sexe') is-invalid @enderror" wire:model="editUser.sexe">
<option value="">------</option>
<option value="H">Homme</option>
<option value="F">Femme</option>
</select>
@error("editUser.sexe")
    <span class="text-danger">{{$message}}</span>
@enderror
</div>

<div class="form-group">
<label>Adresse e-mail</label>
<input type="email" class="form-control @error('editUser.email') is-invalid @enderror" wire:model="editUser.email">
@error("editUser.email")
    <span class="text-danger">{{$message}}</span>
@enderror
</div>

<div class="row">
<div class="col-6">
<div class="form-group">
<label>Telephone1</label>
<input type="text" class="form-control @error('editUser.telephone1') is-invalid @enderror" wire:model="editUser.telephone1">
@error("editUser.telephone1")
    <span class="text-danger">{{$message}}</span>
@enderror
</div>
</div>
<div class="col-6">
<div class="form-group">
<label>Telephone2</label>
<input type="text" class="form-control" wire:model="editUser.telephone2">
</div>
</div>
</div>

<div class="form-group">
<label>Piece d'identité</label>
<select class="form-control @error('editUser.pieceIdentite') is-invalid @enderror" wire:model="editUser.pieceIdentite">
<option value="">------</option>
<option value="CIN">CIN</option>
<option value="PASSPORT">PASSPORT</option>
<option value="PERMIS DE CONDUIRE">PERMIS DE CONDUIRE</option>
</select>
@error("editUser.pieceIdentite")
    <span class="text-danger">{{$message}}</span>
@enderror
</div>

<div class="form-group">
<label>Numero de piece d'identité</label>
<input type="text" class="form-control @error('editUser.numeroPieceIdentite') is-invalid @enderror" wire:model="editUser.numeroPieceIdentite">
@error("editUser.numeroPieceIdentite")
    <span class="text-danger">{{$message}}</span>
@enderror
</div>

</div>
<div class="card-footer">
<button type="submit" class="btn btn-primary">Appliquer les modifications</button>
<button type="button" class="btn btn-danger" wire:click="goToListUser()">Retourner à la liste des utilsateurs</button>
</div>
</form>
</div>

  </div>

   <div class="col-md-6"> 
     <div class="row"> 
        <div class="col-md-12"> 
           <div class="card card-primary">
             <div class="card-header">
               <h3 class="card-title"><i class="fas fa-key fa-2x"></i>Réinitialisation de mot de passe </h3>
                 </div>

                <div class="card-body">
                    <ul>
                    <li>
                     <a href="" class="btn btn-link" wire:click.prevent="confirmPwdReset">Réinitialiser le mot de passe </a>
                     <span>(par defaut: "password")</span>
                    </li>
                    </ul>
                </div>
      </div>
   </div>
    <div class="col-md-12 mt-4"> 
           <div class="card card-primary">
             <div class="card-header">
               <h3 class="card-title"><i class="fas fa-fingerprint fa-2x"></i>Rôles & permissions </h3>
                 </div>

                <div class="card-body">

                </div>
   </div>


  </div>
    