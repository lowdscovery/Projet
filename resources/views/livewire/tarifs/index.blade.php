<div class="row p-4 pt-5">
<div class="col-md-12">
<div class="card">
<div class="card-header bg-gradient-primary  align-items-center">
<h3 class="card-title flex-grow-1"><i class="fa fa-list fa-2x"></i>Tarification - {{$article->nom}}</h3>

<div class="card-tools d-flex align-items-center">
<a href="{{route('admin.gestarticles.articles')}}" class="btn btn-link text-white mr-4 d-block"><i class="fas fa-long-arrow-alt-left"></i>Retourner vers la liste des articles</a>
<a class="btn btn-link btn-db text-white mr-4 d-block" wire:click="nouveauTarif"><i class="fas fa-plus"></i>Nouveau Tarifs</a>

</div>
</div>

<div class="card-body table-responsive p-0 table-striped"  style="height: 300px; width:900px;">
@if($isAddTarif)
<div class="p-4">
  <div>
    <div class="form-group">
      <select wire:model="newTarif.duree_location_id" class="form-control @error('newTarif.duree_location_id')
          is-invalid @enderror">
        <option value="" selected>Choisissez une durée de location</option>
        @foreach ($dureeLocations as $duree)
        <option value="{{$duree->id}}">{{$duree->libelle}}</option>  
        @endforeach
      </select>
      @error('newTarif.duree_location_id')
           <span class="text-danger">{{ $message }}</span>
      @enderror
    </div>
     <div class="form-group">
        <input type="number" class="form-control @error('newTarif.prix') is-invalid @enderror" wire:model="newTarif.prix">
        @error('newTarif.prix')
           <span class="text-danger">{{ $message }}</span>
      @enderror
     </div>
  </div>
    <div>
        <button class="btn btn-primary" wire:click="saveTarif">Valider <i class="fa fa-check"></i></button>
       <button class="btn btn-danger" wire:click="cancel">Annuler <i class="fa fa-times"></i></button>
    </div>
</div>
@endif

<div style="height: 300px;">
<table class="table table-head-fixed">
<thead>
<tr>
<th></th>
<th >Durée Location</th>
<th class="text-center">Prix</th>
<th class="text-center">Action</th>
</tr>
</thead>
<tbody>
 
 @forelse ($tarifs as $tarif)
    <tr>
      <td>{{ ++$loop->index}}</td>
      <td>{{ $tarif->dureeLocation->libelle}}</td>
      <td class="text-center">{{ $tarif->prixForHumans}}</td>
      <td class="text-center">
        <button class="btn btn-link" wire:click="editTarif({{$tarif->id}})"><i class="far fa-edit"></i></button>    
      </td>
    </tr> 
 @empty
     <tr>
<td colspan="4">
<div class="alert alert-info">
<h5><i class="icon fas fa-ban">Information!</i></h5>
Cet article ne dispose pas encore de tarifs.
</div>
</td>
</tr>
 @endforelse


</tbody>
</table>
</div>
</div>
</div>

</div>
</div>