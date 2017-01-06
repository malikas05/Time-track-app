jQuery('select.tags option').on('mousedown', function(e) {
    e.preventDefault();
    jQuery(this).prop('selected', !jQuery(this).prop('selected'));
    colorAtag(this);
    updateTags(jQuery(this).parent());
    return false;
});

jQuery('select.projects').on('click', function(e) {
    var id = jQuery(this).attr("data-day-id");
    if (id == "cur"){
        // current task
        colorAproject(this, "projectH");
    }else {
        // old task
        colorAproject(this, "projectB");
    }
});

function handleTimeChanges(element, newTime, oldTime){
    var el = jQuery(element)[0];
    var dayID = el.getAttribute('data-day-id');
    var taskID = el.getAttribute('data-task-id');
    var task;
    var time = Math.round(newTime/1000);
    if (dayID == "cur") {
        // current time etry
        task = user_data.current;
        taskID="currentTask";
    }else {
        // old time entry
        task = user_data.thisweek[dayID].filter(function(day){
            return day.id == taskID;
        })[0];
    }
    if(el.getAttribute('class').indexOf("startTime") !== -1){
        // start time
        if(time>task.endTime){
            handleErrors("startGRend");
            el.setAttribute('style','color:red;');
        }else {
            el.setAttribute('style','');
            task.startTime = time;
            handleTaskChange({"startTime": task.startTime}, task.id, 'changeField');
            updateElapsedTime("#"+taskID, ":", task.startTime, task.endTime||new Date());
            setStorageData(user_data);
            jQuery(el).fadeOut(100).fadeIn(100);
        }
    }else {
        // end time
        if(time<task.startTime){
            handleErrors("endLSstart");
            el.setAttribute('style','color:red;');
        }else {
            el.setAttribute('style','');
            task.endTime = time;
            handleTaskChange({"endTime": task.endTime}, task.id, 'changeField');
            updateElapsedTime("#"+taskID, ":", task.startTime, task.endTime||new Date());
            setStorageData(user_data);
            jQuery(el).fadeOut(100).fadeIn(100);
        }
    }
}

jQuery('input.taskName').on('change', function(e) {
    var dayID = jQuery(this).attr("data-day-id");
    var value = jQuery(this).val();
    var taskID = jQuery(this).attr('data-task-id');
    var task;
    if (dayID == "cur"){
        // current task
        task = user_data.current;
        taskID="currentTask";
    }else {
        // old task
        task = user_data.thisweek[dayID].filter(function(day){
            return day.id == taskID;
        })[0];
    }
    task.name = value;
    handleTaskChange({"name": task.name}, task.id, 'changeField');
    setStorageData(user_data);
    jQuery(this).fadeOut(200).fadeIn(200);
});

function updateTags(element) {
    var dayID = jQuery(element).attr("data-day-id");
    var values = [], i = 0;
    jQuery(element).children().each(function(tag){
      if(jQuery(this).prop('selected')) {
        values[i] = +(jQuery(this).attr('val')); i++;
      }
    });
    var taskID = jQuery(element).attr('data-task-id');
    var task;
    if (dayID == "cur"){
        // current task
        task = user_data.current;
        dayID="currentTask";
    }else {
        // old task
        task = user_data.thisweek[dayID].filter(function(day){
            return day.id == taskID;
        })[0];
    }
    task.tagsApplied = undefined;
    setStorageData(user_data);
    if (values.lenght == 0){
        task.tagsApplied = undefined;
    }else {
        task.tagsApplied = values;
    }
    console.log(task.tagsApplied );
    console.log(values);
    handleTaskChange({"tagsApplied": task.tagsApplied}, task.id, 'changeField');
    setStorageData(user_data);
    jQuery(element).fadeOut(200).fadeIn(200);
}

function updateProject(element) {
    var dayID = jQuery(element).attr("data-day-id");
    // TODO adjust to get correct values
    var valueProject = jQuery(element).val();
    var valueCategory = jQuery(element).val();
    var taskID = jQuery(element).attr('data-task-id');
    var task;
    if (dayID == "cur"){
        // current task
        task = user_data.current;
        dayID="currentTask";
    }else {
        // old task
        task = user_data.thisweek[dayID].filter(function(day){
            return day.id == taskID;
        })[0];
    }
    task.tagsApplied = value;
    handleTaskChange({"projectApplied": task.projectApplied, "categoryApplied": tsak.categoryApplied }, task.id, 'changeField');
    setStorageData(user_data);
}

jQuery('.deleteTaskLink').on('click', function(e) {
    var dayID = jQuery(this).attr("data-day-id");
    var taskID = jQuery(this).attr('data-task-id');
    var task;
    var confirmed = false;
    if (dayID == "cur"){
        // current task
        task = user_data.current;
        dayID="currentTask";
    }else {
        // old task
        task = user_data.thisweek[dayID].filter(function(day){
            return day.id == taskID;
        })[0];
    }
    // TODO show diolog and handle selection
    confirmed = false;
    if (confirmed){
        handleTaskChange(null, task.id, 'deleteTask');
    }
});

jQuery('.playStopControlButton').on('click', function(e) {
    var dayID = jQuery(this).attr("data-day-id");
    var taskID = jQuery(this).attr('data-task-id');
    var currentlyRunningTask = JSON.parse(JSON.stringify(user_data.current));
    var task;
    if (dayID == "cur"){
        // current task
        task = user_data.current;
        dayID="currentTask";
    }else {
        // old task
        task = user_data.thisweek[dayID].filter(function(day){
            return day.id == taskID;
        })[0];
    }
    // TODO handle selection and start/save tasks
    // user_data.current = JSON.parse(JSON.stringify(empty_task));
});

/* AJAX Handler*/
// Updates a task based on action
// action can be one of the following:
//  - changeField
//  - deleteTask
//  - addTask
function handleTaskChange(data, taskId, action){
    processData({'data':data, 'id': taskId, 'do': action}, taskChangeOutputHandler, ajaxHandler);
}

// Handles results of a task update
function taskChangeOutputHandler(data){
    /*
    if (data !== null) {
        // success?
        //TODO asjust based on rela data
        console.log(data);
        // If there is data and new task was created with newTskID update currenlty running task id
        if ( !!data && !!data.newTaskID ){
            user_data.current.id = data.newTaskID;
        }
    }else {
        // deffenetly an error
        handleErrors("serverIssue");
    }
    */
}

function handleErrors (error) {
    var message;
    var label = "Error";
    var footer = '<button type="button" class="btn btn-default" data-dismiss="modal">Close</button>';
    switch (error) {
        case 'serverIssue':
            message = "Something went wrong while updating task details on our server.<br/> Please try adjusting your task again.";
            break;
        case 'endLSstart':
            message = "Task End time cannot be bigger than Start time.<br/> Data will not be saved. Please enter correct time";
            label = "Time entry issue";
            break;
        case 'startGRend':
            message = "Task Start time cannot be bigger than End time.<br/> Data will not be saved. Please enter correct time";
            label = "Time entry issue";
            break;
        default:
          // unknown error show notification
          message = "Something went wrong. Please try again. <br/> If problem persists reload a page and try one more time before contcting us."
          break;
    }
    messageModal(message, label, footer)
}
