<table class="table">
  <thead>
    <tr>
      <th scope="col">ID</th>
      <th scope="col">Name</th>
      <th scope="col">
        <a type="button" href="<?php echo base_url('child_data/'.$idBack); ?>"  class="btn btn-link">Back</a>
        <a type="button" href="<?php echo base_url('form_add/'.$idParent); ?>"  class="btn btn-primary">Add</a>
      </th>
    </tr>
  </thead>
  <tbody>
    <?php 
      $i = 0;
      foreach ($strukturs as $struktur) { 
        if ($struktur->active == 1) {
    ?>
    <tr>
      <th scope="row"><?= ++$i ?></th>
      <td><?= $struktur->judul ?></td>
      <td>
        <a type="button" href="<?php echo base_url('child_data/'.$struktur->id); ?>" class="btn btn-link">Sub</a>
        <a type="button" href="<?php echo base_url('form_edit/'.$struktur->id); ?>" class="btn btn-warning">Edit</a>
        <a onclick="deleteStruktur(<?= $struktur->id ?>)" type="button" class="btn btn-danger">Delete</a>
      </td>
    </tr>
    <?php 
        }
      }
    ?>
  </tbody>
</table>
<script>
  var server = "<?php echo base_url() ?>";
  var delete_struktur = server+"rest/delete/struktur/";
  var redirect = server+"child_data/<?= $idParent ?>";

  function deleteStruktur(id) {
      console.log("delete : ", delete_struktur+id);
      $.get(delete_struktur+id, function(data, status){
        alert("Data: " + data + "\nStatus: " + status);
        window.location.replace(redirect);
      });
  }
</script>