<div class="row p-4 pt-5">
<div class="col-md-12">
<div class="card">
<div class="card-header bg-gradient-primary  align-items-center">
<h3 class="card-title flex-grow-1"><i class="fa fa-list fa-2x"></i>Liste des types d'articles</h3>

<div class="card-tools d-flex align-items-center">
<a class="btn btn-link text-white mr-4 d-block" wire:click="toggleShowAddTypeArticleForm"><i class="fas fa-plus"></i>Nouveau type d'article</a>
<div class="input-group input-group-md" style="width: 250px;">
<input type="text" name="table_search" wire:model.debounce.250ms="search" class="form-control float-right" placeholder="Search">
<div class="input-group-append">
<button type="submit" class="btn btn-default">
<i class="fas fa-search"></i>
</button>
</div>
</div>
</div>
</div>

<div class="card-body table-responsive p-0 table-striped"  style="height: 450px; width:1260px;">
<table class="table table-head-fixed">
<thead>
<tr>

<th style="width: 30%;">Type d'article</th>
<th style="width: 40%;" class="text-center">Ajouté</th>
<th style="width: 30%;" class="text-center">Action</th>
</tr>
</thead>
<tbody>
@if ($isAddTypeArticle)
    <tr>
      <td colspan="2">
        <input type="text" class="form-control  
        @error('newTypeArticleName') is-invalid @enderror" 
        wire:keydown.enter="addTypeArticle"
        wire:model="newTypeArticleName"/>

        @error('newTypeArticleName')
           <span class="text-danger">{{$message}}</span>
        @enderror
      </td>
      <td class="text-center">
       <button class="btn btn-primary" wire:click="addTypeArticle">Valider <i class="fa fa-check"></i></button>
       <button class="btn btn-danger" wire:click="toggleShowAddTypeArticleForm">Annuler <i class="fa fa-times"></i></button>
      </td>
    </tr>
@endif
@foreach ( $typearticles as $typearticle)
    <tr>
     <td>{{ $typearticle->nom}}</td>
     <td class="text-center">{{ optional($typearticle->created_at)->diffForHumans()}}</td>
     <td class="text-center">
       <button class="btn btn-link" wire:click="editTypeArticle({{$typearticle->id}})"><i class="far fa-edit"></i></button>
       <button class="btn btn-link" wire:click="showProp({{$typearticle->id}})">
       <i class="fa fa-list"></i> Propriété</button>
       @if (count($typearticle->articles)==0)
       <button class="btn btn-link" wire:click="confirmDelete('{{$typearticle->nom}}', {{$typearticle->id}})"><i class="far fa-trash-alt"></i></button>
       @endif
      </td>
   </tr>
@endforeach
</tbody>
</table>
</div>
<div class="card-footer">
<div class="float-right">
{{ $typearticles->links()}}
</div>
</div>
</div>

</div>
</div>