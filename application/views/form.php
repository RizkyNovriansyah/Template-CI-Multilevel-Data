<div>
<input id="id" value="<?php echo $id ?>" disabled hidden>
  <div class="form-group" hidden>
    <label for="inputAddress">Parent</label>
    <input type="text" class="form-control" id="idParent" placeholder="id parent" value="<?php echo $idParent ?>" disabled>
  </div>
  <div class="form-group" hidden>
    <label for="inputAddress2">Nomor</label>
    <input type="text" class="form-control" id="nomor" placeholder="Nomor" value="<?php echo $nomor ?>">
  </div>
  <div class="form-group">
    <label for="inputAddress2">Judul</label>
    <input type="text" class="form-control" id="judul" placeholder="Judul" value="<?php echo $judul ?>">
  </div>
  <a id="add" type="button" class="btn btn-primary">Submit</a>
  <a type="button" href="<?php echo base_url('child_data/'.$idParent); ?>"  class="btn btn-link">Back</a>
</div>
<script>
  var server = "<?php echo base_url() ?>";
  var insert_struktur = server+"rest/insert/struktur";
  var update_struktur = server+"rest/update/struktur";
  var redirect = server+"child_data/";

  $("#add").click(function(){
      let data = new Object();
      let idParent = $("#idParent").val();
      let judul = $("#judul").val();
      let nomor = $("#nomor").val();
      let id = $("#id").val();
      
      data.id_parent = idParent;
      data.judul = judul;
      data.nomor = nomor;
      if (id == '') {
        $.post(insert_struktur, data).done(function (data) {
          console.log(data);
          if (data == 1) {
            window.location.replace(redirect+idParent);
          }
        });
      } else {
        data.id = id;
        console.log("edit ");
        $.post(update_struktur, data).done(function (data) {
          console.log(data);
          if (data == 1) {
            window.location.replace(redirect+idParent);
          }
        });
      }
  });
</script>