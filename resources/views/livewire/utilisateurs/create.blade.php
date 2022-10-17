<div class="row p-4 pt-5">
<div class="col-md-12">

<div class="card card-primary">
<div class="card-header">
<h3 class="card-title"><i class="fas fa-user-plus fa-2x"></i>Formulaire de création d'un nouvel utilisateur</h3>
</div>

<form wire:submit.prevent="addUser()">
<div class="card-body">
<div class="row">
<div class="col-6">
<div class="form-group">
<label>Nom</label>
<input type="text" class="form-control @error('newUser.nom') is-invalid @enderror" wire:model="newUser.nom">
@error("newUser.nom")
    <span class="text-danger">{{$message}}</span>
@enderror
</div>
</div>
<div class="col-6">
<div class="form-group">
<label>Prenom</label>
<input type="text" class="form-control @error('newUser.prenom') is-invalid @enderror" wire:model="newUser.prenom">
@error("newUser.prenom")
    <span class="text-danger">{{$message}}</span>
@enderror
</div>
</div>
</div>

<div class="form-group">
<label>Sexe</label>
<select class="form-control @error('newUser.sexe') is-invalid @enderror" wire:model="newUser.sexe">
<option value="">------</option>
<option value="H">Homme</option>
<option value="F">Femme</option>
</select>
@error("newUser.sexe")
    <span class="text-danger">{{$message}}</span>
@enderror
</div>

<div class="form-group">
<label>Adresse e-mail</label>
<input type="email" class="form-control @error('newUser.email') is-invalid @enderror" wire:model="newUser.email">
@error("newUser.email")
    <span class="text-danger">{{$message}}</span>
@enderror
</div>

<div class="row">
<div class="col-6">
<div class="form-group">
<label>Telephone1</label>
<input type="text" class="form-control @error('newUser.telephone1') is-invalid @enderror" wire:model="newUser.telephone1">
@error("newUser.telephone1")
    <span class="text-danger">{{$message}}</span>
@enderror
</div>
</div>
<div class="col-6">
<div class="form-group">
<label>Telephone2</label>
<input type="text" class="form-control" wire:model="newUser.telephone2">
</div>
</div>
</div>

<div class="form-group">
<label>Piece d'identité</label>
<select class="form-control @error('newUser.pieceIdentite') is-invalid @enderror" wire:model="newUser.pieceIdentite">
<option value="">------</option>
<option value="CIN">CIN</option>
<option value="PASSPORT">PASSPORT</option>
<option value="PERMIS DE CONDUIRE">PERMIS DE CONDUIRE</option>
</select>
@error("newUser.pieceIdentite")
    <span class="text-danger">{{$message}}</span>
@enderror
</div>

<div class="form-group">
<label>Numero de piece d'identité</label>
<input type="text" class="form-control @error('newUser.numeroPieceIdentite') is-invalid @enderror" wire:model="newUser.numeroPieceIdentite">
@error("newUser.numeroPieceIdentite")
    <span class="text-danger">{{$message}}</span>
@enderror
</div>

<div class="form-group">
<label for="exampleInputPassword1">Mot de passe</label>
<input type="password" class="form-control" disable placeholder="Password" >
</div>

</div>

<div class="card-footer">
<button type="submit" class="btn btn-primary">Enregistrer</button>
<button type="button" class="btn btn-danger" wire:click="goToListUser()">Retourner à la liste des utilsateurs</button>
</div>
</form>
</div>

  </div>
  </div>
  
  <script>
        window.addEventListener("showSuccessMessage",event=>{
        Swal.fire({
            position: 'top-end',
            icon: 'success',
            toast:true,
            title: event.detail.message || 'Opération effectuée avec succès!',
            showConfirmButton: false,
            timer: 3000
        })
    })
      </script>

<script> 
    window.addEventListener("showConfirmMessage",event=>{
        Swal.fire({
  title: event.detail.message.title,
  text: event.detail.message.text,
  icon: event.detail.message.type,
  showCancelButton: true,
  confirmButtonColor: '#3085d6',
  cancelButtonColor: '#d33',
  confirmButtonText: 'Continuer',
  cancelButtonText: 'Annuler'
          }).then((result) => {
  if (result.isConfirmed) {
    if(event.detail.message.data){
 @this.deleteUser(event.detail.message.data.user_id)
    }
  @this.resetPassword()
}
  
     })
    })
    </script>