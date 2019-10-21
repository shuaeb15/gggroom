function addOption(currNum, currOpt){
  // var currNum = parseInt($(".radioGroup input:radio:last").attr('value'));
  // var newI = parseInt($(".radioGroup input:radio:last").attr('value'))+1;
  var buttonLength = $(".inner-radioGroup"+currNum+" input:radio").length+1;
  // alert($(".radioGroup input:radio").length+1);
  var newI = currNum+1;
  var newOpt = currOpt + 1;
  // alert(newI);
  var optionsHTML = '<input type="radio" name="radio_opt'+currNum+buttonLength+'" id="radio'+currNum+buttonLength+'" class="css-checkbox radio_day" value="'+currNum+buttonLength+'"/> <label for="radio'+currNum+buttonLength+'" class="css-label radGroup1 radGroup2"> <span>Option '+buttonLength+'</span> </label><input type="text" name="option-'+currNum+'-'+buttonLength+'" class="form-control" placeholder="Please enter option for your question"><hr>';
  $(".inner-radioGroup"+currNum).append(optionsHTML);
}
function removeOption(currPage){
  // alert("sadf");
  $('.inner-radioGroup'+currPage+' input:radio:last').remove();
  $('.inner-radioGroup'+currPage+' label:last').remove();
  $('.inner-radioGroup'+currPage+' input:text:last').remove();
  $('.inner-radioGroup'+currPage+' hr:last').remove();
}
function addNewQuestion(currNum){
  var numofelements = $("#insert_page .mainQuestionDiv").length;
  var last = $( '.radioGroup a' ).last().attr( "data-num" );
  // alert(numofelements);
  var latestNum = currNum;
  var oneplus = parseInt(last) + 1;
  var selectText = '';
  selectText = $(".questionDiv option:selected").val();
  // selectText = $.parseHTML(selectText);
  console.log(selectText);
  var i = 1;
  var max = 0;

  $('.radioGroup a').each(function() {
    // alert($(this).attr('data-num'));
      max = Math.max($(this).attr('data-num'), max);
      // alert(max);
      var text = $(this).text();
      // $(this).text(text.replace('Add New Question', 'Remove Question'));
      // $(this).attr('onclick',$(this).attr('onclick').replace('addNewQuestion('+oneplus+');','removeQuestion('+oneplus+');'));
      // $('#add-new-question').removeAttr('onclick');

      // $('.addque').attr('class', 'fa fa-minus-circle removeque');
      $('#add-new-question').attr('onclick', 'addNewQuestion('+oneplus+');');
      // $(this).attr('onclick','removeQuestion('+oneplus+');');
      i++;
  });
  var html = '<div class="row x_title mainQuestionDiv" id="questionDiv'+oneplus+'"> <div class="col-md-9 col-xs-12"> <div class="item form-group"> <label for="">Question '+oneplus+':</label> <input type="text" name="question-'+oneplus+'" class="form-control"> <br><select class="form-control questionDiv" name="queOption-'+oneplus+'" id="queOption'+oneplus+'" data-value="'+latestNum+'" onchange="changeOption('+oneplus+', this.value);"> <option value="1">Radio Button</option> <option value="2">Text Area</option> </select> <br><div class="col-xs-12 radioGroup" id="option'+oneplus+'"> <div class="col-xs-12 inner-radioGroup'+oneplus+'"> <input type="radio" name="radio_opt'+oneplus+'1" id="radio'+latestNum+'" class="css-checkbox radio_day" value="'+latestNum+'"/> <label for="radio'+latestNum+'" class="css-label radGroup1 radGroup2"> <span>Option 1</span> </label> <input type="text" name="option-'+oneplus+'-1" class="form-control" placeholder="Please enter option for your question"> <hr> </div><i class="fa fa-plus-circle addo" id="add'+latestNum+'" title="Add Option" onclick="addOption('+oneplus+');"></i><label for="add-option">Add New Radio Button</label> <i class="fa fa-minus-circle remove" id="RemoveButton'+latestNum+'" title="Add Option" onclick="removeOption('+oneplus+');"></i><label for="remove-option">Remove Radio Button</label> <a href="javascript:void(0);" title="Remove Question" style="color:#000; text-decoration:underline; float:right;" data-num="'+oneplus+'" onclick="removeQuestion('+oneplus+');">Remove Question</a><i class="fa fa-minus-circle addque" style="float:right;"></i> </div></div></div></div>';

  $("#questionDiv"+last).after(html);
}
function removeQuestion(currPage){
  var numofelements = $("#insert_page .mainQuestionDiv").length;
  // alert(numofelements);

  var i = 1;
  $('.radioGroup a').each(function() {
    var text = $(this).text();
    // alert(text);
    if(text == 'Add New Question'){
      // var html = '<a href="javascript:void(0);" title="Add New Question" id="add-new-question" style="color:#000; text-decoration:underline; float:right;" data-num="'+i-1+'" onclick="addNewQuestion('+i-1+');">Add New Question</a>';
      // i++;
    }
    // alert(i);

  });
  $('#questionDiv'+currPage).remove();

  // $('.inner-radioGroup'+currPage+' label:last').remove();
  // $('.inner-radioGroup'+currPage+' input:text:last').remove();
  // $('.inner-radioGroup'+currPage+' hr:last').remove();
}
function changeOption(currNum, questionType){
  // alert($('#option'+currNum+' a').text());
  // var currNum = parseInt($(this).attr('data-value'));

  var hrefText = ''
  hrefText = $('#option'+currNum+' a').text();

  var latestNum = currNum + 1;
  // var questionType = $(this).val();
  // var questionType = $(this).children("option:selected").val();
  // alert(currNum);
  // $("#option1").html('');
  $("#option"+currNum).empty();
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
  if(questionType == 2){
    if(hrefText == 'Add New Question'){
      var addRemoveLink = '<a href="javascript:void(0);" title="'+addRemoveType+' Question" style="color:#000; text-decoration:underline; float:right;" data-num="'+currNum+'" onclick="addNewQuestion('+currNum+');">Add New Question</a><i class="fa fa-plus-circle addque" style="float:right;"></i>';
    }else{
      var addRemoveLink = '<a href="javascript:void(0);" title="'+addRemoveType+' Question" style="color:#000; text-decoration:underline; float:right;" data-num="'+currNum+'" onclick="removeQuestion('+currNum+');">Remove Question</a><i class="fa fa-minus-circle addque" style="float:right;"></i>';
    }
    html = '</br></br><a href="" style="color:#000; text-decoration:underline;">'+addRemoveLink;
    $('#option'+currNum).append(html);
  }else{
    if(hrefText == 'Add New Question'){
      var addRemoveLink = '<a href="javascript:void(0);" title="'+addRemoveType+' Question" style="color:#000; text-decoration:underline; float:right;" data-num="'+currNum+'" onclick="addNewQuestion('+currNum+');">Add New Question</a><i class="fa fa-plus-circle addque" style="float:right;"></i>';
    }else{
      var addRemoveLink = '<a href="javascript:void(0);" title="'+addRemoveType+' Question" style="color:#000; text-decoration:underline; float:right;" data-num="'+currNum+'" onclick="removeQuestion('+currNum+');">Remove Question</a><i class="fa fa-minus-circle addque" style="float:right;"></i>';
    }
    html = '<div class="col-xs-12 inner-radioGroup'+currNum+'"> <input type="radio" name="radio_opt'+currNum+'1" id="radio'+currNum+'1" class="css-checkbox radio_day" value="'+currNum+'"/> <label for="radio'+currNum+'1" class="css-label radGroup1 radGroup2"> <span>Option 1</span> </label> <input type="text" name="option-'+currNum+'-1" class="form-control" placeholder="Please enter option for your question"> <hr> </div><i class="fa fa-plus-circle addo" id="add'+currNum+'" title="Add Option" onclick="addOption('+currNum+');"></i><label for="add-option">Add New Radio Button</label> <i class="fa fa-minus-circle remove" id="RemoveButton'+currNum+'" title="Add Option" onclick="removeOption('+currNum+');"></i><label for="remove-option">Remove Radio Button</label> '+addRemoveLink;
    $("#option"+currNum).append(html);
    // $("#option"+currNum).reload;
  }
}
