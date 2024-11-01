var wpia = jQuery.noConflict();
function showLoader($this){
    $this.find('.wpia-loading').fadeTo(0,0).css('display','block').fadeTo(200,1);
    $this.find('.wpia-calendar ul').animate({
        'opacity' : '0.7'
    },200);
}
function hideLoader(){
    wpia('.wpia-loading').css('display','none');
}
function changeDay(direction, timestamp, $this){
    var data = {
		action: 'changeDay',
        calendarDirection: direction,
        currentTimestamp: timestamp,
        calendarData: $this.find(".wpia-calendar-data").attr('data-calendar-data'),
        calendarLegend: $this.find(".wpia-calendar-legend").attr('data-calendar-legend'),
        showLegend: $this.find(".wpia-show-legend").attr('data-show-legend'),
        calendarLanguage: $this.find(".wpia-calendar-language").attr('data-calendar-language'),
        calendarID : $this.find(".wpia-calendar-ID").attr('data-calendar-ID')       
	};
	wpia.post(wpia_ajaxurl, data, function(response) {
		$this.find('.wpia-calendars').html(response);
        hideLoader();     
        $this.find('.wpia-dropdown').customSelect();  
	});
}

wpia(document).ready(function(){
    wpia('.wpia-dropdown').customSelect();
    wpia('div.wpia-container').each(function(){
        
        var $instance = wpia(this);
        
        wpia($instance).on('change','.wpia-dropdown',function(e){
            showLoader($instance);     
            e.preventDefault();        
            changeDay('jump',wpia(this).val(), $instance)
        });
        
        wpia($instance).on('click','.wpia-prev',function(e){
            showLoader($instance);
            e.preventDefault();
            timestamp = $instance.find(".wpia-current-timestamp").attr('data-current-timestamp');
            changeDay('prev',timestamp, $instance);
        });
        
        
        wpia($instance).on('click','.wpia-next',function(e){  
            showLoader($instance);
            e.preventDefault();     
            timestamp = $instance.find(".wpia-current-timestamp").attr('data-current-timestamp'); 
            changeDay('next',timestamp, $instance);
        });
    
    });
    
  
})
$ = jQuery.noConflict();