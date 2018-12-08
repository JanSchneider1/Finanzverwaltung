//Every dropdown element with the same DOM -Structure will trigger this function
//Access data by calling '$(this).parents(".dropdown").find('.btn').val()'
$(".dropdown-menu li a").click(function(){
    $(this).parents(".dropdown").find('.btn').html($(this).text() + ' <span class="caret"></span>');
    $(this).parents(".dropdown").find('.input').val($(this).data('value'));
});

/*
$(".dropdown-toggle").focus(function(){
    alert($(this).parents(".dropdown").find('.input').val());
    var a = $(this).parents(".dropdown").find('ul li a');
    foreach(a){
  }
});*/