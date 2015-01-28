(function($){
  
  var showTextField = function($flexi, $select) {
    $('.FlexiChoiceFieldText', $flexi).toggle(!Boolean($select.val()));  
  };
  
  $('div.FlexiChoiceField').entwine({
    onadd: function(){
      var $flexi = this,
          $select = $flexi.find('.FlexiChoiceFieldSelect select');
      
      $select.on('change', function(){
        showTextField($flexi, $select);
      });
      
      // show initial field
      showTextField($flexi, $select);
    }
  });
  
  
})(jQuery);