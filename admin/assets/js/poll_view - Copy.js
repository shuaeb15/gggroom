$(document).ready(function(){
  // $("#queOption1").change(function(){
  $(".questionDiv").change(function(){
    var currNum = parseInt($(this).attr('data-value'));

    var latestNum = currNum + 1;
    var questionType = $(this).val();
    // alert($(this).val());
    // $("#option1").html('');
    $("#option1").empty();
    var html = '';
    var buttonType = '';
    var addRemoveType = '';
    if ( $("#insert_page div").is( ":first-child" ) ) {
      buttonType = 'plus';
      addRemoveType = 'Add';
    }else{
      buttonType = 'minus';
      addRemoveType = 'Remove';
    }
    if(questionType == 'textarea'){
      html = '</br></br><a href="" style="color:#000; text-decoration:underline;"><i class="fa fa-'+buttonType+'-circle"></i>'+addRemoveType+' New Question</a>';
      $('#option1').append(html);
    }else{
      alert(currNum);
      // html = '<div class="col-xs-12" id="option1"><div class="col-xs-8"> <input type="radio" name="radio_day" id="radio1" class="css-checkbox radio_day" value="1"/> <label for="radio1" class="css-label radGroup1 radGroup2"> <span>Option 1</span> </label> <i class="fa fa-plus-circle" class="add" id="add1" title="Add Option"></i> <br><br><a href="" style="color:#000; text-decoration:underline;"><i class="fa fa-'+buttonType+'-circle"></i> '+addRemoveType+' Question</a> </div></div>';

      html = '<div class="col-xs-12 inner-radioGroup"> <input type="radio" name="radio_day" id="radio'+currNum+'" class="css-checkbox radio_day" value="'+currNum+'"/> <label for="radio'+currNum+'" class="css-label radGroup1 radGroup2"> <span>Option 1</span> </label> <input type="text" name="option1" class="form-control" placeholder="Please enter option for your question"> <hr> </div><i class="fa fa-plus-circle addo" id="add'+currNum+'" title="Add Option" onclick="addOption();"></i><label for="add-option">Add New Radio Button</label> <i class="fa fa-minus-circle remove" id="RemoveButton" title="Add Option"></i><label for="remove-option">Remove Radio Button</label> <a href="javascript:void(0);" title="'+addRemoveType+' Question" style="color:#000; text-decoration:underline; float:right;">Add New Question</a><i class="fa fa-'+buttonType+'-circle" style="float:right;"></i>';
      $("#option"+currNum).append(html);
      // $("#option"+currNum).reload;
    }
  });
  var i = 1;
  // $(".addo").click(function(){
  // // $(".add").on('click',function(){
  //   // if($(this).attr('id') == 'add'+i){
  //   //   var optionsHTML = '';
  //   //   var newI = i+1;
  //     // alert($('.add:first').remove());
  //     // $('.add:first').remove();
  //     // alert($(".radioGroup input:radio:first").attr('value'));
  //     var newI = parseInt($(".radioGroup input:radio:last").attr('value'))+1;
  //     optionsHTML = '<input type="radio" name="radio_day" id="radio'+newI+'" class="css-checkbox radio_day" value="'+newI+'"/> <label for="radio'+newI+'" class="css-label radGroup1 radGroup2"> <span>Option '+newI+'</span> </label><input type="text" name="option'+newI+'" class="form-control" placeholder="Please enter option for your question"><hr>';
  //     $(".inner-radioGroup").append(optionsHTML);
  //   // }else{
  //   //   alert("out");
  //   // }
  // });

  $('#RemoveButton').click(function(){
     // alert($('.inner-radioGroup input:radio:last').attr('value'));
     $('.inner-radioGroup input:radio:last').remove();
     $('.inner-radioGroup label:last').remove();
     $('.inner-radioGroup input:text:last').remove();
     $('.inner-radioGroup hr:last').remove();
     // $('#after').children().remove();
  });
  function addNewDiv(questionNum, labelNum){

  }
  $("#add-new-question").click(function(){
    var currNum = parseInt($(this).attr('data-num'));
    var latestNum = currNum + 1;
    // alert(latestNum);
    var html = '<div class="row x_title" id="questionDiv'+latestNum+'"> <div class="col-md-9 col-xs-12"> <div class="item form-group"> <label for="">Question '+latestNum+':</label> <input type="text" name="question" class="form-control"> <br><select class="form-control" name="question" class="questionDiv" id="queOption'+latestNum+'" data-value="'+latestNum+'"> <option value="radio">Radio Button</option> <option value="textarea">Text Area</option> </select> <br><div class="col-xs-12 radioGroup" id="option'+latestNum+'"> <div class="col-xs-12 inner-radioGroup"> <input type="radio" name="radio_day" id="radio'+latestNum+'" class="css-checkbox radio_day" value="'+latestNum+'"/> <label for="radio'+latestNum+'" class="css-label radGroup1 radGroup2"> <span>Option 1</span> </label> <input type="text" name="option1" class="form-control" placeholder="Please enter option for your question"> <hr> </div><i class="fa fa-plus-circle addo" id="add'+latestNum+'" title="Add Option"></i><label for="add-option">Add New Radio Button</label> <i class="fa fa-minus-circle remove" id="RemoveButton" title="Add Option"></i><label for="remove-option">Remove Radio Button</label> <a href="javascript:void(0);" title="Add New Question" id="add-new-question" style="color:#000; text-decoration:underline; float:right;" data-num="'+latestNum+'">Add New Question</a><i class="fa fa-plus-circle" style="float:right;"></i> </div></div></div></div>';

    $("#insert_page").append(html);
    // var $div = $('#insert_page .x_title[id^="questionDiv"]:last');
    // var num = parseInt( $div.prop("id").match(/\d+/g), 10 ) +1;
    //
    // var $label = $("#insert_page").find('label:first').html();
    // var lbl = parseInt( $label.match(/\d+/g), 10 ) +1;
    //
    // var $klon = $div.clone().prop('id', 'questionDiv'+num );
    // var $klonlbl = $label.clone().html('Question'+lbl);
    //
    // $div.after( $klon.text('klon'+num) );
  });
});
function addOption(){
  alert("Asdf");
  var newI = parseInt($(".radioGroup input:radio:last").attr('value'))+1;
  optionsHTML = '<input type="radio" name="radio_day" id="radio'+newI+'" class="css-checkbox radio_day" value="'+newI+'"/> <label for="radio'+newI+'" class="css-label radGroup1 radGroup2"> <span>Option '+newI+'</span> </label><input type="text" name="option'+newI+'" class="form-control" placeholder="Please enter option for your question"><hr>';
  $(".inner-radioGroup").append(optionsHTML);
}
