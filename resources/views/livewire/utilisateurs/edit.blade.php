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
                     <a href="#" class="btn btn-link" wire:click.prevent="confirmPwdReset">Réinitialiser le mot de passe </a>
                     <span>(par defaut: "password")</span>
                    </li>
                    </ul>
                </div>
      </div>
   </div>
    <div class="col-md-12 mt-4"> 
           <div class="card card-primary">
             <div class="card-header d-flex align-items-center">
               <h3 class="card-title flex-grow-1"><i class="fas fa-fingerprint fa-2x"></i>Rôles & permissions </h3>
               <button class="btn bg-gradient-success" wire:click="updateRoleAndPermissions()"><i class="fas fa-check"></i>Appliquer les modifications</button>
                 </div>

        <div class="card-body">
            <div id="accordion">
            @foreach ($rolePermissions["roles"] as $role )
            
             <div class="card">
              <div class="card-header d-flex justify-content-between">
                <h4 class="card-title flex-grow-1">
                  <a data-parent="#accordion" href="#" aria-expnded="true"> {{$role["role_nom"]}} </a>
                </h4>
                    <div class="custom-control custom-switch custom-switch-off-danger custom-switch-on-success">
                  <input type="checkbox" class="custom-control-input" wire:model.lazy="rolePermissions.roles.{{$loop->index}}.active" id="customSwitch {{$role['role_id']}}" @if ($role["active"]) checked  @endif>
                  <label class="custom-control-label"  for="customSwitch {{$role['role_id']}}">{{$role["active"]? "Activé" : "Desactivé"}}</label>  
                    </div>  
              </div>
             </div>

             @endforeach

            </div>
        </div>

        <div class="p-3">
            <table class="table table-bordered">
             <thead>
                <th>Permissions</th>
                <th></th>
             </thead>
             <tbody>
               @foreach ($rolePermissions["permissions"] as $permission)
                   
                <tr>
                 <td>{{$permission["permission_nom"]}}</td>
                 <td>
                  <div class="custom-control custom-switch custom-switch-off-danger custom-switch-on-success">
                  <input type="checkbox" class="custom-control-input" wire:model.lazy="rolePermissions.permissions.{{$loop->index}}.active" id="customSwitchPermission {{$permission['permission_id']}}" @if ($permission["active"]) checked  @endif >
                  <label class="custom-control-label"  for="customSwitchPermission {{$permission['permission_id']}}">{{$permission["active"]? "Activé" : "Desactivé"}}</label>  
                    </div> 
                 </td> 
                </tr>

                    @endforeach
             </tbody>
            </table>
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
    