(function($){
    
    
    $.fn.balanceHeight = function()
    {
        
        var max = 0;
        
        this.each(function(i,v){
            max = $(v).height() > max ? $(v).height() : max;
        })
        
        $(this).height(max);
        
        return this;
        
    }
    
}(jQuery));