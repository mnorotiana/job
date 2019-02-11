$(document).ready(function(){
    var active_page = $('#active_page').val();
    var data_length = $('#data_length').val();

    var buttonCommon = {
        exportOptions: {
            format: {
                body: function ( data, row, column, node ) {
                    /*data = $('<p>' + data + '</p>').text();
                    var result = $.isNumeric(data.replace(',', '.')) ? data.replace(',', '.') : data;
                    return result;
                    */
                    return data;
                }
            }
        }
    };
     
    if(typeof active_page === 'undefined')
    {
        active_page = 0;
    }
    else
    {
        active_page = parseInt(active_page);
    }

    if(typeof data_length === "undefined")
    {
        data_length = 10;
    }
    else
    {
        data_length = parseInt(data_length);
    }

    var datatable = $('.datatable');

    if(datatable && typeof datatable == 'object')
    {
        var table = $('.datatable').DataTable({
            dom: 'lBfrtip',
            buttons: [   
                $.extend( true, {}, buttonCommon, {
                    extend: 'excelHtml5'
                } )
            ]
        });
        
        table
        .buttons()
        .container()
        .appendTo( '.dataTables_filter' );   

        table.page(active_page).draw('page');
    }

    var datatableNoButtons = $('.datatable-no-buttons').DataTable();


    $('.role_user').click(function(){

      $(this).find("input:radio").each(function(e){

        if($(this).prop("checked"))
        {
          var role = $(this).val();
          if(role == "ROLE_SOCIETE")
          {
            $('.role_societe').css('display','block');
          }
          else
          {
            $('.role_societe').css('display','none');
          }
        }        
      });
      
    });

    $('#role_user').change(function(){      
        var role = $(this).val();
        if(role == "ROLE_SOCIETE")
        {
          $('.role_societe').css('display','block');
        }
        else
        {
          $('.role_societe').css('display','none');
        }       
    });

    setInterval(function() {
      // recupération des données pour afficher dans le modal
      var urlGet = $('#get_online_url').val();
      $.ajax({
          type: "POST",
          url: urlGet,
          cache: false,
          success: function(data){
            console.log(data);
             $('#list-user').html(data);
             $('.active_user').each(function(){
                $(this).click();
              }); 
          }
      });      
    }, 3000);   

    /*setInterval(function() {
      // recupération des données pour afficher dans le modal
      var urlGet = $('#get_message_url').val();      
      $.ajax({
          type: "POST",
          url: urlGet,
          cache: false,
          success: function(data){
             $('#history').html(data);
          }
      });      
    }, 3000); 
    */

});


function autocomplete(inp, arr) {
  /*the autocomplete function takes two arguments,
  the text field element and an array of possible autocompleted values:*/
  var currentFocus;
  /*execute a function when someone writes in the text field:*/
  $(inp).on("input", function(e) {
      var a, b, i, val = this.value;
      /*close any already open lists of autocompleted values*/
      closeAllLists();
      if (!val) { return false;}
      currentFocus = -1;
      /*create a DIV element that will contain the items (values):*/
      a = document.createElement("DIV");
      a.setAttribute("id", this.id + "autocomplete-list");
      a.setAttribute("class", "autocomplete-items");
      /*append the DIV element as a child of the autocomplete container:*/
      this.parentNode.appendChild(a);
      /*for each item in the array...*/
      for (i = 0; i < arr.length; i++) {
        /*check if the item starts with the same letters as the text field value:*/
        if (arr[i].substr(0, val.length).toUpperCase() == val.toUpperCase()) {
          /*create a DIV element for each matching element:*/
          b = document.createElement("DIV");
          /*make the matching letters bold:*/
          b.innerHTML = "<strong>" + arr[i].substr(0, val.length) + "</strong>";
          b.innerHTML += arr[i].substr(val.length);
          /*insert a input field that will hold the current array item's value:*/
          b.innerHTML += "<input type='hidden' value='" + arr[i] + "'>";
          /*execute a function when someone clicks on the item value (DIV element):*/
              $(b).on("click", function(e) {
              /*insert the value for the autocomplete text field:*/
              inp.value = this.getElementsByTagName("input")[0].value;
              /*close the list of autocompleted values,
              (or any other open lists of autocompleted values:*/
              closeAllLists();
          });
          a.appendChild(b);
        }
      }
  });
  /*execute a function presses a key on the keyboard:*/
  $(inp).on("keydown", function(e) {
      var x = $("div#"+this.id + "autocomplete-list");

      if (e.keyCode == 40) {
        /*If the arrow DOWN key is pressed,
        increase the currentFocus variable:*/
        currentFocus++;
        /*and and make the current item more visible:*/
        addActive(x);
      } else if (e.keyCode == 38) { //up
        /*If the arrow UP key is pressed,
        decrease the currentFocus variable:*/
        currentFocus--;
        /*and and make the current item more visible:*/
        addActive(x);
      } else if (e.keyCode == 13) {
        /*If the ENTER key is pressed, prevent the form from being submitted,*/
        e.preventDefault();
        if (currentFocus > -1) {
          /*and simulate a click on the "active" item:*/
          if (x) x[currentFocus].click();
        }
      }
  });
  function addActive(x) {
    /*a function to classify an item as "active":*/
    if (!x) return false;
    /*start by removing the "active" class on all items:*/
    removeActive(x);
    if (currentFocus >= x.length) currentFocus = 0;
    if (currentFocus < 0) currentFocus = (x.length - 1);
    /*add class "autocomplete-active":*/
    x[currentFocus].classList.add("autocomplete-active");
  }
  function removeActive(x) {
    /*a function to remove the "active" class from all autocomplete items:*/
    for (var i = 0; i < x.length; i++) {
      x[i].classList.remove("autocomplete-active");
    }
  }
  function closeAllLists(elmnt) {
    /*close all autocomplete lists in the document,
    except the one passed as an argument:*/
    var x = $(".autocomplete-items");
    for (var i = 0; i < x.length; i++) {
      if (elmnt != x[i] && elmnt != inp) {
      x[i].parentNode.removeChild(x[i]);
    }
  }
}
/*execute a function when someone clicks in the document:*/
$(document).on("click", function (e) {
    closeAllLists(e.target);
});
} 

function sendAddForm()
{
	$('#addForm').submit();
}

function sendEditForm()
{
	$('#editForm').submit();
}

function editOffre(id)
{
    // recupération des données pour afficher dans le modal
    var urlGet = $('#edit_offre_url').val();
    //$('#mask').css('display','block');
    var DATA = 'id=' + id;
    //$("body").LoadingOverlay("show");
    $.ajax({
        type: "POST",
        url: urlGet,
        data: DATA,
        cache: false,
        success: function(data){
            //$("body").LoadingOverlay("hide");
           $('.editForm').html(data);
           $('#editModal').modal('show');
        }
    }); 
}

function editUser(id)
{
    // recupération des données pour afficher dans le modal
    var urlGet = $('#edit_user_url').val();
    //$('#mask').css('display','block');
    var DATA = 'id=' + id;
    //$("body").LoadingOverlay("show");
    $.ajax({
        type: "POST",
        url: urlGet,
        data: DATA,
        cache: false,
        success: function(data){
            //$("body").LoadingOverlay("hide");
           $('.editForm').html(data);
           $('#editModal').modal('show');
        }
    }); 
}

function viewOffre(id)
{
    // recupération des données pour afficher dans le modal
    var urlGet = $('#view_offre_url').val();
    //$('#mask').css('display','block');
    var DATA = 'id=' + id;
    //$("body").LoadingOverlay("show");
    $.ajax({
        type: "POST",
        url: urlGet,
        data: DATA,
        cache: false,
        success: function(data){
            //$("body").LoadingOverlay("hide");
           $('#viewModal').html(data);
           $('#viewModal').modal('show');
        }
    }); 
}

function treatCandidature(id,type)
{
    $('#type_action').val(type);
    $('#id_candidature').val(id);
    $('.treatInfo').css('display','none');
    if(type == "rejet")
    {
        $('#noteDiv').css('display','block');
        $('#motifDiv').css('display','block');
    }
    else if(type == "validation")
    {
        $('#noteDiv').css('display','block');
        $('#commentaireDiv').css('display','block');
    }
    else if(type == "test")
    {
        $('#dateTestDiv').css('display','block');
        $('#commentaireDiv').css('display','block');
    }
    else
    {
        $('#dateEntretienDiv').css('display','block');
        $('#commentaireDiv').css('display','block');
    }

    $('#treatModal').modal('show');
}

function sendTreatForm()
{
    $('#treatForm').submit();
}

function sendCandidature()
{
    $("#recruitmentbundle_profil_step4").click();
}

function editDossier(id)
{
  // recupération des données pour afficher dans le modal
  var urlGet = $('#view_dossier_url').val();
  //$('#mask').css('display','block');
  var DATA = 'id=' + id;
  //$("body").LoadingOverlay("show");
  $.ajax({
      type: "POST",
      url: urlGet,
      data: DATA,
      cache: false,
      success: function(data){
          //$("body").LoadingOverlay("hide");
         $('.editRegleForm').html(data);
         $('#editRegleModal').modal('show');
      }
  }); 
    
}

function sendEditRegle()
{
  $("#editDossierForm").submit();    
}

function previousCandidat(position)
{
  $('.candidatSection').css('display','none');
  var index = position-1;
  $('#candidat-'+index).css('display','block');
}

function nextCandidat(position)
{  
  $('.candidatSection').css('display','none');
  var index = parseInt(position+1);
  $('#candidat-'+index).css('display','block');
}

function addDomaine()
{
  // recupération des données pour afficher dans le modal
    var urlGet = $('#add_domaine_url').val();
    var libelle = $("#mot_cle").val();
    //$('#mask').css('display','block');
    var DATA = 'libelle=' + libelle;
    //$("body").LoadingOverlay("show");
    $.ajax({
        type: "POST",
        url: urlGet,
        data: DATA,
        cache: false,
        success: function(data){
            //$("body").LoadingOverlay("hide");
          if(data != "existant")
          {
           $('#domaine_list').append(data);
          }
        }
    }); 
}

function addSociete()
{
  // recupération des données pour afficher dans le modal
    var urlGet = $('#add_societe_url').val();
    var libelle = $("#societe_nom").val();
    //$('#mask').css('display','block');
    var DATA = 'libelle=' + libelle;
    //$("body").LoadingOverlay("show");
    $.ajax({
        type: "POST",
        url: urlGet,
        data: DATA,
        cache: false,
        success: function(data){
            //$("body").LoadingOverlay("hide");
          if(data == "ok")
          {
           $('#societe_list').append("<p class='selection-item'>"+libelle+"</p>");
          }
        }
    }); 
}
