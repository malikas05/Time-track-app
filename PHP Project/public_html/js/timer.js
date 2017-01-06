var currentBlinked = true;
var updateCurrentTaskTime;

function updateRunningTask(){
    var t = new Date();
    var eT = Math.round(t / 1000);
    var s = ":";
    currentFormatedTime = t.getHours() + ":" + (t.getMinutes()<10?"0"+t.getMinutes(): t.getMinutes());
    jQuery("#currentTask span.endTime").html("-&nbsp;"+currentFormatedTime);
    jQuery("#currentTask span.endTime").attr("data-time", eT);
    if(currentBlinked){
        s=":";
        currentBlinked = false;
    }else {
        s=" ";
        currentBlinked = true;
    }
    updateElapsedTime("#currentTask", s, user_data.current.startTime + new Date().getTimezoneOffset()*60, eT)
}

function stopTimer(){
    clearInterval(updateCurrentTaskTime);
}

function startTimer(){
    updateCurrentTaskTime = setInterval(updateRunningTask, 1000);
}

function addTimePicker(element, maxTime){
    if(isNaN(maxTime)){
        maxTime = false;
    }
    var id = element;
    $(function () {
        $(id).datetimepicker({
            maxDate: maxTime,
            format: 'H:mm'
        }).on("dp.change", function(e){
            handleTimeChanges(id, e.date._d, e.oldDate._d);
        }).on("dp.show", function(e){
            var currentTime = e.timestamp;
            $(id).data("DateTimePicker").maxDate(new Date());
        });
    });
}

function updateElapsedTime(parent, separator, startTime, endTime){
    elpasedTime = endTime-startTime;
    elpasedFromatedTime = (""+elpasedTime).toHHMM(separator);
    jQuery(parent+" div.timeSpent").html(elpasedFromatedTime);
    jQuery(parent+" div.timeSpent").attr("data-time", elpasedTime);
}
