var wpia = jQuery.noConflict();
var $instance;
function htmlEscape(str) {
    return String(str)
            .replace(/&/g, '--AMP--')
            .replace(/"/g, '--DOUBLEQUOTE--')
            .replace(/'/g, '--QUOTE--')
            .replace(/</g, '--LT--')
            .replace(/>/g, '--GT--');
}
function showLoader(){
    wpia('.wpia-loading').fadeTo(0,0).css('display','block').fadeTo(200,1);
    wpia('.wpia-calendar ul').animate({
        'opacity' : '0.7'
    },200);
}
function hideLoader(){
    wpia('.wpia-loading').css('display','none');
}
function changeDay(direction, timestamp){

    var data = {
		action: 'changeDayAdmin',
        calendarDirection: direction,

        currentTimestamp: timestamp,
        calendarData: $instance.find(".wpia-calendar-data").attr('data-calendar-data'),
        
        calendarLegend: $instance.find(".wpia-calendar-legend").attr('data-calendar-legend'),
        showLegend: $instance.find(".wpia-show-legend").attr('data-show-legend'),
        

        calendarLanguage: $instance.find(".wpia-calendar-language").attr('data-calendar-language'),
        
        calendarID : $instance.find(".wpia-calendar-ID").attr('data-calendar-ID')
        
	};
	wpia.post(ajaxurl, data, function(response) {
		$instance.find('.wpia-calendars').html(response);
        hideLoader();  
        wpia('.wpia-dropdown').customSelect();    
        wpia('.wpia-chosen').chosen(); 
	});
}

wpia(document).ready(function(){
    
    wpia('.wpia-chosen').chosen();
    
    wpia('.wpia-dropdown').customSelect();
    wpia('.wpia-container').each(function(){
    $instance = wpia(this);
    wpia($instance).on('change','.wpia-dropdown',function(e){
        showLoader();     
        e.preventDefault();        
        changeDay('jump',wpia(this).val())
    });
    
    wpia($instance).on('click','.wpia-prev',function(e){
        showLoader();
        e.preventDefault();
        if($instance.find(".wpia-current-timestamp a").length == 0)
            timestamp = $instance.find(".wpia-current-timestamp").attr('data-current-timestamp');
        else 
            timestamp = $instance.find(".wpia-current-timestamp a").attr('data-current-timestamp') 
        changeDay('prev',timestamp);
    });
    
    
    wpia($instance).on('click','.wpia-next',function(e){  
        showLoader();
        e.preventDefault();        
        if($instance.find(".wpia-current-timestamp a").length == 0)
            timestamp = $instance.find(".wpia-current-timestamp").attr('data-current-timestamp')
        else 
            timestamp = $instance.find(".wpia-current-timestamp a").attr('data-current-timestamp') 
        changeDay('next',timestamp);
    });
    
    })

    wpia(document).on('click',"#calendarBatchUpdate",function(e){
        e.preventDefault();
        var wpiaCalendarData = JSON.parse(wpia(".wpia-calendar-data").html());  
        if (!wpiaCalendarData) {
            wpiaCalendarData = {};
        } 
        var currentTimestamp = wpia(".wpia-current-timestamp").attr('data-current-timestamp')
        var currentDate = new Date(currentTimestamp * 1000);
       
        var startDay = wpia("#startDay").val();
        var startMonth = wpia("#startMonth").val();
        var startYear = wpia("#startYear").val();
        
        var endDay = wpia("#endDay").val();
        var endMonth = wpia("#endMonth").val();
        var endYear = wpia("#endYear").val();
        
        var selectStatus = wpia("#changeStatus").val();
        
        var bookingDetails = wpia("#bookingDetails").val();

        var startTime = (Date.parse(startDay + " " + startMonth + " " + startYear))/1000;
        var endTime = (Date.parse(endDay + " " + endMonth + " " + endYear))/1000;
        if(startTime < endTime){
            for(i=startTime; i <= endTime; i = i + 60*60*24){
                var changeDate = new Date(i * 1000);
                if(changeDate.getMonth() == currentDate.getMonth() && changeDate.getFullYear() == currentDate.getFullYear()){
                    if(!wpia("select.wpia-day-"+(changeDate.getDate())).find('option.wpia-option-' + selectStatus).prop('selected')){
                        wpia("select.wpia-day-"+(changeDate.getDate())).find('option').prop("selected",false);
                        wpia("select.wpia-day-"+(changeDate.getDate())).find('option.wpia-option-' + selectStatus).prop("selected",true);
                    }
                    wpia("select.wpia-day-"+(changeDate.getDate())).parent().find('span.wpia-select-status').removeClass().addClass('wpia-select-status status-' + selectStatus);
                    wpia("select.wpia-day-"+(changeDate.getDate())).parent().find('span.wpia-day-split-top').removeClass().addClass('wpia-day-split-top wpia-day-split-top-' + selectStatus);
                    wpia("select.wpia-day-"+(changeDate.getDate())).parent().find('span.wpia-day-split-bottom').removeClass().addClass('wpia-day-split-bottom wpia-day-split-bottom-' + selectStatus);
                    wpia("select.wpia-day-"+(changeDate.getDate())).parent().find(".wpia-input-description").val(bookingDetails);
                    
                    
                    wpia(".wpia-calendars li.wpia-day-" + changeDate.getDate()).removeClass().addClass('wpia-day wpia-day-' + changeDate.getDate() + ' status-' + selectStatus);
                    wpia(".wpia-calendars li.wpia-day-" + changeDate.getDate() + " span.wpia-day-split-top").removeClass().addClass('wpia-day-split-top wpia-day-split-top-' + selectStatus);
                    wpia(".wpia-calendars li.wpia-day-" + changeDate.getDate() + " span.wpia-day-split-bottom").removeClass().addClass('wpia-day-split-bottom wpia-day-split-bottom-' + selectStatus);
                    
                }
               
                var currentYear = 'year' + changeDate.getFullYear();
        		var currentMonth = 'month' + (changeDate.getMonth()+1);
        		var currentDay = 'day' + (changeDate.getDate());
                
                var currentTimestamp = wpia(".wpia-current-timestamp").attr('data-current-timestamp');
                var currentDate = new Date(currentTimestamp * 1000);
                var currentMonth = changeDate.getMonth()+1;
                var currentYear = changeDate.getFullYear();
                var currentDay = changeDate.getDate();
                
                
                if (!(currentYear in wpiaCalendarData)) {
        			wpiaCalendarData[currentYear] = {};
        		}
        		
        		if (!(currentMonth in wpiaCalendarData[currentYear])) {
        			wpiaCalendarData[currentYear][currentMonth] = {};
        		}
                wpiaCalendarData[currentYear][currentMonth][currentDay] = selectStatus;
                wpiaCalendarData[currentYear][currentMonth]['description-' + currentDay] = bookingDetails;
                
                wpia("span.error").css('display','none');
            }
        } else {
            wpia("span.error").css('display','block');
        }
        wpia(".wpia-calendar-data").html(JSON.stringify(wpiaCalendarData));
        wpia("#inputCalendarData").val(JSON.stringify(wpiaCalendarData));        
    })
    

    wpia(document).on('change',".wpia-day-select",function(e){
        var wpiaCalendarData = JSON.parse(wpia(".wpia-calendar-data").html());  
        if (!wpiaCalendarData) {
            wpiaCalendarData = {};
        } 
        var currentTimestamp = wpia(".wpia-current-timestamp").attr('data-current-timestamp');
        var currentDate = new Date(currentTimestamp * 1000);
        var currentMonth = currentDate.getMonth()+1;
        var currentYear = currentDate.getFullYear();
        var currentDay = wpia(this).attr('name').replace('wpia-day-','');
        var selectStatus = wpia(this).val();
        
        if (!(currentYear in wpiaCalendarData)) {
			wpiaCalendarData[currentYear] = {};
		}
		
		if (!(currentMonth in wpiaCalendarData[currentYear])) {
			wpiaCalendarData[currentYear][currentMonth] = {};
		}
        wpiaCalendarData[currentYear][currentMonth][currentDay] = selectStatus;

        //change colors
        wpia(this).parent().find('span.wpia-select-status').removeClass().addClass('wpia-select-status status-' + selectStatus);
        wpia(this).parent().find('span.wpia-day-split-top').removeClass().addClass('wpia-day-split-top wpia-day-split-top-' + selectStatus);
        wpia(this).parent().find('span.wpia-day-split-bottom').removeClass().addClass('wpia-day-split-bottom wpia-day-split-bottom-' + selectStatus);
        
        wpia(".wpia-calendar li.wpia-day-" + currentDay).removeClass().addClass('wpia-day wpia-day-' + currentDay + ' status-' + selectStatus);
        wpia(".wpia-calendar li.wpia-day-" + currentDay + " span.wpia-day-split-top").removeClass().addClass('wpia-day-split-top wpia-day-split-top-' + selectStatus);
        wpia(".wpia-calendar li.wpia-day-" + currentDay + " span.wpia-day-split-bottom").removeClass().addClass('wpia-day-split-bottom wpia-day-split-bottom-' + selectStatus);
        
        
        wpia(".wpia-calendar-data").html(JSON.stringify(wpiaCalendarData));
        wpia("#inputCalendarData").val(JSON.stringify(wpiaCalendarData));
       
    })
    
    
    
    wpia(document).on('keyup change click',".wpia-input-description",function(e){
        
        var wpiaCalendarData = JSON.parse(wpia(".wpia-calendar-data").text());  
        if (!wpiaCalendarData) {
            wpiaCalendarData = {};
        } 
        var currentTimestamp = wpia(".wpia-current-timestamp").attr('data-current-timestamp');
        var currentDate = new Date(currentTimestamp * 1000);
        var currentMonth = currentDate.getMonth()+1;
        var currentYear = currentDate.getFullYear();
        var currentDay = wpia(this).attr('name').replace('wpia-description-','');
        var selectStatus = wpia(this).val();
        
        if (!(currentYear in wpiaCalendarData)) {
			wpiaCalendarData[currentYear] = {};
		}
		
		if (!(currentMonth in wpiaCalendarData[currentYear])) {
			wpiaCalendarData[currentYear][currentMonth] = {};
		}
        wpiaCalendarData[currentYear][currentMonth]['description-' + currentDay] = htmlEscape(selectStatus);
        
        wpia(".wpia-calendar-data").text(JSON.stringify(wpiaCalendarData));
        wpia("#inputCalendarData").val(JSON.stringify(wpiaCalendarData));
       
    })
    
    wpia(".saveCalendar").click(function(){
        if (!wpia.trim(wpia(".fullTitle").val()).length) {
            wpia(".fullTitle").addClass('error').focus();
            return false;
        }
        return true;
        
    })
    
    wpia(".open-wpia-legend-translations").click(function(e){
        e.preventDefault();
        if(wpia(this).find('span').text() == '+'){
            wpia(this).siblings('.wpia-legend-translations').slideDown();
            wpia(this).find('span').text('-');
        } else {
            wpia(this).siblings('.wpia-legend-translations').slideUp();
            wpia(this).find('span').text('+');
        }    
        
    })
})
function wpia_select_text(containerid) {
    if (document.selection) {
        var range = document.body.createTextRange();
        range.moveToElementText(containerid);
        range.select();
    } else if (window.getSelection) {
        var range = document.createRange();
        range.selectNode(containerid);
        window.getSelection().addRange(range);
    }
}