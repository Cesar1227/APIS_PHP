<?php
include_once ("Controlador.php");

?>
<!doctype html>
<html lang="en">
  <head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>ImageLook</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-rbsA2VBKQhggwzxH7pPCaAqO46MgnOM80zW1RWuH61DGLwZJEdK2Kadq2F9CUG65" crossorigin="anonymous">
    <script type="text/javascript" src="https://cdn.jsdelivr.net/npm/jquery@3.2.1/dist/jquery.min.js"></script>
    <link rel="stylesheet"  href="style.css">
  </head>
  <body>
    <h1>ImageLook</h1>
    <section>
      <div>
          <div class="row">
            <label for="exampleFormControlInput1" class="form-label">Frases o palabra clave</label>
          </div>
          <div class="row">
            <div class="col-8">
              <div class="mb-3">
                <input type="text" class="form-control" name="txtkeyWord" id="txtkeyWord" placeholder="Autos" maxlength="100">
              </div>   
            </div>
            <div class="col-2">
              <div class="mb-3">
                <div class="dropdown">
                  <select class="form-select col-sm-10" id="selector_cat" aria-label="Example select with button addon" name="selector_cat">

                  <option selected>All</option>

                  <?php
                    $arrCategories = array("science","education","people","feelings","computer","buildings");

                    foreach($arrCategories as $i => $var){ ?>
                      <option value='<?php echo $var?>'><?php echo $var ?></option>
                  <?php  } ?> 

                  </select>
                </div>
              </div>
            </div>
            <div class="col-2">
              <div class="mb-10">
                <input class="btn btn-primary" type="button" value="Buscar" name="btn_buscarImgs" id="btn_buscarImgs"> 
              </div>
            </div>
          </div>
 
      </div>
    </section>
    <section>
      <div class="container text-center">
        <div class="row">
          
          <div id="container_imgs" class="col-10">
            
          </div>
          
          <div class="col-2" id="container_previews">
            <div class="text-center">
              <img id="previewImg" src="" class="rounded" alt="">
            </div>
            <div class="mb-3 row">
              <label for="tags" class="col-sm-4 col-form-label">Tags</label>
              <div class="col-sm-8">
                <label id="previewTags" class="col-form-label"></label>
              </div>
            </div>
            <div class="mb-3 row">
              <label for="vistas" class="col-sm-4 col-form-label">Vistas</label>
              <div class="col-sm-8">
                <label id="previewViews" class="col-form-label"></label>
              </div>
            </div>
            <div class="mb-3 row">
              <label for="likes" class="col-sm-4 col-form-label">Like's</label>
              <div class="col-sm-8">
                <label id="previewLikes" class="col-form-label"></label>
              </div>
            </div>
          </div>
            </div>              
          </div>
          
        </div>
      </div>
    </section>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-kenU1KFdBIe4zVF0s0G1M5b4hcpxyD9F7jL+jjXkk+Q2h455rYXK/7HAuoJl+0I4" crossorigin="anonymous"></script>
  </body>

</html>

<script type="text/javascript">
  
  $(document).ready(function(){
    $("#btn_buscarImgs").click(function(){

      keyW=$("#txtkeyWord").val();
      category=$("#selector_cat").val();
      if(category=='All'){
        category="";
      }
      $.post("Controlador.php",{'keyWord':keyW,'category':category},function($data){
        $("#container_imgs").html($data);
        
      });       
    });   
  });

  $("#selector_cat").change(function(){
    keyW=$("#txtkeyWord").val();
    category=$("#selector_cat").val();
    if(category=='All'){
      category="";
    }
    $.post("Controlador.php",{'keyWord':keyW,'category':category},function($data){
      $("#container_imgs").html($data);
      
    });           
  });

  $("#txtkeyWord").keypress(function(e){
    if (e.keyCode === 13) {
      keyW=$("#txtkeyWord").val();
      category=$("#selector_cat").val();
      if(category=='All'){
        category="";
      }
      $.post("Controlador.php",{'keyWord':keyW,'category':category},function($data){
        $("#container_imgs").html($data);
        
      });   
    }        
  });

  function preview(el){
  
    pos=el.getAttribute("pos");
    document.getElementById("previewImg").src=el.getAttribute("src");
    document.getElementById("previewTags").innerHTML=el.getAttribute("alt");
    document.getElementById("previewViews").innerHTML=el.getAttribute("views");
    document.getElementById("previewLikes").innerHTML=el.getAttribute("likes");

  }


</script>