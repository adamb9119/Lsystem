function setHeiHeight() {
  $('#final-system').css({
    height: ($(window).height()) + 'px'
  });
}

function resizeViewBox(id){
  var obj = $('#'+id)[0];
  var bb  = obj.getBBox();
  var bbx = bb.x-5;
  var bby = bb.y-5;
  var bbw = bb.width+10;
  var bbh = bb.height+10;
  var vb  = [bbx,bby,bbw,bbh];
  obj.setAttribute('viewBox', vb.join(' '));
}

function parseData(){
  var axiom = $('#axiom').val();
  var gens  = $('#num-generations').val();
  var rules = {};
  var obj   = {};

  $('.rule-input').each(function(){
    var key    = $(this).find('.key').val();
    var value  = $(this).find('.value').val();
    rules[key] = value;
  });


  obj.axiom = axiom;
  obj.gens  = gens;
  obj.rules = rules;
  return obj;
}

$('#createSystem').on('click', function(event){
  event.preventDefault();
  var loadIcon  = $('.preloader-wrapper').clone().removeClass('hide');
  var data      = parseData();

  $('#final-system').empty();
  $('#final-system').append(loadIcon);

  $.post(
    "create/",
    {
      'axiom'      : data.axiom,
      'generations': data.gens,
      'rule'       : data.rules
    },
        function(data){
      data = JSON.parse(data);
      console.log(data);
      $('#final-system').empty();

      var mainImage       = data.pic.image;
      var mainId          = data.pic.id;
      
      $(mainImage).appendTo('#final-system');
      resizeViewBox(mainId);
      Materialize.toast('Ok', 5000, 'rounded');
    }
  ).fail(function(xhr, status, error) {
     Materialize.toast(xhr.status+' - '+error, 5000, 'rounded');
     $('#final-system').empty();
     $('#final-system').html(xhr.status+' - '+error);
  });
});

$(document).ready(function(){
  setHeiHeight();
  $('ul.tabs').tabs();
  $('select').material_select();
  $('.collapsible').collapsible();
  $('.modal').modal();
  $(window).resize( setHeiHeight );
  $('#createSystem').click();
});