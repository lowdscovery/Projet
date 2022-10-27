<div>
@if($editArticle != [])
   @include("livewire.articles.edit") 
@endif

 @include("livewire.articles.add") 
 @include("livewire.articles.list") 

</div>

   <script>
        window.addEventListener("showSuccessMessage",event=>{
        Swal.fire({
            position: 'top-end',
            icon: 'success',
            toast:true,
            title: event.detail.message || 'Opération effectuée avec succès!',
            showConfirmButton: false,
            time: 3000
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
    const article_id = event.detail.message.data.article_id
    if(article_id){
     @this.deleteArticle(article_id)
    }
}
     })
    })
    </script>

<script>
  window.addEventListener("showModal", event=>{
      $("#modalAdd").modal("show")
    })
    window.addEventListener("closeModal", event=>{
      $("#modalAdd").modal("hide")
    })

     window.addEventListener("showEditModal", event=>{
      $("#editModal").modal("show")
    })
    window.addEventListener("closeEditModal", event=>{
      $("#editModal").modal("hide")
    })
</script>

<script src="https://code.jquery.com/jquery-3.2.1.slim.min.js" integrity="sha384-KJ3o2DKtIkvYIK3UENzmM7KCkRr/rE9/Qpg6aAZGJwFDMVNA/GpGFF93hXpG5KkN" crossorigin="anonymous"></script>
<script src="https://cdn.jsdelivr.net/npm/popper.js@1.12.9/dist/umd/popper.min.js" integrity="sha384-ApNbgh9B+Y1QKtv3Rn7W3mgPxhU9K/ScQsAP7hUibX39j7fakFPskvXusvfa0b4Q" crossorigin="anonymous"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@4.0.0/dist/js/bootstrap.min.js" integrity="sha384-JZR6Spejh4U02d8jOt6vLEHfe/JQGiRRSQQxSfFWpi1MquVdAyjUar5+76PVCmYl" crossorigin="anonymous"></script>